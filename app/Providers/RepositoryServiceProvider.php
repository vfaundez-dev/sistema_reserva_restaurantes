<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
    
    public function register(): void {
        $this->bindRepositories();
    }

    protected function bindRepositories() {

        $this->app->bind(
            \App\Repositories\Interfaces\CustomerRepositoryInterfaces::class,
            \App\Repositories\CustomerRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\TableRepositoryInterface::class,
            \App\Repositories\TableRepository::class
        );

    }
}
