<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
    use HasFactory;

    /**
     * ฟิลด์ที่อนุญาตให้บันทึกผ่าน Mass Assignment
     */
    protected $fillable = [
        'requester_name',
        'department',
        'equipment_name',
        'problem_detail',
        'image',
        'status',
    ];

    /**
     * แปลรหัสสถานะเป็นข้อความภาษาไทย (ใช้ในหน้า Blade)
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'รอดำเนินการ',
            'processing' => 'กำลังดำเนินการ',
            'completed' => 'เสร็จสิ้น',
            default => $this->status,
        };
    }

    /**
     * สีของ Badge ตามสถานะ (Bootstrap class)
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'processing' => 'bg-info text-dark',
            'completed' => 'bg-success',
            default => 'bg-secondary',
        };
    }
}
