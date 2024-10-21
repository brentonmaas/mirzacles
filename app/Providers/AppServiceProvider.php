<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the softDeletes route macro
        Route::macro('softDeletes', function ($prefix, $controller) {
            Route::get("$prefix/trashed", "$controller@trashed")->name("$prefix.trashed");
            Route::patch("$prefix/{id}/restore", "$controller@restore")->name("$prefix.restore");
            Route::delete("$prefix/{id}/delete", "$controller@delete")->name("$prefix.delete");
        });
    }
}
