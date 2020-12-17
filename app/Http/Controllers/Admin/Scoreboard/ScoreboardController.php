<?php

namespace App\Http\Controllers\Admin\Scoreboard;

use App\Http\Controllers\Controller;
use App\Scoreboard;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scoreboards = Scoreboard::all();

        return view('admin.scoreboard.scoreboards.index', compact('scoreboards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scoreboard.scoreboards.create');
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
     * @param  \App\Scoreboard  $scoreboard
     * @return \Illuminate\Http\Response
     */
    public function show(Scoreboard $scoreboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Scoreboard  $scoreboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Scoreboard $scoreboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scoreboard  $scoreboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scoreboard $scoreboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scoreboard  $scoreboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scoreboard $scoreboard)
    {
        //
    }
}
