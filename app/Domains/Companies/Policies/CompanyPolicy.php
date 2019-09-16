<?php

namespace App\Domains\Companies\Policies;

use App\Units\Auth\User;
use App\Domains\Companies\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any companies.
     *
     * @param  \App\Units\Auth\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return mixed
     */
    public function view(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can create companies.
     *
     * @param  \App\Units\Auth\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the company.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can delete the company.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can restore the company.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return mixed
     */
    public function restore(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the company.
     *
     * @param  \App\Units\Auth\User  $user
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return mixed
     */
    public function forceDelete(User $user, Company $company)
    {
        //
    }
}
