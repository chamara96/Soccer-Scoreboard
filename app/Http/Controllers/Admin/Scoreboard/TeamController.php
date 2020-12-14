<?php

namespace App\Http\Controllers\Admin\Scoreboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Scoreboard\StoreTeamRequest;
use App\Http\Requests\Admin\Scoreboard\UpdateTeamRequest;
use App\Team;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();

        return view('admin.scoreboard.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scoreboard.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $created_by = Auth::id();

        $img_ext = $request->file('team_logo')->getClientOriginalExtension();
        $filename = time() . '.' . $img_ext;
        $request->file('team_logo')->move(public_path('storage/images/team_logo'), $filename);

        $request->merge([
            'created_by' => $created_by,
            'logo' => $filename,
        ]);

        // dd($request->except(['team_logo']));

        Team::create($request->except(['team_logo']));

        return redirect()->route('admin.teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return view('admin.scoreboard.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        return view('admin.scoreboard.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {

        if ($request->hasFile('team_logo')) {
            $img_ext = $request->file('team_logo')->getClientOriginalExtension();
            $filename = time() . '.' . $img_ext;
            $request->file('team_logo')->move(public_path('storage/images/team_logo'), $filename);

            $request->merge([
                'logo' => $filename,
            ]);
        }

        $team->update($request->except(['team_logo']));

        return redirect()->route('admin.teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('admin.teams.index');
    }


    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Team::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
