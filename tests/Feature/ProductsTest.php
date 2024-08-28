<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase; //make sure not to use it on real database

    public function test_product_page_with_no_product(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('No Products Found');
    }

    public function test_product_page_with_products(): void
    {
        //arrange: build the scenario
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 123,
        ]);

        //act: simulate the actual action
        $response = $this->get('/products');

        //assert
        $response->assertStatus(200);
        $response->assertViewIs('product.index');
        $response->assertSee('Test Product');
        $response->assertViewHas('products', function ($collection) use ($product) {
            return $collection->contains($product);
        });
    }

    public function test_pagination_in_products_index_page()
    {
        $prodcuts = Product::factory()->count(11)->create();
        $lastProduct = $prodcuts->last();

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewIs('product.index');
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
    }
}
