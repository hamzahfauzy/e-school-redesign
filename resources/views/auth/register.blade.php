<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>e-School Register</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="shortcut icon" href="{{asset('assets/default.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                width: 450px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body style="background-image: url({{asset('assets/login-bg.jpg')}});background-size: cover;background-repeat: no-repeat;">
        <div class="flex-center position-ref full-height">
            <div class="content" style="background-color: rgba(255,255,255,.7);padding: 30px;">
                <center>
                <!-- <img src="{{asset('assets/z-techno.png')}}"> -->
                <img src="{{asset('assets/default.png')}}" width="150px">
                <h2>E-School Register</h2>
                <!-- <h2>SMK Negeri 1 Pulau Rakyat</h2> -->
                </center>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-horizontal z-login-form" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Password Confirmation" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-block z-techno-login-btn z-techno-btn z-techno-primary">
                                        Register
                                    </button>
                                    <center>
                                        <p></p>
                                        Sudah Punya Akun ? Silahkan <a href="{{url('/login')}}">Login</a>
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
