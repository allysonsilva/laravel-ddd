<?php

namespace App\Support\Repository\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Support\Repository\Eloquent\Operations\{
    RepositoryCreate as RepositoryCreateOperation,
    RepositoryRead as RepositoryReadOperation,
    RepositoryUpdate as RepositoryUpdateOperation,
    RepositoryDelete as RepositoryDeleteOperation
};
use Illuminate\Container\Container as BaseApplication;
use App\Support\Repository\Exceptions\RepositoryException;
use App\Support\Repository\Eloquent\Traits\HandleCriteria;
use App\Support\Repository\Eloquent\Traits\CacheableRepository;
use App\Support\Repository\Eloquent\Contracts\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    use RepositoryCreateOperation,
        RepositoryReadOperation,
        RepositoryUpdateOperation,
        RepositoryDeleteOperation,
        HandleCriteria,
        CacheableRepository;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $entity;

    /** @var \Illuminate\Foundation\Application */
    protected $app;

    public function __construct(BaseApplication $container)
    {
        $this->criteria = app(Collection::class);
        $this->entity = $this->resolveEntity();
        $this->app = $container;

        $this->boot();
    }

    abstract public function entity(): string;
    abstract public function domain(): string;

    public function boot()
    {
        //
    }

    public function reset()
    {
        $this->entity = $this->resolveEntity();

        $this->resetCache();
        $this->resetCriteria();
    }

    protected function resolveEntity(): Model
    {
        $entity = app($this->entity());

        if (! $entity instanceof Model) {
            throw new RepositoryException(
                "Class {$this->entity()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }

        return $entity;
    }

    public function __get(string $name)
    {
        return $this->entity->{$name};
    }

    /**
     * Forward all method calls to {\Illuminate\Database\Eloquent\Model}.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return $this
     */
    public function __call(string $method, array $parameters): self
    {
        $this->entity = call_user_func_array([$this->entity, $method], $parameters);

        return $this;
    }
}
