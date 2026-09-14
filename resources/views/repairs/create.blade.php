@extends('layouts.app')

@section('title', 'แจ้งซ่อมใหม่ - ระบบแจ้งซ่อมอุปกรณ์ IT')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">แจ้งซ่อมอุปกรณ์ IT</h4>

            <form action="{{ route('repairs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">ชื่อผู้แจ้ง <span class="text-danger">*</span></label>
                    <input type="text" name="requester_name"
                           class="form-control @error('requester_name') is-invalid @enderror"
                           value="{{ old('requester_name') }}">
                    @error('requester_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">หน่วยงาน / แผนก</label>
                    <input type="text" name="department"
                           class="form-control @error('department') is-invalid @enderror"
                           value="{{ old('department') }}">
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">ชื่ออุปกรณ์ <span class="text-danger">*</span></label>
                    <input type="text" name="equipment_name"
                           class="form-control @error('equipment_name') is-invalid @enderror"
                           value="{{ old('equipment_name') }}">
                    @error('equipment_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รายละเอียดปัญหา <span class="text-danger">*</span></label>
                    <textarea name="problem_detail" rows="4"
                              class="form-control @error('problem_detail') is-invalid @enderror">{{ old('problem_detail') }}</textarea>
                    @error('problem_detail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รูปภาพปัญหา (jpg, jpeg, png ไม่เกิน 2MB)</label>
                    <input type="file" name="image" accept="image/*"
                           class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-success" type="submit">บันทึก</button>
                    <a href="{{ route('repairs.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
                </div>
            </form>
        </div>
    </div>
@endsection
