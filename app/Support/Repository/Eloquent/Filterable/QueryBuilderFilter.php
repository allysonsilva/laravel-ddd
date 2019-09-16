<?php

namespace App\Support\Repository\Eloquent\Filterable;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use App\Support\Repository\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Clauses\WhereClause;
use App\Support\Repository\Eloquent\Filterable\Clauses as FilterableClauses;
use App\Support\Repository\Eloquent\Filterable\Constants as FilterableConstants;

abstract class QueryBuilderFilter
{
    /** @var \Illuminate\Http\Request */
    protected $request;

    /** @var \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  */
    protected $query;

    /** @var array */
    protected $custom = [];

    /**
     * Create a new repository filter instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->request = app(Request::class);
    }

    protected abstract function accepted(): array;

    public function build(object $builder, string $namespace = null): object
    {
        // if ($builder instanceof Model) {
        //     $builder = $builder->newModelQuery();
        // } elseif (! $builder instanceof QueryBuilder && ! $builder instanceof EloquentBuilder) {
        //     throw new RepositoryException(
        //         "\$builder parameter must be an instance of Illuminate\Database\Eloquent\Builder in $this"
        //     );
        // }

        $this->query =& $builder;

        if (method_exists($this, 'bootBuilderFilter')) {
            $this->bootBuilderFilter();
        }

        $this->applyFieldsToWheres();
        $this->applyConstantsToWheres();
        $this->applyCustomFiltersToWheres($namespace);

        return $this->query;
    }

    /**
     * @example
     *     array:3 [▼
     *       "orLike" => "App\Support\Repository\Eloquent\Filterable\Clauses\OrWhereLikeClause"
     *       "or" => "App\Support\Repository\Eloquent\Filterable\Clauses\OrWhereClause"
     *       "where" => "App\Support\Repository\Eloquent\Filterable\Clauses\WhereClause"
     *       "like" => "App\Support\Repository\Eloquent\Filterable\Clauses\WhereLikeClause"
     *     ]
     *
     * @param string|null $parameter
     *
     * @return array|string
     */
    private function listWhereClauses(?string $keyParameter = null)
    {
        static $listClauses = [];

        if (! empty($listClauses))
            return $listClauses[$keyParameter] ?? $listClauses;

        $getClauseQualifiedNamespace = function(string $className): string {
            return FilterableClauses::class. '\\' .Str::studly($className);
        };

        foreach (glob(__DIR__.DIRECTORY_SEPARATOR. 'Clauses' .DIRECTORY_SEPARATOR. '*.php') as $filename) {
            // get the file name of the current file without
            // the extension which is essentially the class name
            $className = basename($filename, '.php');

            // This is an identifier with a namespace separator, such as Foo\Bar.
            $clauseQualifiedNamespace = $getClauseQualifiedNamespace($className);

            if (class_exists($clauseQualifiedNamespace) &&
                ! empty($parameter = $clauseQualifiedNamespace::parameter())) {
                    $listClauses[$parameter] = $clauseQualifiedNamespace;
            }
        }

        return $listClauses[$keyParameter] ?? $listClauses;
    }

    private function keyToColumn(string $method, string $key)
    {
        if (! array_key_exists($key, $methodData = $this->{$method}())) {
            return;
        }

        return $methodData[$key];
    }

    private function onlyFieldsAcceptedInRequest(?string $key = null)
    {
        static $onlyFieldsAcceptedInRequest = [];

        if (! empty($onlyFieldsAcceptedInRequest))
            return $onlyFieldsAcceptedInRequest[$key] ?? $onlyFieldsAcceptedInRequest;

        /** @var array */
        $onlyFieldsAcceptedInRequest = request_filled(array_keys($this->accepted()));

        return $onlyFieldsAcceptedInRequest[$key] ?? $onlyFieldsAcceptedInRequest;
    }

    protected function applyFieldsToWheres(): void
    {
        if (! empty($this->onlyFieldsAcceptedInRequest())) {
            array_walk($this->onlyFieldsAcceptedInRequest(), [$this, 'addWhereToQuery']);
        }
    }

    protected function addWhereToQuery($valueRequest, string $keyRequest): void
    {
        $column = null;
        $clause = null;

        /** @var array|string */
        $fieldAccepted = $this->accepted()[$keyRequest];

        if (is_array($fieldAccepted)) {
            $column = $fieldAccepted['column'] ?? $keyRequest;
            $clause = $fieldAccepted['clause'] ?: 'where';

            $this->query = app($this->listWhereClauses($clause))->apply($this->query, $column, $valueRequest);

        } elseif (is_string($fieldAccepted)) {
            $column = $fieldAccepted;

            $this->query = app(WhereClause::class)->apply($this->query, $column, $valueRequest);
        } else {
            throw new RepositoryException(
                "\$value parameter value in {addWhereToQuery} method must be of type {array} or {string} in $this"
            );
        }
    }

    protected function applyConstantsToWheres()
    {
        /** @var string */
        $pathConstants = __DIR__.DIRECTORY_SEPARATOR.'Constants';

        $methodCustomName = function(string $classConstants): string {
            return 'setTo'.($classConstants);
        };

        /** @var \Symfony\Component\Finder\Finder */
        $files = (Finder::create()->files()->name('*.php')->in($pathConstants)->exclude('Off'));

        foreach ($files as $splFileInfo) {
            /** @var string */
            $filenameWithoutExtension = $splFileInfo->getFilenameWithoutExtension();

            /** @var string */
            $filenameSnake = Str::snake($filenameWithoutExtension);

            if (! $this->request->filled($filenameSnake)) {
                continue;
            }

            $constant = app(FilterableConstants::class. '\\' .$filenameWithoutExtension);

            $methodConstantCustomName = $methodCustomName($filenameWithoutExtension);

            if (method_exists($this, $methodConstantCustomName) &&
                Str::endsWith($methodConstantCustomName, $filenameWithoutExtension)) {
                    ($this->{$methodConstantCustomName}())->bindTo($constant)();
            }

            $this->query = $constant->apply($this->query, request($filenameSnake));
        }
    }

    protected function applyCustomFiltersToWheres(string $namespace = null): void
    {
        $methodCustomName = function(string $fieldStudly): string {
            return 'filterBy'.($fieldStudly);
        };

        foreach (request_filled($this->custom) as $fieldName => $value) {
            $filter = ($namespace ?? __NAMESPACE__). '\\Filters\\' .($fieldStudly = Str::studly($fieldName));

            if (class_exists($filter)) {

                $this->query = app($filter)->apply($this->query, $value);

            } elseif (method_exists($this, $methodCustomName($fieldStudly))) {

                $callback = [$this, $methodCustomName($fieldStudly)];
                $this->query = call_user_func_array($callback, [&$this->query, $value]);

            }
        }
    }

    /**
     * Convert to string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return get_class($this); // or static::class;
    }
}
