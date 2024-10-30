<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperince extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'company_name', 'from_date', 'to_date','years_of_experience','experience_image'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
