<?php

use Illuminate\Database\Seeder;
use App\Timer;

class TimerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timer = Timer::create([
            'timer_name' => '1st Half',
            'time' => 45,
            'created_by' => 1
        ]);

        $timer = Timer::create([
            'timer_name' => '2nd Half',
            'time' => 45,
            'created_by' => 1
        ]);
    }
}
