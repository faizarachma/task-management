<?php

namespace App\Filament\Resources\UserManageResource\Pages;

use App\Filament\Admin\Resources\UserManageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserManage extends EditRecord
{
    protected static string $resource = UserManageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
