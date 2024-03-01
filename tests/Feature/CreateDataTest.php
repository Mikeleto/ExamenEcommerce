<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\Product;

use App\Http\Livewire\Admin\ShowProducts;
use Laravel\Jetstream\Features;
use Tests\CreateData;
use Illuminate\Database\Eloquent\Builder;

class CreateDataTest extends TestCase
{
    use RefreshDatabase, CreateData;

   /** @test */
public function showProducts_show()
{
    $category = $this->createCategory();
    $subcategory = $this->createSubcategory($category);
    $brand = $this->createBrand($category);

    $product = $this->createProduct($subcategory, $brand);

    Livewire::test(ShowProducts::class)
        ->assertSee($product->name);
}


  /** @test */
  public function showProducts_search()
  {
    $category = $this->createCategory();
    $subcategory = $this->createSubcategory($category);
    $brand = $this->createBrand($category);
    $color = $this->createColor($subcategory); 
    $product = $this->createProduct($subcategory, $brand);
    $product2 = $this->createProductWithColor($subcategory, $brand);
  
      Livewire::test(ShowProducts::class)
      ->set('search', $product2->name)
      ->assertSee($product2->name)
      ->assertDontSee($product->name); 
  }


   /** @test */
   public function showProducts_sort()
   {
       $category = $this->createCategory();
       $subcategory = $this->createSubcategory($category);
       $brand = $this->createBrand($category);
   
       $product = $this->createProduct($subcategory, $brand);
   
       Livewire::test(ShowProducts::class)
       ->call('sortBy', 'sold')
           ->assertSee($product->sold = 1);
   }


}