<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Livewire\LivewireServiceProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    BladeHeroiconsServiceProvider::class,
    BladeIconsServiceProvider::class,
    ActionsServiceProvider::class,
    FilamentServiceProvider::class,
    FormsServiceProvider::class,
    InfolistsServiceProvider::class,
    NotificationsServiceProvider::class,
    SchemasServiceProvider::class,
    SupportServiceProvider::class,
    TablesServiceProvider::class,
    WidgetsServiceProvider::class,
    LivewireServiceProvider::class,
];
