<?php

namespace App\Filament\Developer\Resources\TaskDeveloperResource\Pages;

use App\Filament\Developer\Resources\TaskDeveloperResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskDeveloper extends EditRecord
{
    protected static string $resource = TaskDeveloperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
