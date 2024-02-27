<?php

use App\Http\Livewire\Admin\Link;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Image;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Productos2Test extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function link_component_renders_correctly()
    {

        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'subcategoria',
            'slug' => 'subcategoria',
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'casa',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);


        Livewire::test(Link::class)
            ->assertSee($p1->name); // Assuming 'Agregar producto' is part of your component's output
    }

    /** @test */
    public function link_component_filters_correctly()
    {
        // You can add more test cases based on your filter functionality
        Livewire::test(Link::class)
            ->set('nameFilter', 'SomeProduct')
            ->assertDontSee('SomeProduct'); // Assuming 'SomeProduct' is part of the filtered result

        // Add more test cases for other filters as needed
    }

    /** @test */
    public function link_component_resets_filters_correctly()
    {
        // You can add more test cases based on your reset filter functionality
        Livewire::test(Link::class)
            ->set('nameFilter', 'SomeProduct')
            ->call('resetFilters')
            ->assertDontSee('SomeProduct'); // Assuming 'SomeProduct' is not part of the result after resetting filters

        // Add more test cases for other filters as needed
    }

    /** @test */
    public function link_component_pagination_works_correctly()
    {

        $brand = Brand::factory()->create();
        $category = Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);
        $category->brands()->attach($brand->id);
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => true,
            'size' => true
        ]);
        $subcategory2 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'tele',
            'slug' => 'tele',
        ]);
        $subcategory3 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'movil',
            'slug' => 'movil',
            'color' => true,
        ]);
        $subcategory4 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'turco',
            'slug' => 'turco',
        ]);
        $subcategory5 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'movil',
            'slug' => 'movil',
            'color' => true,
        ]);
        $subcategory6 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'movil',
            'slug' => 'movil',
            'color' => true,
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => 2,
            'name' => 'algo1',
            'slug' => 'algo1',
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory2->id,
            'quantity' => 2,
            'name' => 'algo2',
            'slug' => 'algo2',
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory3->id,
            'quantity' => 2,
            'name' => 'algo3',
            'slug' => 'algo3',
        ]);
        $p4 = Product::factory()->create([
            'subcategory_id' => $subcategory4->id,
            'quantity' => 2,
            'name' => 'algo3',
            'slug' => 'algo3',
        ]);
        $p5 = Product::factory()->create([
            'subcategory_id' => $subcategory5->id,
            'quantity' => 2,
            'name' => 'algo3',
            'slug' => 'algo3',
        ]);
        $p6 = Product::factory()->create([
            'subcategory_id' => $subcategory6->id,
            'quantity' => 2,
            'name' => 'algo6',
            'slug' => 'algo6',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        Image::factory()->create([
            'imageable_id' => $p6->id,
            'imageable_type' => Product::class
        ]);
        $size = Size::factory()->create([
            'name' => 'Talla M',
            'product_id' => $p1->id,
        ]);
        $colors = ['azul'];
        foreach ($colors as $color) {
            Color::create([
                'name' => $color
            ]);
        }
        $sizes = Size::all();
        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 10],
                ]);
        }
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 10
                ],
            ]);
        }

        // You can add more test cases based on your pagination functionality
        Livewire::test(Link::class)
            ->set('perPage', 5) // Set the number of items per page to 20
            ->assertSee($p1->name) // Assuming 'Item1' is part of the first page
            ->assertDontSee($p6->name); // Assuming 'Item1' is not part of the second page

        // Add more test cases for other pagination scenarios as needed
    }


    /** @test */
