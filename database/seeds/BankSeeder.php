<?php

use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $names = [
            '工商银行', '农业银行', '建设银行', '交通银行', '中国银行', '民生银行', '光大银行',
            '中信银行', '兴业银行', '邮政储蓄银行', '华夏银行', '上海浦东发展银行'
            ];

        DB::table('banks')->delete();

        $i = 0;
        foreach($names as $name) {
            \App\Models\Bank::create(['name' => $name]);
        }
    }
}
