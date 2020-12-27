<?php

namespace App\Http\Controllers\Admin\Score;

use App\Counters;
use App\Events\Event;
use App\Scoreboard;
use App\Team;
use App\Game;
use App\Timer;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Song;
use App\Whistle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd(Carbon::now());

        try {
            $decrypted = decrypt($request->ref);
            // dd($decrypted);
        } catch (DecryptException $e) {
            dd("Error ID");
        }

        $game = Game::find($decrypted);
        $last_scoreboard = Scoreboard::where('game_id', $decrypted)->latest()->first();

        if (isset($last_scoreboard)) {
            //
        } else {
            $first_val = [
                'game_id' => $decrypted,
                'score_team_a' => 0,
                'score_team_b' => 0,
                'time' => 0,
                'status' => 0,
                'timer_id' => 1,
                'created_by' => Auth::id()
            ];
            Scoreboard::create($first_val);

            $game->status = 1;
            $game->save();
            // return "1st";
        }
        $last_scoreboard = Scoreboard::where('game_id', $decrypted)->latest()->first();

        $counter = Counters::where(['game_id' => $decrypted, 'timer_id' => $last_scoreboard->timer_id])->get();

        // $game_stoped = Counters::where(['game_id' => $decrypted, 'status' => 0])->get();
        // $game_started = Counters::where(['game_id' => $decrypted, 'status' => 1])->get();
        // $game_paused = Counters::where(['game_id' => $decrypted, 'status' => 2])->get();


        // dd($counter->last());

        $front_timer = [
            'status' => 0,
            'time' => 0
        ];

        if ($counter->isEmpty()) {
            // counter table is empty
            $front_timer = [
                'status' => 0,
                'time' => (Timer::find($last_scoreboard->timer_id)->time) * 60
            ];
            // dd($front_timer);
        } elseif ($counter->last()->status == 0) {

            $front_timer = [
                'status' => 0,
                'time' => (Timer::find($last_scoreboard->timer_id)->time) * 60
            ];
            // dd("Staus=0");
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
                // else {
                //     # code...
                // }
            }
            // $temp = $counter[count($counter) - 2]->status;
            // dd(count($counter));
            else {
            }



            $stared_time = $counter->last()->created_at;
            $now_time = Carbon::now();
            $totalDuration =  $counter->last()->remaining_time - $now_time->diffInSeconds($stared_time);
            $front_timer = [
                'status' => 1,
                'time' =>  $totalDuration
            ];
            // dd("Staus=1");

        } elseif ($counter->last()->status == 2) {
            $paused_time = $counter->last()->created_at;
            $stared_time = $counter[count($counter) - 2]->created_at;
            $totalDuration = $counter->last()->remaining_time;
            $front_timer = [
                'status' => 2,
                'time' =>  $totalDuration
            ];

            // dd("Staus=2");
        }


        // dd($counter->id);





        $timers = Timer::all();
        $whistles = Whistle::all();

        $game = Game::find($decrypted);  //updated game 

        $team_a = Team::find($game->team_a);
        $team_b = Team::find($game->team_b);

        $last_scoreboard_updated = Scoreboard::where('game_id', $decrypted)->latest()->first();

        $wistles_paths = [
            'whistle_path_start' => Whistle::find(Timer::find($last_scoreboard_updated->timer_id)->start_whistle_id)->soundclip,
            'whistle_path_end' => Whistle::find(Timer::find($last_scoreboard_updated->timer_id)->end_whistle_id)->soundclip
        ];

        $songs = Song::all();

        return view('admin.scoreboard.score.index', compact('timers', 'songs', 'wistles_paths', 'front_timer', 'game', 'last_scoreboard_updated', 'team_a', 'team_b', 'whistles'));
        // return view('admin.scoreboard.scoreboards.index', compact('scoreboards'));
    }


    public function index_ajax(Request $request)
    {

        $decrypted = $request->game_id;

        $last_scoreboard = Scoreboard::where('game_id', $decrypted)->latest()->first();

        $counter = Counters::where(['game_id' => $decrypted, 'timer_id' => $last_scoreboard->timer_id])->get();

        $front_timer = [
            'status' => 0,
            'time' => 0
        ];

        if ($counter->isEmpty()) {
            $front_timer = [
                'status' => 0,
            ];
        } elseif ($counter->last()->status == 0) {
            $front_timer = [
                'status' => 0,
            ];
        } elseif ($counter->last()->status == 1) {

            if (count($counter) != 1) {
                $temp = $counter[count($counter) - 2]->status;
                if ($temp == 2) {
                    $front_timer = [
                        'status' => 1,
                    ];
                }
            } else {
            }

            $front_timer = [
                'status' => 1,
            ];
        } elseif ($counter->last()->status == 2) {
            $front_timer = [
                'status' => 2,
            ];
        }

        return $front_timer;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Click START button in controller dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function btnstart(Request $request)
    {

        $last_scoreboard = Scoreboard::where('game_id', $request->game_id)->latest()->first()->toArray();
        $last_scoreboard['status'] = 1;
        $last_scoreboard['timer_id'] = $request->timer_id;

        $new_score = Scoreboard::create($last_scoreboard);


        $counter = [
            'game_id' => $request->game_id,
            'timer_id' => $request->timer_id,
            'status' => 1,
            'remaining_time' => (Timer::find($request->timer_id)->time) * 60,
            'created_by' => Auth::id(),
        ];
        Counters::create($counter);

        // $msg = 'start';
        $msg = [
            'action' => 'start',
            'whistle_path' => Whistle::find(Timer::find($request->timer_id)->start_whistle_id)->soundclip
        ];

        event(new Event($msg));

        return $new_score;
    }

    /**
     * Click STOP button in controller dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function btnstop(Request $request)
    {
        $last_scoreboard = Scoreboard::where('game_id', $request->game_id)->latest()->first()->toArray();
        $last_scoreboard['status'] = 0;

        $new_score = Scoreboard::create($last_scoreboard);

        $last_counter = Counters::where(['game_id' =>  $request->game_id, 'timer_id' => $request->timer_id])->get();

        $now_time = Carbon::now();
        $last_time = $last_counter->last()->created_at;

        $rem_sec = $last_counter->last()->remaining_time - $now_time->diffInSeconds($last_time);

        $counter = [
            'game_id' => $request->game_id,
            'timer_id' => $request->timer_id,
            'status' => 0,
            'remaining_time' => $rem_sec,
            'created_by' => Auth::id(),
        ];
        Counters::create($counter);

        // $msg = 'stop';
        $msg = [
            'action' => 'stop',
            'whistle_path' => Whistle::find(Timer::find($request->timer_id)->end_whistle_id)->soundclip
        ];

        event(new Event($msg));
        return $new_score;
    }


    /**
     * Click PAUSE button in controller dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function btnpause(Request $request)
    {
        // $last_scoreboard = Scoreboard::where('game_id', $request->game_id)->latest()->first()->toArray();
        // $last_scoreboard['status'] = 2;

        // $new_score = Scoreboard::create($last_scoreboard);
        $last_counter = Counters::where(['game_id' =>  $request->game_id, 'timer_id' => $request->timer_id])->get();

        $now_time = Carbon::now();
        $last_time = $last_counter->last()->created_at;

        $rem_sec = $last_counter->last()->remaining_time - $now_time->diffInSeconds($last_time);

        $counter = [
            'game_id' => $request->game_id,
            'timer_id' => $request->timer_id,
            'status' => 2,
            'remaining_time' => $rem_sec,
            'created_by' => Auth::id(),
        ];
        Counters::create($counter);

        // $msg = 'pause';
        $msg = [
            'action' => 'pause',
            // 'whistle_path'=>Whistle::find(Timer::find($request->timer_id)->end_whistle_id)->soundclip
        ];

        event(new Event($msg));
        return $counter;
    }

    /**
     * Click RESUME button in controller dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function btnresume(Request $request)
    {
        // $last_scoreboard = Scoreboard::where('game_id', $request->game_id)->latest()->first()->toArray();
        // $last_scoreboard['status'] = 2;

        // $new_score = Scoreboard::create($last_scoreboard);

        $last_counter = Counters::where(['game_id' =>  $request->game_id, 'timer_id' => $request->timer_id])->get();
        $rem_sec = $last_counter->last()->remaining_time;

        $counter = [
            'game_id' => $request->game_id,
            'timer_id' => $request->timer_id,
            'status' => 1,
            'remaining_time' => $rem_sec,
            'created_by' => Auth::id(),
        ];
        Counters::create($counter);

        // $msg = 'resume';
        $msg = [
            'action' => 'resume',
            // 'whistle_path'=>Whistle::find(Timer::find($request->timer_id)->end_whistle_id)->soundclip
        ];

        event(new Event($msg));
        return $counter;
    }


    /**
     * Click NAVI button in controller dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function scorenavigate(Request $request)
    {
        $last_scoreboard = Scoreboard::where('game_id', $request->game_id)->latest()->first()->toArray();

        if ($request->has(['team', 'dir'])) {
            if ($request->team == 'a') {
                if ($request->dir == 'up') {
                    $last_scoreboard['score_team_a'] = $last_scoreboard['score_team_a'] + 1;
                    $msg = [
                        'team' => 'a',
                        'score' => $last_scoreboard['score_team_a']
                    ];
                } elseif ($request->dir == 'down') {
                    $last_scoreboard['score_team_a'] = $last_scoreboard['score_team_a'] - 1;
                    $msg = [
                        'team' => 'a',
                        'score' => $last_scoreboard['score_team_a']
                    ];
                } else {
                    return "Error";
                }
            } elseif ($request->team == 'b') {
                if ($request->dir == 'up') {
                    $last_scoreboard['score_team_b'] = $last_scoreboard['score_team_b'] + 1;
                    $msg = [
                        'team' => 'b',
                        'score' => $last_scoreboard['score_team_b']
                    ];
                } elseif ($request->dir == 'down') {
                    $last_scoreboard['score_team_b'] = $last_scoreboard['score_team_b'] - 1;
                    $msg = [
                        'team' => 'b',
                        'score' => $last_scoreboard['score_team_b']
                    ];
                } else {
                    return "Error";
                }
            } else {
                return "Error";
            }
        } else {
            return "Error";
        }

        $new_score = Scoreboard::create($last_scoreboard);

        event(new Event($msg));

        return $new_score;
        // return $last_scoreboard;

    }


    /**
     * Change Timer Drop down in controller dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changetimer(Request $request)
    {
        $last_scoreboard = Scoreboard::where('game_id', $request->game_id)->latest()->first();
        $last_scoreboard->timer_id = $request->timer_id;
        $last_scoreboard->update();
        // return $last_scoreboard;
        $timer = Timer::find($request->timer_id);
        $msg = [
            'timer_id' => $timer->id,
            'timer_name' => $timer->timer_name,
            'time' => $timer->time
        ];

        event(new Event($msg));
        return $timer;
    }
}
