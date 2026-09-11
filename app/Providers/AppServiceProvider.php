<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Service;
use App\Models\Setting;
use App\Observers\MenuItemObserver;
use App\Observers\MenuObserver;
use App\Services\MenuService;
use App\Services\SettingService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        Model::preventLazyLoading(! app()->isProduction());
        Menu::observe(MenuObserver::class);
        MenuItem::observe(MenuItemObserver::class);
        Setting::saved(fn () => Cache::forget('website.settings'));
        Setting::deleted(fn () => Cache::forget('website.settings'));

        RateLimiter::for('admin-login', fn (Request $request): Limit => Limit::perMinute(5)
            ->by($request->string('email')->lower().'|'.$request->ip()));
        RateLimiter::for('contact-form', fn (Request $request): Limit => Limit::perMinute(3)
            ->by($request->ip()));

        View::composer(['frontend.*', 'components.frontend.header', 'components.frontend.footer', 'components.frontend.floating-contact'], function ($view): void {
            $view->with('websiteSettings', app(SettingService::class)->all());
        });
        View::composer('components.frontend.header', function ($view): void {
            $view->with([
                'primaryMenuItems' => app(MenuService::class)->items('primary'),
                'headerServices' => Service::query()
                    ->published()
                    ->orderByDesc('is_featured')
                    ->orderBy('sort_order')
                    ->take(5)
                    ->get(['id', 'name', 'slug']),
            ]);
        });
        View::composer('components.frontend.footer', function ($view): void {
            $settingService = app(SettingService::class);

            $view->with([
                'footerServices' => Service::query()
                    ->published()
                    ->orderBy('sort_order')
                    ->take(7)
                    ->get(['id', 'name', 'slug']),
                'footerSalesContacts' => $settingService->json('footer_sales_contacts'),
                'footerConsultingContacts' => $settingService->json('footer_consulting_contacts'),
            ]);
        });

        if (app()->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
