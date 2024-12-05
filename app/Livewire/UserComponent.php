<?php

namespace App\Livewire;

use App\Models\Person;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use function Laravel\Prompts\text;

class UserComponent extends Component
{
    use AuthorizesRequests, WithPagination;
    public $nombre,$apellido,$ci,$telefono,$estado;
    public $role,$email,$fecha_n,$direccion,$selector;
    public $id,$search,$create=true;
    public function mount(){
        $this->role='Elegir';
        $this->estado='Elegir';
        $this->authorize('view',User::make());


    }
    protected function rules()
    {
        if($this->id){
            $user_id=Person::find($this->id)->user->id;
        }else{
            $user_id=null;
        }
        return[
            'nombre'=>'required|min:4',
            'apellido'=>'required|min:4',
            'role'=>'required|not_in:Elegir',
            'email'=>'required|email|unique:users,email,'.$user_id,
            'estado'=>'required|not_in:Elegir',
            'direccion'=>'required',
            'fecha_n'=>'required',
            'telefono'=>'required|digits:8|numeric|unique:people,telefono,'.$this->id,
            'ci'=>'required|digits_between:8,12|numeric|unique:people,ci,'.$this->id,
        ];
    }
    public function render()
    {
        $query = User::question();
        if (!empty($this->selector)) {
            $query->where('r.name', 'LIKE', '%' . $this->selector . '%');
        }
        
        if (!empty($this->search)) {
            $query->orWhere(function ($query) {
                $query->where('p.nombre', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('p.ci', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('p.apellido', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('p.estado', 'LIKE', '%' . $this->search . '%');
            });
        }
        
        $users = $query->take(50)->paginate(10);
        $roles=Role::OrderBy('name','asc')->get();
        return view('livewire.users.user-component',compact('users','roles'))
        ->layout('layouts.base');
    }
    public function store(){
        $this->validate();
        $person=Person::create([
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'ci'=>$this->ci,
            'telefono'=>$this->telefono,
            'estado'=>$this->estado
        ]);
        $user=$person->user()->create([
            'email'=>$this->email,
            'fecha_n'=>$this->fecha_n,
            'direccion'=>$this->direccion,
            'password'=>bcrypt($person->ci)
        ]);
        $user->assignRole((int)$this->role);
        $this->dispatch('closeModal');
        $this->dispatch('notify',text:'Usuario registrado exitosamente',title:'Registro almacenado',icon:'success');
        $this->clear();

    }
    public function update(){
        $this->validate();
        $person=Person::find($this->id);
        $person->update([
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'ci'=>$this->ci,
            'telefono'=>$this->telefono,
            'estado'=>$this->estado
        ]);
        $person->user()->update([
            'email'=>$this->email,
            'fecha_n'=>$this->fecha_n,
            'direccion'=>$this->direccion,
        ]);
        $this->dispatch('closeModal');
        $this->dispatch('notify',text:'Los datos del usuario se actualizaron correctamente',title:'Registro actualizado',icon:'success');
        $this->clear();
    }
    protected $listeners=['delete'=>'delete'];
    public function delete($id){
        Person::find($id)->delete();
        $this->dispatch('notify',text:'El usuario fue eliminado correctamente',title:'Registro eliminado',icon:'info');
    }
    public function edit($id){
        $person=Person::find($id);
        $this->nombre=$person->nombre;
        $this->apellido=$person->apellido;
        $this->ci=$person->ci;
        $this->telefono=$person->telefono;
        $this->estado=$person->estado;
        $this->email=$person->user->email;
        $this->direccion=$person->user->direccion;
        $this->fecha_n=$person->user->fecha_n;
        $this->id=$person->id;
        $this->create=false;
    }
    public function clear(){
        $this->reset();
        $this->resetValidation();
    }
    public function changeStatus(User $user)
    {
        $person=Person::find($user->person_id);
        if($person->estado=='Activo')
        {
            $person->estado='Bloqueado';
            $this->dispatch('notify',text:'El usuario '.$person->nombre.' fue bloqueado ',title:'Usuario bloqueado',icon:'info');

        }else
        {
            $person->estado='Activo';
            $this->dispatch('notify',text:'El usuario '.$person->nombre.'fue activado ',title:'Usuario activado',icon:'info');
        }
        $person->save();
    }
}
