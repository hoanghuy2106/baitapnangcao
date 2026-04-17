<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Một sinh viên thuộc về MỘT lớp học (belongsTo)
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    // Một sinh viên đăng ký NHIỀU môn học (Many-to-Many)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
                    ->withPivot(['score', 'registered_at']); // Lấy thêm cột ở bảng trung gian
    }
    // app/Models/Student.php

// Nhớ import Subject ở đầu file nếu cần
public function scopeHighAchievers($query)
{
    // Lọc những sinh viên có điểm ở bảng trung gian > 8
    return $query->whereHas('subjects', function ($q) {
        $q->where('score', '>', 8.0);
    });
}
// app/Models/Student.php

protected static function booted()
{
    static::addGlobalScope('has_class', function ($builder) {
        $builder->whereNotNull('class_id');
    });
}
}
