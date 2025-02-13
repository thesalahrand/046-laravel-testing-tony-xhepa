<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
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

    public function test_auth_user_can_see_buy_button(): void
    {
        $user = User::factory()->create();
        Product::factory()->create();

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertSee('Buy');
    }

    public function test_unauth_user_cannot_see_buy_button(): void
    {
        Product::factory()->create();

        $response = $this->get(route('products.index'));

        $response->assertDontSee('Buy');
    }

    public function test_normal_auth_user_cannot_see_create_product_button_on_products_index_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertDontSee('Create Product');
    }

    public function test_admin_can_see_create_product_button_on_products_index_screen(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertSee('Create Product');
    }

    public function test_unauth_user_cannot_see_create_product_button_on_products_index_screen(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertDontSee('Create Product');
    }

    public function test_normal_auth_user_cannot_see_products_create_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('products.create'));

        $response->assertStatus(403);
    }

    public function test_admin_can_see_products_create_screen(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get(route('products.create'));

        $response->assertStatus(200);
    }

    public function test_unauth_user_cannot_see_products_create_screen(): void
    {
        $response = $this->get(route('products.create'));

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_normal_auth_user_cannot_store_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Product 01',
            'type' => 'fruit',
            'price' => 49.99
        ]);

        $response->assertForbidden();
    }

    public function test_admin_can_store_product(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Product 01',
            'type' => 'fruit',
            'price' => 49.99
        ]);

        $response->assertStatus(302)
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Product 01',
            'type' => 'fruit',
            'price' => 49.99
        ]);
    }

    public function test_unauth_user_can_store_product(): void
    {
        $response = $this->post(route('products.store'), [
            'name' => 'Product 01',
            'type' => 'fruit',
            'price' => 49.99
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
