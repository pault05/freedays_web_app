<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\File;
use App\Models\FreeDaysReqFile;
use App\Models\FreeDaysRequest;
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
        Company::factory(10)->create();
           $this->call([
              CategorySeeder::class,
           ]);
        User::factory(30)->create();
        OfficialHoliday::factory(10)->create();
        FreeDaysRequest::factory(10)->create();
        File::factory(10)->create();
        UserFile::factory(10)->create();
        FreeDaysReqFile::factory()->count(10)->create();

    }
}
