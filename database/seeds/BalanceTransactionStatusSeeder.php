<?php

use Illuminate\Database\Seeder;

class BalanceTransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = ['created', 'pending', 'faild', 'success', 'cancel'];

        DB::table('balance_transaction_statuses')->delete();
        $i = 1;
        foreach($statuses as $status)
        {
            \App\Models\BalanceTransactionStatus::create(['id' => $i, 'name' => $status]);
            $i++;
        }
    }
}
