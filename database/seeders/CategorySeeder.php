<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array( 
                'name' =>  "Foredom",
                'group_id' => 1,
                'image' => "foredom",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Dremel",
                'group_id' => 1,
                'image' => "dremel",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ), 
            array( 
                'name' =>  "Fundición",
                'group_id' => 2,
                'image' => "fundicion_equipos",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Galvanoplastia",
                'group_id' => 2,
                'image' => "galvanoplastia",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Grabado",
                'group_id' => 2,
                'image' => "grabado",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Laminadoras",
                'group_id' => 3,
                'image' => "laminadoras",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Ceras",
                'group_id' => 3,
                'image' => "ceras",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Brocas",
                'group_id' => 3,
                'image' => "brocas",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Fundición",
                'group_id' => 3,
                'image' => "fundicion",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Sujetadores",
                'group_id' => 4,
                'image' => "sujetadores",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Prensas",
                'group_id' => 4,
                'image' => "prensas",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ];
        
        DB::table('categories')->insert($datos);
    }
}