public function it_can_sort_products_by_name()
{
    $brand = Brand::factory()->create();
    $category = Category::factory()->create([
        'name' => 'categoria',
        'slug' => 'categoria',
        'icon' => 'categoria',
    ]);
    $category->brands()->attach($brand->id);
    $subcategory = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'ropa',
        'slug' => 'ropa',
        'color' => true,
        'size' => true
    ]);
    $subcategory2 = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'tele',
        'slug' => 'tele',
    ]);
    $subcategory3 = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'movil',
        'slug' => 'movil',
        'color' => true,
    ]);
    $subcategory4 = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'turco',
        'slug' => 'turco',
    ]);
    $subcategory5 = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'movil',
        'slug' => 'movil',
        'color' => true,
    ]);
    $subcategory6 = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'movil',
        'slug' => 'movil',
        'color' => true,
    ]);
    $p1 = Product::factory()->create([
        'subcategory_id' => $subcategory->id,
        'quantity' => 2,
        'name' => 'quechua',
        'slug' => 'quechua',
    ]);
    $p2 = Product::factory()->create([
        'subcategory_id' => $subcategory2->id,
        'quantity' => 2,
        'name' => 'rango',
        'slug' => 'rango',
    ]);
    $p3 = Product::factory()->create([
        'subcategory_id' => $subcategory3->id,
        'quantity' => 2,
        'name' => 'zapato',
        'slug' => 'zapato',
    ]);

    Image::factory()->create([
        'imageable_id' => $p1->id,
        'imageable_type' => Product::class
    ]);
    Image::factory()->create([
        'imageable_id' => $p2->id,
        'imageable_type' => Product::class
    ]);
    Image::factory()->create([
        'imageable_id' => $p3->id,
        'imageable_type' => Product::class
    ]);

    Livewire::test(Link::class)
        ->call('sortBy', 'name') // Call the method to sort by name
        ->assertSeeInOrder([$p3->name, $p2->name, $p1->name]);
}

  /** @test */
  public function it_can_filter_products_with_sizes()
  {
    $brand = Brand::factory()->create();
    $category = Category::factory()->create([
        'name' => 'categoria',
        'slug' => 'categoria',
        'icon' => 'categoria',
    ]);
    $category->brands()->attach($brand->id);
    $subcategory = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'ropa',
        'slug' => 'ropa',
        'color' => true,
        'size' => true
    ]);
    $subcategory2 = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'tele',
        'slug' => 'tele',
    ]);

  
    $p1 = Product::factory()->create([
        'subcategory_id' => $subcategory->id,
        'quantity' => 2,
        'name' => 'algo1',
        'slug' => 'algo1',
    ]);
    $p2 = Product::factory()->create([
        'subcategory_id' => $subcategory2->id,
        'quantity' => 2,
        'name' => 'algo2',
        'slug' => 'algo2',
    ]);
  
  
    Image::factory()->create([
        'imageable_id' => $p1->id,
        'imageable_type' => Product::class
    ]);
    Image::factory()->create([
        'imageable_id' => $p2->id,
        'imageable_type' => Product::class
    ]);

   
    $size = Size::factory()->create([
        'name' => 'Talla M',
        'product_id' => $p1->id,
    ]);
    $colors = ['azul'];
    foreach ($colors as $color) {
        Color::create([
            'name' => $color
        ]);
    }
    $sizes = Size::all();
    foreach ($sizes as $size) {
        $size->colors()
            ->attach([
                1 => ['quantity' => 10],
            ]);
    }
    $products = Product::whereHas('subcategory', function (Builder $query) {
        $query->where('color', true)
            ->where('size', true);
    })->get();
    foreach ($products as $product) {
        $product->colors()->attach([
            1 => [
                'quantity' => 10
            ],
        ]);
    }

      // Crear un componente Livewire y establecer filtros
      Livewire::test(Link::class)
          ->set('sizeFilter', true) 
          ->assertSee($p1->name)
          ->assertDontSee($p2->name);
  }

    /** @test */
    public function it_can_filter_products_with_brands()
    {
      $brand = Brand::factory()->create([ 'name' => 'aut',
      ]);
      $brand2 = Brand::factory()->create([ 'name' => 'poem',
      ]);
      $category = Category::factory()->create([
          'name' => 'categoria',
          'slug' => 'categoria',
          'icon' => 'categoria',
      ]);
      $category->brands()->attach($brand->id);
      $category2 = Category::factory()->create([
        'name' => 'link',
        'slug' => 'link',
        'icon' => 'link',
    ]);
    $category2->brands()->attach($brand2->id);
     
      $subcategory2 = Subcategory::factory()->create([
          'category_id' => $category2->id,
          'name' => 'tele',
          'slug' => 'tele',
      ]);
      $subcategory3 = Subcategory::factory()->create([
          'category_id' => $category->id,
          'name' => 'movil',
          'slug' => 'movil',
          'color' => true,
      ]);
    
      $p2 = Product::factory()->create([
        'subcategory_id' => $subcategory3->id,
        'brand_id' => $brand2->id,
        'quantity' => 2,
        'name' => 'algo2',
        'slug' => 'algo2',
    ]);
  
      $p3 = Product::factory()->create([
          'subcategory_id' => $subcategory3->id,
          'brand_id' => $brand->id,
          'quantity' => 2,
          'name' => 'algo3',
          'slug' => 'algo3',
      ]);
    
      Image::factory()->create([
          'imageable_id' => $p2->id,
          'imageable_type' => Product::class
      ]);
      Image::factory()->create([
          'imageable_id' => $p3->id,
          'imageable_type' => Product::class
      ]);
     
     
      Livewire::test(Link::class)
    ->set('selectedBrand', $brand->id)
    ->assertSee($p3->name)
    ->assertDontSee($p2->name);
    }


     /** @test */
  public function show_columns()
  {
    $brand = Brand::factory()->create();
    $category = Category::factory()->create([
        'name' => 'categoria',
        'slug' => 'categoria',
        'icon' => 'categoria',
    ]);
    $category->brands()->attach($brand->id);
    $subcategory = Subcategory::factory()->create([
        'category_id' => $category->id,
        'name' => 'ropa',
        'slug' => 'ropa',
        'color' => true,
        'size' => true
    ]);
   
  
    $p1 = Product::factory()->create([
        'subcategory_id' => $subcategory->id,
        'quantity' => 2,
        'name' => 'algo1',
        'slug' => 'algo1',
    ]);

  
    Image::factory()->create([
        'imageable_id' => $p1->id,
        'imageable_type' => Product::class
    ]);
 
   
    $size = Size::factory()->create([
        'name' => 'Talla M',
        'product_id' => $p1->id,
    ]);
    $colors = ['azul'];
    foreach ($colors as $color) {
        Color::create([
            'name' => $color
        ]);
    }
    $sizes = Size::all();
    foreach ($sizes as $size) {
        $size->colors()
            ->attach([
                1 => ['quantity' => 10],
            ]);
    }
    $products = Product::whereHas('subcategory', function (Builder $query) {
        $query->where('color', true)
            ->where('size', true);
    })->get();
    foreach ($products as $product) {
        $product->colors()->attach([
            1 => [
                'quantity' => 10
            ],
        ]);
    }

    // Remove this line if you want to handle exceptions

    Livewire::test(Link::class)
        ->set('nameSelect', false)  // Hide the name column
        ->assertDontSee('Nombre')
        ->assertDontSee($p1->name);
        
  }

}
