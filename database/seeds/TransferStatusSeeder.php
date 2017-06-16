<?php

use Illuminate\Database\Seeder;

class TransferStatusSeeder extends Seeder
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
            ['name' => 'pending' , 'display_name' => '待审'],
            ['name' => 'faild' ,'display_name' => '失败'],
            ['name' => 'success', 'display_name' => '成功'],
            ['name' => 'cancel', 'display_nae' => '取消']
        ];

        DB::table('transfer_statuses')->delete();
        $i = 1;
        foreach($statuses as $status)
        {
            \App\Models\TransferStatus::create(['id' => $i, 'name' => $status->name, 'display_name' => $status->display_name]);
            $i++;
        }
    }
}
