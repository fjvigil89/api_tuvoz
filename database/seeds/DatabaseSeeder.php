<?php

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
    	 
    	 $this->call(RecordSeeder::class);    	         
         $this->call(PermissionSeeder::class);
         $this->call(RoleSeeder::class);
         $this->call(RoleHasPermissionSeeder::class);
         $this->call(UserSeeder::class);           
         $this->call(TreatmentSeeder::class); 
         $this->call(PhraseSeeder::class);
         $this->call(User_TreatmentSeeder::class);
         $this->call(chatSeeder::class);

    }
}
