<?php

namespace App\Domains\Suppliers\Repositories;

use App\Domains\Suppliers\Models\Supplier;
use App\Support\Repository\Eloquent\BaseRepository;

class SupplierRepository extends BaseRepository
{
    /**
     * For global tags in repository cache.
     *
     * @var array
     */
    protected $rememberCacheTag = ['suppliers', 'repository', 'cache'];

    protected const __DOMAIN = 'Suppliers';

    // Setting this property to NULL causes the cache to be forever.
    // protected $cacheSeconds;

    public function entity(): string
    {
        return Supplier::class;
    }

    public function domain(): string
    {
        return self::__DOMAIN;
    }

    /**
     * @inheritDoc
     */
    public function store(array $attributes): bool
    {
        $entity = $this->entity->newInstance()->fill($attributes);

        $wasSaved = $entity->saveOrFail();

        $entity->sendLinkToSupplierActivationNotification();

        $this->reset();

        // event(new RepositoryEntityCreated($this, $entity));

        return $wasSaved;
    }
}
