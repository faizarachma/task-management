<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaskStatuseResource\Pages\ListTaskStatuses;
use App\Models\TaskStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Database\Eloquent\Builder;

class TaskStatuseResource extends Resource
{
    protected static ?string $model = TaskStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Task Statuses';
    protected static ?string $modelLabel = 'Task Status';
    protected static ?string $navigationGroup = 'Task Attributes';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Status Information')
                    ->description('Define the task status properties')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Status Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->unique(ignoreRecord: true),



                        ColorPicker::make('color')
                            ->label('Status Color')
                            ->required()
                            ->default('#6b7280')
                            ->rgb(),


                        Forms\Components\Toggle::make('is_default')
                            ->label('Default Status')
                            ->inline(false)
                            ->helperText('Mark this as the default status for new tasks'),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Status')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\ColorColumn::make('color')
                    ->label('Color')
                    ->width(80)
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_default')
                    ->label('Default')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modified')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\Filter::make('default_only')
                    ->label('Default Status Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_default', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->modalWidth('sm'),

                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->modalWidth('sm'),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->successNotificationTitle('Status deleted successfully'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete selected')
                        ->successNotificationTitle('Statuses deleted successfully'),
                ]),
            ])
            ->emptyStateHeading('No task statuses found')
            ->emptyStateDescription('Create your first task status to get started')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create Status')
                    ->modalWidth('sm'),
            ])
            ->deferLoading()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTaskStatuses::route('/'),
        ];
    }
}
