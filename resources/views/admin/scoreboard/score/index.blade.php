<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ScoreCard Controller</title>
    <link rel="stylesheet" href="/assets-controller/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets-controller/css/styles.css">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />

    <style>
        .displayhide {
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center" style="margin-top: 15px;">{{$game->game_name}}</h1>
                <hr>
                <div class="row">
                    <div class="col text-center">
                        <p>{{$team_a->team_name}}</p><img src="/storage/images/team_logo/{{ $team_a->logo }}"
                            style="width: 100px;height: 100px;">
                        <h1 id="score_a" class="display-1 text-center">{{$last_scoreboard_updated->score_team_a}}</h1>
                        <div class="row text-center">
                            <div class="col">
                                <button {{ $front_timer['status']==1 ? '' : 'disabled' }} id="team_a_up"
                                    class="btn btn-dark text-center border rounded-0" type="button"
                                    style="width: 70px;height: 70px;"><i class="fas fa-arrow-circle-up"></i></button>
                            </div>
                            <div class="col"><button {{ $front_timer['status']==1 ? '' : 'disabled' }} id="team_a_down"
                                    class="btn btn-dark border rounded-0" type="button"
                                    style="width: 70px;height: 70px;"><i class="fas fa-arrow-circle-down"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <p class="text-center">{{$team_b->team_name}}</p><img
                            src="/storage/images/team_logo/{{ $team_b->logo }}" style="width: 100px;height: 100px;">
                        <h1 id="score_b" class="display-1 text-center">{{$last_scoreboard_updated->score_team_b}}</h1>
                        <div class="row text-center">
                            <div class="col"><button {{ $front_timer['status']==1 ? '' : 'disabled' }} id="team_b_up"
                                    class="btn btn-dark border rounded-0" type="button"
                                    style="width: 70px;height: 70px;"><i class="fas fa-arrow-circle-up"></i></button>
                            </div>
                            <div class="col"><button {{ $front_timer['status']==1 ? '' : 'disabled' }} id="team_b_down"
                                    class="btn btn-dark border rounded-0" type="button"
                                    style="width: 70px;height: 70px;"><i class="fas fa-arrow-circle-down"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-right: 0;">
        <div class="col text-center">
            <h1 class="text-center" style="margin-top: 15px;" id="timer_main">
                <span class="minutes">00</span>
                <span class="dots">:</span>
                <span class="seconds">00</span>
            </h1>
            <input type="hidden" id="countdoun_num" class="form-control" min="0">

            @if ($game->status == 1)

            <div>
                <p id="selected_timer" class="text-center"></p>
                <input type="hidden" value="{{$last_scoreboard_updated->timer_id}}" name="selected_timer_val"
                    id="selected_timer_val">
            </div>

            <div class="dropdown">
                <select {{ $last_scoreboard_updated->status==1 ? 'disabled' : '' }} id="dropdown-timer"
                    name="Select-item">
                    {{-- <option value="" disabled selected>Select Timer</option> --}}
                    @foreach ($timers as $timer)
                    <option {{ $timer->id==$last_scoreboard_updated->timer_id ? 'selected' : '' }} href="#"
                        value="{{$timer->id}}">{{$timer->timer_name}} - {{$timer->time}} min</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div id="abcdef" class="col text-center">
                    @if ($front_timer['status']==0)
                    <button id="start_button" class="btn btn-success text-center" type="button"
                        style="margin: 20px;">Start</button>

                    <button style="display: none;" id="stop_button" class="btn btn-danger text-center" type="button"
                        style="margin: 20px;">Stop</button>
                    <button style="display: none;" id="pause_button" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">Pause</button>

                    <button style="display: none;" id="resume_button" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">Resume</button>
                    @endif

                    @if ($front_timer['status']==1)
                    <button id="stop_button" class="btn btn-danger text-center" type="button"
                        style="margin: 20px;">Stop</button>
                    <button id="pause_button" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">Pause</button>

                    <button style="display: none;" id="start_button" class="btn btn-success text-center" type="button"
                        style="margin: 20px;">Start</button>

                    <button style="display: none;" id="resume_button" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">Resume</button>
                    @endif

                    @if ($front_timer['status']==2)
                    <button id="resume_button" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">Resume</button>

                    <button style="display: none;" id="start_button" class="btn btn-success text-center" type="button"
                        style="margin: 20px;">Start</button>

                    <button style="display: none;" id="stop_button" class="btn btn-danger text-center" type="button"
                        style="margin: 20px;">Stop</button>
                    <button style="display: none;" id="pause_button" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">Pause</button>
                    @endif

                    <button class="btn btn-dark text-center" type="button" style="margin: 20px;"><a target="_blank"
                            href="{{ route("publicscore", ['ref' => $game->id ]) }}">Go to Public
                            View</a></button>

                    {{-- <a style="margin-top:20px;" class="btn btn-success text-center" target="_blank"
                        href="{{ route("publicscore", ['ref' => $game->id ]) }}">
                    Go to Public View
                    </a> --}}

                    <audio style="display: none" id="whistle_start" controls>
                        <source src="/storage/sounds/whistle_clips/1608881753.mp3" type="audio/mpeg">
                    </audio>

                    <audio style="display: none" id="whistle_end" controls>
                        <source src="/storage/sounds/whistle_clips/1608881753.mp3" type="audio/mpeg">
                    </audio>

                    {{-- <button id="test_btn" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">TEST</button> --}}

                    <div class="buttons-wrapper">
                        {{-- <input type="hidden" id="countdoun_num" class="form-control" min="0"> --}}
                        {{-- <button class="btn" id="start-countdown">Start Countdown</button>
                            <button class="btn" id="resume-timer">Resume Timer</button>
                            <button class="btn" id="stop-timer">Stop Timer</button>
                            <button class="btn" id="reset-timer">Reset Timer</button> --}}
                    </div>

                    @foreach ($whistles as $whistle)
                    <button id="whistle_{{$whistle->id}}" class="btn btn-warning text-center" type="button"
                        style="margin: 20px;">{{$whistle->whistle_name}}</button>
                    @endforeach

                    <br>
                    <h5>Songs Play List</h5>
                        <div class="col">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Song</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($songs as $song)
                                    <tr>
                                        <th scope="row">{{$song->id}}</th>
                                        <td>{{$song->song_name}}</td>
                                        <td>
                                            <audio controls>
                                                <source src="/storage/sounds/song_clips/{{ $song->songclip }}"
                                                    type="audio/mpeg">
                                            </audio>
                                        </td>
                                    </tr>
                                    @endforeach
    
                                </tbody>
                            </table>
                        </div>
                </div>



            </div>

            @else

            <h4>Game has ENDED or not STARTED</h4>
            <p>Please contact the Admin</p>

            @endif


        </div>
    </div>

    <script src="/assets-controller/js/jquery.min.js"></script>
    <script src="/assets-controller/bootstrap/js/bootstrap.min.js"></script>

    {{-- <script src="/assets-controller/js/timer.js"></script> --}}

    <script>
        $(document).ready(function () {

            // TIMER Functions

            const ammount = $('#countdoun_num')
            const timer = $('#timer_main')
            const s = $(timer).find('.seconds')
            const m = $(timer).find('.minutes')
            const h = $(timer).find('.hours')

            var seconds = 0
            var minutes = 0
            var hours = 0

            var interval = null;

            var clockType = undefined;
            clockType = 'countdown';


            // $('button#test_btn').on('click', function () {
            //     $('#Test_Audio').get(0).play();
            // })

            // console.log("{!! $whistles[0]['soundclip'] !!}");

            $("button#whistle_{!! $whistles[0]['id'] !!}").click( () => new Audio("/storage/sounds/whistle_clips/{!! $whistles[0]['soundclip'] !!}").play() );
            $("button#whistle_{!! $whistles[1]['id'] !!}").click( () => new Audio("/storage/sounds/whistle_clips/{!! $whistles[1]['soundclip'] !!}").play() );
            $("button#whistle_{!! $whistles[2]['id'] !!}").click( () => new Audio("/storage/sounds/whistle_clips/{!! $whistles[2]['soundclip'] !!}").play() );
            // $("button#start_button").click( () => new Audio("/storage/sounds/whistle_clips/{!! $whistles[2]['soundclip'] !!}").play() );


            $('button#start-countdown').on('click', function () {
                if ($(ammount).val() != '' && $(ammount).val() > 0) {
                    // clockType = 'countdown'
                    startClock()
                }
                else if ($(ammount).val() == '') {
                    alert('Type in the Ammount')
                }

            })


            $('button#stop-timer').on('click', function () {
                pauseClock()
            })

            $('button#reset-timer').on('click', function () {
                restartClock()
            })

            $('button#resume-timer').on('click', function () {
                //   $('button#resume-timer').fadeOut(100)
                //   $('button#reset-timer').fadeOut(100)
                switch (clockType) {
                    case 'countdown':
                        countdown()
                        break
                    //    case 'cronometer':
                    //        cronometer()
                    //        break
                    default:
                        break;
                }
            })

            function pad(d) {
                return (d < 10) ? '0' + d.toString() : d.toString()
            }

            function startClock() {
                hasStarted = false
                hasEnded = false

                seconds = 0
                minutes = 0
                hours = 0



                if ($(ammount).val() > 3599) {
                    // let hou = Math.floor($(ammount).val() / 3600)
                    // hours = hou
                    let min = Math.floor($(ammount).val() / 60)
                    minutes = min
                    // let min = Math.floor(($(ammount).val() - (hou * 3600)) / 60)
                    // minutes = min;
                    let sec = $(ammount).val() - (min * 60)
                    seconds = sec
                }
                else if ($(ammount).val() > 59) {
                    let min = Math.floor($(ammount).val() / 60)
                    minutes = min
                    let sec = $(ammount).val() - (min * 60)
                    seconds = sec
                }
                else {
                    seconds = $(ammount).val()
                }

                // if ($(ammount).val() > 59) {
                //     minutes = $(ammount).val()
                // }
                // else {
                //     minutes = $(ammount).val()
                // }

                if (seconds <= 10 && minutes == 0 && hours == 0) {
                    $(timer).find('span').addClass('red')
                }

                refreshClock()

                // $('.input-wrapper').slideUp(350)
                // setTimeout(function(){
                //     $('#timer').fadeIn(350)
                //     $('#stop-timer').fadeIn(350)

                // }, 350)

                switch (clockType) {
                    case 'countdown':
                        countdown()
                        break
                    // case 'cronometer':
                    //     cronometer()
                    //     break
                    default:
                        break;
                }
            }

            function restartClock() {
                clear(interval)
                hasStarted = false
                hasEnded = false

                seconds = 0
                minutes = 0
                hours = 0

                $(s).text('00')
                $(m).text('00')
                $(h).text('00')

                $(timer).find('span').removeClass('red')

                // $('#timer').fadeOut(350)
                // $('#stop-timer').fadeOut(100)
                // $('button#resume-timer').fadeOut(100)
                // $('button#reset-timer').fadeOut(100)
                // setTimeout(function(){
                //     $('.input-wrapper').slideDown(350)
                // },350)
            }

            function pauseClock() {
                clear(interval)
                //   $('#resume-timer').fadeIn()
                //   $('#reset-timer').fadeIn()
            }

            var hasStarted = false
            var hasEnded = false
            if (hours == 0 && minutes == 0 && seconds == 0 && hasStarted == true) {
                hasEnded = true
            }

            function countdown() {
                hasStarted = true
                interval = setInterval(() => {
                    if (hasEnded == false) {
                        if (seconds <= 11 && minutes == 0 && hours == 0) {
                            $(timer).find('span').addClass('red')
                        }

                        if (seconds == 0 && minutes == 0 || (hours > 0 && minutes == 0 && seconds == 0)) {
                            hours--
                            minutes = 59
                            seconds = 60
                            refreshClock()
                        }

                        if (seconds > 0) {
                            seconds--
                            refreshClock()
                        }
                        else if (seconds == 0) {
                            minutes--
                            seconds = 59
                            refreshClock()
                        }
                    }
                    else {
                        restartClock()
                    }

                }, 1000)
            }

            function refreshClock() {
                $(s).text(pad(seconds))
                $(m).text(pad(minutes))
                if (hours < 0) {
                    $(s).text('00')
                    $(m).text('00')
                    $(h).text('00')
                } else {
                    $(h).text(pad(hours))
                }

                if (minutes == 1 && seconds == 0 && hasStarted == true) {
                    console.log("Last min reached");
                    $('#pause_button').prop("disabled", true);
                }

                if (minutes == 0 && seconds == 0 && hasStarted == true) {
                    hasEnded = true

                    $('#whistle_end')[0].play();

                    // $.ajax({
                    //     url: "{{ route('admin.scorecontrollerstop') }}",
                    //     data: {
                    //         'game_id': {{ $game-> id}},
                    //         'timer_id': $("#selected_timer_val").val(),
                    //         },
                    //     type: 'POST',
                    //     success: function (response) {
                    //         console.log(response);
                    //         window.location.reload(true);
                    //     }
                    // });
                    // alert('The Timer has Ended !')
                }
            }

            function clear(intervalID) {
                clearInterval(intervalID)
                console.log('cleared the interval called ' + intervalID)
            }

            // End Timer Functions

            $('#whistle_start').attr("src", "/storage/sounds/whistle_clips/{{$wistles_paths['whistle_path_start']}}");
            $('#whistle_end').attr("src", "/storage/sounds/whistle_clips/{{$wistles_paths['whistle_path_end']}}");

            
            $('#countdoun_num').val("{{$front_timer['time']}}");
            var current_timer_status="{{$front_timer['status']}}";
            console.log(current_timer_status);

            if (current_timer_status==0) {
                console.log("Not Started")
            } 
            else if (current_timer_status==1) {
                console.log("Started");
                if ($(ammount).val() != '' && $(ammount).val() > 0) {
                    startClock()
                }
                else if ($(ammount).val() == '') {
                    alert('Type in the Ammount')
                }
            } 
            else if (current_timer_status==2) {
                console.log("Paused");
                // $hours = floor($seconds / 3600);
                var paused_sec="{{$front_timer['time']}}";
                let min = Math.floor(paused_sec / 60)
                minutes=min;
                let sec = paused_sec - (min * 60)
                seconds=sec;
                $(m).text(pad(min));
                $(s).text(pad(sec));
            }


            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#dropdown-timer").on('change', function () {
                $("#selected_timer").text($("#dropdown-timer :selected").text());
                $("#selected_timer_val").val($("#dropdown-timer :selected").val());
                $('#whistle_start').attr("src", "/storage/sounds/whistle_clips/{{$wistles_paths['whistle_path_start']}}");
                $('#whistle_end').attr("src", "/storage/sounds/whistle_clips/{{$wistles_paths['whistle_path_end']}}");
                $.ajax({
                    url: "{{ route('admin.changetimer') }}",
                    data: {
                        'game_id': {{ $game-> id}},
                        'timer_id': $("#selected_timer_val").val(),
                    },
                    type: 'POST',
                    success: function (response) {
                            console.log(response);
                            // window.location.reload(true);
                    }
                });

            });



            $("#start_button").on('click', function () {
                $(this).prop("disabled", true);
                $('#whistle_start')[0].play();
            });

            $('#whistle_start').on('ended', function() {
                $.ajax({
                    url: "{{ route('admin.scorecontrollerstart') }}",
                    data: {
                        'game_id': {{ $game-> id}},
                        'timer_id': $("#selected_timer_val").val(),
                    },
                    type: 'POST',
                    success: function (response) {
                            console.log(response);
                            window.location.reload(true);
                    }
                });

            });


            $("#stop_button").on('click', function () {
                $(this).prop("disabled", true);
                $('#whistle_end')[0].play();
            });

            $('#whistle_end').on('ended', function() {
                $.ajax({
                    url: "{{ route('admin.scorecontrollerstop') }}",
                    data: {
                        'game_id': {{ $game-> id}},
                        'timer_id': $("#selected_timer_val").val(),
                        },
                    type: 'POST',
                    success: function (response) {
                        console.log(response);
                        window.location.reload(true);
                        // $("#stop_button").addClass('displayhide');
                        // $("#start_button").removeClass('displayhide');
                    }
                });
            });


            $("#pause_button").on('click', function () {
                $(this).prop("disabled", true);
                pauseClock();
                $.ajax({
                    url: "{{ route('admin.scorecontrollerpause') }}",
                    data: {
                        'game_id': {{ $game-> id}},
                        'timer_id': $("#selected_timer_val").val(),
                        },
                    type: 'POST',
                    success: function (response) {
                        console.log(response);

                        $("#start_button").hide();
                        $("#stop_button").show();
                        $("#resume_button").show();
                        $("#pause_button").hide();
                        $("#pause_button").prop("disabled", false);
                        // window.location.reload(true);
                        // $("#stop_button").addClass('displayhide');
                        // $("#start_button").removeClass('displayhide');
                    }
                });
            });

            $("#resume_button").on('click', function () {
                $(this).prop("disabled", true);
                countdown()
                $.ajax({
                    url: "{{ route('admin.scorecontrollerresume') }}",
                    data: {
                        'game_id': {{ $game-> id}},
                        'timer_id': $("#selected_timer_val").val(),
                        },
                    type: 'POST',
                    success: function (response) {
                        console.log(response);

                        $("#start_button").hide();
                        $("#stop_button").show();
                        $("#pause_button").show();
                        $("#resume_button").hide();
                        $("#resume_button").prop("disabled", false);
                        // window.location.reload(true);
                        // $("#stop_button").addClass('displayhide');
                        // $("#start_button").removeClass('displayhide');
                    }
                });
            });


            // ============================================ Arrow Keys
            $("#team_a_up").on('click', function () {
                $(this).prop("disabled", true);
                $.ajax({
                    url: "{{ route('admin.scorenavigate') }}",
                    data: {
                        'team': 'a',
                        'dir': 'up',
                        'game_id': {{ $game-> id}},
                        'timer_id': {{ $last_scoreboard_updated-> timer_id}},
                            },
                type: 'POST',
                success: function (response) {
                    console.log(response);
                    $('#score_a').text(response.score_team_a);
                    $("#team_a_up").prop("disabled", false);
                    // window.location.reload(true);
                }
                        });
                });

            $("#team_a_down").on('click', function () {
                $(this).prop("disabled", true);
                $.ajax({
                    url: "{{ route('admin.scorenavigate') }}",
                    data: {
                        'team': 'a',
                        'dir': 'down',
                        'game_id': {{ $game-> id}},
                'timer_id': {{ $last_scoreboard_updated-> timer_id}},
                            },
                type: 'POST',
                success: function (response) {
                    console.log(response);
                    $('#score_a').text(response.score_team_a);
                    $("#team_a_down").prop("disabled", false);
                    // window.location.reload(true);
                }
                        });
                });


            $("#team_b_up").on('click', function () {
                $(this).prop("disabled", true);
                $.ajax({
                    url: "{{ route('admin.scorenavigate') }}",
                    data: {
                        'team': 'b',
                        'dir': 'up',
                        'game_id': {{ $game-> id}},
                'timer_id': {{ $last_scoreboard_updated-> timer_id}},
                            },
                type: 'POST',
                success: function (response) {
                    console.log(response);
                    $('#score_b').text(response.score_team_b);
                    $("#team_b_up").prop("disabled", false);
                    // window.location.reload(true);
                }
                        });
                });

            $("#team_b_down").on('click', function () {
                $(this).prop("disabled", true);
                $.ajax({
                    url: "{{ route('admin.scorenavigate') }}",
                    data: {
                        'team': 'b',
                        'dir': 'down',
                        'game_id': {{ $game-> id}},
                'timer_id': {{ $last_scoreboard_updated-> timer_id}},
                            },
                type: 'POST',
                success: function (response) {
                    console.log(response);
                    $('#score_b').text(response.score_team_b);
                    $("#team_b_down").prop("disabled", false);
                    // window.location.reload(true);
                }
                        });
            });



            // END  ============================================ Arrow Keys



            


        });

    </script>
</body>

</html>