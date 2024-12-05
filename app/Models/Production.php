<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $guarded=['id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class,'production_product')
        ->withPivot('cantidad','bajas');
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('entrada','salida')
        ->using(UserProduction::class);
    }
    public function material(){
        return $this->belongsTo(Material::class);
    }
}
