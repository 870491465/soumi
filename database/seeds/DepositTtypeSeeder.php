<?php

use Illuminate\Database\Seeder;

class DepositTtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 充值类型
        $deposits = ['通道使用费', '消费'];

        DB::table('deposit_types')->delete();
        $i = 1;
        foreach($deposits as $deposit)
        {
            \App\Models\DepositType::create(['id' => $i, 'name' => $deposit]);
            $i++;
        }
    }
}
