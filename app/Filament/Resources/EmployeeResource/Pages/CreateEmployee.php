<?php

// namespace App\Filament\Resources\EmployeeResource\Pages;

// use App\Filament\Resources\EmployeeResource;
// use Filament\Actions;
// use Filament\Resources\Pages\CreateRecord;

// class CreateEmployee extends CreateRecord
// {
//     protected static string $resource = EmployeeResource::class;
// }


namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Education;
use App\Models\WorkExperince;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Extract personal details data
        $employeeData = [
            'name' => $data['name'],
            'age' => $data['age'],
            'email' => $data['email'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'image' => $data['image'],
            'id_proof' => $data['id_proof'],
        ];
        try {
        // Create employee record
        $employee = Employee::create($employeeData);

        // // Save multiple education entries
        // foreach ($data['education'] as $educationData) {
        //     $educationData['employee_id'] = $employee->id;
        //     Education::create($educationData);
        // }

        // // Save multiple work experience entries
        // foreach ($data['work_experiences'] as $experienceData) {
        //     $experienceData['employee_id'] = $employee->id;
        //     WorkExperince::create($experienceData);
        // }

        Log::info('Employee created with ID:', ['employee_id' => $employee->id]);

        if (isset($data['educations']) && is_array($data['educations'])) {
            foreach ($data['educations'] as $educationData) {
                $educationData['employee_id'] = $employee->id;
                Education::create($educationData);
            }
        }

        if (isset($data['work_experiences']) && is_array($data['work_experiences'])) {
            foreach ($data['work_experiences'] as $experienceData) {
                $experienceData['employee_id'] = $employee->id;
                WorkExperince::create($experienceData);
            }
        }
    } catch (\Exception $e) {
        Log::error('Error creating employee or related records:', ['message' => $e->getMessage()]);
        throw $e; // Re-throw to allow Filament to handle the error
    }

        return $employee;
    }

    protected function getRedirectUrl(): string
    {
        return EmployeeResource::getUrl('index');
    }
}
