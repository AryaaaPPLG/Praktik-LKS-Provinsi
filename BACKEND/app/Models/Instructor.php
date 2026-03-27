<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $table = 'instructors';

    protected $fillable = [
        'user_id',
        'bio',
        'experience_year'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
