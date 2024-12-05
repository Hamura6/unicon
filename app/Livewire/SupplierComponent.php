<?php

namespace App\Livewire;

use App\Models\Person;
use App\Models\Supplier;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Permission;

class SupplierComponent extends Component
{
    use AuthorizesRequests, WithPagination;
    public $supplier=[];
    public $create,$search;
    protected $listeners=['delete'=>'destroy'];
    public function mount()
    {

        $this->supplier['id']=null;
        $this->create=true;
        $this->authorize('view',Supplier::make());

    }
    protected function rules(){
        return[
            'supplier.nombre'=>'required|string|min:3',
            'supplier.apellido'=>'required|string|min:3',
            'supplier.telefono'=>'required|numeric|digits:8|unique:people,telefono,'.$this->supplier['id'],
            'supplier.ci'=>'required|numeric|digits_between:7,12|unique:people,ci,'.$this->supplier['id'],
            'supplier.empresa'=>'required|string|min:4'
        ];
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $suppliers=Person::join('suppliers as s','s.person_id','people.id')
        ->where('nombre','LIKE','%'.$this->search.'%')
        ->orWhere('empresa','LIKE','%'.$this->search.'%')
        ->orWhere('apellido','LIKE','%'.$this->search.'%')
        ->orWhere('telefono','LIKE','%'.$this->search.'%')
        ->orWhere('ci','LIKE','%'.$this->search.'%')
        ->orderBy('nombre','asc')->take(50)->paginate(10);
        return view('livewire.suppliers.supplier-component',compact('suppliers'))
        ->layout('layouts.base');
    }
    public function store()
    {
        $this->validate();
        $person = Person::create(collect($this->supplier)->except('empresa')->toArray());
        $person->supplier()->create(['empresa'=>$this->supplier['empresa']]);
        $this->dispatch('closeModal');
        $this->notify('Proveedor registrado','El proveedor fue registrado correctamente','success');
        $this->clear();
    }
    public function edit(Supplier $supplier)
    {
        $this->supplier['empresa']=$supplier->empresa;
        $this->supplier['nombre']=$supplier->person->nombre;
        $this->supplier['id']=$supplier->person->id;
        $this->supplier['apellido']=$supplier->person->apellido;
        $this->supplier['ci']=$supplier->person->ci;
        $this->supplier['telefono']=$supplier->person->telefono;
        $this->create=false;
    }
    public function update()
    {
        $this->validate();
        $person=Person::find($this->supplier['id']);
        $person->update(collect($this->supplier)->except('empresa')->toArray());
        $person->supplier()->update(['empresa'=>$this->supplier['empresa']]);
        $this->dispatch('closeModal');
        $this->clear();
        $this->notify('Proveedor actualizado','Los datos del proveedor fueron actualizados','info');
    }
    public function destroy($id)
    {
        Person::find($id)->delete();
    }
    public function changeStatus(Supplier $supplier)
    {
        if($supplier->person->estado=='Activo')
        $supplier->person->estado='Bloqueado';
        else
        $supplier->person->estado='Activo';
        $supplier->person->save();
        $this->notify('Proveedor '.$supplier->person->estado,'El proveedor fue '.$supplier->person->estado,'info');
    }
    public function clear()
    {
        $this->resetValidation();
        $this->reset();
        $this->create=true;
    }
    public function notify($title,$text,$icon){
        $this->dispatch('notify',text:$text,title:$title,icon:$icon);
    }
}
