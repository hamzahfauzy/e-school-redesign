<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>E-School | Reset Password</title>

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

            @media screen and (max-width: 450px) {
                .content {
                    width: auto;
                }
            }
        </style>
    </head>
    <body style="background-image: url({{asset('assets/login-bg.jpg')}});background-size: cover;background-repeat: no-repeat;">
        <div class="flex-center position-ref full-height">
            <div class="content" style="background-color: rgba(255,255,255,.7);padding: 30px;">
                <center>
                <!-- <img src="{{asset('assets/z-techno.png')}}"> -->
                <img src="{{asset('assets/default.png')}}" width="150px">
                <h2>E-School Reset Password</h2>
                <!-- <h2>SMK Negeri 1 Pulau Rakyat</h2> -->
                </center>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <center>
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    </center>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <center>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>