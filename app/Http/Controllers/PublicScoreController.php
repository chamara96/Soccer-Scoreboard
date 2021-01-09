<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Counters;
use App\Game;
use App\Scoreboard;
use App\Setting;
use App\Timer;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicScoreController extends Controller
{
    //
    /**
     * Show the Public dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('ref')) {
            $gid = $request->ref;
            $game = Game::find($gid);
            if ($game == null) {
                dd("Worgn Game ID");
            }

            $team_a = Team::find($game->team_a);
            $team_b = Team::find($game->team_b);

            $livescore = Scoreboard::where('game_id', $gid)->latest()->first();
            $timer = Timer::find($livescore->timer_id);


            // TIMER
            $counter = Counters::where(['game_id' => $gid, 'timer_id' => $livescore->timer_id])->get();

            $front_timer = [
                'status' => 0,
                'time' => 0
            ];

            if ($counter->isEmpty()) {
                $front_timer = [
                    'status' => 0,
                    'time' => (Timer::find($livescore->timer_id)->time) * 60
                ];
            } elseif ($counter->last()->status == 0) {
                $front_timer = [
                    'status' => 0,
                    'time' => (Timer::find($livescore->timer_id)->time) * 60
                ];
            } elseif ($counter->last()->status == 1) {

                if (count($counter) != 1) {
                    $temp = $counter[count($counter) - 2]->status;
                    if ($temp == 2) {
                        $stared_time = $counter->last()->created_at;
                        $now_time = Carbon::now();
                        $totalDuration = $counter->last()->remaining_time  - $now_time->diffInSeconds($stared_time);

                        $front_timer = [
                            'status' => 1,
                            'time' =>  $totalDuration
                        ];
                    }
                } else {
                }



                $stared_time = $counter->last()->created_at;
                $now_time = Carbon::now();
                $totalDuration =  $counter->last()->remaining_time - $now_time->diffInSeconds($stared_time);
                $front_timer = [
                    'status' => 1,
                    'time' =>  $totalDuration
                ];
            } elseif ($counter->last()->status == 2) {
                $paused_time = $counter->last()->created_at;
                $stared_time = $counter[count($counter) - 2]->created_at;
                $totalDuration = $counter->last()->remaining_time;
                $front_timer = [
                    'status' => 2,
                    'time' =>  $totalDuration
                ];
            }
            // End Timer

            $ads = Advertisement::where('game_id', $gid)->get();
            $bg_img=Setting::find(1);

            return view('publicscore.index', compact('game','bg_img', 'team_a', 'team_b', 'livescore', 'timer', 'front_timer', 'ads'));
        } else {
            dd($request->all());
        }
    }
}
