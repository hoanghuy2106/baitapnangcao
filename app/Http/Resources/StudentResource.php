<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'ma_so' => $this->id,
        'ho_ten' => $this->student_name,
        // Hợp tác với Bài 3: Lấy thông tin lớp qua quan hệ
        'lop_hoc' => $this->classroom->class_name ?? 'Chưa có lớp',
        // Hợp tác với Bài 4: Lấy danh sách môn học và điểm
        'mon_hoc' => $this->subjects->map(function ($subject) {
            return [
                'ten_mon' => $subject->subject_name,
                'diem_so' => $subject->pivot->score,
            ];
        }),
    ];
}
}
