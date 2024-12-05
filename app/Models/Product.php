<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Product extends Model
{
    protected $guarded=['id'];
    public function getImagenAttribute()
    {
        if($this->foto)
        {
            return file_exists(public_path('storage/products/'.$this->foto))?
        asset('storage/products/'.$this->foto):
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
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'product_sale')
                    ->withPivot('cantidad', 'precio'); // Si deseas acceder a las fechas de creación y actualización
    }
    public function productions(){
        return $this->belongsToMany(Production::class,'production_product')
        ->withPivot('cantidad','bajas');
    }
}
