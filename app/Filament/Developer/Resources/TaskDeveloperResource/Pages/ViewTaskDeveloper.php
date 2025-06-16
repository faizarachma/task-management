<?php

namespace App\Filament\Developer\Resources\TaskDeveloperResource\Pages;

use App\Filament\Developer\Resources\TaskDeveloperResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTaskDeveloper extends ViewRecord
{
    protected static string $resource = TaskDeveloperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
