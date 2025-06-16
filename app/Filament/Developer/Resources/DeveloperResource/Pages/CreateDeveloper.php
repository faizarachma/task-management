<?php

namespace App\Filament\Developer\Resources\DeveloperResource\Pages;

use App\Filament\Developer\Resources\DeveloperResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeveloper extends CreateRecord
{
    protected static string $resource = DeveloperResource::class;
}
