<?php

namespace App\Support\Repository\Eloquent\Operations;

trait RepositoryCreate
{
    /**
     * Save the model to the database using transaction.
     *
     * @param array $attributes
     *
     * @return bool
     *
     * @throws \Throwable
     */
    public function store(array $attributes): bool
    {
        $entity = $this->entity->newInstance()->fill($attributes);

        $wasSaved = $entity->saveOrFail();

        $this->reset();

        // event(new RepositoryEntityCreated($this, $entity));

        return $wasSaved;
    }
}
