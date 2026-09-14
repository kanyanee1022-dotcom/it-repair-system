<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RepairRequestFactory extends Factory
{
    protected $model = \App\Models\RepairRequest::class;

    public function definition(): array
    {
        $equipment = ['เครื่องพิมพ์', 'คอมพิวเตอร์', 'จอมอนิเตอร์', 'เครื่องสำรองไฟ', 'เมาส์', 'คีย์บอร์ด', 'เราเตอร์ Wi-Fi'];
        $departments = ['ฝ่ายบุคคล', 'ฝ่ายการเงิน', 'ฝ่ายไอที', 'ฝ่ายจัดซื้อ', 'ฝ่ายธุรการ'];

        return [
            'requester_name' => $this->faker->name(),
            'department' => $this->faker->randomElement($departments),
            'equipment_name' => $this->faker->randomElement($equipment),
            'problem_detail' => $this->faker->sentence(10),
            'image' => null,
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed']),
        ];
    }
}
