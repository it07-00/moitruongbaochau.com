<?php

namespace App\Filament\Resources\GhgDeclarations;

use App\Filament\Resources\GhgDeclarations\Pages\EditGhgDeclaration;
use App\Filament\Resources\GhgDeclarations\Pages\ListGhgDeclarations;
use App\Filament\Resources\GhgDeclarations\Pages\ViewGhgDeclaration;
use App\Filament\Resources\GhgDeclarations\Tables\GhgDeclarationsTable;
use App\Models\GhgDeclaration;
use App\Support\GhgSurveyDefinition;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class GhgDeclarationResource extends Resource
{
    protected static ?string $model = GhgDeclaration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Phiếu khai báo khí nhà kính';

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function getModelLabel(): string
    {
        return 'Phiếu khai báo khí nhà kính';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Phiếu khai báo khí nhà kính';
    }

    public static function canViewAny(): bool
    {
        return (bool) auth()->user()?->is_admin;
    }

    public static function canView(Model $record): bool
    {
        return self::canViewAny();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return self::canViewAny();
    }

    public static function canDelete(Model $record): bool
    {
        return self::canViewAny();
    }

    public static function canDeleteAny(): bool
    {
        return self::canViewAny();
    }

    public static function form(Schema $schema): Schema
    {
        $components = [
            Section::make('Thông tin quản lý phiếu')
                ->components([
                    TextInput::make('reference')
                        ->label('Mã phiếu')
                        ->disabled()
                        ->dehydrated(false),
                    TextInput::make('company_name')
                        ->label('Tên doanh nghiệp')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('contact_email')
                        ->label('Email liên hệ')
                        ->email()
                        ->maxLength(255),
                    Select::make('status')
                        ->label('Trạng thái')
                        ->options([
                            'draft' => 'Bản nháp',
                            'submitted' => 'Đã nộp',
                        ])
                        ->required(),
                    Select::make('current_step')
                        ->label('Bước hiện tại')
                        ->options(GhgSurveyDefinition::steps())
                        ->required(),
                    DateTimePicker::make('submitted_at')
                        ->label('Ngày nộp phiếu'),
                ])
                ->columns(2),
        ];

        $generalComponents = [];
        foreach (GhgSurveyDefinition::generalFields() as $key => $field) {
            $generalComponents[] = self::buildFieldComponent("data.1.{$key}", $field);
        }

        $components[] = Section::make('Bước 1: '.GhgSurveyDefinition::steps()[1])
            ->collapsible()
            ->components($generalComponents)
            ->columns(2);

        foreach (range(2, 6) as $stepNumber) {
            $stepLabel = GhgSurveyDefinition::steps()[$stepNumber];
            $stepComponents = [];

            foreach (GhgSurveyDefinition::sections($stepNumber) as $sectionKey => $section) {
                $rowComponents = [];
                foreach ($section['fields'] as $fieldName => $field) {
                    $rowComponents[] = self::buildFieldComponent($fieldName, $field);
                }

                $stepComponents[] = Repeater::make("data.{$stepNumber}.{$sectionKey}")
                    ->label($section['label'])
                    ->schema($rowComponents)
                    ->columns(min(4, max(2, count($rowComponents))))
                    ->defaultItems(0)
                    ->columnSpanFull();
            }

            if ($stepComponents !== []) {
                $components[] = Section::make("Bước {$stepNumber}: {$stepLabel}")
                    ->collapsible()
                    ->collapsed()
                    ->components($stepComponents);
            }
        }

        return $schema->components($components);
    }

    /**
     * @param  array<string, mixed>  $field
     */
    private static function buildFieldComponent(string $statePath, array $field): Component
    {
        return match ($field['type'] ?? 'text') {
            'select' => Select::make($statePath)
                ->label($field['label'])
                ->options($field['options'] ?? []),
            'number', 'decimal' => TextInput::make($statePath)
                ->label($field['label'])
                ->numeric(),
            'email' => TextInput::make($statePath)
                ->label($field['label'])
                ->email()
                ->maxLength(255),
            default => TextInput::make($statePath)
                ->label($field['label'])
                ->maxLength(255),
        };
    }

    public static function table(Table $table): Table
    {
        return GhgDeclarationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGhgDeclarations::route('/'),
            'view' => ViewGhgDeclaration::route('/{record}'),
            'edit' => EditGhgDeclaration::route('/{record}/edit'),
        ];
    }
}
