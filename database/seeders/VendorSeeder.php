<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;



class VendorSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        
         Db::table('model_has_roles')->insert([

            ['role_id' => '1'],
            ['model_type' => 'App\Models\Admin'],
            ['model_id' => '1'],
            
        ]);

    }
}
