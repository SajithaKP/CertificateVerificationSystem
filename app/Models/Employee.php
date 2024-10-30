<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'age', 'email', 'dob', 'gender', 'address', 'profile_image', 'id_proof'
    ];

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperince::class);
    }
    public function latestEducation()
    {
        return $this->hasOne(Education::class)->latestOfMany(); // Fetch latest education
    }
    public function latestWorkExperience()
    {
        return $this->hasOne(WorkExperince::class)->latestOfMany(); // Fetch latest work experience
    }

}
