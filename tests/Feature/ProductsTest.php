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
        Product::create([
            'name' => 'Test Product',
            'price' => 123,
        ]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertDontSee('No Products Found');
    }
}
