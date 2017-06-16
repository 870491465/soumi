<?php

use Illuminate\Database\Seeder;

class DeclarationStatusSeeder extends Seeder
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
            ['name' => 'pending', 'display_name'=> '待审核'],
            ['name' => 'success', 'display_name' => '成功'],
            ['name' => 'faild', 'display_name' => '失败']
        ];

        DB::table('declaration_status')->delete();
        $i = 1;
        foreach($statuses as $status)
        {
            $status['id'] = $i;
            \App\Models\DeclarationStatus::create($status);
            $i++;
        }
    }
}
