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
        Product::create([
            'name' => 'Test Product',
            'price' => 123,
        ]);

        //act: simulate the actual action
        $response = $this->get('/products');

        //assert
        $response->assertStatus(200);
        $response->assertDontSee('No Products Found');
        $response->assertSee('Test Product');
    }
}
