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
       $faker = Faker::create();
       $admin = User::create([
            'name' => "Admin",
            'username' => 'admin',
            'email' => "tuvoz.unizar@gmail.com",
            'password' => bcrypt("admin"),
            'identificador' => bcrypt("Admin"),
            'role'=> 'Admin',            
            'status' => true,
            'foto'=> "http://lorempixel.com/grey/400/200/people/fake/",
        ])->assignRole('Admin');

        $specialis = User::create([
            'name' => "Frank Josué Vigil Vega",
            'username' => 'frankjosue.vigilvega',
            'email' => "frankjosue.vigilvega@gmail.com",
            'password' => bcrypt("89120815065"),
            'identificador' => bcrypt("Frank Josué Vigil Vega"),
            'role'=> 'Specialist',
            'status' => true,
            'foto'=> "http://lorempixel.com/grey/400/200/people/fake/",
        ])->assignRole('Specialist');
        
        $demo = User::create([
            'name' => "Demo",
            'username' => 'demo',
            'email' => "demo@unizar.es",
            'password' => bcrypt("demo"),
            'identificador' => bcrypt("Demo"),
            'role'=> 'Guest',
            'specialist_id'=> $specialis->id,
            'status' => true,
            'foto'=> "http://lorempixel.com/grey/400/200/people/fake/",
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
