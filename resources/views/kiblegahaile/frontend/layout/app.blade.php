<!doctype html>
<html class="no-js" lang="tr">
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
        {!! SEOMeta::generate() !!}
        {!! OpenGraph::generate() !!}
        {!! Twitter::generate() !!}
        @include(config('app.tema').'/frontend.layout.css')
        @yield('customCSS')
    </head>

    <body>

        <main id="content" role="main">
            @include('backend.layout.alert')

            @include(config('app.tema').'/frontend.layout.header')

                @yield('content')

            @include(config('app.tema').'/frontend.layout.footer')

            @include(config('app.tema').'/frontend.layout.js')
            @yield('customJS')
        </main>

    </body>

</html>
