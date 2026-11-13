<?php

namespace App\Http\Controllers\Frontend;

use App\CtaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrackCtaClickRequest;
use App\Models\CtaClick;
use Illuminate\Http\JsonResponse;

class CtaTrackingController extends Controller
{
    /**
     * Record a CTA interaction event.
     */
    public function __invoke(TrackCtaClickRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $click = CtaClick::record(
            type: CtaType::from($validated['type']),
            label: $validated['label'] ?? null,
            targetUrl: $validated['target_url'] ?? null,
            pageUrl: $validated['page_url'] ?? null,
            position: $validated['position'] ?? null,
            request: $request,
            metadata: is_array($validated['metadata'] ?? null) ? $validated['metadata'] : [],
        );

        return response()->json([
            'ok' => true,
            'id' => $click->id,
        ], 201);
    }
}
