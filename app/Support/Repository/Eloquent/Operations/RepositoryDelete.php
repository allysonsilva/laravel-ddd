<?php

namespace App\Support\Repository\Eloquent\Operations;

use Illuminate\Database\Eloquent\Model;
use App\Support\Repository\Eloquent\Criteria\FindWhere;

trait RepositoryDelete
{
    /**
     * Destroy the models for the given IDs.
     *
     * @param  \Illuminate\Support\Collection|array|int  $ids
     *
     * @return int Total of records removed from the database.
     */
    public function destroy($ids): int
    {
        $this->applyCriteria();

        $countDeleted = $this->entity->destroy($ids);

        $this->reset();

        return $countDeleted;
    }

    /**
     * Delete the model from the database.
     *
     * @param int|\Illuminate\Database\Eloquent\Model $model
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete($model):? bool
    {
        if (! $model instanceof Model)
            $model = $this->entity->findOrFail($model);

        $hasDeleted = $model->delete();

        $this->reset();

        return $hasDeleted;
    }

    /**
     * Delete multiple models by multiple fields.
     *
     * @param array $where
     *
    * @example
     *  $posts = $this->repository->deleteWhere([
     *      //Default Condition =
     *      'category_id' => '2',
     *      'user_id' => '1',
     *      //Custom Condition
     *      ['column_name', '>', '10']
     *  ]);
     *
     * @return bool|null
     */
    public function deleteWhere(array $where):? bool
    {
        $hasDeleted = $this->withCriteria(app(FindWhere::class, ['conditions' => $where]))->delete();

        // event(new RepositoryEntityDeleted($this, $this->entity->getModel()));

        $this->reset();

        return $hasDeleted;
    }
}
