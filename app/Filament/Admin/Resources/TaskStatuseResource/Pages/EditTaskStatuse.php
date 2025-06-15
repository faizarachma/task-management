<?php

namespace App\Filament\Resources\TaskStatuseResource\Pages;

use App\Filament\Resources\TaskStatuseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskStatuse extends EditRecord
{
    protected static string $resource = TaskStatuseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
