<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveEnvironmentSurveyRequest;
use App\Models\EnvironmentSurvey;
use App\Models\SurveyFile;
use App\Services\EnvironmentSurveyExport;
use App\Services\EnvironmentSurveyService;
use App\Support\EnvironmentSurveyDefinition as Definition;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EnvironmentSurveyController extends Controller
{
    public function __construct(private EnvironmentSurveyService $surveys) {}

    public function index(Request $request): View|RedirectResponse
    {
        $survey = $this->current($request);

        return $survey ? to_route('bvmt.show', ['survey' => $survey->token]) : $this->show($request);
    }

    public function show(Request $request, ?EnvironmentSurvey $survey = null, int $step = 0): View
    {
        $step = $step ?: ($survey?->current_step ?? 1);
        abort_unless(in_array($step, range(1, 7), true), 404);
        $survey?->load('files');
        $data = array_replace(Definition::defaults($step), $survey?->data ?? [], (array) $request->old('data', []));
        $completed = $survey ? $this->surveys->completedSteps($survey) : [];
        $missing = $survey ? $this->surveys->missingDocuments($survey) : Definition::documents();
        $seo = SeoData::forPage('Phiếu khảo sát công tác BVMT 2026', 'Cung cấp thông tin, số liệu và hồ sơ phục vụ Báo cáo công tác bảo vệ môi trường năm 2026.', route('bvmt.index'));
        $seo['robots'] = 'noindex,nofollow';

        return view('frontend.environment-survey', compact('survey', 'step', 'data', 'completed', 'missing', 'seo'));
    }

    public function store(SaveEnvironmentSurveyRequest $request, ?EnvironmentSurvey $survey = null, int $step = 1): RedirectResponse
    {
        $survey = $this->surveys->save($survey ?? $this->current($request), $step, $request->validated());
        $request->session()->put('bvmt_survey.reference', $survey->reference);

        return to_route('bvmt.step', ['survey' => $survey->token, 'step' => $survey->current_step])->with('bvmt_saved', 'Đã lưu dữ liệu lúc '.now()->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y').'.');
    }

    public function download(EnvironmentSurvey $survey, SurveyFile $file): StreamedResponse
    {
        abort_unless($file->environment_survey_id === $survey->id && Storage::disk('local')->exists($file->path), 404);

        return Storage::disk('local')->download($file->path, $file->original_name);
    }

    public function delete(EnvironmentSurvey $survey, SurveyFile $file): Response
    {
        $this->surveys->deleteFile($survey, $file);

        return response()->noContent();
    }

    public function export(EnvironmentSurvey $survey, EnvironmentSurveyExport $export): StreamedResponse
    {
        return $export->download($survey);
    }

    public function archive(EnvironmentSurvey $survey, EnvironmentSurveyExport $export): BinaryFileResponse
    {
        return $export->archive($survey);
    }

    private function current(Request $request): ?EnvironmentSurvey
    {
        $reference = $request->session()->get('bvmt_survey.reference');

        return $reference ? EnvironmentSurvey::query()->where('reference', $reference)->first() : null;
    }
}
