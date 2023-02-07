<?php

namespace App\Providers;

use App\UrlPaginator;
use Illuminate\Support\ServiceProvider;
use Statamic\Extensions\Pagination\LengthAwarePaginator;
use Statamic\Facades\Entry;
use Statamic\StaticSite\Generator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootSsg();
        }
    }

    /**
     * This is a bit blech
     * @see https://gist.github.com/jasonvarga/256f293f8f55bf564c907a335a2f40f3
     */
    private function bootSsg()
    {
        $this->app->extend(LengthAwarePaginator::class, function ($paginator) {
            $options = $paginator->getOptions();
            $options['path'] = preg_replace('/\/page\/\d+$/', '', $options['path']);

            return $this->app->makeWith(UrlPaginator::class, [
                'items' => $paginator->getCollection(),
                'total' => $paginator->total(),
                'perPage' => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'options' => $options,
            ]);
        });

        UrlPaginator::currentPageResolver(function () {
            return optional($this->app['request']->route())->parameter('page');
        });

        $this->app->beforeResolving(Generator::class, function ($generator) {
            $config = config('statamic.ssg');

            $config['urls'] = array_merge(
                $config['urls'],
                $this->articleUrls(),
            );

            config(['statamic.ssg' => $config]);
        });
    }

    private function articleUrls()
    {
        // TODO: Make these dynamic
        // The URL of the listing.
        $url = '/blog';

        // The number of entries per page, according to your collection tag.
        $perPage = 20;

        // The total number of entries in the collection.
        // Make sure to mimic whatever params/filters are on the collection tag.
        $total = Entry::query()->where('collection', 'articles')->where('status', 'published')->count();

        return collect(range(1, ceil($total / $perPage)))
            ->map(fn ($page) => $url.'/page/'.$page)
            ->all();
    }
}
