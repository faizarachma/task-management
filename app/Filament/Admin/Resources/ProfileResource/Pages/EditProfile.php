<?php

namespace App\Filament\Admin\Resources\ProfileResource\Pages;

use App\Filament\Admin\Resources\ProfileResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    // Pastikan akses public dan override method getRecord() untuk ambil user login
    public function getRecord(): Model
    {
        return auth()->user();
    }

    protected function getRedirectUrl(): string
    {
        // Setelah edit, redirect ke halaman edit profil user login juga
        return $this->getResource()::getUrl('edit', ['record' => auth()->id()]);
    }
}
