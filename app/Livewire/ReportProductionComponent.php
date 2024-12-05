<?php

namespace App\Livewire;

use App\Models\Production;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ReportProductionComponent extends Component
{
    use AuthorizesRequests;
    public $dateFrom,$dateTo,$consult;
    public function mount()
    {
        $this->consult='';
        $this->report();
        $this->authorize('report',Production::make());


    }
    public function render()
    {
        $productions=Production::where('estado','Concluido')
        ->when($this->dateFrom,fn($q,$start)=>$q->whereDate('updated_at','>=',$start))
        ->when($this->dateTo,fn($q,$end)=>$q->whereDate('updated_at','<=',$end))
        ->get();
        return view('livewire.report.report-production-component',compact('productions'))
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
    {$from=Carbon::parse(Carbon::now()->startOfWeek())->format('Y-m-d');
        $to=Carbon::parse(Carbon::now()->endOfWeek())->format('Y-m-d');
        $this->dateFrom=$from;
        $this->dateTo=$to;
    }
}
