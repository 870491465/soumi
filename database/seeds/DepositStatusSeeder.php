<?php

use Illuminate\Database\Seeder;

class DepositStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = ['create', 'pending', 'success', 'cancel', 'faild'];

        DB::table('deposit_statuses')->delete();
        $i = 1;
        foreach($statuses as $status)
        {
            \App\Models\DepositStatus::create(['id' => $i, 'name' => $status]);
            $i++;
        }
    }
}
