<?php

use Illuminate\Database\Seeder;
use App\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game = Game::create([
            'game_name' => 'LPL 2020',
            'date' => '2020-12-14',
            'ground' => 'Pallekale',
            'game_logo' => '1607961630.jpeg',
            'team_a' => 1,
            'team_b' => 2,
            'created_by' => 1
        ]);
    }
}
