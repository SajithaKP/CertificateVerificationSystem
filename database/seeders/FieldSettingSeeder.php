<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;

// class FieldSettingSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         //
//     }
// }
use Illuminate\Database\Seeder;
use App\Models\FieldSetting;

class FieldSettingSeeder extends Seeder
{
    public function run()
    {
        
    //     $fields = [
    //         'name', 'age', 'email', 'dob', 'gender', 'address', 'image', 'id_proof',
    //         'course_name', 'college', 'date_of_passing', 'percentage_of_mark', 'certificate_image',
    //         'company_name', 'from_date', 'to_date', 'years_of_experience', 'experience_image'
    //     ];

    //     foreach ($fields as $field) {
    //         FieldSetting::updateOrCreate(['field_name' => $field], ['is_enabled' => true]);
    //     }
    $fields = [
        'name', 'age', 'email', 'dob', 'gender', 'address', 'image', 'id_proof',
        'course_name', 'college', 'date_of_passing', 'percentage_of_mark', 'certificate_image',
        'company_name', 'from_date', 'to_date', 'years_of_experience', 'experience_image'
    ];

    foreach ($fields as $field) {
        FieldSetting::updateOrCreate(
            ['field_name' => $field],
            ['is_enabled' => true]
        );
    }

    // Seed wizard steps with default ordering
    FieldSetting::updateOrCreate(
        ['field_name' => 'Personal Details'],
        ['is_enabled' => true, 'step_order' => 1]
    );
    FieldSetting::updateOrCreate(
        ['field_name' => 'Education Details'],
        ['is_enabled' => true, 'step_order' => 2]
    );
    FieldSetting::updateOrCreate(
        ['field_name' => 'Work Experiences'],
        ['is_enabled' => true, 'step_order' => 3]
    );
    }
    
}

