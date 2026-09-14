<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepairRequestController extends Controller
{
    /**
     * แสดงรายการแจ้งซ่อมทั้งหมด (รองรับค้นหาและกรองสถานะ)
     */
    public function index(Request $request)
    {
        $query = RepairRequest::latest();

        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('requester_name', 'like', "%{$keyword}%")
                  ->orWhere('equipment_name', 'like', "%{$keyword}%")
                  ->orWhere('department', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $repairs = $query->paginate(10)->withQueryString();

        return view('repairs.index', compact('repairs'));
    }

    /**
     * แสดงฟอร์มแจ้งซ่อมใหม่
     */
    public function create()
    {
        return view('repairs.create');
    }

    /**
     * บันทึกข้อมูลแจ้งซ่อมใหม่ลงฐานข้อมูล
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'equipment_name' => 'required|string|max:255',
            'problem_detail' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'requester_name.required' => 'กรุณากรอกชื่อผู้แจ้งซ่อม',
            'equipment_name.required' => 'กรุณากรอกชื่ออุปกรณ์',
            'problem_detail.required' => 'กรุณากรอกรายละเอียดปัญหา',
            'image.image' => 'ไฟล์ที่อัปโหลดต้องเป็นรูปภาพเท่านั้น',
            'image.mimes' => 'รองรับเฉพาะไฟล์ .jpg .jpeg .png เท่านั้น',
            'image.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('repairs', 'public');
        }

        RepairRequest::create($validated);

        return redirect()
            ->route('repairs.index')
            ->with('success', 'บันทึกข้อมูลแจ้งซ่อมเรียบร้อยแล้ว');
    }

    /**
     * แสดงฟอร์มแก้ไขข้อมูล / เปลี่ยนสถานะ
     */
    public function edit(RepairRequest $repair)
    {
        return view('repairs.edit', compact('repair'));
    }

    /**
     * อัปเดตข้อมูลแจ้งซ่อม
     */
    public function update(Request $request, RepairRequest $repair)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'equipment_name' => 'required|string|max:255',
            'problem_detail' => 'required|string',
            'status' => 'required|in:pending,processing,completed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'requester_name.required' => 'กรุณากรอกชื่อผู้แจ้งซ่อม',
            'equipment_name.required' => 'กรุณากรอกชื่ออุปกรณ์',
            'problem_detail.required' => 'กรุณากรอกรายละเอียดปัญหา',
            'status.required' => 'กรุณาเลือกสถานะ',
            'image.image' => 'ไฟล์ที่อัปโหลดต้องเป็นรูปภาพเท่านั้น',
            'image.mimes' => 'รองรับเฉพาะไฟล์ .jpg .jpeg .png เท่านั้น',
            'image.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
        ]);

        if ($request->hasFile('image')) {
            if ($repair->image) {
                Storage::disk('public')->delete($repair->image);
            }

            $validated['image'] = $request->file('image')->store('repairs', 'public');
        }

        $repair->update($validated);

        return redirect()
            ->route('repairs.index')
            ->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    /**
     * ลบรายการแจ้งซ่อม
     */
    public function destroy(RepairRequest $repair)
    {
        if ($repair->image) {
            Storage::disk('public')->delete($repair->image);
        }

        $repair->delete();

        return redirect()
            ->route('repairs.index')
            ->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
