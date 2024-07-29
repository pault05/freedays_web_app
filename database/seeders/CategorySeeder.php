<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Paid', 'is_subtractable' => true],
            ['name' => 'Unpaid', 'is_subtractable' => false],
            ['name' => 'Medical', 'is_subtractable' => true],
            ['name' => 'Motivated', 'is_subtractable' => false],
        ];

        $colors = ['#FF5733', '#33FF57', '#3357FF', '#F333FF'];

        foreach ($categories as $index => $category) {
            Category::factory()->create([
                'name' => $category['name'],
                'color' => $colors[$index],
                'is_subtractable' => $category['is_subtractable'],
            ]);
        }
    }
}
