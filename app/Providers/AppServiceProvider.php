<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- ADD THIS IMPORT

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tell Laravel that our public folder is 'public_html'
        $this->app->usePublicPath('/home/wopg9327/public_html');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS if using Ngrok or in Production
        if($this->app->environment('production') || 
           str_contains(request()->getHost(), 'ngrok') || 
           env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}