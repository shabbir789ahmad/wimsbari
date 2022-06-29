<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Branch;

class BranchSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        
        Branch::insert([

            [ 'branch_name' => 'Johar Town Branch']

        ]);

    }
}
