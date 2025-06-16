<?php

namespace App\Filament\Admin\Resources\ProfileResource\Pages;

use App\Filament\Admin\Resources\ProfileResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;


    public function getRecord(): Model
    {
        return auth()->user();
    }

    protected function getRedirectUrl(): string
    {

        return $this->getResource()::getUrl('edit', ['record' => auth()->id()]);
    }
}
