<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use  App\Dept;

class MasterSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //一括削除
        DB::select("SET FOREIGN_KEY_CHECKS = 0");
        \App\User::truncate();
        \App\Staff::truncate();
        \App\Time::truncate();
        Dept::truncate();
        DB::select("SET FOREIGN_KEY_CHECKS = 1");
        // フェイクデータを生成するジェネレータを作成
        $faker = Faker::create('ja_JP');
        DB::table('users')->insert([
            'name' => $faker->name,
            'email' => "test@test.co.jp",
            'email_verified_at' => now(),
            'password' =>  Hash::make('test0001'), // password
            'remember_token' => Str::random(10),
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('dept')->insert([
                 'dept_name' => $faker->jobTitle,
                 'del_flg' => 0,
                 'created_at' => now(),
            ]);
        }
//        $this->call(App\User::class,1)->create();
    }
}
