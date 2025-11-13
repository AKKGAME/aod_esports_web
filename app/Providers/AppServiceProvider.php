<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Sponsor;

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
        View::composer('layouts.public', function ($view) {

            $sponsors = Sponsor::where('is_active', true)
                               ->orderBy('sort_order', 'asc')
                               ->get();

            $groupedSponsors = $sponsors->groupBy('level');

            $view->with('groupedSponsors', $groupedSponsors);
        });
    }
}
