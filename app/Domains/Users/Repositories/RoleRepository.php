<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Models\Role;
use App\Support\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Collection as SupportCollection;
use App\Domains\Users\Repositories\Criteria\UserPermissionCriteria;

class RoleRepository extends BaseRepository
{
    /**
     * For global tags in repository cache.
     *
     * @var array
     */
    protected $rememberCacheTag = ['roles', 'repository', 'cache'];

    protected const __DOMAIN = 'Users';

    public function entity(): string
    {
        return Role::class;
    }

    public function domain(): string
    {
        return self::__DOMAIN;
    }

    /**
     * User role mapping {id, name}.
     *
     * @param array $exceptRoleCode
     * @param string $columnLatest
     *
     * @return \Illuminate\Support\Collection
     */
    public function mapRoles(array $exceptRoleCode = [], string $columnLatest = 'level'): SupportCollection
    {
        $this->pushCriteria(UserPermissionCriteria::class);

        $this->applyCriteria();

        $results = $this->entity
                        ->whereNotIn('roles.code', $exceptRoleCode)
                        ->latest($columnLatest)
                        ->get(['id', 'name'])
                        ->pluck('name', 'id');

        $this->reset();

        return $results;
    }
}
