<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\UserManageResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class UserManageResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'User';
    protected static ?string $modelLabel = 'User';
    protected static ?string $slug = 'users';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->description('Basic user details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Security')
                    ->description('Authentication details')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof Pages\CreateUserManage)
                            ->minLength(8)
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->revealable()
                            ->confirmed()
                            ->visible(fn ($livewire) => $livewire instanceof Pages\CreateUserManage),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->requiredWith('password')
                            ->minLength(8)
                            ->maxLength(255)
                            ->revealable()
                            ->visible(fn ($livewire) => $livewire instanceof Pages\CreateUserManage),

                        Forms\Components\Select::make('role')
                            ->label('User Role')
                            ->options(self::getEnumValues('users', 'role'))
                            ->required()
                            ->native(false)
                            ->default('developer'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'manager' => 'warning',
                        'user' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filter by Role')
                    ->options([
                        'admin' => 'Administrator',
                        'manager' => 'Manager',
                        'user' => 'Regular User',
                    ])
                    ->multiple()
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('xl')
                    ->modal(),

                Tables\Actions\Action::make('changePassword')
                    ->label('Change Password')
                    ->icon('heroicon-o-lock-closed')
                    ->form([
                        Forms\Components\TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->maxLength(255)
                            ->revealable()
                            ->confirmed(),

                        Forms\Components\TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->maxLength(255)
                            ->revealable(),
                    ])
                    ->action(function (User $user, array $data): void {
                        $user->update([
                            'password' => Hash::make($data['new_password']),
                        ]);
                    })
                    ->modal(),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected Users'),
                ]),
            ])
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserManages::route('/'),
            'create' => Pages\CreateUserManage::route('/create'),
        ];
    }

    public static function getEnumValues(string $table, string $column): array
    {
        $type = \DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array_map(fn ($value) => trim($value, "'"), explode(',', $matches[1]));

        return array_combine($enum, array_map('ucfirst', $enum));
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id', '!=', Auth::id());
    }
}
