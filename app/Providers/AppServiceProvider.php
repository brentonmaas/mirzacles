<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Services\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding the UserService to its interface
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the softDeletes route macro
        Route::macro('softDeletes', function ($prefix, $controller) {
            Route::get("$prefix/trashed", "$controller@trashed")->name("$prefix.trashed");
            Route::patch("$prefix/restore/{id}", "$controller@restore")->name("$prefix.restore");
            Route::delete("$prefix/delete/{id}", "$controller@delete")->name("$prefix.delete");
        });
    }
}
