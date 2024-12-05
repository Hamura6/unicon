<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProduction extends Pivot
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function production(){
        return $this->belongsTo(Production::class);
    }
    public function getEntradaAttribute(){
        return Carbon::parse($this->attributes['entrada'])->format('H:i');
    }
    public function getSalidaAttribute(){
        
        return Carbon::parse($this->attributes['salida'])->format('H:i');
    }
    public function getHourAttribute()
    {
        $start = Carbon::parse($this->attributes['entrada']);
        $end = Carbon::parse($this->attributes['salida']);
         /* $allhour = $start->diffForHumans($end);  */
        $allhour = $start->diffInSeconds($end);
         return $allhour;
    }
}
