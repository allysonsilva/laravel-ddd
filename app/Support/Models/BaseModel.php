<?php

namespace App\Support\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class BaseModel extends EloquentModel
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * [MODEL EVENTS]
     *
     * The "booting" method of the model.
     *
     * @see https://laravel.com/docs/eloquent#events
     */
    protected static function boot()
    {
        parent::boot();

        // Setup event bindings...

        // In case of new object,
        // It's useful to track before a sucessful save in the database
        static::creating(function (EloquentModel $model) {
            // write any code.
        });

        // In case of new object,
        // It's useful to track after a sucessful save in the database
        static::created(function (EloquentModel $model) {
            // write any code.
        });

        // In case of existing object,
        // It's useful to track before a sucessful save in the database
        static::updating(function (EloquentModel $model) {
            // write any code.
        });

        // In case of existing object,
        // It's useful to track after a sucessful save in the database
        static::updated(function (EloquentModel $model) {
            // write any code.
        });

        // It's useful to track before a sucessful save in the database
        static::saving(function (EloquentModel $model) {
            // write any code.
        });

        // It's useful to track after a sucessful save in the database
        static::saved(function (EloquentModel $model) {
            // write any code.
        });

        // It's useful to track before successful delete
        static::deleting(function (EloquentModel $model) {
            // write any code.
        });

        // It's useful to track after successful delete
        static::deleted(function (EloquentModel $model) {
            // write any code.
        });

        // Incase of soft delete,
        // It's useful to track before successfully restored.
        // static::restoring(function(EloquentModel $model) {
            // write any code.
        // });

        // Incase of soft delete,
        // It's useful to track after successfully restored.
        // static::restored(function(EloquentModel $model) {
            // write any code.
        // });
    }

    /**
     * Save model to the database using transaction without running any events.
     *
     * @param  array  $options
     *
     * @return bool
     *
     * @throws \Throwable
     */
    public function saveQuietly(array $options = []): bool
    {
        return static::withoutEvents(function() use ($options): bool {
            return $this->saveOrFail($options);
        });
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new BaseCollection($models);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new BaseEloquentBuilder($query);
    }

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query(): BaseEloquentBuilder
    {
        return parent::query();
    }
}
