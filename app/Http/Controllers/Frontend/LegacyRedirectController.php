<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LegacyRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $redirect = Redirect::query()
            ->where('old_path', '/'.ltrim($request->path(), '/'))
            ->where('is_active', true)
            ->firstOrFail();

        $redirect->increment('hit_count');
        $redirect->forceFill(['last_hit_at' => now()])->save();

        return redirect($redirect->new_path, $redirect->status_code);
    }
}
