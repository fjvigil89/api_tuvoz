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
    	 $this->call(PhraseSeeder::class);
    	 $this->call(RecordSeeder::class);
    	 $this->call(TreatmentSeeder::class);
         $this->call(UserSeeder::class);
    }
}
