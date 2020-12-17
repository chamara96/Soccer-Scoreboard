@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <h4>Instruction</h4>
        </div>
        <p>1. This is Main Admin Dashboard<br>
        2. Super Admin can create user and assign roles and permissions to each game. (Assigning part is not completed yet, but in next stage) <br>
        3. <strong>Scoreboard Manage</strong> <br>
        &emsp; &emsp;  a) First create <b>Teams</b><br>
        &emsp; &emsp;  b) Then create <b>Timers</b><br>
        &emsp; &emsp;  c) Then create a <b>Game</b><br>
        &emsp; &emsp;  d) Then click <b>view</b> button in the Game list. <br>
        &emsp; &emsp;  e) click <b>Go to Contol Panel</b> button in the Game details view. <br>
        &emsp; &emsp;  f) Select a timer and click Start then Score Controlling button can increase or decrease score. Click on the Public view button to show Public Audience's view.


    </p>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection