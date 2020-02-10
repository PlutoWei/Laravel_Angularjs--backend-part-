<?php

namespace App\Models2\Royex;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'royex_job';
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'job_id', 'job_title','post','job_description','application_end_date','created_by','updated_by','status'
    ];

    public function createdBy(){
        return $this->belongsTo(Employee::class,'created_by');
    }
}
