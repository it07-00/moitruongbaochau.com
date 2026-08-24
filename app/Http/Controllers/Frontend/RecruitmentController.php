<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class RecruitmentController extends Controller
{
    public function index(): View
    {
        $jobs = JobPosting::query()->published()->open()->latest('published_at')->paginate(12);
        $seo = SeoData::forPage(
            'Tuyển dụng Môi Trường Bảo Châu',
            'Cơ hội nghề nghiệp trong lĩnh vực tư vấn, quan trắc và kỹ thuật môi trường.',
            route('recruitment.index'),
        );

        return view('frontend.recruitment.index', compact('jobs', 'seo'));
    }

    public function show(string $slug): View
    {
        $job = JobPosting::query()->published()->open()->where('slug', $slug)->firstOrFail();
        $seo = SeoData::forContent($job, route('recruitment.show', $job->slug), 'JobPosting');

        return view('frontend.recruitment.show', compact('job', 'seo'));
    }
}
