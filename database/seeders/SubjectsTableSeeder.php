<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // データベースの受付窓口
use Carbon\Carbon; // 日付操作ライブラリ

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 国語、数学、英語を追加
        DB::table('subjects')->insert([
            [
                'subject' => '国語',
                'created_at' => Carbon::now(),
            ],
            [
                'subject' => '数学',
                'created_at' => Carbon::now(),
            ],
            [
                'subject' => '英語',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
