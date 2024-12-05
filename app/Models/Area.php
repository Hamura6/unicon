<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded=['id'];
    public function sale(){
        return $this->belongsTo(Sale::class);
    }
}
