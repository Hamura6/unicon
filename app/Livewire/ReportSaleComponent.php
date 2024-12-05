<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportSaleComponent extends Component
{
    use AuthorizesRequests;
    public $dateFrom,$dateTo,$consult;
    public function mount(){
        $this->authorize('report',Sale::make());
    }
    public function render()
    {
        if($this->consult=='week')
        {
            $this->dateFrom = Carbon::parse($this->dateFrom)->startOfWeek();
            $this->dateTo = Carbon::parse($this->dateTo)->endOfWeek();
        }
        elseif($this->consult=='month')
        {
            $this->dateFrom = Carbon::parse($this->dateFrom)->startOfMonth();
            $this->dateTo = Carbon::parse($this->dateTo)->endOfMonth();
        }
        elseif($this->consult=='quarterly')
        {
            $this->dateFrom = Carbon::parse($this->dateFrom)->startOfMonth()->subMonth(2);
            $this->dateTo = Carbon::parse($this->dateTo)->endOfMonth();
        }
        elseif($this->dateFrom && $this->dateTo)
        {
            $this->dateFrom=Carbon::parse($this->dateFrom);
            $this->dateTo=Carbon::parse($this->dateTo);
        }
        else{

            $this->dateFrom = Carbon::parse($this->dateFrom)->startOfWeek();
            $this->dateTo = Carbon::parse($this->dateTo)->endOfWeek();
        }
        $users=User::with(['sales'=>function($query){
            $query->where('estado', 'Ejecutado');
        }])->whereHas('sales',function(Builder $q){
            $q->where('estado', 'Ejecutado')
            ->when($this->dateFrom, fn ($q, $start) => $q->whereDate('updated_at', '>=', $start))
            ->when($this->dateTo, fn ($q, $to) => $q->whereDate('updated_at', '<=', $to));
        },'>=',1)
        ->get();
        
        return view('livewire.report.report-sale-component',compact('users'))
        ->layout('layouts.base');
    }
}
