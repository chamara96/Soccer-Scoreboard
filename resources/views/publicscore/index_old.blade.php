<!DOCTYPE html>
<html style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Scoreboard-Publicview</title>
    <link rel="stylesheet" href="assets-public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets-public/css/styles.css">

    <link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/assets/owl.theme.default.min.css">

</head>

<body style="height: 100%;">
    <div class="container" style="height: 100%; max-width:3840px;">
        <div class="row" style="height: 100%;">
            <div class="col-3" style="height: 100%;">
                <div class="row">
                    <div class="col text-center" style="margin-top: 50px;">
                        <h1 id="team_a_score" class="display-1 text-center">{{$livescore->score_team_a}}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="margin-top: 25px;">
                        <h1 class="text-center">{{$team_a->team_name}}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center" style="margin-top: 25px;"><img class="img-fluid" height="300px"
                            src="/storage/images/team_logo/{{ $team_a->logo }}"></div>
                </div>
            </div>
            <div class="col-6">
                <div class="row" style="margin-top: 25px;">
                    <div class="col text-center">
                        <h1 class="text-center">{{ $game->game_name }}</h1>
                    </div>
                </div>
                <div class="row text-center" style="margin-top: 50px;">
                    <div class="col text-center"><img class="img-fluid"
                            src="/storage/images/game_logo/{{ $game->game_logo }}" height="250px"></div>
                </div>
                {{-- <h1 class="display-1 text-center">00:00</h1> --}}
                <h1 class="display-1 text-center" id="timer_main">
                    <span class="minutes">00</span>
                    <span class="dots">:</span>
                    <span class="seconds">00</span>
                </h1>
                <input type="hidden" id="countdoun_num" class="form-control" min="0">
                <h4 id="timer_name" class="text-center">{{ $timer->timer_name }}</h4>

            </div>
            <div class="col">
                <div class="row">
                    <div class="col text-center" style="margin-top: 50px;">
                        <h1 id="team_b_score" class="display-1 text-center">{{$livescore->score_team_b}}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center" style="margin-top: 25px;">
                        <h1 class="text-center">{{$team_b->team_name}}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="margin-top: 25px;"><img class="img-fluid"
                            src="/storage/images/team_logo/{{ $team_b->logo }}" height="300px"></div>
                </div>
            </div>

            <div class="owl-carousel owl-theme">
                @foreach ($ads as $ad)
                <div class="item"><img src="/storage/images/ad/{{ $ad->path }}" height="300px"></div>
                @endforeach
                
            </div>

            {{-- <button class="btn" id="start-countdown">Start Countdown</button>
            <button class="btn" id="resume-timer">Resume Timer</button>
            <button class="btn" id="stop-timer">Stop Timer</button>
            <button class="btn" id="reset-timer">Reset Timer</button> --}}


        </div>
    </div>
    <script src="assets-public/js/jquery.min.js"></script>
    <script src="assets-public/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script src="owlcarousel/owl.carousel.min.js"></script>

    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots:false,
            autoplay:true,
            autoplayTimeout:2000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
    </script>


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

            // console.log("Hiiii");
            // console.log(pad(12));

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
                console.log('inside countdown');
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

                    alert('The Timer has Ended !')
                }
            }

            function clear(intervalID) {
                clearInterval(intervalID)
                console.log('cleared the interval called ' + intervalID)
            }

            // End Timer Functions




            $('#countdoun_num').val("{{$front_timer['time']}}");
            var current_timer_status = "{{$front_timer['status']}}";
            console.log(current_timer_status);

            if (current_timer_status == 0) {
                console.log("Not Started");

                var totsec_init = "{{$front_timer['time']}}";
                let min_val_init = Math.floor(totsec_init / 60)
                let sec_val_init = totsec_init - (min_val_init * 60)
                $('#timer_main .minutes').text(pad(min_val_init));
                $('#timer_main .seconds').text(pad(sec_val_init));
            }
            else if (current_timer_status == 1) {
                console.log("Started");
                if ($(ammount).val() != '' && $(ammount).val() > 0) {
                    startClock()
                }
                else if ($(ammount).val() == '') {
                    alert('Type in the Ammount')
                }
            }
            else if (current_timer_status == 2) {
                console.log("Paused");
                // $hours = floor($seconds / 3600);
                var paused_sec = "{{$front_timer['time']}}";
                let min = Math.floor(paused_sec / 60)
                minutes = min;
                let sec = paused_sec - (min * 60)
                seconds = sec;
                $(m).text(pad(min));
                $(s).text(pad(sec));
            }


            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            // ====================================
            // let whistle_audio= Audio();
            Pusher.logToConsole = false;

            var pusher = new Pusher('f83b6d2fe18b90359101', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function (data) {
                console.log(data.message);

                if (data.message.team == 'a') {
                    $('#team_a_score').text(data.message.score);
                } else if (data.message.team == 'b') {
                    $('#team_b_score').text(data.message.score);
                }

                if (data.message.action == 'start') {
                    if ($(ammount).val() != '' && $(ammount).val() > 0) {
                        startClock()
                    }
                    // console.log("/storage/sounds/whistle_clips/"+data.message.whistle_path);
                    // $('#whistle_player_start').get(0).play();
                    // $("#whistle_player_start").prop('muted', true);
                    // $("#whistle_player_start")[0].play();
                    // const audio2 = new Audio("/storage/sounds/whistle_clips/"+data.message.whistle_path);
                    // audio2.play();
                    // let whistle_audio = new Audio("/storage/sounds/whistle_clips/"+data.message.whistle_path);
                    // whistle_audio.play();
                    console.log("T-Start");
                } else if (data.message.action == 'stop') {
                    pauseClock();
                    // restartClock();
                    console.log("T-Stop");
                    // $('#whistle_player_end').get(0).play();
                    // $("#whistle_player_end").prop('muted', true);
                    // $("#whistle_player_end")[0].play();
                    // new Audio("/storage/sounds/whistle_clips/"+data.message.whistle_path).play();
                    // const audio2 = new Audio("/storage/sounds/whistle_clips/"+data.message.whistle_path);
                    // audio2.play();
                } else if (data.message.action == 'pause') {
                    pauseClock();
                    console.log("T-Pause");
                } else if (data.message.action == 'resume') {
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
                    console.log("T-Resume");
                }

                if (data.message.timer_id) {

                    var totsec = data.message.time * 60;
                    let min_val = Math.floor(totsec / 60)
                    let sec_val = totsec - (min_val * 60)
                    $('#timer_main .minutes').text(pad(min_val));
                    $('#timer_main .seconds').text(pad(sec_val));

                    $('#timer_name').text(data.message.timer_name);
                    $('#countdoun_num').val(data.message.time * 60);
                }

                // window.location.reload(true);
                // alert(JSON.stringify(data));
            });
            // ====================================



        });

    </script>

    {{--
    <script>

    </script> --}}

</body>

</html>