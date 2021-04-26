<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::create([
            'name' => "Frank Josué Vigil Vega",
            'email' => "frankjosue.vigilvega@gmail.com",
            'password' => bcrypt("89120815065"),
        ])->assignRole('Admin');

        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) {
              $user = User::create([
                  'name'       => $faker->firstName("male"),
                  'email'      => $faker->email,
                  'password'   => $faker->password,
                  'created_at' => date('Y-m-d H:m:s'),
                  'updated_at' => date('Y-m-d H:m:s')
              ])->assignRole($faker->randomElement(['Guest', 'Specialist']));
        }
    }
}
