<?php

namespace App\Http\Controllers\Admin\Scoreboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Scoreboard\StoreWhistleRequest;
use App\Http\Requests\Admin\Scoreboard\UpdateWhistleRequest;
use App\Whistle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhistleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $whistles = Whistle::all();
        return view('admin.scoreboard.whistles.index', compact('whistles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scoreboard.whistles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWhistleRequest $request)
    {
        $created_by = Auth::id();

        $sound_ext = $request->file('soundclip_raw')->getClientOriginalExtension();
        $filename = time() . '.' . $sound_ext;
        $request->file('soundclip_raw')->move(public_path('storage/sounds/whistle_clips'), $filename);

        $request->merge([
            'created_by' => $created_by,
            'soundclip' => $filename,
        ]);

        // dd($request->except(['soundclip_raw']));

        Whistle::create($request->except(['soundclip_raw']));

        return redirect()->route('admin.whistles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Whistle  $whistle
     * @return \Illuminate\Http\Response
     */
    public function show(Whistle $whistle)
    {
        return view('admin.scoreboard.whistles.show', compact('whistle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Whistle  $whistle
     * @return \Illuminate\Http\Response
     */
    public function edit(Whistle $whistle)
    {
        return view('admin.scoreboard.whistles.edit', compact('whistle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Whistle  $whistle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWhistleRequest $request, Whistle $whistle)
    {
        if ($request->hasFile('soundclip_raw')) {
            $img_ext = $request->file('soundclip_raw')->getClientOriginalExtension();
            $filename = time() . '.' . $img_ext;
            $request->file('soundclip_raw')->move(public_path('storage/sounds/whistle_clips'), $filename);

            $request->merge([
                'soundclip' => $filename,
            ]);
        }

        $whistle->update($request->except(['soundclip_raw']));

        return redirect()->route('admin.whistles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Whistle  $whistle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Whistle $whistle)
    {
        $whistle->delete();

        return redirect()->route('admin.whistles.index');
    }


    /**
     * Delete all selected Whistles at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Whistle::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}
