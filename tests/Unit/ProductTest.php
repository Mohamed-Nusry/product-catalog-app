<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
      
    }

    /** @test */
    public function it_can_create_a_product()
    {
        // Arrange
        $data = [
            'code' => '5454',
            'category' => 'Material',
            'name' => 'Paper',
            'description' => 'Test Description',
            'selling_price' => 50.50,
            'special_price' => 45,
            'status' => 'Published',
            'is_delivery_available' => 1,
            'image' => 'product-image.jpg',
        ];

        // Act
        $product = Product::create($data);

        // Assert
        $this->assertDatabaseHas('products', $data);
    }
 
    /** @test */
    public function it_can_read_a_product()
    { 
        // Arrange
        $data = [
            'code' => '5455',
            'category' => 'Material',
            'name' => 'Rubber',
            'description' => 'Test Material Description',
            'selling_price' => 50.50,
            'special_price' => 45,
            'status' => 'Published',
            'is_delivery_available' => 1,
            'image' => 'test',
        ];

        $product = Product::create($data);

        // Act
        $foundProduct = Product::find($product->id);

        // Assert
        $this->assertNotNull($foundProduct);
        $this->assertEquals($product->id, $foundProduct->id);
        $this->assertEquals($product->name, $foundProduct->name);
    }
 
    /** @test */
    public function it_can_update_a_product()
    {
        // Arrange
        $data = [
            'code' => '5455',
            'category' => 'Material',
            'name' => 'Rubber',
            'description' => 'Test Material Description',
            'selling_price' => 50.50,
            'special_price' => 45,
            'status' => 'Published',
            'is_delivery_available' => 1,
            'image' => 'test',
        ];

        $product = Product::create($data);

        // Arrange
        $newData = [
            'code' => '5455',
            'category' => 'Material',
            'name' => 'Quality Rubber',
            'description' => 'Test Quality Material Description',
            'selling_price' => 70.50,
            'special_price' => 75,
            'status' => 'Published',
            'is_delivery_available' => 1,
            'image' => 'test',
            ];

        // Act
        $product->update($newData);

        // Assert
        $this->assertDatabaseHas('products', $newData);
    }
 
    /** @test */
    public function it_can_delete_a_product()
    {
        // Arrange
        $data = [
            'code' => '5455',
            'category' => 'Material',
            'name' => 'Rubber',
            'description' => 'Test Material Description',
            'selling_price' => 50.50,
            'special_price' => 45,
            'status' => 'Published',
            'is_delivery_available' => 1,
            'image' => 'test',
        ];

        $product = Product::create($data);
 
        // Act
        $product->delete();
 
        // Assert
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
