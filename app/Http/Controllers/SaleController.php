<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function show($id)
    {
        $sale=Sale::find($id);
        return view('sale.edit',compact('sale'));
    }
    public function reportUser($id,$from,$to){
        $from=Carbon::parse($from);
        $to=Carbon::parse($to);
        $informations=User::where('id',$id)->
        with(['sales'=>function($q)use($from,$to){
            $q->where('estado','Ejecutado')
            ->when($from, fn ($q, $start) => $q->whereDate('updated_at', '>=', $start))
            ->when($to, fn ($q, $to) => $q->whereDate('updated_at', '<=', $to));
        }])->first();
        return view('sale.report',compact('informations','from','to'));
    }
}
