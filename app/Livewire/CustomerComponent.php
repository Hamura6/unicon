<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Person;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Permission;

use function Laravel\Prompts\text;

class CustomerComponent extends Component
{
    use AuthorizesRequests, WithPagination;

    public $nombre,$apellido,$ci,$telefono,$search;
    public $email;
    public $create=true,$id;

    public function mount(){
        
        $this->authorize('view',Customer::make());

    }
    public function render()
    {
        $customers=Person::join('customers as s','s.person_id','people.id')
        ->where('nombre','LIKE','%'.$this->search.'%')
        ->orWhere('apellido','LIKE','%'.$this->search.'%')
        ->orWhere('telefono','LIKE','%'.$this->search.'%')
        ->orWhere('ci','LIKE','%'.$this->search.'%')
        ->orderBy('nombre','asc')->take(50)->paginate(10);
        return view('livewire.customers.customer-component',compact('customers'))
        ->layout('layouts.base');
    }
    protected function rules(){
        if($this->id){
            $customer_id=Person::find($this->id)->customer->id;
        }else{

            $customer_id=null;
        }
        return [
            'nombre' => 'required|string|min:3|string',
            'apellido' => 'required|string|min:3|string',
            'telefono' => 'required|numeric|digits:8|unique:people,telefono,' . $this->id,
            'email' => 'email|unique:customers,email,' . $customer_id   ,
            'ci' => 'required|numeric|digits_between:7,12|unique:people,ci,' . $this->id
        ];
    }
    public function store(){
        $this->Validate();
        $person=Person::create([
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'ci'=>$this->ci,
            'telefono'=>$this->telefono,
            'email'=>$this->email,
        ]);
        $person->customer()->create([
            'email'=>$this->email
        ]);
        $this->dispatch('closeModal');
        $this->dispatch('notify',text:'El cliente se registro correctamente',title:'Se registro un cliente',icon:'success');
        $this->clear();
    }
    public function update(){
        $this->Validate();
        $person=Person::find($this->id);
        $person->update([
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'ci'=>$this->ci,
            'telefono'=>$this->telefono,
            'email'=>$this->email,
        ]);
        $person->customer()->update([
            'email'=>$this->email
        ]);
        $this->dispatch('closeModal');
        $this->dispatch('notify',text:'Los datos del cliente se actualizo correctamente',title:'Registro actualizado',icon:'success');
        $this->clear();
    }
    public function edit($id){
        $person=Person::find($id);
        $this->nombre=$person->nombre;
        $this->apellido=$person->apellido;
        $this->ci=$person->ci;
        $this->telefono=$person->telefono;
        $this->email=$person->customer->email;
        $this->id=$person->id;
        $this->create=false;
    }
    protected $listeners=['delete'=>'delete'];
    public function delete($id){
        Person::find($id)->delete();
        $this->dispatch('notify',text:'El cliente fue eliminado correctamente',title:'Registro eliminado',icon:'info');
    }
    public function clear(){
        $this->reset();
        $this->resetValidation();
    }
}
