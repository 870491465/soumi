<?php

use Illuminate\Database\Seeder;

class BalanceTransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $types = ['deposit', 'transfer', 'bonus', 'declaration'];

        DB::table('balance_transaction_types')->delete();
        $i = 1;
        foreach($types as $type)
        {
            \App\Models\BalanceTransactionType::create(['id' => $i, 'name' => $type]);
            $i++;
        }
    }
}
