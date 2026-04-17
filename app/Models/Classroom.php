<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    // Một lớp học có NHIỀU sinh viên (hasMany)
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
