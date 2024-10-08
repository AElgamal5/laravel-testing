<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    //---------------------pagination----------------------------//
    public function test_paginated_products_contain_10th_record(): void
    {
        $products = Product::factory(10)->create();
        $lastProduct = $products->last();

        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($products) use ($lastProduct) {
            return $products->contains($lastProduct);
        });
    }

    public function test_paginated_products__doesnt_contain_11th_record(): void
    {
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($products) use ($lastProduct) {
            return !$products->contains($lastProduct);
        });
    }

    //---------------------authorization----------------------------//
    public function test_admin_can_see_product_create_button(): void
    {
        $response = $this->actingAs($this->admin)->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Create New A Product');
    }

    public function test_non_admin_can_not_see_product_create_button(): void
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee('Create New A Product');
    }

    public function test_admin_can_access_product_create_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/products/create');

        $response->assertOk(); // status = 200
        $response->assertSee(['Products Create', 'name', 'price']);
    }

    public function test_non_admin_can_not_access_product_create_page(): void
    {
        $response = $this->actingAs($this->user)->get('/products/create');

        $response->assertForbidden(); //status = 403
    }


    public function test_product_create_successfully(): void
    {
        $productData = [
            'name' => "test",
            'price' => 123,
        ];

        $response = $this->actingAs($this->admin)->post('/products', $productData);
        $lastProduct = Product::latest()->first();

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $productData);
        $this->assertEquals($productData['name'], $lastProduct->name);
        $this->assertEquals($productData['price'], $lastProduct->price);
    }

    //---------------------validation----------------------------//
    public function test_product_edit_contains_correct_values(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->get("/products/{$product->id}/edit");

        $response->assertStatus(200);
        $response->assertSee([
            "value=\"{$product->name}\"",
            "value=\"{$product->price}\"",
            'Products Edit',
        ], false);
        $response->assertViewHas('product', $product);
    }

    public function test_product_update_validation_redirect_back_to_edit_form(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->put("/products/{$product->id}", [
            'name' => '',
            'price' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'price']);
        $response->assertInvalid(['name', 'price']);
    }

    public function test_product_deleted_successfully(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/products/{$product->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseMissing('products', $product->toArray());
        $this->assertDatabaseCount('products', 0);
    }

    //--------------------------APIs------------------------------//
    public function test_api_return_products_list(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJson([$product->toArray()]);

    }

    public function test_api_product_store_successfully(): void
    {
        $productData = [
            'name' => 'Prod 1',
            'price' => 123,
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertCreated(); //status = 201
        $response->assertJson($productData);
    }

    public function test_api_product_store_unsuccessfully(): void
    {
        $productData = [
            'name' => '',
            'price' => 123,
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertUnprocessable(); //status = 422
        $response->assertJsonValidationErrors(['name']);
    }

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create([
            'is_admin' => $isAdmin
        ]);
    }
}
