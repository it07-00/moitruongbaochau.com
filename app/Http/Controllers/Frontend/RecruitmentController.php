<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobApplicationRequest;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Page;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RecruitmentController extends Controller
{
    public function index(): View
    {
        $page = Page::query()->where('slug', 'tuyen-dung')->orWhere('template', 'recruitment')->first();
        $jobs = JobPosting::query()->published()->open()->latest('published_at')->paginate(12);

        $seoTitle = $page?->meta_title ?: 'Tuyển dụng Môi Trường Bảo Châu';
        $seoDescription = $page?->meta_description ?: 'Cơ hội nghề nghiệp trong lĩnh vực tư vấn, quan trắc và kỹ thuật môi trường.';

        $seo = SeoData::forPage(
            $seoTitle,
            $seoDescription,
            route('recruitment.index'),
            [],
            $page?->og_image ? asset($page->og_image) : null,
        );

        return view('frontend.recruitment.index', compact('page', 'jobs', 'seo'));
    }

    public function show(string $slug): View
    {
        $job = JobPosting::query()->published()->open()->where('slug', $slug)->firstOrFail();
        $relatedJobs = JobPosting::query()->published()->open()->where('id', '!=', $job->id)->latest('published_at')->take(4)->get();
        $seo = SeoData::forContent($job, route('recruitment.show', $job->slug), 'JobPosting');

        return view('frontend.recruitment.show', compact('job', 'relatedJobs', 'seo'));
    }

    public function apply(StoreJobApplicationRequest $request, string $slug): RedirectResponse
    {
        $job = JobPosting::query()->published()->open()->where('slug', $slug)->firstOrFail();

        $cvPath = $request->file('cv_file')->store('resumes', 'public');

        JobApplication::query()->create([
            'job_posting_id' => $job->id,
            'job_title' => $job->title,
            'fullname' => $request->validated('fullname'),
            'phone' => $request->validated('contact_phone'),
            'email' => $request->validated('contact_email'),
            'message' => $request->validated('message'),
            'cv_path' => $cvPath,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->to(route('recruitment.show', $job->slug).'#form-ung-tuyen')
            ->with('success', 'Cảm ơn bạn đã nộp hồ sơ ứng tuyển vị trí '.$job->title.'! Bộ phận tuyển dụng Môi Trường Bảo Châu sẽ xem xét và phản hồi trong thời gian sớm nhất.');
    }

    public function applyGeneral(StoreJobApplicationRequest $request): RedirectResponse
    {
        $jobIdentifier = $request->validated('job_posting_id');
        $job = null;

        if ($jobIdentifier && $jobIdentifier !== 'other' && $jobIdentifier !== 'khac') {
            $job = is_numeric($jobIdentifier)
                ? JobPosting::query()->find($jobIdentifier)
                : JobPosting::query()->where('slug', $jobIdentifier)->first();
        }

        $jobTitle = $job?->title ?? ($request->validated('custom_position') ?? 'Ứng tuyển tự do / Vị trí khác');

        $cvPath = $request->file('cv_file')->store('resumes', 'public');

        JobApplication::query()->create([
            'job_posting_id' => $job?->id,
            'job_title' => $jobTitle,
            'fullname' => $request->validated('fullname'),
            'phone' => $request->validated('contact_phone'),
            'email' => $request->validated('contact_email'),
            'message' => $request->validated('message'),
            'cv_path' => $cvPath,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->to(route('recruitment.index').'#form-ung-tuyen')
            ->with('success', 'Cảm ơn bạn đã nộp hồ sơ ứng tuyển vị trí '.$jobTitle.'! Bộ phận tuyển dụng Môi Trường Bảo Châu sẽ xem xét và phản hồi trong thời gian sớm nhất.');
    }
}
