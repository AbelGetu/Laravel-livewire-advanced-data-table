<html>
    <head>
        @vite('resources/css/app.css')
        @livewireStyles
    </head>
    <body>
        @yield('content')

        @livewireScripts
    </body>
</html>