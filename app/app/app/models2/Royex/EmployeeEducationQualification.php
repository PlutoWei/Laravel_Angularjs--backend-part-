<?php

namespace App\Models2\Royex;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationQualification extends Model
{
    protected $table = 'royex_employee_education_qualification';
    protected $primaryKey = 'employee_education_qualification_id';
    protected $fillable = [
        'employee_education_qualification_id','employee_id','institute','board_university','degree','passing_year','result','cgpa','year'
    ];
}
