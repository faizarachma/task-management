<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeverityResource\Pages;
use App\Filament\Resources\SeverityResource\RelationManagers;
use App\Models\Severity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeverityResource extends Resource
{
    protected static ?string $model = Severity::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle'; // Icon lebih relevan
    protected static ?string $navigationLabel = 'Severity'; // Label lebih deskriptif
    protected static ?string $modelLabel = 'Severity Management';
    protected static ?string $navigationGroup = 'Setting'; // Grup navigasi untuk konsistensi
    protected static ?string $slug = 'Severity Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tingkat Keparahan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Select::make('color')
                    ->label('Warna')
                    ->options([
                        'red' => 'Merah',
                        'green' => 'Hijau',
                        'blue' => 'Biru',
                        'yellow' => 'Kuning',
                        'purple' => 'Ungu',
                        'gray' => 'Abu-abu',
                    ])
                    ->default('gray')
                    ->required()
                    ->native(false) // Untuk tampilan yang lebih baik
                    ->columnSpan(1),

                Forms\Components\TextInput::make('priority')
                    ->label('Prioritas (1-10)')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(10)
                    ->default(1)
                    ->columnSpan(1),
            ])
            ->columns(2); // Membagi form menjadi 2 kolom
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ColorColumn::make('color')
                    ->label('Warna')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioritas')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('md')
                    ->modalHeading('Edit Tingkat Keparahan')
                    ->icon('heroicon-o-pencil'),

                Tables\Actions\ViewAction::make()
                    ->modalWidth('md')
                    ->icon('heroicon-o-eye'),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // ->headerActions([
            //     Tables\Actions\CreateAction::make()
            //         ->modalWidth('md')
            //         ->modalHeading('Tambah Tingkat Keparahan Baru')
            //         ->label('Tambah Baru')
            //         ->icon('heroicon-o-plus'),
            // ])
            ->defaultSort('priority', 'asc') // Urutkan berdasarkan prioritas
            ->emptyStateHeading('Belum ada Tingkat Keparahan')
            ->emptyStateDescription('Klik tombol "Tambah Baru" untuk membuat yang pertama');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeverities::route('/'),
            // Hapus rute create dan edit karena menggunakan modal
        ];
    }
}
