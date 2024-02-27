<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Order;

class ShowProducts extends Component
{
    use WithPagination;

    public $search;

    public $orderBy = 'name'; 
    public $orderDirection = 'asc';


    public function sortBy($column)
{
    if ($this->orderBy === $column) {
        $this->orderDirection = $this->orderDirection === 'asc' ? 'desc' : 'asc';
    } else {
        $this->orderBy = $column;
        $this->orderDirection = 'asc';
    }
}

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $query = Product::query();
    
       
        if ($this->search) {
            $query->where('name', 'LIKE', "%{$this->search}%");
        }
    
       
        if ($this->orderBy == 'sold') {
            $query->orderBy('sold', $this->orderDirection);
        } elseif ($this->orderBy == 'reserved') {
            $query->orderByReservedQuantity($this->orderDirection);
        } else {
        
            $query->orderBy('name', 'asc');
        }
    
      
        $products = $query->paginate(10);
    
        return view('livewire.admin.show-products', compact('products'))->layout('layouts.admin');
    }
}
