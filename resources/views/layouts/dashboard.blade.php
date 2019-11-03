<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div id="app">
        @include('layouts.partials.top-navbar')
        @include('layouts.partials.left-sidebar')

        <div style="padding-top: 80px;"></div>
        <main>
            <div class="content-container">
                @yield('content')

                <div class="footer" style="padding-top: 40px;padding-bottom: 20px;">
                    <center>&copy; 2019 . Z-Techno e-School</center>
                </div>
            </div>
        </main>
    </div>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js" defer=""></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript">
    function toggleLeftSidebar(){
        $('.left-sidebar-section').toggleClass('toggle-sidebar')
    }
    $(document).ready(function() {
        $('select.select2').select2();
        $(".search-field").keyup(function(){
            var searchVal = $(this).val().toLowerCase();
            if(searchVal == "")
            {
                $('.search-row').show()
            }
            else
            {
                $('.search-row').hide()
                $('.search-row').each(function( index ) {
                    var username = $(this).data("username").toString().toLowerCase();
                    if(username.indexOf(searchVal) != -1)
                    {
                        $(this).show()
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
