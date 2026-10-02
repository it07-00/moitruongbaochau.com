<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGhgDeclarationStepRequest;
use App\Models\GhgDeclaration;
use App\Services\GhgDeclarationService;
use App\Support\GhgSurveyDefinition;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GhgDeclarationController extends Controller
{
    public function __construct(private GhgDeclarationService $declarations) {}

    public function show(Request $request, int $step = 0): View
    {
        $declaration = $this->declarations->current($request);
        $step = $step ?: ($declaration?->current_step ?? 1);
        $this->declarations->assertAccessible($declaration, $step);
        $steps = GhgSurveyDefinition::steps();
        $sections = GhgSurveyDefinition::sections($step);
        $fields = GhgSurveyDefinition::generalFields();
        $data = $request->old('data', $declaration?->data[$step] ?? GhgSurveyDefinition::defaults($step));
        $data = is_array($data) ? $data : GhgSurveyDefinition::defaults($step);
        $seo = SeoData::forPage('Biểu mẫu khai báo kiểm kê khí nhà kính 2026', 'Khai báo dữ liệu kiểm kê khí nhà kính theo 7 bước.', route('ghg-form.index'));
        $seo['robots'] = 'noindex,nofollow';

        return view('frontend.ghg-survey', compact('declaration', 'step', 'steps', 'sections', 'fields', 'data', 'seo'));
    }

    public function store(SaveGhgDeclarationStepRequest $request, int $step): RedirectResponse
    {
        $declaration = $this->declarations->save($request, $step, $request->validated());

        return to_route('ghg-form.step', $declaration->current_step)->with('ghg_saved', 'Dữ liệu đã được lưu lúc '.now()->format('H:i d/m/Y').'.');
    }

    public function download(Request $request, GhgDeclaration $declaration, int $evidence): StreamedResponse
    {
        abort_unless($request->user()?->is_admin, 403);
        $file = $declaration->evidence[$evidence] ?? null;
        abort_unless($file && Storage::disk('local')->exists($file['path']), 404);

        return Storage::disk('local')->download($file['path'], $file['name']);
    }
}
