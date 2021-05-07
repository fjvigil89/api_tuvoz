<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) {
            \DB::table("treatments")->insert(
                  array(
                        //'id'         => $faker->unique()->randomNumber,
                        'name'       => $faker->firstName("male"),
                        'desc'       => $faker->sentence,  
                        'specialist_id' => '1',               
                        'created_at' => date('Y-m-d H:m:s'),
                        'updated_at' => date('Y-m-d H:m:s')
                  )
            );
        }
    }
}
