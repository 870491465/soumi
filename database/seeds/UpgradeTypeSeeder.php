<?php

use Illuminate\Database\Seeder;

class UpgradeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = [
            ['name' => '升级服务商' , 'role_id' => '2', 'amount' => 6000],
            ['name' => '升级运营商' ,'role_id' => '3', 'amount' => 36000]
        ];

        DB::table('upgrade_types')->delete();
        $i = 1;
        foreach($statuses as $status)
        {
            $status['id'] = $i;
            \App\Models\UpgradeType::create($status);
            $i++;
        }
    }
}
