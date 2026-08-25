<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SeoSection
{
    /**
     * Build the standard SEO Meta Section for Filament resources.
     */
    public static function make(string $title = 'Tối ưu hóa SEO Meta'): Section
    {
        return Section::make($title)
            ->description('Tất cả các trường SEO đều được hệ thống tự động tối ưu nếu để trống.')
            ->collapsed()
            ->components([
                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->maxLength(255)
                    ->placeholder('Tự động tạo theo tiêu đề bài viết/dịch vụ...')
                    ->helperText('Tự động đồng bộ theo tiêu đề. Độ dài lý tưởng: 50 - 60 ký tự.')
                    ->columnSpanFull(),

                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->rows(3)
                    ->maxLength(320)
                    ->placeholder('Tự động trích xuất từ tóm tắt hoặc nội dung...')
                    ->helperText('Tự động trích xuất từ tóm tắt hoặc nội dung. Độ dài lý tưởng: 120 - 160 ký tự.')
                    ->columnSpanFull(),

                TextInput::make('canonical_url')
                    ->label('Canonical URL')
                    ->url()
                    ->placeholder('Mặc định tự động tạo theo URL chuẩn của trang')
                    ->helperText('Để trống để hệ thống tự động áp dụng đường dẫn chuẩn.'),

                Select::make('robots')
                    ->label('Robots Meta Tag')
                    ->options([
                        'index,follow' => 'index,follow (Mặc định - Cho phép Google lập chỉ mục)',
                        'noindex,follow' => 'noindex,follow (Không lập chỉ mục nhưng vẫn quét link)',
                        'noindex,nofollow' => 'noindex,nofollow (Không lập chỉ mục và không quét link)',
                    ])
                    ->default('index,follow')
                    ->required(),

                TextInput::make('og_title')
                    ->label('OG Title (Mạng xã hội)')
                    ->maxLength(255)
                    ->placeholder('Mặc định tự động theo Meta Title...')
                    ->helperText('Tiêu đề hiển thị khi chia sẻ lên Facebook, Zalo, LinkedIn.'),

                Textarea::make('og_description')
                    ->label('OG Description (Mạng xã hội)')
                    ->rows(2)
                    ->maxLength(320)
                    ->placeholder('Mặc định tự động theo Meta Description...')
                    ->helperText('Mô tả hiển thị khi chia sẻ lên mạng xã hội.'),

                FileUpload::make('og_image')
                    ->label('OG Image (Ảnh chia sẻ mạng xã hội)')
                    ->image()
                    ->directory('uploads/seo')
                    ->helperText('Nếu để trống, hệ thống sẽ tự động dùng ảnh đại diện (Thumbnail) của bài viết/dịch vụ.')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
