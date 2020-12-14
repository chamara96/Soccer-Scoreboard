<?php

namespace App\Http\Controllers\Admin\Scoreboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Scoreboard\StoreTimerRequest;
use App\Http\Requests\Admin\Scoreboard\UpdateTimerRequest;
use App\Timer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class TimerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timers = Timer::all();

        return view('admin.scoreboard.timers.index', compact('timers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scoreboard.timers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimerRequest $request)
    {
        $created_by = Auth::id();

        $request->merge([
            'created_by' => $created_by,
        ]);

        Timer::create($request->all());

        return redirect()->route('admin.timers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function show(Timer $timer)
    {
        return view('admin.scoreboard.timers.show', compact('timer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function edit(Timer $timer)
    {
        return view('admin.scoreboard.timers.edit', compact('timer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimerRequest $request, Timer $timer)
    {
        $timer->update($request->all());

        return redirect()->route('admin.timers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timer $timer)
    {
        $timer->delete();

        return redirect()->route('admin.timers.index');
    }


    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Timer::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }


}
