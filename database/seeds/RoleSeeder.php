<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $roles=[
            ['name' => 'Free', 'display_name' => '免费用户'],
            ['name' => 'Supplier', 'display_name'=>'服务商'],
            ['name' => 'Operator', 'display_name' => '运营商'],
            ['name' => 'Branch', 'display_name' => '分公司']

        ];
        DB::table('roles')->delete();
        $id = 1;
        foreach ($roles as $role) {
            $role['id'] = $id;
            \App\Models\Role::create($role);
            $id++;
        }
    }
}
