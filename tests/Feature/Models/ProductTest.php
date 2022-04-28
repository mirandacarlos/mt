<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Initial data is loaded.
     *
     * @return void
     */
    public function test_database_count()
    {
        $this->assertDatabaseCount('products', 5);
    }

    /**
     * Product 000003 is loaded.
     *
     * @return void
     */
    public function test_database_has_sku_3()
    {
        $this->assertDatabaseHas('products', ['sku' => '000003']);
    }

    /**
     * Instantiate single Product without persist.
     *
     * @return void
     */
    public function test_single_model_instantiation()
    {
        $product = Product::factory()->make();
        $this->assertInstanceOf(Product::class, $product);
    }

    /**
     * Instantiate multiple Products without persist.
     *
     * @return void
     */
    public function test_multiple_models_instantiation()
    {
        $products = Product::factory()->count(3)->make();
        $this->assertCount(3, $products);
    }

    /**
     * Category filter.
     *
     * @return void
     */
    public function test_category_filter()
    {
        $response = $this->get('/products?category=boots');
        $response->assertJsonCount(3);
    }

    /**
     * Price filter.
     *
     * @return void
     */
    public function test_price_filter()
    {
        $response = $this->get('/products?priceLessThan=59001');
        $response->assertJsonFragment(['original' => 59000]);
    }

    /**
     * Category and Price filter.
     *
     * @return void
     */
    public function test_category_and_price_filter()
    {
        $response = $this->get('/products?priceLessThan=59001');
        $response->assertJsonFragment(['original' => 59000]);
    }

    /**
     * Id to string service.
     *
     * @return void
     */
    public function test_id_to_string_service()
    {

    }

    /**
     * Discount service.
     *
     * @return void
     */
    public function test_discount_service()
    {
    }
    
    /**
     * Pagination.
     *
     * @return void
     */
    public function test_pagination()
    {
    }

    /**
     * 15% discount.
     *
     * @return void
     */
    public function test_15_percent_discount()
    {
    }

    /**
     * Restore database to initial state.
     *
     * @return void
     */
    public function test_database_migration()
    {
        $this->artisan('migrate:fresh --path=database/migrations/mt --seed')
            ->assertSuccessful();
    }
}
