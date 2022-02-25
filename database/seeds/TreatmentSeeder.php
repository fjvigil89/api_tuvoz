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
         for ($i=0; $i < 1; $i++) {
             \DB::table("treatments")->insert(
                   array(
                         //'id'         => $faker->unique()->randomNumber,
                         'name'          => "Frases Neurologia",
                         'desc'          => "Haciendo banco de voces para el trabajo de Interligibilidad", 
                         'status'        => 1,
                         'specialist_id' => 2,                        
                         'created_at'    => date('Y-m-d H:m:s'),
                         'updated_at'    => date('Y-m-d H:m:s')
                   )
             );
             \DB::table("treatments")->insert(
                array(
                      //'id'         => $faker->unique()->randomNumber,
                      'name'          => "Vocales",
                      'desc'          => "Haciendo banco de voces para el trabajo de Interligibilidad", 
                      'status'        => 1,
                      'specialist_id' => 2,                        
                      'created_at'    => date('Y-m-d H:m:s'),
                      'updated_at'    => date('Y-m-d H:m:s')
                )
          );
         }
    }
}