<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use App\Models\Setting;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->menuItems = Menu::get();
        $this->settings = Setting::first();
        
        view()->composer('backend.layout.app', function($view) {
            $view->with(['contents' => $this->menuItems , 'settings' => $this->settings]);
        });

        view()->composer('frontend.layout.app', function($view) {
            $view->with(['contents' => $this->menuItems , 'settings' => $this->settings]);
        });
    }
}
