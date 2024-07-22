<?php

namespace Database\Seeders;

use App\Models\Metal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MetalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metals = [
            [
                "name" => "Gold",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name" => "Silver",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name" => "Imitation",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name" => "Alloy",
                "status" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            
            ]; 
            Metal::insert($metals); 
        //
    }
}
