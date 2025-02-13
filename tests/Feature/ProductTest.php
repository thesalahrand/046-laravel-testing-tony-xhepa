<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_screen_can_be_rendered_with_header_text(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(200)
            ->assertSee('All Products');
    }

    public function test_products_list_are_empty(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertSee('No products found.');
    }

    public function test_products_list_are_not_empty(): void
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->get(route('products.index'));

        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }
}
