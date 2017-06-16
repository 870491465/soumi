<?php

use Illuminate\Database\Seeder;

class BonusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bonus = ['权益1', '权益2', '权益3', '权益4',
            '权益5', '权益6', '权益7', '权益8'];
        \Illuminate\Support\Facades\DB::table('bonus')->delete();
        DB::table('bonus_types')->delete();
        $i = 1;
        foreach($bonus as $bonu)
        {
            \App\Models\BonusType::create(['id' => $i, 'name' => $bonu]);
            $i++;
        }
    }
}
