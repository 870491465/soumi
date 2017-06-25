<?php

use Illuminate\Database\Seeder;

class SmsContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('sms_contents')->delete();
        $content = '用户,#name#. 您好，由于您的代理,#upgrade_name#.升级为运营商.您目前的代理级别达不到返益要求,请您在一天内尽快升级。以免影响您的收益.';
        \App\Models\SmsContent::create(['content' => $content]);

    }
}
