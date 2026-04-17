<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // Một môn học có NHIỀU sinh viên đăng ký (Many-to-Many)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject')
                    ->withPivot(['score', 'registered_at']);
    }
}
