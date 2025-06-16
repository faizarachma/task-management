<?php

namespace App\Filament\Developer\Resources\DeveloperResource\Pages;

use App\Filament\Developer\Resources\DeveloperResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDevelopers extends ListRecords
{
    protected static string $resource = DeveloperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
