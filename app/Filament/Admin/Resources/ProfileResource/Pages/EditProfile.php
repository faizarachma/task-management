<?php

namespace App\Filament\Admin\Resources\ProfileResource\Pages;

use App\Filament\Admin\Resources\ProfileResource;
use Filament\Resources\Pages\EditRecord;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    public function mount($record): void
    {
        // Get the authenticated user's ID
        $user = auth()->user();

        // Ensure we're only editing the logged-in user's profile
        if ($record != $user->id) {
            abort(403, 'You can only edit your own profile');
        }

        // Set the record to the authenticated user
        $this->record = $user;

        // Call parent mount with the record ID
        parent::mount($record);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => auth()->id()]);
    }
}
