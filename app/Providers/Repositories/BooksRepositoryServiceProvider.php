<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class BooksRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\BookRepository',
            'App\Repositories\DbBookRepository');
    }
}
