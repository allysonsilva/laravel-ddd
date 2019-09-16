<?php

namespace App\Domains\Suppliers\Policies;

use App\Units\Auth\User;
use App\Domains\Suppliers\Models\Supplier;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any suppliers.
     *
     * @param  \App\Units\Auth\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the supplier.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\=App\Domains\Suppliers\Models\Supplier  $supplier
     * @return mixed
     */
    public function view(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can create suppliers.
     *
     * @param  \App\Units\Auth\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the supplier.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\=App\Domains\Suppliers\Models\Supplier  $supplier
     * @return mixed
     */
    public function update(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can delete the supplier.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\=App\Domains\Suppliers\Models\Supplier  $supplier
     * @return mixed
     */
    public function delete(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can restore the supplier.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\=App\Domains\Suppliers\Models\Supplier  $supplier
     * @return mixed
     */
    public function restore(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the supplier.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\=App\Domains\Suppliers\Models\Supplier  $supplier
     * @return mixed
     */
    public function forceDelete(User $user, Supplier $supplier)
    {
        //
    }
}
