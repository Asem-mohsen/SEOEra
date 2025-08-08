<head>
    <title>
        @yield('title','Dashboard')
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />

    {!! getStyles() !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

@yield('css')