<?php

namespace Tests\Browser\Tareas\Semana2;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Image;
use App\Models\Subcategory;
use App\Models\Color;
use App\Models\ColorProduct;
use App\Models\Size;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Semana2Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */

    protected function setUp(): void{

        parent::setUp();
        $this->category = Category::factory()->create([
            'name' => 'INFORMATICA',
            'slug' => 'INFORMATICA',
            'icon' => '->',
        ]);
        $this->role = Role::create(['name' => 'admin']);
        $this->user = User::factory()->create([
            'name' => 'mike',
            'email' => 'pococho@gmail.com',
            'password' => bcrypt('poco1234')
        ])->assignRole('admin');
    }
    public function test_s2_tarea1() {
        $category = $this->category;
        $role = $this->role;
        $user = $this->user;
       
        $this->browse(function (Browser $browser) use ($category, $role, $user){
         $browser->visit('/')
            ->pause(500)
            ->screenshot('s2-1-0')
            ->click('@perfil')
            ->pause(500)
            ->assertSee('Iniciar sesión')
            ->assertSee('Registrarse')
            ->assertDontSee('Perfil')
            ->assertDontSee('Finalizar sesión')
            ->screenshot('s2-1-1')
            ->click('@login')
            ->pause(500)
            ->type('email' , 'pococho@gmail.com')
            ->type('password', 'poco1234')
            ->pause(500)
            ->screenshot('s2-1-2')
            ->press('INICIAR SESIÓN')
            ->pause(600)
            ->screenshot('s2-1-3')
            ->click('@perfilLogued')
            ->pause(500)
            ->assertSee('Perfil')
            ->assertSee('Finalizar sesión')
            ->assertDontSee('Iniciar sesión')
            ->assertDontSee('Registrarse')
            ->screenshot('s2-1-4')

            ;
            
        });
    }

    public function test_s2_tarea2(){
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
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'interior',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'exterior',
        ]);
        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);
        $p4 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'cocina',
        ]);
        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);
        $p5 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'habitaciones',
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($p1, $p2, $p3, $p4, $p5){
            $browser->visit('/')
            ->pause(500)
            ->assertSee($p1->name)
            ->assertSee($p2->name)
            ->assertSee($p3->name)
            ->assertSee($p4->name)
            ->assertSee($p5->name)
            ->screenshot('s2-2');
        });
    }

    public function test_s2_tarea3(){
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
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'interior',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $p3 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'exterior',
        ]);
        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);
        $p4 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'cocina',
        ]);
        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);
        $p5 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'habitaciones',
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        $p6 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'status' => 1,
            'name' => 'dormitorio',
        ]);
        Image::factory()->create([
            'imageable_id' => $p5->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($p1, $p2, $p3, $p4, $p5 , $p6) {
            $browser->visit('/')
            ->pause(500)
            ->assertSee($p1->name)
            ->assertSee($p2->name)
            ->assertSee($p3->name)
            ->assertSee($p4->name)
            ->assertSee($p5->name)
            ->assertDontSee($p6->name)
            ->screenshot('s2-3');
        });
    }
    public function test_s2_tarea4() {
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
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'coche',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category,$brand,$p1,$p2) {
            $browser->visit('/categories/' . $category->slug)
                ->pause(600)
                ->assertSee('Subcategorías')
                ->assertSee('Marcas')
                ->assertSee($p1->name)
                ->assertSee($p2->name)
                ->screenshot('s2-4');
        });
    }

    public function test_s2_tarea5() {
        $brand = Brand::factory()->create([
            'name' => 'marca',
        ]);
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
       
        $brand2 = Brand::factory()->create([
            'name' => 'wizard',
        ]);
        $category->brands()->attach($brand2->id);
        $category2 = Category::factory()->create([
            'name' => 'categoria2',
            'slug' => 'categoria2',
            'icon' => 'categoria2',
        ]);
        $category2->brands()->attach($brand2->id);
        $subcategory2 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'subcategoria2',
            'slug' => 'subcategoria2',
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'casa',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $p2 = Product::factory()->create([
            'subcategory_id' => $subcategory2->id,
            'name' => 'coche',
        ]);
        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($category, $subcategory, $subcategory2, $brand,$brand2 , $p1 , $p2) {
            $browser->visit('/categories/' . $category->slug)
                ->pause(600)
                ->assertSee('Subcategorías')
                ->assertSee('Marcas')
                ->assertSee($p1->name)
                ->assertSee($p2->name)
                ->screenshot('s2-5-1')
                ->clickLink($subcategory2->name)
                ->pause(500)
                ->assertDontSee($p1->name)
                ->assertSee($p2->name)
                ->screenshot('s2-5-2')
                ->clickLink($brand->name)
                ->pause(500)
                ->screenshot('s2-5-3')
                ;
        });
    }


    public function test_s2_tarea6() {
        $brand = Brand::factory()->create([
            'name' => 'marca',
        ]);
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
            'slug' => 'casa',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($p1) {
            $browser->visit('/products/' . $p1->name)
                ->pause(600)
                ->assertSee($p1->name)
                ->screenshot('s2-6-1');
        });
    }

    public function test_s2_tarea7() {
        $brand = Brand::factory()->create([
            'name' => 'marca',
        ]);
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
            'slug' => 'casa',
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($p1) {
            $browser->visit('/products/' . $p1->name)
                ->pause(600)
                ->assertSee($p1->description)
                ->assertSee($p1->name)
                ->assertSee($p1->price)
                ->assertSee($p1->quantity)
                ->assertSee($p1->description)
                ->screenshot('s2-7');
        });
    }

    public function test_s2_tarea8() {
        $brand = Brand::factory()->create([
            'name' => 'marca',
        ]);
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
            'slug' => 'casa',
            'quantity' => 2,
        ]);
        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $this->browse(function (Browser $browser) use ($p1) {
            $browser->visit('/products/' . $p1->name)
                ->pause(600)
                ->screenshot('s2-8-1')
                ->press('+')
                ->pause(600)
                ->assertSee($p1->quantity = 2)
                ->screenshot('s2-8-2')
                ->press('-')
                ->pause(600)
                ->assertSee($p1->quantity = 1)
                ->screenshot('s2-8-3');
        });
    }

    public function test_s2_tarea9() {
        $brand = Brand::factory()->create([
            'name' => 'marca',
        ]);
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
            'color' => true,
            'size' => true
        ]);
        $p1 = Product::factory()->create([
            'subcategory_id' => $subcategory->id,
            'name' => 'casa',
            'slug' => 'casa',
            'quantity' => 2,
        ]);
        $image = Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);
        $size = Size::factory()->create([
            'product_id' => $p1->id,
            'name' => 'talla',
        ]);

        $color = Color::factory()->create([
            'name' => 'azul',
        ]);
        $p1->colors()->attach([$color->id => ['quantity' => 10]  ]);
    
       

     
        $this->browse(function (Browser $browser) use ($p1, $category, $subcategory, $color , $size,$brand , $image) {
            $browser->visit('/products/' . $p1->name)
                ->pause(600)
                ->assertSee('Seleccione una talla')
                ->assertSee('Seleccione un color')
                ->screenshot('s2-9-1')
                ->click('@talla')
                ->pause(600)
                ->assertSee($size->name)
                ->screenshot('s2-9-2')
                ->click('@color')
                ->pause(600)
                ->screenshot('s2-9-3');
        });
    }


    

}