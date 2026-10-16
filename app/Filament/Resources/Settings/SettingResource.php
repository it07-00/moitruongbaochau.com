<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\Pages\CreateSetting;
use App\Filament\Resources\Settings\Pages\EditSetting;
use App\Filament\Resources\Settings\Pages\ListSettings;
use App\Models\Setting;
use App\Support\SeoData;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class SettingResource extends Resource
{
    public const IMAGE_SETTINGS = [
        'logo' => 'Logo website',
        'favicon' => 'Biểu tượng website (Favicon)',
        'seo_default_image' => 'Ảnh chia sẻ mặc định (SEO)',
        'about_image' => 'Ảnh giới thiệu doanh nghiệp',
        'content_editor_logo' => 'Logo ban biên tập',
    ];

    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Cấu hình & Hệ thống';

    protected static ?string $navigationLabel = 'Cài đặt Website & SEO';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Cài đặt';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cài đặt Website';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin cài đặt')
                    ->components([
                        TextInput::make('key')
                            ->label('Khóa cấu hình (Setting Key)')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->unique(Setting::class, 'key', ignoreRecord: true),
                        Select::make('group')
                            ->label('Nhóm cài đặt')
                            ->options([
                                'general' => '1. Thông tin doanh nghiệp (Tên cty, MST, Logo)',
                                'contact' => '2. Liên hệ & Trụ sở (Hotline, Email, Địa chỉ, Map)',
                                'social' => '3. Kênh truyền thông & MXH (Zalo, Facebook, Youtube)',
                                'seo' => '4. Cấu hình SEO mặc định toàn trang',
                                'homepage' => '5. Khối giới thiệu Trang chủ',
                                'content' => '6. Nội dung dùng chung (Tác giả, mô tả)',
                            ])
                            ->default('general')
                            ->required(),
                        Textarea::make('value')
                            ->label('Giá trị (Value)')
                            ->visible(fn (Get $get): bool => ! isset(self::IMAGE_SETTINGS[$get('key') ?? '']))
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('image_value')
                            ->label(fn (Get $get): string => self::IMAGE_SETTINGS[$get('key') ?? ''] ?? 'Hình ảnh')
                            ->visible(fn (Get $get): bool => isset(self::IMAGE_SETTINGS[$get('key') ?? '']))
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/x-icon', 'image/vnd.microsoft.icon'])
                            ->disk('public')
                            ->visibility('public')
                            ->directory('uploads/settings')
                            ->maxSize(5120)
                            ->fetchFileInformation(false)
                            ->preventFilePathTampering(allowFilePathUsing: fn (string $file, ?Setting $record): bool => $record !== null && $file === $record->value)
                            ->getUploadedFileUsing(fn (string $file): array => [
                                'name' => basename($file),
                                'size' => 0,
                                'type' => null,
                                'url' => SeoData::absoluteAsset($file),
                            ])
                            ->helperText('Chọn hoặc kéo thả ảnh vào đây. Tối đa 5 MB. Hệ thống tự lưu ảnh và cập nhật website.')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    /** @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public static function prepareFormData(array $data): array
    {
        if (isset(self::IMAGE_SETTINGS[$data['key']])) {
            $data['value'] = $data['image_value'] ?? null;
        }

        unset($data['image_value']);

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Khóa cấu hình')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('value')
                    ->label('Giá trị')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('group')
                    ->label('Nhóm')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Lọc theo nhóm')
                    ->options([
                        'general' => 'Thông tin chung',
                        'homepage' => 'Trang chủ (Sứ mệnh & Thống kê)',
                        'about' => 'Trang Giới thiệu (Lịch sử, Tổ chức, Sứ mệnh)',
                        'seo' => 'Cấu hình SEO',
                        'contact' => 'Thông tin liên hệ',
                        'social' => 'Kênh truyền thông & MXH',
                        'content' => 'Nội dung dùng chung',
                    ]),
            ])
            ->defaultSort('group', 'asc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettings::route('/'),
            'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }
}
