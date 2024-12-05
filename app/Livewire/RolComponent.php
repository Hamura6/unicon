<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolComponent extends Component
{
    use AuthorizesRequests, WithPagination;
    public $create,$search,$name='',$id;
    public function mount(){
        $this->authorize('roles',User::make());
        $this->name='';
        $this->create=true;
        $this->search='';
    }
    protected function rules(){
        return[
            'name'=>'required|unique:roles,name,'.$this->id
        ];
    }
    public function render()
    {
        $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')
        ->take(25)
        ->paginate(10);
        return view('livewire.roles.rol-component',compact('roles'))
        ->layout('layouts.base');
    }
    public function store(){
        $this->validate();
        Role::create([
            'name'=>$this->name
            ]); 
        $this->clear();
        $this->dispatch('closeModal'); 
        $this->dispatch('notify',
        text: 'Rol registrado correctamente',icon:'success',title:'Rol registrado');
        /* $this->emit('closeModal', [
            'text' => 'Registrado correctamente',
            'title' => 'Rol',
            'icon' => 'success',
            ]);
            */
        }
        public function edit($id){
            $role=Role::find($id);
            $this->name=$role->name;
            $this->dispatch('showModal');
            $this->create=false;
            $this->id=$role->id;
            
        }
        public function update(){
            $role=Role::find($this->id);
            $role->name=$this->name;
            $role->save();
            $this->dispatch('closeModal'); 
            $this->dispatch('notify',
            text: 'El rol fue actualizado correctamente',icon:'success',title:'Rol actualizado');
            $this->clear();
    }
    public function clear(){
        $this->create=true;
        $this->name='';
        $this->id=null;
        $this->resetValidation();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $listeners=['delete'=>'deleteRow'];
    public function deleteRow($id){
        Role::find($id)->delete();
    }
}
