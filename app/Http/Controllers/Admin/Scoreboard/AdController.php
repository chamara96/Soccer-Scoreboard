<?php

namespace App\Http\Controllers\Admin\Scoreboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Advertisement;
use App\Game;

use App\Http\Requests\Admin\Scoreboard\StoreAdRequest;
use App\Http\Requests\Admin\Scoreboard\UpdateAdRequest;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Advertisement::all();
        $games = Game::all();

        return view('admin.scoreboard.ads.index', compact('ads','games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $games = Game::all();
        return view('admin.scoreboard.ads.create', compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdRequest $request)
    {
        $created_by = Auth::id();

        $img_ext = $request->file('ad_path')->getClientOriginalExtension();
        $filename = time() . '.' . $img_ext;
        $request->file('ad_path')->move(public_path('storage/images/ad'), $filename);

        $request->merge([
            'created_by' => $created_by,
            'path' => $filename,
        ]);

        // dd($request->except(['ad_path']));

        Advertisement::create($request->except(['ad_path']));

        return redirect()->route('admin.ads.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $ad)
    {
        return view('admin.scoreboard.ads.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $ad)
    {
        $games = Game::all();
        return view('admin.scoreboard.ads.edit', compact('ad', 'games'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdRequest $request, Advertisement $ad)
    {
        if ($request->hasFile('ad_path')) {
            $img_ext = $request->file('ad_path')->getClientOriginalExtension();
            $filename = time() . '.' . $img_ext;
            $request->file('ad_path')->move(public_path('storage/images/ad'), $filename);

            $request->merge([
                'path' => $filename,
            ]);
        }

        $ad->update($request->except(['ad_path']));

        return redirect()->route('admin.ads.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $ad)
    {
        $ad->delete();

        return redirect()->route('admin.ads.index');
    }
}
