<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded=['id'];
    public function buys(){
        return $this->hasMany(Buy::class);
    }
    public function productions(){
        return $this->hasMany(Production::class);
    }
    public function getImagenAttribute()
    {
        if($this->foto)
        {
            return file_exists(public_path('storage/materials/'.$this->foto))?
        asset('storage/materials/'.$this->foto):
        $this->defaultImagen();
        }
        else
        {
            return $this->defaultImagen();
        }
    }
    protected function defaultImagen()
    {
        $name = trim(collect(explode(' ', $this->nombre))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));
       /*  dd('https://ui-avatars.com/api/?name='.urlencode($name).'&background=random&color=0000ff'); */
        return'https://ui-avatars.com/api/?name='.urlencode($name).'&background=random&color=0000ff';
    }
}
