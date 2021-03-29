<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) {
              \DB::table("users")->insert(
                    array(
                          //'id'         => $faker->unique()->randomNumber,
                          'name'       => $faker->firstName("male"),
                          'email'      => $faker->email,
                          'password'   => $faker->password,
                          'treatment_id'  => $i+1,
                          'created_at' => date('Y-m-d H:m:s'),
                          'updated_at' => date('Y-m-d H:m:s')
                    )
              );
        }
    }
}
