<?php

use Illuminate\Database\Seeder;

class HardwareCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	DB::table('hardware_category')->insert([
    		'name' => 'เครื่องโทรสาร', 'type' => 'equipment',
    	]);
        DB::table('hardware_category')->insert([
    		'name' => 'โทรศัพท์', 'type' => 'equipment',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'เครื่องถ่ายเอกสาร', 'type' => 'equipment',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'เครื่องพิมพ์', 'type' => 'equipment',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'ตู้', 'type' => 'equipment',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'โต๊ะ', 'type' => 'equipment',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'เก้าอี้', 'type' => 'equipment',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'อุปกรณ์ดำเนินกิจกรรมของนักศึกษา', 'type' => 'equipment',
        ]);

        
        DB::table('hardware_category')->insert([
    		'name' => 'อุปกรณ์เครื่องเขียน', 'type' => 'material',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'เครื่องเย็บกระดาษ', 'type' => 'material',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'ลวดเย็บกระดาษ', 'type' => 'material',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'กระดาษ', 'type' => 'material',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'หมึก', 'type' => 'material',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'ซองจดหมาย', 'type' => 'material',
        ]);
        DB::table('hardware_category')->insert([
    		'name' => 'แผ่นซีดี', 'type' => 'material',
        ]);
    }
}
