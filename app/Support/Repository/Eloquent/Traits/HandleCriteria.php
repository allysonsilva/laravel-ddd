<?php

namespace App\Support\Repository\Eloquent\Traits;

use Illuminate\Support\Collection;
use App\Support\Repository\Exceptions\RepositoryException;
use App\Support\Repository\Eloquent\Contracts\CriterionInterface;

trait HandleCriteria
{
    /**
     * Collection of criterion.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $criteria;

    protected $skipAllCriteria = false;

    /**
     * Push Criteria for filter the query.
     *
     * @param $criterion
     * @param mixed $parameters
     *
     * @return $this
     *
     * @see https://www.php.net/manual/en/migration56.new-features.php#migration56.new-features.variadics
     *
     * @throws \App\Support\Repository\Exceptions\RepositoryException
     */
    public function pushCriteria($criterion, ...$parameters): self
    {
        if (is_string($criterion)) {
            $criterion = new $criterion(...$parameters);
        }

        if (! $criterion instanceof CriterionInterface) {
            throw new RepositoryException(
                "Class ". get_class($criterion) ." must be an instance of App\\Support\\Repository\\Eloquent\\Contracts"
            );
        }

        $this->criteria->push($criterion);

        return $this;
    }

    public function popCriteria(CriterionInterface $criterion): self
    {
        $this->criteria = $this->criteria->reject(function ($item) use ($criterion) {
            return get_class($item) === get_class($criterion);
        });

        return $this;
    }

    public function getByCriteria(CriterionInterface $criterion, string $method = 'get', ...$parameters)
    {
        $this->entity = $criterion->apply($this->entity, $this);

        $results = $this->entity->{$method}(...$parameters);

        $this->reset();

        return $results;
    }

    public function skipAllCriteria(bool $status = true): self
    {
        $this->skipAllCriteria = $status;

        return $this;
    }

    public function getAllCriteria(): Collection
    {
        return $this->criteria;
    }

    public function resetCriteria(): self
    {
        $this->criteria = app(Collection::class);

        return $this;
    }

    protected function applyCriteria() : self
    {
        if ($this->skipAllCriteria === true) {
            $this->skipAllCriteria(false);

            return $this;
        }

        /** @var \Illuminate\Support\Collection */
        $allCriteria = $this->getAllCriteria();

        if ($allCriteria->isNotEmpty()) {
            foreach ($allCriteria as $criterion) {
                if ($criterion instanceof CriterionInterface)
                    $this->entity = $criterion->apply($this->entity, $this);
            }
        }

        return $this;
    }

    /**
     * @example
     *      return $this->repository->withCriteria(
     *          new MyCriteria1([
     *              'name' => 'Name'
     *          ]),
     *          new MyCriteria2(),
     *          ...
     *      )->get();
     *
     * @param \App\Support\Repository\Contracts\CriterionInterface ...$collectionOfCriteria
     *
     * @return $this
     */
    public function withCriteria(CriterionInterface ...$collectionOfCriteria): self
    {
        foreach ($collectionOfCriteria as $criterion) {
            $this->entity = $criterion->apply($this->entity, $this);
        }

        return $this;
    }
}
