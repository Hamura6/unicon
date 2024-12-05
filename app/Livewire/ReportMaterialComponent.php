<?php

namespace App\Livewire;

use App\Models\Buy;
use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ReportMaterialComponent extends Component
{
    use AuthorizesRequests;
    public $dateFrom, $dateTo,$consult;
    public function mount()
    {
        $this->authorize('report',Material::make());

        $this->report();
    }
    public function render()
    {
        $buys=Buy::where('updated_at','>=',$this->dateFrom)
        ->where('updated_at','<=',$this->dateTo)->get();
        return view('livewire.report.report-material-component',compact('buys'))
        ->layout('layouts.base');
    }
    public function report()
    {
        if($this->consult=='week')
        { $from = Carbon::parse(Carbon::now()->startOfWeek())->format('Y-m-d');
            $to = Carbon::parse(Carbon::now()->endOfWeek())->format('Y-m-d');

        }
        elseif($this->consult=='month')
        {
            $from = Carbon::parse(Carbon::now()->startOfMonth())->format('Y-m-d');
            $to = Carbon::parse(Carbon::now()->endOfMonth())->format('Y-m-d');
        }
        elseif($this->consult=='quarterly')
        {
            $from = Carbon::parse(Carbon::now()->startOfMonth())->subMonth(2)->format('Y-m-d');
            $to = Carbon::parse(Carbon::now()->endOfMonth())->format('Y-m-d');
        }
        elseif($this->dateFrom && $this->dateTo)
        {
            $from=Carbon::parse($this->dateFrom)->format('Y-m-d');
            $to=Carbon::parse($this->dateTo)->format('Y-m-d');
        }
        else{

            $from=Carbon::parse(Carbon::now()->startOfWeek())->format('Y-m-d');
            $to=Carbon::parse(Carbon::now()->endOfWeek())->format('Y-m-d');
        }
        $this->dateFrom=$from;
        $this->dateTo=$to;
    }
    public function resetReport()
    {
        $this->consult='Elegir';
        $from=Carbon::parse(Carbon::now()->startOfWeek())->format('Y-m-d');
        $to=Carbon::parse(Carbon::now()->endOfWeek())->format('Y-m-d');
    }
}
