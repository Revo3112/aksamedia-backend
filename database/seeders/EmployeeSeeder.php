<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan divisions sudah ada
        $divisions = Division::pluck('id', 'name');

        // URL dummy image (akan disimpan di storage/app/public/employees)
        $dummyImage = 'employees/default.png';
        Storage::disk('public')->put($dummyImage, '');

        $data = [
            [
                'name'   => 'Agus Setiawan',
                'phone'  => '081111111111',
                'email'  => 'agus.setiawan@company.com',
                'position' => 'Frontend Developer',
                'division' => 'Frontend',
            ],
            [
                'name'   => 'Siti Nurhaliza',
                'phone'  => '082222222222',
                'email'  => 'siti.nurhaliza@company.com',
                'position' => 'UI/UX Designer',
                'division' => 'UI/UX Designer',
            ],
            [
                'name'   => 'Budi Santoso',
                'phone'  => '083333333333',
                'email'  => 'budi.santoso@company.com',
                'position' => 'Backend Developer',
                'division' => 'Backend',
            ],
            [
                'name'   => 'Maya Sari',
                'phone'  => '084444444444',
                'email'  => 'maya.sari@company.com',
                'position' => 'Full Stack Developer',
                'division' => 'Full Stack',
            ],
            [
                'name'   => 'Rizki Pratama',
                'phone'  => '085555555555',
                'email'  => 'rizki.pratama@company.com',
                'position' => 'DevOps Engineer',
                'division' => 'QA',
            ],
            [
                'name'   => 'Dewi Lestari',
                'phone'  => '086666666666',
                'email'  => 'dewi.lestari@company.com',
                'position' => 'QA Engineer',
                'division' => 'QA',
            ],
            [
                'name'   => 'Ahmad Fauzi',
                'phone'  => '087777777777',
                'email'  => 'ahmad.fauzi@company.com',
                'position' => 'Marketing Specialist',
                'division' => 'Mobile Apps',
            ],
        ];

        foreach ($data as $row) {
            Employee::create([
                'image'      => $dummyImage,
                'name'       => $row['name'],
                'phone'      => $row['phone'],
                'division_id'=> $divisions[$row['division']],
                'position'   => $row['position'],
            ]);
        }
    }
}
