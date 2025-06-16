<?php

namespace App\Filament\Developer\Resources\DeveloperResource\Pages;

use App\Filament\Developer\Resources\DeveloperResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeveloper extends EditRecord
{
    protected static string $resource = DeveloperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
