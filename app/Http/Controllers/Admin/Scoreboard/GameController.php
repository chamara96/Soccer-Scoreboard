<?php

namespace App\Http\Controllers\Admin\Scoreboard;

use App\Game;
use App\Team;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Scoreboard\StoreGameRequest;
use App\Http\Requests\Admin\Scoreboard\UpdateGameRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();
        $teams = Team::all();

        return view('admin.scoreboard.games.index', compact('games', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        return view('admin.scoreboard.games.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $created_by = Auth::id();

        $img_ext = $request->file('game_logo_raw')->getClientOriginalExtension();
        $filename = time() . '.' . $img_ext;
        $request->file('game_logo_raw')->move(public_path('storage/images/game_logo'), $filename);

        $request->merge([
            'created_by' => $created_by,
            'game_logo' => $filename,
        ]);

        Game::create($request->except(['game_logo_raw']));

        return redirect()->route('admin.games.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $teams = Team::all();
        return view('admin.scoreboard.games.show', compact('game', 'teams'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        $teams = Team::all();
        // $vvv = $teams->where('id', 1)->first()->team_name;
        // dd($vvv);
        return view('admin.scoreboard.games.edit', compact('game', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        if ($request->hasFile('game_logo_raw')) {
            $img_ext = $request->file('game_logo_raw')->getClientOriginalExtension();
            $filename = time() . '.' . $img_ext;
            $request->file('game_logo_raw')->move(public_path('storage/images/game_logo'), $filename);

            $request->merge([
                'game_logo' => $filename,
            ]);
        }

        $game->update($request->except(['game_logo_raw']));

        return redirect()->route('admin.games.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('admin.games.index');
    }



    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Game::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }


}
