<?php

namespace App\Filament\Admin\Resources\TaskStatuseResource\Pages;

use App\Filament\Admin\Resources\TaskStatuseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaskStatuses extends ListRecords
{
    protected static string $resource = TaskStatuseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
