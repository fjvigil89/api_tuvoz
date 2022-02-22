<?php

use Illuminate\Database\Seeder;

use App\ChatModel;

class chatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatModel::create([
                'identificador'=>"init",
                'msg' => "Bienvenido al Bot de TuVoz!\nen que te pudo ayudar?",           
                'user_id'=> '4',
            ]);
    }
}
