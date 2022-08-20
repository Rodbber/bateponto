<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('title')

    {{-- <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" /> --}}
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <!--Totally optional :) -->
    {{-- fontawesome --}}

    @vite('resources/css/app.css')

    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script> --}}
</head>

<body class="bg-gray-400 font-sans leading-normal tracking-normal">
    <div id="app" class="flex-1">
        <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6 fixed w-full z-10 top-0">
          <div class="flex items-center flex-shrink-0 text-white mr-6">
            <a class="text-white no-underline hover:text-white hover:no-underline" href="#">
              <span class="text-2xl pl-2">
                <i class="em em-books"></i>
                  Painel do Administrador
                </span>
            </a>
          </div>
          

          @yield('navbar')

        </nav>

        <!--Container-->
        <div class="container shadow-lg mx-auto bg-white pt-24 md:pt-18 px-2 mb-5">
            @yield('content')
        </div>
    </div>
</body>

</html>
