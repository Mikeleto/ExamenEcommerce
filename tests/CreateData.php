<?php

namespace Tests;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Department;
use App\Models\District;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;

trait CreateData
{

    public function createCategory(){
        return  Category::factory()->create([
            'name' => 'categoria',
            'slug' => 'categoria',
            'icon' => 'categoria',
        ]);

    }

    public function createSubcategory( $category , $color = false , $size = false){
        return Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => $color,
            'size' => $size,
        ]);
    }

    public function createSubcategoryWithColor( $category, $color = true , $size = false){
        return Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => $color,
            'size' => $size,
        ]);
    }

    public function createSubcategoryWithColorSize( $category, $color = true , $size = true){
        return Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'ropa',
            'slug' => 'ropa',
            'color' => $color,
            'size' => $size
        ]);
    }
    public function createBrand($category)
    {
        $brand = Brand::factory()->create();
        $category->brands()->attach($brand->id);
        return $brand;
    }

    public function createBrand2($category)
    {
        $brand = Brand::factory()->create();
        $category->brands()->attach($brand->id);
        return $brand;
    }
   
    public function createColor()
    {
        return Color::factory()->create();
    }

    public function createSize($product)
    {
        return Size::factory()->create([
            'product_id' => $product->id
        ]);
    }
    public function createProduct($subcategory, $brand)
    {
        $brand = $this->createBrand($subcategory->category);
        $category = $this->createCategory();
        $category->brands()->attach($brand->id);
        $subcategory = $this->createSubcategory($subcategory->category);
    
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
    
        return $p1;
    }

    public function createProductWithColor($subcategory, $brand,  $quantity = 5,)
    {
        $brand = $this->createBrand2($subcategory->category);
        $category = $this->createCategory();
        $category->brands()->attach($brand->id);
        $subcategory = $this->createSubcategoryWithColor($subcategory->category);
        $color = $this->createColor();
      
    
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => 2,
            'name' => 'algo2',
            'slug' => 'algo2',

        ]);
    
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p1->quantity = null;
        $productColor = $this->createColor();

        $p1->colors()->attach($color->id, ['quantity' => $quantity]);
    
        return $p1;
    }

    public function createProductWithColorSize($subcategory, $brand, $quantity = 5,)
    {
        $brand = $this->createBrand($subcategory->category);
        $category = $this->createCategory();
        $category->brands()->attach($brand->id);
        $subcategory = $this->createSubcategoryWithColorSize($subcategory->category);
        $size = $this->createSize($product);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => 2,
            'name' => 'algo3',
            'slug' => 'algo3',
        ]);
    
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p1->colors()->attach($color->id, ['quantity' => $quantity]);
        $p1->sizes()->attach($size->id, ['quantity' => $quantity]);
    
        return $p1;
    }

    public function createUser($name)
    {
        return User::factory()->create(['name' => $name]);
    }

    public function createAdminUser()
    {
        $admin = Role::create(['name' => 'admin']);
        $user = User::factory()->create()->assignRole($admin);

        return $user;
    }


    public function createDepartment()
    {
        return Department::factory()->create();
    }

    public function createCity($name, $department)
    {
        return City::factory()->create([
            'name' => $name,
            'department_id' => $department->id
        ]);
    }

    public function createDistrict($name, $city)
    {
        return District::factory()->create([
            'name' => $name,
            'city_id' => $city->id
        ]);
    }


    public function createDefault()
    {
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory($category);
        $brand = $this->createBrand($category);
        $this->createUser('Prueba');
        $product = $this->createProduct($subcategory, $brand);
    }


    public function createTestProduct()
    {
        $product = new Product([
            'name' => 'Producto de Prueba',
            'slug' => Str::slug('Producto de Prueba'),
            'description' => 'descripcion producto de prueba',
            'price' => 19.99
        ]);

        return $product;
    }


   
}