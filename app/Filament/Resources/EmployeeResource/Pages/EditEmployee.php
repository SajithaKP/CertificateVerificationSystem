<?php 
namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Education;
use App\Models\WorkExperince;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function saved(): void
    {
        $data = $this->form->getState(); // Fetches the current form state

        // Update education records
        $this->record->education()->delete(); // Delete old records
        foreach ($data['education'] as $educationData) {
            $educationData['employee_id'] = $this->record->id;
            Education::create($educationData); // Insert new education records
        }

        // Update work experience records
        $this->record->workExperiences()->delete(); // Delete old records
        foreach ($data['work_experiences'] as $experienceData) {
            $experienceData['employee_id'] = $this->record->id;
            WorkExperince::create($experienceData); // Insert new work experience records
        }
    }

    protected function getRedirectUrl(): string
    {
        return EmployeeResource::getUrl('index');
    }
}
