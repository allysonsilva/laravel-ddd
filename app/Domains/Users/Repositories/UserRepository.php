<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Models\User;
use App\Support\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * For global tags in repository cache.
     *
     * @var array
     */
    protected $rememberCacheTag = ['users', 'repository', 'cache'];

    protected const __DOMAIN = 'Users';

    // Setting this property to NULL causes the cache to be forever.
    // protected $cacheSeconds;

    public function entity(): string
    {
        return User::class;
    }

    public function domain(): string
    {
        return self::__DOMAIN;
    }

    /**
     * Salva o usuário, retornar o ID do novo usuário.
     *
     * @param array $attributes
     *
     * @return int|null
     */
    public function storeKeyResult(array $attributes):? int
    {
        $entity = $this->entity->newInstance()->fill($attributes);

        $wasSaved = $entity->saveOrFail();
        $userKey = $entity->getKey();

        $this->reset();

        return $userKey;
    }
}
