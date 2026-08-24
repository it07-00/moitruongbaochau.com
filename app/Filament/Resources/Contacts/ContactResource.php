<?php

namespace App\Filament\Resources\Contacts;

use App\ContactStatus;
use App\Filament\Resources\Contacts\Pages\CreateContact;
use App\Filament\Resources\Contacts\Pages\EditContact;
use App\Filament\Resources\Contacts\Pages\ListContacts;
use App\Models\Contact;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Yêu cầu tư vấn / Liên hệ';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Liên hệ';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Liên hệ khách hàng';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Contact::where('status', ContactStatus::New)->count();

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
                Section::make('Thông tin khách hàng liên hệ')
                    ->components([
                        TextInput::make('name')
                            ->label('Họ và tên')
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
                            ->maxLength(255),
                        TextInput::make('topic')
                            ->label('Chủ đề / Dịch vụ quan tâm')
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Trạng thái xử lý')
                            ->options(ContactStatus::class)
                            ->required(),
                        Textarea::make('message')
                            ->label('Nội dung tin nhắn khách gửi')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Thông tin kỹ thuật')
                    ->collapsed()
                    ->components([
                        TextInput::make('source')
                            ->label('Nguồn gửi')
                            ->disabled(),
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
                TextColumn::make('name')
                    ->label('Họ tên')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Đã sao chép số điện thoại'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('topic')
                    ->label('Dịch vụ cần tư vấn')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Thời gian gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options(ContactStatus::class),
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
            'index' => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }
}
