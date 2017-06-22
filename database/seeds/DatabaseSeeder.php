<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(BalanceStatusSeeder::class);
        $this->call(BonusTypeSeeder::class);
        $this->call(BalanceTransactionTypeSeeder::class);
        $this->call(DepositTtypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TransferStatusSeeder::class);
        $this->call(DepositStatusSeeder::class);
        $this->call(BalanceTransactionStatusSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(AdminAccountSeeder::class);
        $this->call(DeclarationStatusSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(UpgradeTypeSeeder::class);
    }
}
