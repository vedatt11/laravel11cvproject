<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Career::create([
            'title'=> 'Software Engineer',
            'company'=> 'Macellan',
            'start_date'=> '2023-07-07',
            'end_date'=> '2023-09-09',
            'description'=> 'MerhabaLaravelciiyim',
            'status'=> 1,
        ]);
    }
}
