<?php

namespace Database\Seeders;

use App\Models\Gender;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            [
                "name" => "Male",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name" => "Female",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name" => "Unisex",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name" => "Kid Boys",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name" => "Kid Girls",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            ]; 
            Gender::insert($genders); 
    }
}
