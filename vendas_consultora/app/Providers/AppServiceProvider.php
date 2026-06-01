<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Adicione esta importação
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

public function boot(): void
{
    // Se o acesso está vindo pelo túnel do Cloudflare ou se não for local, força HTTPS
    if (config('app.env') !== 'local' || str_contains(request()->getHost(), 'trycloudflare.com')) {
        URL::forceScheme('https');
    }

    Vite::prefetch(concurrency: 3);
    Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    \Inertia\Inertia::setRootView('layouts.inertia');
} 
}
