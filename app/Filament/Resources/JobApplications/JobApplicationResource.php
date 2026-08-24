<?php

namespace App\Filament\Resources\JobApplications;

use App\Filament\Resources\JobApplications\Pages\EditJobApplication;
use App\Filament\Resources\JobApplications\Pages\ListJobApplications;
use App\Models\JobApplication;
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
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Hồ sơ ứng tuyển CV';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Hồ sơ ứng tuyển';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Hồ sơ ứng tuyển CV';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = JobApplication::where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin ứng viên & Hồ sơ CV')
                    ->components([
                        TextInput::make('job_title')
                            ->label('Vị trí ứng tuyển')
                            ->disabled(),
                        TextInput::make('fullname')
                            ->label('Họ và tên ứng viên')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Trạng thái hồ sơ')
                            ->options([
                                'new' => 'Mới nộp',
                                'reviewed' => 'Đã xem xét',
                                'interviewed' => 'Hẹn phỏng vấn',
                                'accepted' => 'Trúng tuyển',
                                'rejected' => 'Không phù hợp',
                            ])
                            ->required(),
                        FileUpload::make('cv_path')
                            ->label('File CV đính kèm')
                            ->disk('public')
                            ->downloadable()
                            ->openable()
                            ->disabled(),
                        Textarea::make('message')
                            ->label('Lời nhắn / Giới thiệu kinh nghiệm')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Thông tin kỹ thuật')
                    ->collapsed()
                    ->components([
                        TextInput::make('ip_address')
                            ->label('Địa chỉ IP')
                            ->disabled(),
                        TextInput::make('user_agent')
                            ->label('Trình duyệt / Thiết bị')
                            ->columnSpanFull()
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')
                    ->label('Họ tên ứng viên')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('job_title')
                    ->label('Vị trí ứng tuyển')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Đã sao chép số điện thoại'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Mới nộp',
                        'reviewed' => 'Đã xem',
                        'interviewed' => 'Phỏng vấn',
                        'accepted' => 'Trúng tuyển',
                        'rejected' => 'Từ chối',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'reviewed' => 'info',
                        'interviewed' => 'primary',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Thời gian nộp')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options([
                        'new' => 'Mới nộp',
                        'reviewed' => 'Đã xem',
                        'interviewed' => 'Hẹn phỏng vấn',
                        'accepted' => 'Trúng tuyển',
                        'rejected' => 'Từ chối',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => ListJobApplications::route('/'),
            'edit' => EditJobApplication::route('/{record}/edit'),
        ];
    }
}
