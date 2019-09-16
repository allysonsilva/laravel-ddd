<?php

namespace App\Support\Repository\Eloquent\Traits;

use Closure;
use ReflectionClass;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

trait CacheableRepository
{
    /**
     * The key that should be used when caching the query.
     *
     * @var string
     */
    protected $cacheKey;

    /**
     * The number of seconds to cache the query.
     *
     * @var int
     */
    protected $cacheSeconds = 3600;

    /**
     * The tags for the query cache.
     *
     * @var array
     */
    protected $cacheTags = [];

    /**
     * The cache driver to be used.
     *
     * @var string
     */
    protected $cacheDriver;

    /**
     * A cache prefix.
     *
     * @var string
     */
    private $cachePrefix;

    /**
     * Main method for cache handling.
     *
     * @param string $method
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function cacheHandle(string $method, Closure $callback)
    {
        if ($this->isSkippedCache()) {
            return value($callback);
        }

        $this->rememberCacheTag();

        $this->setCachePrefixDomain(...$this->getCacheKeyDomain($method));

        // If the query is requested to be cached, we will cache it using a unique key
        // for this database connection and query statement, including the bindings
        // that are used on this query, providing great convenience when caching.
        [$key, $seconds] = $this->getCacheInfo($method);

        $cache = $this->getCache();

        if (is_null($seconds)) {
            return $cache->rememberForever($key, $callback);
        }

        return $cache->remember($key, $seconds, $callback);
    }

    public function getCacheKeyDomain(string $method): array
    {
        $domain = $this->domain();
        $repositoryClassShortName = (app(ReflectionClass::class, ['argument' => $this]))->getShortName();

        return [
            sprintf('%s.%s.%s', $domain, $repositoryClassShortName, $method),
            sprintf('%s.%s', $domain, $repositoryClassShortName),
        ];
    }

    private function setCachePrefixDomain(string $fullCacheKey, string $domainAndRepositoryCacheKey): void
    {
        if (is_null($this->cachePrefix)) {
            $this->cachePrefix($fullCacheKey);
        }

        $this->cacheTags([ $fullCacheKey, $domainAndRepositoryCacheKey ]);
    }

    /**
     * Get an item from the cache.
     *
     * Indicate that the query results should be cached.
     *
     * @param \DateTimeInterface|\DateInterval|int|null $ttl
     * @param string $key
     *
     * @return $this
     */
    public function cacheRemember($ttl, $key = null): self
    {
        $this->cacheSeconds($ttl);
        $this->cacheKey = $key;

        return $this;
    }

    /**
     * Indicate that the query results should be cached forever.
     *
     * @param string|null $key
     *
     * @return $this
     */
    public function cacheRememberForever($key = null): self
    {
        // @see https://github.com/laravel/framework/blob/5.8/src/Illuminate/Cache/Repository.php#L201
        // When the seconds or ttl is null then the repository implementation is to store forever.
        return $this->cacheRemember(null, $key);
    }

    /**
     * Indicate that the query/method should not be cached.
     *
     * @return $this
     */
    public function doNotCache(): self
    {
        $this->cacheKey = 'no-cache';

        return $this;
    }

    /**
     * Indicate that the results, if cached, should use the given cache driver.
     *
     * @param string $cacheDriver
     *
     * @return $this
     */
    public function cacheDriver(string $cacheDriver): self
    {
        $this->cacheDriver = $cacheDriver;

        return $this;
    }

    /**
     * Set the cache prefix.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function cachePrefix(string $prefix): self
    {
        $this->cachePrefix = $prefix;

        return $this;
    }

    /**
     * Flush the cache for the current model or a given tag name.
     *
     * @param array|null $cacheTags
     * @param string|null $method
     *
     * @return void
     */
    public function flushCache(?array $cacheTags = [], string $method = null): void
    {
        $cache = $this->getCacheRepository();

        $this->rememberCacheTag();

        $cacheTags = $cacheTags ?: $this->cacheTags;

        if (! empty($method)) {
            $cacheTags = array_merge($cacheTags, Arr::wrap(($this->getCacheKeyDomain($method))[0]));
        }

        $cache->tags($cacheTags)->flush();

        $this->resetCache();
    }

    /**
     * Check if cache should be skipped.
     *
     * @return bool
     */
    public function isSkippedCache(): bool
    {
        if ($this->cacheKey === 'no-cache' || app(Request::class)->filled('skip-cache')) {
            return true;
        }

        return false;
    }

    /**
     * Indicate that the results, if cached, should use the given cache tags.
     *
     * @param  array  $cacheTags
     *
     * @return $this
     */
    public function cacheTags(array $cacheTags = []): self
    {
        if (! is_array($this->cacheTags)) {
            $this->cacheTags = [];
        }

        if (! empty($cacheTags)) {
            $this->cacheTags = array_merge($this->cacheTags, $cacheTags);
        }

        return $this;
    }

    /**
     * Reset to default cache settings.
     *
     * @return void
     */
    protected function resetCache(): void
    {
        $this->cacheSeconds(3600);

        $this->cacheTags = [];
        $this->cacheKey = null;
        $this->cachePrefix = null;
    }

    /**
     * Set time in cache storage.
     *
     * @param \DateTimeInterface|\DateInterval|int|null $ttl
     *
     * @return $this
     */
    protected function cacheSeconds($ttl): self
    {
        $this->cacheSeconds = $ttl;

        return $this;
    }

    /**
     * Get the cache driver.
     *
     * @return \Illuminate\Cache\Repository
     */
    protected function getCacheRepository(): CacheRepository
    {
        return cache()->driver($this->cacheDriver);
    }

    /**
     * Get the cache object with tags assigned, if applicable.
     *
     * @return \Illuminate\Cache\Repository
     */
    protected function getCache(): CacheRepository
    {
        $cache = $this->getCacheRepository();

        return ! empty($this->cacheTags) ? $cache->tags($this->cacheTags) : $cache;
    }

    /**
     * Get the cache key and cache seconds as an array.
     *
     * @param string $method
     *
     * @return array
     */
    public function getCacheInfo(string $method): array
    {
        return [$this->getCacheKey($method), $this->cacheSeconds];
    }

    /**
     * Get a unique cache key for the complete query.
     *
     * @param string $method
     *
     * @return string
     */
    public function getCacheKey(string $method): string
    {
        $cachePrefix = $this->cachePrefix;

        if (empty($cachePrefix)) {
            $cachePrefix = ($this->getCacheKeyDomain($method))[0];
        }

        return sprintf('%s@%s', $cachePrefix, ($this->cacheKey ?: $this->generateCacheKey()));
    }

    /**
     * Generate the unique cache key for the query.
     *
     * @return string
     */
    protected function generateCacheKey(): string
    {
        $connectionName = $this->entity->getConnection()->getName();
        $SQLRepresentation = $this->entity->toSql();
        $queryValueBindings = $this->entity->getBindings();

        return hash('sha256', $connectionName. '@' .$SQLRepresentation . '@' . serialize($queryValueBindings));
    }

    /**
     * Repository default cache tags that will be used for each select.
     *
     * @return void
     */
    private function rememberCacheTag(): void
    {
        if (isset($this->rememberCacheTag)) {
            $this->cacheTags($this->rememberCacheTag);
        }
    }
}
