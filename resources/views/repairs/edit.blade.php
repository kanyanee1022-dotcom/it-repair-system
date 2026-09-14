@extends('layouts.app')

@section('title', 'แก้ไขรายการแจ้งซ่อม - ระบบแจ้งซ่อมอุปกรณ์ IT')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">แก้ไขรายการแจ้งซ่อม</h4>

            <form action="{{ route('repairs.update', $repair->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ชื่อผู้แจ้ง <span class="text-danger">*</span></label>
                    <input type="text" name="requester_name"
                           class="form-control @error('requester_name') is-invalid @enderror"
                           value="{{ old('requester_name', $repair->requester_name) }}">
                    @error('requester_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">หน่วยงาน / แผนก</label>
                    <input type="text" name="department"
                           class="form-control @error('department') is-invalid @enderror"
                           value="{{ old('department', $repair->department) }}">
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">ชื่ออุปกรณ์ <span class="text-danger">*</span></label>
                    <input type="text" name="equipment_name"
                           class="form-control @error('equipment_name') is-invalid @enderror"
                           value="{{ old('equipment_name', $repair->equipment_name) }}">
                    @error('equipment_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รายละเอียดปัญหา <span class="text-danger">*</span></label>
                    <textarea name="problem_detail" rows="4"
                              class="form-control @error('problem_detail') is-invalid @enderror">{{ old('problem_detail', $repair->problem_detail) }}</textarea>
                    @error('problem_detail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">สถานะ <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="pending" {{ old('status', $repair->status) == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                        <option value="processing" {{ old('status', $repair->status) == 'processing' ? 'selected' : '' }}>กำลังดำเนินการ</option>
                        <option value="completed" {{ old('status', $repair->status) == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รูปภาพใหม่ (เว้นว่างไว้หากไม่ต้องการเปลี่ยน)</label>
                    <input type="file" name="image" accept="image/*"
                           class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($repair->image)
                        <div class="mt-2">
                            <small class="text-muted d-block mb-1">รูปปัจจุบัน:</small>
                            <img src="{{ asset('storage/' . $repair->image) }}"
                                 alt="รูปปัจจุบัน" width="140" class="rounded border">
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-success" type="submit">อัปเดต</button>
                    <a href="{{ route('repairs.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
                </div>
            </form>
        </div>
    </div>
@endsection
