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
        $this->call(PermissionSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);
        $this->call(TeamSeeder::class);
        $this->call(WhistleSeeder::class);
        $this->call(TimerSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
