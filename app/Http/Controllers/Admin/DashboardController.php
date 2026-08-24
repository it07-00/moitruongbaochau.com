<?php

namespace App\Http\Controllers\Admin;

use App\ContactStatus;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\JobPosting;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $counts = [
            'pages' => Page::query()->count(),
            'services' => Service::query()->count(),
            'posts' => Post::query()->count(),
            'projects' => Project::query()->count(),
            'jobs' => JobPosting::query()->count(),
            'new_contacts' => Contact::query()->where('status', ContactStatus::New)->count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
