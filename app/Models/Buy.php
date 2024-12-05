<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    protected $guarded=['id'];
    public function material(){
        return $this->belongsTo(Material::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
