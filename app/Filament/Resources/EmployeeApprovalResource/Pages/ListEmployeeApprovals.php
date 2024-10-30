<?php

namespace App\Filament\Resources\EmployeeApprovalResource\Pages;

use App\Filament\Resources\EmployeeApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeApprovals extends ListRecords
{
    protected static string $resource = EmployeeApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
