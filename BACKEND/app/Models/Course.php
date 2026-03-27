<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'title',
        'description',
        'price',
        'image'
    ];

    public function materials() {
        return $this->hasMany(Material::class);
    }

    public function instructor() 
    {
        return $this->belongsTo(Instructor::class);
    }

    public function categories() 
    {
        return $this->belongsToMany(Categories::class, 'course_category'); 
    }

    public static function getAllCourses() 
    {
        return self::with(['materials', 'instructor.user'])->get();
    }

    public static function getAllCourseDetail($id)
    {
        return self::with(['materials', 'instructor.user'])->findOrFail($id);
    }
}
