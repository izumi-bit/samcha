<?php

namespace App\Filament\Resources\JobpResource\Pages;

use App\Filament\Resources\JobpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobp extends EditRecord
{
    protected static string $resource = JobpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
