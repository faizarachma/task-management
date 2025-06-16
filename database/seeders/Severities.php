<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Severities extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $severities = [
            [
                'name' => 'Low',
                'color' => '#4CAF50', // Green
                'priority' => 1 // Prioritas terendah
            ],
            [
                'name' => 'Medium',
                'color' => '#FFC107', // Amber
                'priority' => 2
            ],
            [
                'name' => 'High',
                'color' => '#FF9800', // Orange
                'priority' => 3
            ],
            [
                'name' => 'Critical',
                'color' => '#F44336', // Red
                'priority' => 4
            ],
            [
                'name' => 'Emergency',
                'color' => '#9C27B0', // Purple
                'priority' => 5 // Prioritas tertinggi
            ]
        ];

        DB::table('severities')->insert($severities);
    }
}
