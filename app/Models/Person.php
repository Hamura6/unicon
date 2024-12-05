<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded=['id'];
    public function user(){
        return $this->hasOne(User::class);
    }
    public function customer(){
        return $this->hasOne(Customer::class);
    }
    public function supplier(){
        return $this->hasOne(Supplier::class);
    }
}
