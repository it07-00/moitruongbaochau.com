<?php

namespace App\Filament\Resources\EnvironmentSurveys;

use App\Filament\Resources\EnvironmentSurveys\Pages\EditEnvironmentSurvey;
use App\Filament\Resources\EnvironmentSurveys\Pages\ListEnvironmentSurveys;
use App\Filament\Resources\EnvironmentSurveys\Pages\ViewEnvironmentSurvey;
use App\Filament\Resources\EnvironmentSurveys\Tables\EnvironmentSurveysTable;
use App\Models\EnvironmentSurvey;
use App\Support\EnvironmentSurveyDefinition;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class EnvironmentSurveyResource extends Resource
{
    protected static ?string $model = EnvironmentSurvey::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'company_name';

    protected static ?string $slug = 'khao-sat-bvmt';

    protected static string|UnitEnum|null $navigationGroup = 'Khách hàng & Liên hệ';

    protected static ?string $navigationLabel = 'Khảo sát công tác BVMT 2026';

    public static function getModelLabel(): string
    {
        return 'Phiếu khảo sát BVMT';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Phiếu khảo sát BVMT';
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
                        ->options(EnvironmentSurveyDefinition::statuses())
                        ->required(),
                    Select::make('current_step')
                        ->label('Bước hiện tại')
                        ->options(EnvironmentSurveyDefinition::steps())
                        ->required(),
                    DateTimePicker::make('submitted_at')
                        ->label('Ngày gửi phiếu'),
                ])
                ->columns(2),
        ];

        foreach (EnvironmentSurveyDefinition::steps() as $stepNumber => $stepLabel) {
            $stepComponents = [];

            foreach (EnvironmentSurveyDefinition::fields($stepNumber) as $key => $field) {
                $stepComponents[] = self::buildFieldComponent('data.'.$key, $field);
            }

            foreach (EnvironmentSurveyDefinition::tables($stepNumber) as $tableKey => $table) {
                $rowComponents = [];
                foreach ($table['fields'] as $fieldName => $field) {
                    $rowComponents[] = self::buildFieldComponent($fieldName, $field);
                }

                $stepComponents[] = Repeater::make('data.'.$tableKey)
                    ->label($table['label'])
                    ->schema($rowComponents)
                    ->columns(min(4, max(2, count($rowComponents))))
                    ->defaultItems(0)
                    ->columnSpanFull();
            }

            if ($stepNumber === 6) {
                foreach (EnvironmentSurveyDefinition::documents() as $docKey => $docLabel) {
                    $stepComponents[] = Select::make("data.documents.{$docKey}.status")
                        ->label($docLabel)
                        ->options([
                            'available' => 'Có',
                            'not_available' => 'Không có',
                            'pending' => 'Đang bổ sung',
                        ]);
                    $stepComponents[] = TextInput::make("data.documents.{$docKey}.note")
                        ->label("Ghi chú ({$docLabel})")
                        ->maxLength(2000);
                }
            }

            if ($stepComponents !== []) {
                $components[] = Section::make("Bước {$stepNumber}: {$stepLabel}")
                    ->collapsible()
                    ->collapsed($stepNumber > 1)
                    ->components($stepComponents)
                    ->columns(2);
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
            'textarea' => Textarea::make($statePath)
                ->label($field['label'])
                ->rows(3)
                ->maxLength((int) ($field['max'] ?? 5000))
                ->columnSpanFull(),
            'select' => Select::make($statePath)
                ->label($field['label'])
                ->options($field['options'] ?? []),
            'boolean', 'checkbox' => Toggle::make($statePath)
                ->label($field['label']),
            'integer', 'decimal', 'month' => TextInput::make($statePath)
                ->label($field['label'])
                ->numeric(),
            'email' => TextInput::make($statePath)
                ->label($field['label'])
                ->email()
                ->maxLength(255),
            default => TextInput::make($statePath)
                ->label($field['label'])
                ->maxLength((int) ($field['max'] ?? 255)),
        };
    }

    public static function table(Table $table): Table
    {
        return EnvironmentSurveysTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEnvironmentSurveys::route('/'),
            'view' => ViewEnvironmentSurvey::route('/{record}'),
            'edit' => EditEnvironmentSurvey::route('/{record}/edit'),
        ];
    }
}
