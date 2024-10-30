<?php

namespace App\Filament\Resources\EmployeeApprovalResource\Pages;

use App\Filament\Resources\EmployeeApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeApproval extends EditRecord
{
    protected static string $resource = EmployeeApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
