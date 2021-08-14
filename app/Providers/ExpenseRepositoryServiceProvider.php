<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ExpenseRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\ExpenseRepositoryInterface',
            'App\Repositories\ExpenseRepository'
        );
    }
}
