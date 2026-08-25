<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(): View
    {
        $applications = JobApplication::query()->with('jobPosting')->latest()->paginate(30);

        return view('admin.job-applications.index', compact('applications'));
    }

    public function show(JobApplication $jobApplication): View
    {
        if ($jobApplication->status === 'new') {
            $jobApplication->update(['status' => 'reviewed']);
        }

        return view('admin.job-applications.show', compact('jobApplication'));
    }

    public function update(Request $request, JobApplication $jobApplication): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,reviewed,contacted,rejected'],
        ]);

        $jobApplication->update($validated);

        return back()->with('success', 'Đã cập nhật trạng thái hồ sơ ứng viên.');
    }

    public function destroy(JobApplication $jobApplication): RedirectResponse
    {
        $jobApplication->delete();

        return redirect()->route('admin.job-applications.index')->with('success', 'Đã xóa hồ sơ ứng tuyển.');
    }
}
