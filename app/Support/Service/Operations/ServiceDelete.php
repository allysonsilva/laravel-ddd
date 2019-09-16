<?php

namespace App\Support\Service\Operations;

trait ServiceDelete
{
    /**
     * @param  \Illuminate\Support\Collection|array|int  $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->repository->destroy($ids);
    }

    /**
     * @param  int|\Illuminate\Database\Eloquent\Model  $modelOrId
     *
     * @return bool|null
     */
    public function delete($modelOrId):? bool
    {
        return $this->repository->delete($modelOrId);
    }
}
