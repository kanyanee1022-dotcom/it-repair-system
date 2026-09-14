@extends('layouts.app')

@section('title', 'รายการแจ้งซ่อม - ระบบแจ้งซ่อมอุปกรณ์ IT')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">รายการแจ้งซ่อมอุปกรณ์ IT</h3>
        <a href="{{ route('repairs.create') }}" class="btn btn-primary">
            + แจ้งซ่อมใหม่
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('repairs.index') }}" method="GET" class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control"
                           placeholder="ค้นหาชื่อผู้แจ้ง / อุปกรณ์ / หน่วยงาน"
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- สถานะทั้งหมด --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>กำลังดำเนินการ</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-outline-secondary w-100" type="submit">ค้นหา</button>
                    <a href="{{ route('repairs.index') }}" class="btn btn-outline-danger w-100">ล้าง</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ผู้แจ้ง</th>
                        <th>หน่วยงาน</th>
                        <th>อุปกรณ์</th>
                        <th>ปัญหา</th>
                        <th>รูป</th>
                        <th>สถานะ</th>
                        <th>แจ้งเมื่อ</th>
                        <th width="160">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($repairs as $repair)
                    <tr>
                        <td>{{ $repair->requester_name }}</td>
                        <td>{{ $repair->department ?? '-' }}</td>
                        <td>{{ $repair->equipment_name }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($repair->problem_detail, 40) }}</td>
                        <td>
                            @if($repair->image)
                                <img src="{{ asset('storage/' . $repair->image) }}"
                                     alt="รูปปัญหา" width="80" class="rounded">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $repair->statusBadgeClass() }}">
                                {{ $repair->statusLabel() }}
                            </span>
                        </td>
                        <td>{{ $repair->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('repairs.edit', $repair->id) }}"
                                   class="btn btn-sm btn-warning">แก้ไข</a>

                                <form action="{{ route('repairs.destroy', $repair->id) }}"
                                      method="POST" onsubmit="return confirm('ยืนยันการลบรายการนี้?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">ลบ</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            ยังไม่มีรายการแจ้งซ่อม
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $repairs->links() }}
    </div>
@endsection
