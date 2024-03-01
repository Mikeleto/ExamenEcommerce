<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\CreateProduct;
use App\Http\Livewire\Admin\EditProduct;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ColorProduct;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Str;

class Ejercicios8y9Semana4Test extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_product()
    {
        // Assuming you have necessary models and database setup

        // Create test data (e.g., categories, subcategories) for testing
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
           
        ]);
        Livewire::test(CreateProduct::class)
           
            ->set('subcategory_id', $subcategory->id)
            ->set('name', 'Test Product')
            ->set('slug', 'test-product')
            ->set('description', 'Test Description')
            ->set('brand_id', $brand->id) // Assuming brand_id 1 exists
            ->set('price', 10.99)
            ->call('save')
            ->assertStatus(200)
            ->assertHasErrors([
                'category_id'
            ]);

            Livewire::test(CreateProduct::class)
           
            ->set('category_id', $category->id)
            ->set('name', 'Test Product')
            ->set('slug', 'test-product')
            ->set('description', 'Test Description')
            ->set('brand_id', $brand->id) // Assuming brand_id 1 exists
            ->set('price', 10.99)
            ->call('save')
            ->assertStatus(200)
            ->assertHasErrors([
                'subcategory_id'
            ]);

            Livewire::test(CreateProduct::class)
           
            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('slug', 'test-product')
            ->set('description', 'Test Description')
            ->set('brand_id', $brand->id) // Assuming brand_id 1 exists
            ->set('price', 10.99)
            ->call('save')
            ->assertStatus(200)
            ->assertHasErrors([
                'name'
            ]);

            Livewire::test(CreateProduct::class)
           
            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('description', 'Test Description')
            ->set('brand_id', $brand->id) // Assuming brand_id 1 exists
            ->set('price', 10.99)
            ->call('save')
            ->assertStatus(200)
            ->assertHasErrors([
                'name','slug'
            ]);

            Livewire::test(CreateProduct::class)
           
            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('name', 'test-product')
            ->set('slug', 'test-product')
            ->set('brand_id', $brand->id) 
            ->set('price', 10.99)
            ->call('save')
            ->assertStatus(200)
            ->assertHasErrors([
                'description'
            ]);

            Livewire::test(CreateProduct::class)
           
            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('name', 'test-product')
            ->set('slug', 'test-product')
            ->set('description', 'test-product')
            ->set('price', 10.99)
            ->call('save')
            ->assertStatus(200)
            ->assertHasErrors([
                 'brand_id'
            ]);

            Livewire::test(CreateProduct::class)
           
            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('name', 'test-product')
            ->set('slug', 'test-product')
            ->set('description', 'test-product')
            ->set('brand_id', $brand->id) 
            ->call('save')
            ->assertStatus(200)
            ->assertHasErrors([
                 'price'
            ]);

    }

    /** @test */
    public function validation_errors_are_displayed()
    {
        Livewire::test(CreateProduct::class)
            ->call('save')
            ->assertHasErrors([
                'category_id', 'subcategory_id', 'name', 'description', 'brand_id', 'price'
            ]);
    }
        /** @test */
    public function the_quantity_of_a_product_with_no_color_or_size_must_be_numeric()
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
           
        ]);


           $product = new Product([
            'name' => 'Producto de Prueba',
            'slug' => 'producto-de-prueba',
            'description' => 'descripcion producto de prueba',
            'price' => 19.99
        ]);

        Livewire::test(CreateProduct::class)
            ->set([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'brand_id' => $brand->id,
                'price' => $product->price,
                'quantity' => null,
            ])
            ->call('save')
            ->assertHasErrors([
                'quantity',
            ]);
    }

    /** @test */
    public function the_slug_of_a_product_must_be_unique()
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
           
        ]);


           $product = new Product([
            'name' => 'Producto de Prueba',
            'slug' => 'producto-de-prueba',
            'description' => 'descripcion producto de prueba',
            'price' => 19.99
        ]);
        $product->name = 'Producto de Prueba';
        $product->subcategory_id = $subcategory->id;
        $product->brand_id = $brand->id;
        $product->slug = 'producto-de-prueba';
        $product->save();

        $testProduct = new Product([
            'name' => 'Producto de Prueba',
            'slug' => 'producto-de-prueba',
            'description' => 'descripcion producto de prueba',
            'price' => 19.99
        ]);

        Livewire::test(CreateProduct::class)
            ->set([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'name' => $testProduct->name,
                'slug' => $testProduct->slug,
                'description' => $testProduct->description,
                'brand_id' => $brand->id,
                'price' => $testProduct->price,
            ])
            ->call('save')
            ->assertHasErrors([
                'slug' => 'unique:products'
            ]);
    }

    /** @test */
    public function the_price_of_a_product_must_be_numeric()
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
           
        ]);

        $product = new Product([
            'name' => 'Producto de Prueba',
            'slug' => 'producto-de-prueba',
            'description' => 'descripcion producto de prueba',
            'price' => null,
        ]);

        Livewire::test(CreateProduct::class)
            ->set([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'brand_id' => $brand->id,
                'price' => $product->price,
            ])
            ->call('save')
            ->assertHasErrors([
                'price',
            ]);
    }


      /** @test */
      public function can_edit_product()
      {
          // Assuming you have necessary models and database setup
  
          // Create test data (e.g., categories, subcategories) for testing
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
             
          ]);
  
          $brand2 = Brand::factory()->create();
          $category2 = Category::factory()->create([
              'name' => 'categoria',
              'slug' => 'categoria',
              'icon' => 'categoria',
          ]);
          $category2->brands()->attach($brand2->id);
          $subcategory2 = Subcategory::factory()->create([
              'category_id' => $category2->id,
              'name' => 'ropa',
              'slug' => 'ropa',
             
          ]);
  
  
          $product = new Product([
              'name' => 'Producto de Prueba',
              'slug' => 'producto-de-prueba',
              'description' => 'descripcion producto de prueba',
              'price' => 19.99,
              'subcategory_id'=> $subcategory->id,
          ]);
          Livewire::test(EditProduct::class, ['product' => $product])
          ->set('category_id', $category2->id)
              ->set('product.subcategory_id', $subcategory2->id)
              ->set('product.name', 'Test Product')
              ->set('product.slug', 'test-product')
              ->set('product.description', 'Test Description')
              ->set('product.brand_id', $brand2->id) // Assuming brand_id 1 exists
              ->set('product.price', 10.99)
              ->call('save')
              ->assertStatus(200);
  
            
      }
  
      /** @test */
      public function validation_edit_errors_are_displayed()
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
             
          ]);
  
          $product = new Product([
              'name' => 'Producto de Prueba',
              'slug' => 'producto-de-prueba',
              'description' => 'descripcion producto de prueba',
              'price' => 19.99,
              'subcategory_id'=> $subcategory->id,
          ]);
          Livewire::test(EditProduct::class , ['product' => $product])
          ->set([
              'category_id' => '',
              'product.subcategory_id' => '',
              'product.name' => '',
              'product.slug' => '',
              'product.description' => '',
              'product.brand_id' => '',
              'product.price' => null,
              'product.quantity' => null,
          ])
          ->call('save')
          ->assertHasErrors([
              'category_id' => 'required',
              'product.subcategory_id' => 'required',
              'product.name' => 'required',
              'product.slug' => 'required',
              'product.description' => 'required',
              'product.brand_id' => 'required',
              'product.price' => 'required',
          ]);
  
          
      }
          /** @test */
      public function the_quantity_of_a_product_with_no_color_or_size_must_be_numericall()
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
             
          ]);
  
  
             $product = new Product([
              'name' => 'Producto de Prueba',
              'slug' => 'producto-de-prueba',
              'description' => 'descripcion producto de prueba',
              'price' => 19.99
          ]);
  
          Livewire::test(CreateProduct::class)
              ->set([
                  'category_id' => $category->id,
                  'subcategory_id' => $subcategory->id,
                  'name' => $product->name,
                  'slug' => $product->slug,
                  'description' => $product->description,
                  'brand_id' => $brand->id,
                  'price' => $product->price,
                  'quantity' => null
              ])
              ->call('save')
              ->assertHasErrors([
                  'quantity',
              ]);
      }
  
      /** @test */
      public function the_slug_of_a_product_must_be_unique_when_editing()
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
             
          ]);
  
  
             $product = new Product([
              'name' => 'Producto de Prueba',
              'slug' => 'producto-de-prueba',
              'description' => 'descripcion producto de prueba',
              'price' => 19.99
          ]);
          $product->name = 'Producto de Prueba';
          $product->subcategory_id = $subcategory->id;
          $product->brand_id = $brand->id;
          $product->slug = 'producto-de-prueba';
          $product->save();
  
          $product2 = new Product([
              'name' => 'Producto de Prueba2',
              'slug' => 'producto-de-prueba2',
              'description' => 'descripcion producto de prueba',
              'price' => 19.99
          ]);
          $product2->name = 'Producto de Prueba';
          $product2->subcategory_id = $subcategory->id;
          $product2->brand_id = $brand->id;
          $product2->slug = 'producto-de-prueba';
          $product2->save();
  
          Livewire::test(EditProduct::class, ['product' => $product])
              ->set([
                  'product.slug' => $product2->slug
              ])
              ->call('save')
              ->assertHasErrors([
                  'product.slug' => 'unique'
              ]);
      }
  
  
      /** @test */
      public function the_price_of_a_product_must_be_numeric_when_editing()
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
             
          ]);
  
  
             $product = new Product([
              'subcategory_id' => $subcategory->id,
              'brand_id' => $brand->id,
              'name' => 'Producto de Prueba',
              'slug' => 'producto-de-prueba',
              'description' => 'descripcion producto de prueba',
              'price' => 19.99
          ]);
  
          Livewire::test(EditProduct::class, ['product' => $product])
              ->set([
                  'product.price' => null
              ])
              ->call('save')
              ->assertHasErrors([
                  'product.price'
              ]);
      }
  
  
       /** @test */
       public function the_quantity_of_a_product_without_color_or_size_must_be_numeric_when_editing()
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
             
          ]);
  
  
             $product = new Product([
              'subcategory_id' => $subcategory->id,
              'brand_id' => $brand->id,
              'name' => 'Producto de Prueba',
              'slug' => 'producto-de-prueba',
              'description' => 'descripcion producto de prueba',
              'price' => 19.99
          ]);
   
           Livewire::test(EditProduct::class, ['product' => $product])
               ->set([
                   'product.quantity' => 'text'
               ])
               ->call('save')
               ->assertHasErrors([
                   'product.quantity' => 'numeric'
               ]);
       }

   
}