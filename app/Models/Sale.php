<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    protected $guarded=['id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sale')
                    ->withPivot('cantidad', 'precio'); // Si deseas acceder a las fechas de creación y actualización
    }
    public function areas(){
        return $this->hasMany(Area::class);
    }
    public function getPriceAttribute()
    {
        return ($this->products->sum('pivot.precio') * 0.76) + ($this->comision + $this->transporte);
    }
    public function getPriceTotalAttribute()
    {
        return ($this->products->sum('pivot.precio')) + ($this->comision + $this->transporte);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
