<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable = ['name', 'slug', 'description', 'price', 'subcategory_id', 'brand_id', 'quantity', 'sold'];

    //protected $guarded = ['id', 'created_at', 'updated_at'];
    public function sizes() {
        return $this->hasMany(Size::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function colors() {
        return $this->belongsToMany(Color::class)->withPivot('quantity', 'id');
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getRouteKeyName() {
        return 'slug';
    }
    public function reservedQuantity()
    {
        return \DB::table('orders')
                    ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                    ->where('orders.status', '=', 1)
                    ->where('order_items.product_id', $this->id)
                    ->sum('order_items.quantity');
    }
    
    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }
}