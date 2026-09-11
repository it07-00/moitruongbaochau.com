<?php

namespace App\Console\Commands;

use App\Models\JobPosting;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefreshSeoMetadata extends Command
{
    protected $signature = 'seo:refresh {--dry-run : Chỉ thống kê, không cập nhật database}';

    protected $description = 'Chuẩn hóa metadata SEO tự sinh và giữ nguyên các giá trị quản trị viên tùy chỉnh';

    public function handle(): int
    {
        $updated = 0;

        foreach ($this->models() as $modelClass) {
            $modelClass::query()->chunkById(100, function ($models) use (&$updated): void {
                foreach ($models as $model) {
                    if ($this->refreshModel($model)) {
                        $updated++;
                    }
                }
            });
        }

        $action = $this->option('dry-run') ? 'Cần chuẩn hóa' : 'Đã chuẩn hóa';
        $this->info($action.": {$updated} nội dung SEO.");

        return self::SUCCESS;
    }

    /**
     * @return array<int, class-string<Model>>
     */
    private function models(): array
    {
        return [Page::class, Service::class, Post::class, Project::class, JobPosting::class];
    }

    private function refreshModel(Model $model): bool
    {
        $sourceTitle = self::cleanText((string) ($model->getAttribute('title') ?? $model->getAttribute('name') ?? ''));
        $generatedTitle = Str::limit($sourceTitle, 60, '');
        $currentTitle = (string) $model->getAttribute('meta_title');
        $automaticTitle = blank($currentTitle) || in_array($currentTitle, [
            $sourceTitle,
            $sourceTitle.' - '.config('app.name'),
            $generatedTitle,
        ], true);

        $sourceDescription = $this->sourceDescription($model);
        $generatedDescription = Str::limit($sourceDescription, 160, '');
        $currentDescription = (string) $model->getAttribute('meta_description');
        $automaticDescription = blank($currentDescription) || in_array($currentDescription, [
            $sourceDescription,
            $generatedDescription,
        ], true);

        $hasSourceImage = filled($model->getAttribute('thumbnail') ?? $model->getAttribute('image'));
        $needsRefresh = ($automaticTitle && $currentTitle !== $generatedTitle)
            || ($automaticDescription && $currentDescription !== $generatedDescription)
            || blank($model->getAttribute('og_title'))
            || blank($model->getAttribute('og_description'))
            || blank($model->getAttribute('twitter_title'))
            || blank($model->getAttribute('twitter_description'))
            || ($hasSourceImage && blank($model->getAttribute('og_image')))
            || ($hasSourceImage && blank($model->getAttribute('twitter_image')));

        if (! $needsRefresh || $this->option('dry-run')) {
            return $needsRefresh;
        }

        $oldOgTitle = (string) $model->getAttribute('og_title');
        $oldOgDescription = (string) $model->getAttribute('og_description');

        if ($automaticTitle) {
            $model->setAttribute('meta_title', null);

            if (blank($oldOgTitle) || $oldOgTitle === $currentTitle) {
                $model->setAttribute('og_title', null);
            }

            if (blank($model->getAttribute('twitter_title')) || in_array($model->getAttribute('twitter_title'), [$currentTitle, $oldOgTitle], true)) {
                $model->setAttribute('twitter_title', null);
            }
        }

        if ($automaticDescription) {
            $model->setAttribute('meta_description', null);

            if (blank($oldOgDescription) || $oldOgDescription === $currentDescription) {
                $model->setAttribute('og_description', null);
            }

            if (blank($model->getAttribute('twitter_description')) || in_array($model->getAttribute('twitter_description'), [$currentDescription, $oldOgDescription], true)) {
                $model->setAttribute('twitter_description', null);
            }
        }

        $model->save();

        return true;
    }

    private function sourceDescription(Model $model): string
    {
        foreach (['excerpt', 'summary', 'short_description', 'description', 'content'] as $attribute) {
            $value = (string) $model->getAttribute($attribute);

            if (filled($value)) {
                return self::cleanText($value);
            }
        }

        return '';
    }

    private static function cleanText(string $value): string
    {
        return Str::squish(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }
}
