<?php

use App\Whistle;
use Illuminate\Database\Seeder;

class WhistleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $whistles = Whistle::create([
            'whistle_name' => 'Whistle 1',
            'soundclip' => '1608881753.mp3',
            'created_by' => 1
        ]);

        $whistles = Whistle::create([
            'whistle_name' => 'Whistle 2',
            'soundclip' => '1609043948.mp3',
            'created_by' => 1
        ]);

        $whistles = Whistle::create([
            'whistle_name' => 'Whistle 3',
            'soundclip' => '1609043963.mp3',
            'created_by' => 1
        ]);
    }
}
