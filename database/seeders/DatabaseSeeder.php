<?php



namespace Database\Seeders;



use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder

{

    /**

     * Seed the application's database.

     *

     * @return void

     */

    public function run()

    {

        $this->call([

            PermissionTableSeeder::class,

            AdminSeeder::class,

            GenderSeeder::class,

            MetalSeeder::class,

            StateSeeder::class,

            CompanyMaster::class
        ]);

    }

}

