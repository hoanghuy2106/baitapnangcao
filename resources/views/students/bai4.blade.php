@extends('layouts.app') {{-- Nếu bạn có layout chung, không thì dùng HTML cơ bản --}}

@section('content')
<div class="container">
    <h2>Kết quả truy vấn Bài 4</h2>

    <h4>1. Sinh viên lớp CNTT1</h4>
    <table class="table">
        @foreach($studentsInCNTT1 as $sv)
            <tr><td>{{ $sv->student_name }}</td></tr>
        @endforeach
    </table>

    <h4>2. Môn học của SV có ID = 5</h4>
    <ul>
        @forelse($subjectsOfStudent5 as $mon)
            <li>{{ $mon->subject_name }} - Điểm: {{ $mon->pivot->score }}</li>
        @empty
            <li>Không tìm thấy sinh viên hoặc sinh viên chưa đăng ký môn nào.</li>
        @endforelse
    </ul>

    <h4>3. Thống kê sinh viên theo lớp</h4>
    <table class="table">
        @foreach($classCounts as $class)
            <tr>
                <td>Lớp: {{ $class->class_name }}</td>
                <td>Sĩ số: {{ $class->students_count }}</td>
            </tr>
        @endforeach
    </table>

    <h4>4. Danh sách SV và số lượng môn đăng ký</h4>
    <table class="table">
        <thead>
            <tr><th>Tên SV</th><th>Số môn</th></tr>
        </thead>
        <tbody>
            @foreach($studentSubjectCounts as $row)
                <tr>
                    <td>{{ $row->student_name }}</td>
                    <td>{{ $row->registration_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection