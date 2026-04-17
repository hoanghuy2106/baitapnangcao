<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
{
    return true; // Cho phép mọi người dùng thực hiện (để test cho dễ)
}

public function rules(): array
{
    return [
        'student_name' => 'required|string|max:255',
        // Kiểm tra class_id phải tồn tại trong bảng classrooms (Bài 2)
        'class_id' => 'required|exists:classrooms,id', 
        // Kiểm tra danh sách môn học (nếu có)
        'subject_ids' => 'array',
        'subject_ids.*' => 'exists:subjects,id',
    ];
}

public function messages(): array
{
    return [
        'student_name.required' => 'Tên sinh viên không được bỏ trống nhé Tú!',
        'class_id.exists' => 'Mã lớp học này không tồn tại trong hệ thống.',
    ];
}
}
