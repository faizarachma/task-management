<?php

namespace App\Filament\Admin\Resources\SeverityResource\Pages;

use App\Filament\Admin\Resources\SeverityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeverity extends EditRecord
{
    protected static string $resource = SeverityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
