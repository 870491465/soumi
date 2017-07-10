<?php

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['level' => '0', 'name'=> '层级0'],
            ['level' => '1', 'name' => '层级1'],
            ['level' => '2', 'name' => '层级2'],
            ['level' => '3', 'name' => '层级3']
        ];

        DB::table('levels')->delete();
        $i = 1;
        foreach($statuses as $status)
        {
            $status['id'] = $i;
            \App\Models\Level::create($status);
            $i++;
        }
        //
    }
}
