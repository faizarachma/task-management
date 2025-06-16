<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaskResource\Pages;
use App\Filament\Admin\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Tasks';
    protected static ?string $modelLabel = 'Task';
    protected static ?string $slug = 'tasks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Task Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Task Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->rows(5),

                        Forms\Components\DatePicker::make('deadline')
                            ->label('Deadline')
                            ->required()
                            ->native(false)
                            ->minDate(now()), // Opsional: hanya bisa memilih tanggal mulai hari ini



                    ]),

                Forms\Components\Section::make('Task Details')
                    ->schema([
                        Forms\Components\Select::make('severity_id')
                            ->label('Severity Level')
                            ->relationship('severity', 'name')
                            ->required()
                            ->native(false)
                            ->preload(),

                        Forms\Components\Select::make('task_status_id')
                            ->label('Task Status')
                            ->relationship('taskStatus', 'name')
                            ->required()
                            ->native(false)
                            ->preload(),

                        Forms\Components\Select::make('user_id')
                            ->label('Assigned To')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->preload(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('severity.name')
                    ->label('Severity')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Low' => 'gray',
                        'Medium' => 'warning',
                        'High' => 'danger',
                        default => 'primary',
                    }),

                Tables\Columns\TextColumn::make('taskStatus.name')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'In Progress' => 'info',
                        'Completed' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Assignee')
                    ->sortable(),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('severity_id')
                    ->label('Severity')
                    ->relationship('severity', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('task_status_id')
                    ->label('Status')
                    ->relationship('taskStatus', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Assignee')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->modalWidth('xl')
                    ->modal(),

                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->modalWidth('xl')
                    ->modal(),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected'),
                ]),
            ]);

            // ->emptyStateHeading('No tasks found')
            // ->emptyStateDescription('Click "New Task" to create your first task')
            // ->emptyStateActions([
            //     Tables\Actions\CreateAction::make()
            //         ->label('Create Task')
            //         ->modalWidth('xl')
            //         ->modal(),
            // ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\TaskResource\Pages\ListTasks::route('/'),
        ];
    }
}
