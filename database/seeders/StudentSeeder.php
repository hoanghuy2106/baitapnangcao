<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    // 1. Tạo Lớp học mẫu
    $class1 = \App\Models\Classroom::create(['class_name' => 'CNTT1']);
    $class2 = \App\Models\Classroom::create(['class_name' => 'Marketing']);

    // 2. Tạo Môn học mẫu
    $sub1 = \App\Models\Subject::create(['subject_name' => 'Lập trình Laravel']);
    $sub2 = \App\Models\Subject::create(['subject_name' => 'Cơ sở dữ liệu']);

    // 3. Tạo Sinh viên mẫu
    $student = \App\Models\Student::create([
        'student_name' => 'Nguyễn Văn Tú',
        'class_id' => $class1->id
    ]);

    // 4. Cho sinh viên đăng ký môn học (Dữ liệu bảng Pivot)
    $student->subjects()->attach($sub1->id, [
        'score' => 8.5,
        'registered_at' => now()
    ]);
    $student->subjects()->attach($sub2->id, [
        'score' => 9.0,
        'registered_at' => now()
    ]);
}
}
