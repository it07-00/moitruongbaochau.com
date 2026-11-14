<?php

namespace App\Services;

use App\ContactStatus;
use App\ContentStatus;
use App\Models\Contact;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Cell\StringCell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityStatsExcelExport
{
    public function __construct(public ActivityStatisticsService $statistics) {}

    public function download(): StreamedResponse
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $filename = 'thong-ke-hoat-dong-website-'.now()->format('Ymd-His').'.xlsx';

        return response()->streamDownload(function (): void {
            $path = tempnam(sys_get_temp_dir(), 'activity-stats-');
            try {
                $this->writeWorkbook($path);
                readfile($path);
            } finally {
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function writeWorkbook(string $path): void
    {
        $writer = new Writer;
        $writer->openToFile($path);

        try {
            $this->writeSummarySheet($writer);
            $this->writeContentSheet($writer);
            $this->writeRecruitmentSheet($writer);
            $this->writeContactsSheet($writer);
        } finally {
            $writer->close();
        }
    }

    private function writeSummarySheet(Writer $writer): void
    {
        $writer->getCurrentSheet()->setName('Tổng hợp hoạt động');
        $this->row($writer, ['BÁO CÁO THỐNG KÊ CHI TIẾT HOẠT ĐỘNG WEBSITE', 'Xuất lúc: '.now()->format('d/m/Y H:i:s')], (new Style)->setFontBold());
        $this->row($writer, []);
        $this->header($writer, ['Nhóm', 'Hạng mục', 'Hôm nay', 'Tuần này', 'Tháng này', 'Năm nay', 'Tổng cộng', 'Trạng thái / Chi tiết']);

        foreach ($this->statistics->getSummaryRows() as $row) {
            $this->row($writer, [
                $row['group'],
                $row['label'],
                $row['today'],
                $row['week'],
                $row['month'],
                $row['year'],
                $row['total'],
                $row['highlight_label'],
            ]);
        }
    }

    private function writeContentSheet(Writer $writer): void
    {
        $writer->addNewSheetAndMakeItCurrent()->setName('Bài viết - Dịch vụ - Dự án');
        $this->header($writer, ['Loại', 'Tiêu đề / Tên', 'Trạng thái', 'Lượt xem', 'Ngày tạo']);

        foreach (Post::query()->latest('created_at')->limit(500)->get(['title', 'status', 'view_count', 'created_at']) as $post) {
            $this->row($writer, [
                'Bài viết',
                $post->title,
                $this->contentStatusLabel($post->status),
                (int) $post->view_count,
                $post->created_at?->format('d/m/Y H:i'),
            ]);
        }

        foreach (Service::query()->latest('created_at')->limit(500)->get(['name', 'status', 'view_count', 'created_at']) as $service) {
            $this->row($writer, [
                'Dịch vụ',
                $service->name,
                $this->contentStatusLabel($service->status),
                (int) $service->view_count,
                $service->created_at?->format('d/m/Y H:i'),
            ]);
        }

        foreach (Project::query()->latest('created_at')->limit(500)->get(['title', 'status', 'view_count', 'created_at']) as $project) {
            $this->row($writer, [
                'Dự án',
                $project->title,
                $this->contentStatusLabel($project->status),
                (int) $project->view_count,
                $project->created_at?->format('d/m/Y H:i'),
            ]);
        }
    }

    private function writeRecruitmentSheet(Writer $writer): void
    {
        $writer->addNewSheetAndMakeItCurrent()->setName('Tuyển dụng & Ứng viên');
        $this->header($writer, ['Hồ sơ ứng viên - Họ tên', 'Số điện thoại', 'Email', 'Vị trí ứng tuyển', 'Trạng thái', 'Ngày nộp']);

        foreach (JobApplication::query()->latest('created_at')->limit(500)->get(['fullname', 'phone', 'email', 'job_title', 'status', 'created_at']) as $application) {
            $this->row($writer, [
                $application->fullname,
                $application->phone,
                $application->email,
                $application->job_title,
                $application->status === 'new' ? 'Mới' : (string) $application->status,
                $application->created_at?->format('d/m/Y H:i'),
            ]);
        }

        $this->row($writer, []);
        $this->header($writer, ['Tin tuyển dụng', 'Địa điểm', 'Hình thức', 'Trạng thái', 'Hạn nộp', 'Ngày đăng']);

        foreach (JobPosting::query()->latest('created_at')->limit(500)->get(['title', 'location', 'employment_type', 'status', 'expires_at', 'created_at']) as $job) {
            $this->row($writer, [
                $job->title,
                $job->location,
                $job->employment_type,
                $this->contentStatusLabel($job->status),
                $job->expires_at?->format('d/m/Y'),
                $job->created_at?->format('d/m/Y H:i'),
            ]);
        }
    }

    private function writeContactsSheet(Writer $writer): void
    {
        $writer->addNewSheetAndMakeItCurrent()->setName('Liên hệ & Tư vấn');
        $this->header($writer, ['Phân loại', 'Họ tên', 'Số điện thoại', 'Email', 'Chủ đề', 'Trạng thái', 'Ngày gửi']);

        $ghgPath = route('ghg-service.index', [], false);

        foreach (Contact::query()->latest('created_at')->limit(500)->get(['name', 'phone', 'email', 'topic', 'source', 'status', 'created_at']) as $contact) {
            $isGhg = is_string($contact->source) && str_contains($contact->source, $ghgPath);

            $this->row($writer, [
                $isGhg ? 'Tư vấn Khí nhà kính' : 'Liên hệ thường',
                $contact->name,
                $contact->phone,
                $contact->email,
                $contact->topic,
                $contact->status === ContactStatus::New ? 'Chưa xử lý' : 'Đã xử lý',
                $contact->created_at?->format('d/m/Y H:i'),
            ]);
        }
    }

    private function contentStatusLabel(mixed $status): string
    {
        if ($status instanceof ContentStatus) {
            return $status === ContentStatus::Published ? 'Đã xuất bản' : 'Bản nháp';
        }

        return (string) $status === ContentStatus::Published->value ? 'Đã xuất bản' : 'Bản nháp';
    }

    /** @param list<string|int|float|null> $values */
    private function header(Writer $writer, array $values): void
    {
        $this->row($writer, $values, (new Style)->setFontBold()->setFontColor('065F46')->setBackgroundColor('ECFDF5')->setShouldWrapText());
    }

    /** @param list<string|int|float|null> $values */
    private function row(Writer $writer, array $values, ?Style $style = null): void
    {
        $cells = array_map(
            fn (string|int|float|null $value): Cell => is_string($value) ? new StringCell($value, null) : Cell::fromValue($value),
            $values,
        );
        $writer->getCurrentSheet()->setColumnWidthForRange(24, 1, max(2, count($values)));
        $writer->addRow(new Row($cells, $style ?? (new Style)->setShouldWrapText()));
    }
}
