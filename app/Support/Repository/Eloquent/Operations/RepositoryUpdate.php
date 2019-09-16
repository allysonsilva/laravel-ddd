<?php

namespace App\Support\Repository\Eloquent\Operations;

use Illuminate\Database\Eloquent\Model;

trait RepositoryUpdate
{
    /**
     * Update a entity in repository by id or model instance.
     *
     * @param array $attributes
     * @param int|\Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    public function update(array $attributes, $model): bool
    {
        if (! $model instanceof Model)
            $model = $this->entity->findOrFail($model);

        $model->fill($attributes);

        $wasSaved = $model->saveOrFail();

        $this->reset();

        // event(new RepositoryEntityUpdated($this, $model));

        return $wasSaved;
    }
}
