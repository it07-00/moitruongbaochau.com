<?php

namespace App\Models;

use Database\Factories\MenuItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Support\Facades\Route;

class MenuItem extends Model
{
    /** @use HasFactory<MenuItemFactory> */
    use HasFactory;

    protected $fillable = [
        'menu_id', 'parent_id', 'label', 'url', 'route_name', 'target', 'sort_order', 'is_active',
    ];

    protected $attributes = ['target' => '_self', 'sort_order' => 0, 'is_active' => true];

    protected function casts(): array
    {
        return ['sort_order' => 'integer', 'is_active' => 'boolean'];
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function resolvedUrl(): string
    {
        if ($this->route_name !== null && Route::has($this->route_name)) {
            try {
                return route($this->route_name);
            } catch (UrlGenerationException) {
                // Parameterized routes can use the custom URL instead.
            }
        }

        return $this->url && preg_match('/^(https?:\/\/|mailto:|tel:|\/(?!\/)|#)/i', $this->url)
            ? $this->url
            : '#';
    }
}
