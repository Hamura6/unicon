<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    public function view(User $user)
    {
        return $user->hasPermissionTo('Ver permisos');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('Crear permisos');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('Editar permisos');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('Eliminar permisos');
    }
}
