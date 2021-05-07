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
            'role'=> 'Specialist',
        ])->assignRole('Specialist');

        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) {
              $role = 'Guest'; //$faker->randomElement(['Guest', 'Specialist']);
              $user2 = User::create([
                  'name'       => $faker->firstName("male"),
                  'email'      => $faker->email,
                  'password'   => $faker->password,
                  'role'       => $role,
                  'specialist_id' => $user->id,
                  'created_at' => date('Y-m-d H:m:s'),
                  'updated_at' => date('Y-m-d H:m:s')
              ])->assignRole($role);
        }
    }
}
