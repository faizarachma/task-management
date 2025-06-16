<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatuse extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Pending',
                'color' => '#9CA3AF', // Gray
            ],
            [
                'name' => 'In Progress',
                'color' => '#3B82F6', // Blue
            ],
            [
                'name' => 'Completed',
                'color' => '#10B981', // Green
            ],
            [
                'name' => 'On Hold',
                'color' => '#F59E0B', // Amber
            ],
            [
                'name' => 'Cancelled',
                'color' => '#EF4444', // Red
            ]
        ];

        DB::table('task_statuses')->insert($statuses);
    }
}
