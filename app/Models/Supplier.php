<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded=['id'];
    public function person(){
        return $this->belongsTo(Person::class);
    }
    public function buys(){
        return $this->hasMany(Buy::class);
    }
}
