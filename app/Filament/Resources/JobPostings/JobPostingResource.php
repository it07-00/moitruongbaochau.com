<?php

namespace App\Filament\Resources\JobPostings;

use App\ContentStatus;
use App\Filament\Resources\JobPostings\Pages\CreateJobPosting;
use App\Filament\Resources\JobPostings\Pages\EditJobPosting;
use App\Filament\Resources\JobPostings\Pages\ListJobPostings;
use App\Models\JobPosting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class JobPostingResource extends Resource
{
    protected static ?string $model = JobPosting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Nội dung khác';

    protected static ?string $navigationLabel = 'Tuyển dụng';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Vị trí tuyển dụng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tuyển dụng';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin vị trí tuyển dụng')
                    ->components([
                        TextInput::make('title')
                            ->label('Vị trí tuyển dụng')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Đường dẫn tĩnh (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(JobPosting::class, 'slug', ignoreRecord: true),
                        TextInput::make('location')
                            ->label('Địa điểm làm việc')
                            ->default('TP. Hồ Chí Minh')
                            ->maxLength(255),
                        TextInput::make('employment_type')
                            ->label('Hình thức làm việc')
                            ->default('Toàn thời gian')
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        DateTimePicker::make('expires_at')
                            ->label('Hạn nộp hồ sơ'),
                        Textarea::make('summary')
                            ->label('Mô tả ngắn vị trí')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Mô tả công việc (JD)')
                            ->columnSpanFull(),
                        RichEditor::make('requirements')
                            ->label('Yêu cầu ứng viên')
                            ->columnSpanFull(),
                        RichEditor::make('benefits')
                            ->label('Quyền lợi được hưởng')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Cấu hình SEO Meta')
                    ->collapsed()
                    ->components([
                        TextInput::make('meta_title')
                            ->label('Meta Title'),
                        TextInput::make('meta_description')
                            ->label('Meta Description'),
                        TextInput::make('canonical_url')
                            ->label('Canonical URL'),
                        TextInput::make('robots')
                            ->label('Robots Tag')
                            ->default('index,follow'),
                        TextInput::make('og_title')
                            ->label('OG Title'),
                        TextInput::make('og_description')
                            ->label('OG Description'),
                        FileUpload::make('og_image')
                            ->label('OG Image')
                            ->image()
                            ->directory('uploads/seo'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Vị trí tuyển dụng')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('location')
                    ->label('Địa điểm')
                    ->searchable(),
                TextColumn::make('employment_type')
                    ->label('Hình thức')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('expires_at')
                    ->label('Hạn nộp')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options(ContentStatus::class),
            ])
            ->defaultSort('id', 'desc')
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
            'index' => ListJobPostings::route('/'),
            'create' => CreateJobPosting::route('/create'),
            'edit' => EditJobPosting::route('/{record}/edit'),
        ];
    }
}
