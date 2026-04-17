<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
class StudentController extends Controller
{
    public function exercise4()
    {
        // 1. Lấy danh sách sinh viên thuộc lớp “CNTT1”
        // Sử dụng quan hệ 'classroom' đã khai báo ở Bài 3
        $studentsCNTT1 = Student::whereHas('classroom', function ($query) {
            $query->where('class_name', 'CNTT1');
        })->get();

        // 2. Lấy tất cả môn học mà sinh viên có id = 5 đã đăng ký
        // Sử dụng quan hệ 'subjects' (n-n) đã khai báo ở Bài 3
        $student = Student::with('subjects')->find(5);
        $subjects = $student ? $student->subjects : collect();

        // 3. Đếm số sinh viên theo từng lớp
        // Sử dụng withCount dựa trên quan hệ 'students' trong model Classroom
        $classCounts = Classroom::withCount('students')->get();

        // 4. Lấy danh sách sinh viên kèm số lượng môn đăng ký
        // Dùng Query Builder kết hợp LEFT JOIN đúng như yêu cầu Bài 4
        $studentStats = DB::table('students')
            ->leftJoin('student_subject', 'students.id', '=', 'student_subject.student_id')
            ->select(
                'students.id', 
                'students.student_name', 
                DB::raw('count(student_subject.subject_id) as subjects_registered')
            )
            ->groupBy('students.id', 'students.student_name')
            ->get();

        // Trả về dữ liệu (Có thể return view hoặc return json tùy bạn)
        return response()->json([
            'cau_1' => $studentsCNTT1,
            'cau_2' => $subjects,
            'cau_3' => $classCounts,
            'cau_4' => $studentStats
        ]);
    }
    // app/Http/Controllers/StudentController.php

public function exercise5()
{
    // Sử dụng Local Scope đã tạo
    $excellentStudents = Student::highAchievers()->with('classroom')->get();

    // Lưu ý: Câu lệnh này sẽ tự động dính Global Scope (chỉ lấy SV có lớp)
    $allValidStudents = Student::all(); 

    return view('students.bai5', compact('excellentStudents', 'allValidStudents'));
}
public function exercise6($id)
{
    // Tìm sinh viên kèm theo các quan hệ (Eager Loading)
    $student = Student::with(['classroom', 'subjects'])->find($id);

    if (!$student) {
        return response()->json(['message' => 'Không tìm thấy sinh viên'], 404);
    }

    // Trả về dữ liệu đã qua "bộ lọc" Resource
    return new StudentResource($student);
}
public function store(StoreStudentRequest $request)
{
    // 1. Lấy dữ liệu đã được kiểm chứng
    $validated = $request->validated();

    // 2. Tạo sinh viên mới (Dùng Mass Assignment)
    $student = Student::create([
        'student_name' => $validated['student_name'],
        'class_id' => $validated['class_id'],
    ]);

    // 3. Hợp tác Bài 3: Nếu có chọn môn học, dùng attach để lưu vào bảng pivot
    if ($request->has('subject_ids')) {
        $student->subjects()->attach($request->subject_ids);
    }

    return response()->json([
        'message' => 'Thêm sinh viên thành công!',
        'data' => $student
    ], 201);
}protected $fillable = ['student_name', 'class_id'];
}