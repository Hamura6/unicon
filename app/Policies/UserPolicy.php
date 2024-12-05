<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;
    public function view(User $user, User $model)
    {
        return $user->can('Ver usuarios');
    }
    public function create(User $user)
    {
        return $user->can('Crear usuario');
    }
    public function update(User $user, User $model)
    {
        return $user->can('Editar usuario');
    }
    public function delete(User $user, User $model)
    {
        return $user->can('Eliminar usuario');
    }
    public function permisos(User $user, User $model)
    {
        return $user->can('Ver permisos');
    }




    public function roles(User $user, User $model)
    {
        return $user->can('Ver roles');
    }
    public function rolc(User $user)
    {
        return $user->can('Crear rol');
    }
    public function roled(User $user, User $model)
    {
        return $user->can('Editar rol');
    }
    public function roleli(User $user, User $model)
    {
        return $user->can('Eliminar rol');
    }


    
}
