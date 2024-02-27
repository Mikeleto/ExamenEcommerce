<?php

namespace Tests\Browser\Tareas\Semana1;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Semana1Test extends DuskTestCase
{
    use DatabaseMigrations;

    /*
    * A basic browser test example.
    *
    * @return void
    */
    public function test_s1_tarea3() {
        $category = Category::factory()->create([
            'name' => 'INFORMATICA',
            'slug' => 'INFORMATICA',
            'icon' => '->',
        ]);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/')
                ->click('@categorias')
                ->assertSee($category)
                ->screenshot('s1-3');
        });
    }

    public function test_s1_tarea4() {
        $category = Category::factory()->create([
            'name' => 'INFORMATICA',
            'slug' => 'INFORMATICA',
            'icon' => '->',
        ]);
        $subcategory = Subcategory::factory()->create([
            'category_id' => $category->id,
            'name' => 'INFORMATICA',
            'slug' => 'INFORMATICA',
        
            
        ]);
        $this->browse(function (Browser $browser) use ($category, $subcategory) {
            $browser->visit('/')
                ->click('@categorias')
                ->assertSee($subcategory)
                ->screenshot('s1-4');
        });
    }

}