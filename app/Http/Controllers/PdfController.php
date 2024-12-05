<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Production;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


class PdfController extends Controller
{
    public function budget($codigo)
    {
        $sale = Sale::find($codigo);
        view()->share('Pdf.sales.budget', $sale);
        $pdf = pdf::loadView('Pdf.sales.budget', ['sale' => $sale]);
        return $pdf->stream('proforma');
    }
    public function reportSales($from, $to)
    {
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $users = User::with(['sales' => function ($query) {
            $query->where('estado', 'Ejecutado');
        }])->whereHas('sales', function (Builder $q) use ($from, $to) {
            $q->where('estado', 'Ejecutado')
                ->when($from, fn($q, $start) => $q->whereDate('updated_at', '>=', $start))
                ->when($to, fn($q, $to) => $q->whereDate('updated_at', '<=', $to));
        }, '>=', 1)
            ->get();
        view()->share('Pdf.sales.report', $users);
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $pdf = pdf::loadView('Pdf.sales.report', ['users' => $users, 'from' => $from, 'to' => $to]);
        return $pdf->stream('reporte');
    }
    public function reportProduction($from, $to)
    {
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $productions = Production::where('estado', 'Concluido')
            ->when($from, fn($q, $start) => $q->whereDate('updated_at', '>=', $start))
            ->when($to, fn($q, $end) => $q->whereDate('updated_at', '<=', $end))
            ->get();
        view()->share('Pdf.production.report', $productions);
        $pdf = pdf::loadView('Pdf.production.report', ['productions' => $productions]);
        return $pdf->stream('reporte.produccion');
    }
    public function reportProductionUser($from, $to)
    {
        $from = Carbon::parse($from)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($to)->format('Y-m-d') . ' 23:59:59';

        $users=User::with(['productions'=>function($q)use($from,$to){
            $q->where('estado','Concluido')
            ->when($from, fn ($d, $start) => $d->whereDate('updated_at', '>=', $start))
            ->when($to, fn ($d, $to) => $d->whereDate('updated_at', '<=', $to));
        }])
        ->whereHas('productions',function(Builder $q)use($from,$to){
            $q->where('estado','Concluido')->whereDate('updated_at', '>=', $from)
            ->whereDate('updated_at', '<=', $to);
        },'>=',1)->get();


        view()->share('Pdf.production.user', $users);
        $pdf = pdf::loadView('Pdf.production.user', ['users' => $users]);
        return $pdf->stream('reporte.produccion.usuarios');
    }
    public function reportBuys($from,$to){
        $buys=Buy::where('updated_at','>=',$from)
        ->where('updated_at','<=',$to)->get();

        view()->share('Pdf.buys.repor',$buys);
        $pdf=pdf::loadView('Pdf.buys.repor',['buys'=>$buys]);
        return $pdf->stream('reporte.compras');
    }
}
