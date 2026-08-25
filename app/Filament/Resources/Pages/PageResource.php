<?php

namespace App\Filament\Resources\Pages;

use App\ContentStatus;
use App\Filament\Forms\Components\SeoSection;
use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
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

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static string|UnitEnum|null $navigationGroup = 'Nội dung khác';

    protected static ?string $navigationLabel = 'Trang tĩnh / Giới thiệu';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Trang';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Trang tĩnh';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin trang')
                    ->components([
                        TextInput::make('title')
                            ->label('Tiêu đề trang')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, callable $set, callable $get) {
                                if ($operation === 'create' || blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                                if (blank($get('meta_title'))) {
                                    $set('meta_title', $state);
                                }
                                if (blank($get('og_title'))) {
                                    $set('og_title', $state);
                                }
                            }),
                        TextInput::make('slug')
                            ->label('Đường dẫn tĩnh (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(Page::class, 'slug', ignoreRecord: true),
                        Select::make('template')
                            ->label('Giao diện mẫu (Template)')
                            ->options([
                                'default' => 'Mặc định (Standard Page)',
                                'about' => 'Trang Giới thiệu (About Us)',
                            ])
                            ->default('default')
                            ->required(),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Ngày xuất bản')
                            ->default(now()),
                        Textarea::make('excerpt')
                            ->label('Mô tả tóm tắt')
                            ->rows(3)
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set, callable $get) {
                                if (filled($state)) {
                                    $clean = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($state))), 160, '');
                                    if (blank($get('meta_description'))) {
                                        $set('meta_description', $clean);
                                    }
                                    if (blank($get('og_description'))) {
                                        $set('og_description', $clean);
                                    }
                                }
                            }),
                        RichEditor::make('content')
                            ->label('Nội dung chi tiết trang')
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set, callable $get) {
                                if (blank($get('meta_description')) && filled($state)) {
                                    $clean = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($state))), 160, '');
                                    $set('meta_description', $clean);
                                    if (blank($get('og_description'))) {
                                        $set('og_description', $clean);
                                    }
                                }
                            }),
                    ])->columns(2),

                SeoSection::make(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Tiêu đề trang')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                TextColumn::make('template')
                    ->label('Template')
                    ->badge()
                    ->color('info'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật lần cuối')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options(ContentStatus::class),
            ])
            ->defaultSort('id', 'asc')
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
