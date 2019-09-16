<?php

namespace App\Support\View\Building;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class BladeExtensionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerErrorBlockExtension();
        $this->configureGlobalPaginationAppends();
    }

    protected function registerErrorBlockExtension()
    {
        $blade = Blade::getFacadeRoot();

        $blade->directive('hasErrorClass', function ($expression) {
            return '<?php echo ($errors->has(' . $expression . ')) ? "has-error" : null; ?>';
        });

        $blade->directive('errorBlock', function ($expression) {
            $name = str_replace(['(', ')'], null, $expression);

            return '<?php echo $errors->first(' . $name . ', \'<span class="help-block">:message</span>\') ?>';
        });
    }

    private function configureGlobalPaginationAppends()
    {
        $this->app->resolving(LengthAwarePaginator::class, function (Paginator $paginator) {
            return $paginator->appends(Arr::except(request()->query(), $paginator->getPageName()));
        });

        $this->app->resolving(\Illuminate\Contracts\Pagination\Paginator::class, function (Paginator $paginator) {
            return $paginator->appends(Arr::except(request()->query(), $paginator->getPageName()));
        });
    }
}
