<?php

namespace App\Http\Controllers\Admin\Scoreboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Scoreboard\StoreSongRequest;
use App\Http\Requests\Admin\Scoreboard\UpdateSongRequest;
use App\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs=Song::all();
        return view('admin.scoreboard.songs.index', compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scoreboard.songs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongRequest $request)
    {
        $created_by = Auth::id();

        $song_ext = $request->file('songclip_raw')->getClientOriginalExtension();
        $filename = time() . '.' . $song_ext;
        $request->file('songclip_raw')->move(public_path('storage/sounds/song_clips'), $filename);

        $request->merge([
            'created_by' => $created_by,
            'songclip' => $filename,
        ]);

        Song::create($request->except(['songclip_raw']));

        return redirect()->route('admin.songs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        return view('admin.scoreboard.songs.show', compact('song'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        return view('admin.scoreboard.songs.edit', compact('song'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSongRequest $request, Song $song)
    {
        if ($request->hasFile('songclip_raw')) {
            $img_ext = $request->file('songclip_raw')->getClientOriginalExtension();
            $filename = time() . '.' . $img_ext;
            $request->file('songclip_raw')->move(public_path('storage/sounds/song_clips'), $filename);

            $request->merge([
                'songclip' => $filename,
            ]);
        }

        $song->update($request->except(['songclip_raw']));

        return redirect()->route('admin.songs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()->route('admin.songs.index');
    }


    /**
     * Delete all selected Whistles at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Song::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}
