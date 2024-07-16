<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\File;
use App\Models\OfficialHoliday;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserFile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory()->create([
//            'first_name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        Company::factory(10)->create();
        User::factory(10)->create();
        OfficialHoliday::factory(10)->create();
        File::factory(10)->create();
        UserFile::factory(10)->create();
    }
}
