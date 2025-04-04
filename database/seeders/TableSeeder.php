<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder {
    
    public function run(): void {
        $numberOfTables = 16;
        
        for ($i = 1; $i <= $numberOfTables; $i++) {
            Table::updateOrCreate(
                ['table_number' => $i],
                [
                    'capacity' => rand(4, 8),
                    'location' => $i <= 6 ? 'indoor' : 'outdoor',
                ]
            );
        }
    }
}
