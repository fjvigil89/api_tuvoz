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
            'foto'=> "https://picsum.photos/800/800?random",
        ])->assignRole('Admin');

        $specialis = User::create([
            'name' => "Frank Josué Vigil Vega",
            'username' => 'frankjosue.vigilvega',
            'email' => "frankjosue.vigilvega@gmail.com",
            'password' => bcrypt("89120815065"),
            'identificador' => bcrypt("Frank Josué Vigil Vega"),
            'role'=> 'Specialist',
            'status' => true,
            'foto'=> "https://picsum.photos/800/800?random",
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
            'foto'=> "https://picsum.photos/800/800?random",
        ])->assignRole('Guest');
        $bot = User::create([
            'name' => "Bot TuVoz",
            'username' => 'bot',
            'email' => "bot@unizar.es",
            'password' => bcrypt("bot"),
            'identificador' => bcrypt("Bot"),
            'role'=> 'Guest',
            'status' => true,
            'foto'=> "https://picsum.photos/800/800?random",
        ])->assignRole('Guest');

        $test = User::create([
            'name' => "test",
            'username' => 'frank.vigil',
            'email' => "frank.vigil@unizar.es",
            'password' => bcrypt("123"),
            'identificador' => bcrypt("123"),
            'role'=> 'Guest',
            'specialist_id'=> $specialis->id,
            'status' => true,
            'foto'=> "https://picsum.photos/800/800?random",
        ])->assignRole('Guest');
    }
}
