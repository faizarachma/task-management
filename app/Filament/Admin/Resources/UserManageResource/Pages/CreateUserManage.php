<?php

namespace App\Filament\Resources\UserManageResource\Pages;

use App\Filament\Admin\Resources\UserManageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserManage extends CreateRecord
{
    protected static string $resource = UserManageResource::class;
}
