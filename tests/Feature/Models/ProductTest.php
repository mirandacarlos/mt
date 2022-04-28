<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use App\Services\DiscountService;
use App\Services\IdToStringService;
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
        $response = $this->get('/products?priceLessThan=99000&category=boots');
        $response->assertJsonCount(2);
    }

    /**
     * Id to string service.
     *
     * @return void
     */
    public function test_id_to_string_service()
    {
        $product = Product::where('sku', 1)->get();
        $product = IdToStringService::idToString($product);
        $this->assertEquals('000001', $product->get(0)->sku);
    }

    /**
     * Discount service.
     *
     * @return void
     */
    public function test_discount_service()
    {
        $product = Product::where('sku', 1)->get();
        $product = DiscountService::applyDiscount($product);
        $this->assertEquals(62300, $product->get(0)->price->final);
    }
    
    /**
     * Pagination.
     *
     * @return void
     */
    public function test_pagination()
    {
        Product::factory(7)->create();
        $response = $this->get('/products?page=3');
        $response->assertJsonCount(2);
    }

    /**
     * 15% discount.
     *
     * @return void
     */
    public function test_15_percent_discount()
    {
        $product = Product::find(3);
        $product->category = 'sneakers';
        $product->save();
        $response = $this->get('/products');
        $result = json_decode($response->content());
        $this->assertEquals(60350, $result[2]->price->final);
    }

    /**
     * Empty page.
     *
     * @return void
     */
    public function test_empty_page()
    {
        $response = $this->get('/products?page=4');
        $response->assertJsonCount(0);
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
