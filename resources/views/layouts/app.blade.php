<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<script>
setInterval(function () {
    fetch("{{ url('/refresh-csrf') }}")
        .then(res => res.text())
        .then(token => {
            document.querySelector('meta[name="csrf-token"]').setAttribute('content', token);
        });
}, 300000); // 5 minutes
</script> 

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        console.log("Session watcher running");

// check every 5 seconds
setInterval(function () {

    if (!document.cookie.includes('laravel_session')) {
        console.log("Session cookie missing → redirect");
       window.top.location.href = window.LOGIN_URL;
    }

}, 5000);
 let idleTime = 0;

    // ⏱️ Set max idle time (in minutes)
    let maxIdleMinutes = 15;

    // Increment idle time every minute
    setInterval(timerIncrement, 60000); // 1 min

    function timerIncrement() {
        idleTime++;
        if (idleTime >= maxIdleMinutes) {
            window.location.href = "/auth/login?expired=1";
        }
    }

    // Reset idle timer on user activity
    function resetTimer() {
        idleTime = 0;
    }

    // Events to track activity
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    console.log("Global AJAX session watcher active");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Catch all AJAX errors
    $(document).ajaxError(function (event, xhr, settings, thrownError) {

        console.log("AJAX Error Status:", xhr.status);

        if (xhr.status === 419 || xhr.status === 401) {

            alert('Session expired. Please login again.');

            try {
                let response = JSON.parse(xhr.responseText);

                if (response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }
            } catch (e) {
                console.log('JSON parse failed');
            }

            window.location.href = "{{ url('auth/login') }}";
        }
    });

});
</script>

</body>
</html>
