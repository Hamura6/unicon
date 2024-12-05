<?php

namespace App\Livewire;

use App\Models\Material;
use App\Models\Product;
use App\Models\Production;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductionComponent extends Component
{
    use AuthorizesRequests, WithPagination;
    public $create=true, $product = [],$workers=[],$production=[],$dateFrom,$dateTo;
    public function mount(){
        
        $this->authorize('view',Production::make());

        $this->product[]['quantity'] = '';
    }
    protected function rules()
    {
        return [
            'product' => 'required',
            'product.*.product_id' => 'required|not_in:Elegir|distinct',
            'product.*.cantidad' => 'required|numeric|between:1,9999|not_in:nullable',
            'product.*.bajas' => 'nullable|numeric|between:0,9999',
            'production.material_id' => 'required|numeric|not_in:Elegir',
            'production.cantidad' => 'required|numeric|between:1,9999',
            'workers'=>'nullable',
            'workers.*.user_id'=>'required|not_in:Elegir|distinct',
            'workers.*.entrada'=>'required|date_format:H:i',
            'workers.*.salida'=>'required|date_format:H:i|after:workers.*.entrada',
        ];
    }
    public function render()
    {
        $productions=Production::
        when($this->dateFrom,fn($q,$start)=>$q->whereDate('created_at','>=',$start))
        ->when($this->dateTo,fn($q,$end)=>$q->whereDate('created_at','<=',$end))
        ->orderBy('id','desc')->take(50)->paginate(10);
        $products=Product::where('categoria','Plastaformo')->get();
        $materials=Material::where('stock','>',1)->get();
        $users = User::permission('Encargado produccion')->get();
        return view('livewire.productions.production-component',compact('productions','products','materials','users'))
        ->layout('layouts.base');
    }
    public function add()
    {
        $this->product[]['quantity'] = '';
    }
    public function reduce()
    {
        if (count($this->product) >= 2) {
            array_pop($this->product);
        }
    }
    public function addW()
    {
        $this->workers[]['user_id'] = '';
    }
    public function reduceW()
    {
        if (count($this->workers) >= 2) {
            array_pop($this->workers);
        }
    }
    public function store()
    {
        $this->validate();
        $production=Auth::user()->productions()->create([
            'cantidad'=>$this->production['cantidad'],
            'material_id'=>$this->production['material_id']
        ]);
        foreach ($this->product as $p) {
            $production->products()->attach($p['product_id'], [
                'cantidad' => $p['cantidad'],
                'bajas' => !empty($p['bajas'])?$p['bajas']:0
            ]);
        }
        foreach ($this->workers as $w) {
            $production->users()->attach($w['user_id'], [
                'entrada' => $w['entrada'],
                'salida' => $w['salida']
            ]);
        }
        $this->dispatch('closeModal');
        $this->notify('Produccion agregada','Se agrego una nueva produccion exitosamente','success');
        $this->clear();
    }
    public function edit(Production $production)
    {
        $this->production['id'] = $production->id;
        $this->production['cantidad'] = $production->cantidad;
        $this->production['material_id'] = $production->material_id;
        $this->production['user_id'] = $production->user->full_name;
        $this->create = false;
        foreach ($production->products as $key => $product) {
            $this->product[$key]['cantidad'] = $product->pivot->cantidad;
            $this->product[$key]['bajas'] = $product->pivot->bajas;
            $this->product[$key]['product_id'] = $product->pivot->product_id;
        }
        foreach ($production->users as $key => $user) {
            $this->workers[$key]['entrada'] = $user->pivot->entrada;
            $this->workers[$key]['salida'] = $user->pivot->salida;
            $this->workers[$key]['user_id'] = $user->pivot->user_id;
        }
    }
    public function update()
    {
        $this->validate();
        $production=Production::find($this->production['id']);
        $production->update([
            'cantidad'=>$this->production['cantidad'],
            'material_id'=>$this->production['material_id']
        ]);
        $production->products()->detach();
        $production->users()->detach();
        foreach ($this->product as $p) {
            $production->products()->attach($p['product_id'], [
                'cantidad' => $p['cantidad'],
                'bajas' => !empty($p['bajas'])?$p['bajas']:0
            ]);
        }
        foreach ($this->workers as $w) {
            $production->users()->attach($w['user_id'], [
                'entrada' => $w['entrada'],
                'salida' => $w['salida']
            ]);
        }
        $this->notify('Produccion actualizada','Los datos se actualizaron exitosamente','info');
        $this->dispatch('closeModal');
        $this->clear();
    }
    public function clear()
    {
        $this->reset();
        $this->product[]['quantity'] = '';
        $this->resetValidation();
        $this->create=true;
    }
    protected $listeners = ['delete' => 'destroy',
                            'next'=>'change'];
    public function change($id){
        $production=Production::find($id);
        $material=Material::find($production->material_id);
        if($material->stock < $production->cantidad){
            return $this->notity('Stock insuficiente','No se encontro material suficiente para esta produccion','error');
        }
        $material->decrement('stock',$production->cantidad);
        $production->estado='Concluido';
        $production->save(); 
        foreach($production->products as $product){
            $product->increment('stock',$product->pivot->cantidad);
        }
    }
    public function destroy($id)
    {
        $production=Production::find($id);
        $production->delete();
    }
    public function notify($title,$text,$icon){
        $this->dispatch('nofify',title:$title,text:$text,icon:$icon);
    }
}
