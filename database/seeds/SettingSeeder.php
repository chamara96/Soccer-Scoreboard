<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = Setting::create([
            'name' => 'background_img',
            'value' => '1607955084.jpg'
        ]);
    }
}
