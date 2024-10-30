<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'course_name', 'college', 'date_of_passing', 'persentage_of_mark', 'certificate_image'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
