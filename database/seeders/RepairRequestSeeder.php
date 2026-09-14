<?php

namespace Database\Seeders;

use App\Models\RepairRequest;
use Illuminate\Database\Seeder;

class RepairRequestSeeder extends Seeder
{
    /**
     * สร้างข้อมูลตัวอย่าง 15 รายการ เพื่อทดสอบระบบทันทีหลัง migrate
     */
    public function run(): void
    {
        RepairRequest::factory()->count(15)->create();
    }
}
