<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SupplierPolicy
{
    public function view(User $user, Supplier $model)
    {
        return $user->can('Ver proveedores');
    }
    public function create(User $user)
    {
        return $user->can('Crear proveedor');
    }
    public function update(User $user, Supplier $model)
    {
        return $user->can('Editar proveedor');
    }
    public function delete(User $user, Supplier $model)
    {
        return $user->can('Eliminar proveedor');
    }
}
