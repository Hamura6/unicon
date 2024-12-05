<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionComponent extends Component
{
    use AuthorizesRequests, WithPagination;
    public $role,$search;
    public function mount()
    {
        $this->authorize('permisos',User::make());

        $this->role='Elegir';
    }
    public function render()
    {
        $permissions=Permission::where('name','LIKE','%'.$this->search.'%')->select('name','id',DB::raw("0 as checked"))
        ->orderBy('id','asc')->take(40)->paginate(10);
        if($this->role != 'Elegir')
        {
            foreach($permissions as $permission)
            {
                $role=Role::find($this->role);
                $hasPermission=$role->hasPermissionTo($permission->id);
                if($hasPermission)
                {
                    $permission->checked=1;
                }
            }
        }
        $roles=Role::orderBy('name','asc')->get();
        return view('livewire.permission-component',compact('roles','permissions'))
        ->layout('layouts.base');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function  syncPermission($state,$permission)
    {
        if($this->role != 'Elegir')
        {
            $roleName=Role::find($this->role);
            if($state)
            {
                $roleName->givePermissionTo($permission);
                $this->dispatch('notify',text:'Permiso asignado exitosamente',title:'Permiso asignado',icon:'info');
            }
            else{
                $roleName->revokePermissionTo($permission);
                $this->dispatch('notify',text:'Permiso revocado exitosamente',title:'Permiso revocado',icon:'info');
            }

        }else{
            $this->dispatch('notify',text:'Seleccione un rol valido',title:'Error al asignar',icon:'error');
        }
    }
    public function syncAll()
    {
        if($this->role == 'Elegir')
        {
            $this->dispatch('notify',text:'Seleccione un rol valido',title:'Error al asignar',icon:'error');
            return;
        }
        $role=Role::find($this->role);
        $permission=Permission::pluck('id')->toArray();
        $role->syncPermissions($permission);
        $this->dispatch('notify',text:'Se assiganaron todos los permisos al rol '.$role->name,title:'Asignacion de permisos',icon:'info');
    }
    protected $listeners=['delete'=>'detach'];
    public function detach($id)
    {
        if($this->role == 'Elegir')
            return $this->dispatch('notify',text:'Seleccione un rol valido',title:'Revocar permisos',icon:'error');
        $role=Role::find($this->role);

        $role->syncPermissions([0]);
        $this->dispatch('notify',text:'Se revocaron todos los permisos del rol '.$role->name,title:'Permisos revocados',icon:'info');
    }
}
