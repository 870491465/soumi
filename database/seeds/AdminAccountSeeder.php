<?php

use Illuminate\Database\Seeder;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $mobile = '18888888888';
        $name = 'Administraotr';
        $password = '123456';

        $user = \App\Models\User::where('mobile', $mobile)->first();
        if ($user) {
            $user->delete();
            $account= \App\Models\Account::where('mobile', $mobile)->first()->delete();
        }

        $account = [
            'mobile' => $mobile,
            'business_name' => '江苏嗖咪网络'
        ];

        DB::beginTransaction();
        try {
            $account = \App\Models\Account::create($account);
            $user = new \App\Models\User();
            $user->name = $name;
            $user->mobile = $mobile;
            $user->password = Hash::make($password);
            $user->is_confirmed = 1;
            $user->account_id = $account->id;
            $user->role_id = 5;
            $user->save();

            DB::commit();
        }
        catch(\League\Flysystem\Exception $e)
        {
            \Illuminate\Support\Facades\DB::rollBack();
        }
    }
}
