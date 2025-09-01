<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Operation;
use App\Models\PropertyType;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Compartir datos globalmente con todas las vistas
        View::composer('*', function ($view) {
            $view->with([
                'operations' => Operation::all(),
                'propertyTypes' => PropertyType::all(),
            ]);
        });
    }
}