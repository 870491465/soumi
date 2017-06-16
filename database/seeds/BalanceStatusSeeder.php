<?php

use Illuminate\Database\Seeder;

class BalanceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = ['pending', 'faild', 'success'];

        DB::table('balance_statuses')->delete();

        $i = 1;
        foreach($statuses as $status)
        {
                \App\Models\BalanceStatus::create(['id' => $i, 'name' => $status]);
            $i++;
        }

    }
}
