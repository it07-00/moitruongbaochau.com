<?php

namespace App\Filament\Widgets;

use App\ContactStatus;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Tổng quan hệ thống';

    protected function getStats(): array
    {
        $newContacts = Contact::where('status', ContactStatus::New)->count();
        $totalServices = Service::count();
        $totalProjects = Project::count();
        $totalPosts = Post::count();

        return [
            Stat::make('Yêu cầu liên hệ mới', $newContacts)
                ->description($newContacts > 0 ? 'Khách hàng đang chờ phản hồi' : 'Tất cả liên hệ đã xử lý')
                ->descriptionIcon($newContacts > 0 ? Heroicon::OutlinedExclamationCircle : Heroicon::OutlinedCheckCircle)
                ->color($newContacts > 0 ? 'warning' : 'success'),

            Stat::make('Dịch vụ môi trường', $totalServices)
                ->description('Đang cung cấp cho khách hàng')
                ->descriptionIcon(Heroicon::OutlinedBriefcase)
                ->color('primary'),

            Stat::make('Dự án đã thực hiện', $totalProjects)
                ->description('Hồ sơ năng lực thực tế')
                ->descriptionIcon(Heroicon::OutlinedClipboardDocumentCheck)
                ->color('info'),

            Stat::make('Tin tức & Kiến thức', $totalPosts)
                ->description('Bài viết chia sẻ chuyên môn')
                ->descriptionIcon(Heroicon::OutlinedDocumentText)
                ->color('gray'),
        ];
    }
}
