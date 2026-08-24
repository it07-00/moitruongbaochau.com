<?php

namespace App\Providers;

use App\Models\PostCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Services\MenuService;
use App\Services\SettingService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        Model::preventLazyLoading(! app()->isProduction());

        RateLimiter::for('admin-login', fn (Request $request): Limit => Limit::perMinute(5)
            ->by($request->string('email')->lower().'|'.$request->ip()));
        RateLimiter::for('contact-form', fn (Request $request): Limit => Limit::perMinute(3)
            ->by($request->ip()));

        View::composer(['frontend.*', 'components.frontend.*'], function ($view): void {
            $view->with('websiteSettings', app(SettingService::class)->all());
            $view->with('primaryMenuItems', app(MenuService::class)->items('primary'));
            $view->with('headerServiceCategories', ServiceCategory::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->with(['services' => fn ($query) => $query
                    ->published()
                    ->orderBy('sort_order')
                    ->take(8),
                ])
                ->get()
            );
            $view->with('headerPostCategories', PostCategory::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->with(['posts' => fn ($query) => $query
                    ->published()
                    ->latest('published_at')
                    ->take(6),
                ])
                ->get()
            );
            $view->with('footerServices', Service::query()
                ->published()
                ->orderBy('sort_order')
                ->take(7)
                ->get()
            );
        });

        if (app()->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
