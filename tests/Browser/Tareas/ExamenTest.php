<?php

namespace Tests\Browser\Tareas;

use App\Models\City;
use App\Models\Department;
use App\Models\District;
use App\Models\Order;
use App\Models\Size;
use Database\Factories\SizeFactory;
use Facebook\WebDriver\WebDriverKeys;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Support\Str;

class ExamenTest extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */




    public function test_eje3() {
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
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'quantity' => 1,
            'name' => 'algo1',
            'slug' => 'algo1',
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory2->id,
            'quantity' => 1,
            'name' => 'algo2',
            'slug' => 'algo2',
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory3->id,
            'quantity' => 1,
            'name' => 'algo3',
            'slug' => 'algo3',
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
                    1 => ['quantity' => 1],
                ]);
        }
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                ->where('size', false);
        })->get();
        foreach ($products as $product) {
            $product->colors()->attach([
                1 => [
                    'quantity' => 1
                ],
            ]);
        }

        $role = Role::create(['name' => 'admin']);
        $usuario = User::factory()->create([
            'name' => 'Rubén',
            'email' => 'algo1234@gmail.com',
            'password' => bcrypt('algo1234')
        ])->assignRole('admin');
        $this->browse(function (Browser $browser) use ($p1,$p2,$p3, $usuario,$category, $subcategory,$subcategory2,$subcategory3, $brand) {
            $browser
            ->loginAs($usuario)
            ->visit('/products/' . $p1->name)
                ->pause(600)
                ->select('#talla3', 1)
                ->pause(600)
                ->select('#color3', 1)
                ->pause(600)
                ->click('@comprar')
                ->pause(600)
              
                
                ->visit('/products/' . $p2->name)
                ->pause(600)
                ->click('@buy')
                ->pause(600)
        
                ->visit('/products/' . $p3->name)
                ->pause(600)
                ->select('#color3', 1)
                ->pause(1000)
                ->click('@comprarColor')
                ->pause(600)
                ->click('@carrito')
                ->screenshot('hola')
                ->pause(600)
                ->click('@carritoCompras')
                ->pause(700)
                ->assertSee($p1->name)
                ->assertSee($p2->name)
                ->assertSee($p3->name)
                ->assertSee($p1->price)
                ->assertSee($p2->price)
                ->assertSee($p3->price)
                ->assertSee($p1->quantity)
                ->assertSee($p2->quantity)
                ->assertSee($p3->quantity)
                ->pause(700)
                ->screenshot('compras5')
                ->press('@perfilLogued')
                ->pause(600)
                ->screenshot('compras6')
                ->click('@logout')
                ->pause(600)
                ->visit('/login')
                ->pause(500)
                ->type('email' , 'algo1234@gmail.com')
                ->type('password', 'algo1234')
                ->pause(500)
                ->screenshot('compras7')
                ->click('@loginAs')
                ->pause(600)
                ->screenshot('compras8')
                ->visit('/shopping-cart')
                ->pause(300)
                ->assertSee($p1->name)
                ->assertSee($p2->name)
                ->assertSee($p3->name)
                ->assertSee($p1->price)
                ->assertSee($p2->price)
                ->assertSee($p3->price)
                ->assertSee($p1->quantity)
                ->assertSee($p2->quantity)
                ->assertSee($p3->quantity)
                ->screenshot('compras9');
               
                ;
        });
    }

}