<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded=['id'];
    public function person(){
        return $this->belongsTo(Person::class);
    }
    public function getFullNameAttribute(){
        return $this->person->nombre.' '.$this->person->apellido;

    }
    public function sales(){
        return $this->hasMany(Sale::class);
    } 
}
