<?php

use App\Models\Product;

beforeEach(function () {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: true);
});


test('product page list contains empty table', function () {
    $this->actingAs($this->user)->get('/products')
        ->assertStatus(200)
        ->assertSee(__('No products found'));
});

test('product page list contains non empty table', function () {
    $product = Product::factory()->create();

    $this->actingAs($this->user)->get('/products')
        ->assertStatus(200)
        ->assertDontSee(__('No products found'))
        ->assertSee($product->id)
        ->assertSee($product->name)
        ->assertSee($product->price)
        ->assertViewHas('products', function ($products) use ($product) {
            return $products->contains($product);
        })
    ;
});

test('create product successful', function () {
    $productData = [
        'name' => 'Prod 1',
        'price' => 123
    ];

    $this->actingAs($this->admin)
        ->post('/products', $productData)
        ->assertRedirect('/products');

    $lastProduct = Product::latest()->first();
    expect($lastProduct->name)->toBe($productData['name']);
    expect($lastProduct->price)->toBe($productData['price']);
});
