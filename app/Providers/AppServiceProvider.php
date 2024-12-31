<?php

namespace App\Providers;

use App\CustomGenerator;
use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Markdown;
use Statamic\StaticSite\Generator;
use Statamic\StaticSite\Tasks;
use Torchlight\Commonmark\V2\TorchlightExtension;

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
        Markdown::addExtension(function () {
            return [new TorchlightExtension];
        });
    }
}
