<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;
use DB;
class RoleSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        
        Db::table('roles')->insert([

            ['name' => 'admin'],
            ['guard_name' => 'admin'],
            
        ]);

    }
}
