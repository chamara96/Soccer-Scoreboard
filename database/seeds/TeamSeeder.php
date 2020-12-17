<?php

use Illuminate\Database\Seeder;
use App\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = Team::create([
            'team_name' => 'Kandy Tuskers',
            'logo' => '1607955084.jpg',
            'created_by' => 1
        ]);

        $team = Team::create([
            'team_name' => 'Colombo Kings',
            'logo' => '1607960862.jpg',
            'created_by' => 1
        ]);
    }
}
