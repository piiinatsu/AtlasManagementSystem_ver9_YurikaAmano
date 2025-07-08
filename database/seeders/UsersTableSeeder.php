<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '鈴木',
                'under_name' => '一郎',
                'over_name_kana' => 'スズキ',
                'under_name_kana' => 'イチロウ',
                'mail_address' => 'ichiro@example.com',
                'sex' => 0,
                'birth_day' => '2001-01-01',
                'role' => 0,
                'password' => Hash::make('password1'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
