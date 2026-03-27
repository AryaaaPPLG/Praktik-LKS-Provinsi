<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $table = "enrolments";

    protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
