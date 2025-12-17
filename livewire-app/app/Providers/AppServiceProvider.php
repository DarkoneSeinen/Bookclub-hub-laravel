<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Club;
use App\Policies\ClubPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Club::class => ClubPolicy::class,
    ];

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
        //
    }
}
