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
       $specialis = User::create([
            'name' => "Frank Josué Vigil Vega",
            'email' => "frankjosue.vigilvega@gmail.com",
            'password' => bcrypt("89120815065"),
            'identificador' => bcrypt("Frank Josué Vigil Vega"),
            'role'=> 'Specialist',
            'status' => true,
        ])->assignRole('Specialist');

        $patient = User::create([
            'name' => "Invitado",
            'email' => "admin@gmail.com",
            'password' => bcrypt("admin"),
            'identificador' => bcrypt("Invitado"),
            'role'=> 'Guest',
            'specialist_id'=> $specialis->id,
            'status' => true,
        ])->assignRole('Guest');

        $demo = User::create([
            'name' => "Demo",
            'email' => "demo@unizar.es",
            'password' => bcrypt("demo"),
            'identificador' => bcrypt("Demo"),
            'role'=> 'Guest',
            'specialist_id'=> $specialis->id,
            'status' => true,
        ])->assignRole('Guest');

        // $faker = Faker::create();
        // for ($i=0; $i < 10; $i++) {
        //       $role = 'Guest'; //$faker->randomElement(['Guest', 'Specialist']);
        //       $user2 = User::create([
        //           'name'       => $faker->firstName("male"),
        //           'email'      => $faker->email,
        //           'password'   => $faker->password,
        //           'role'       => $role,
        //           'specialist_id' => $user->id,
        //           'created_at' => date('Y-m-d H:m:s'),
        //           'updated_at' => date('Y-m-d H:m:s')
        //       ])->assignRole($role);
        // }
    }
}
