<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      @yield('title')

      <title>{{ config('app.name', 'Laravel') }}</title>

      <!-- Fonts -->
      <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

      <!-- Scripts -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="bg-gray-400 font-sans leading-normal tracking-normal">
      <div class="flex-1">
          <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6 fixed w-full z-10 top-0">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
              <a class="text-white no-underline hover:text-white hover:no-underline" href="#">
                <span class="text-2xl pl-2">
                  <i class="em em-books"></i>
                    Painel do Administrador
                  </span>
              </a>
            </div>
            
            <!-- Responsive Navigation Menu -->
            <nav x-data="{ open: false }">
              <!-- Primary Navigation Menu -->
              <div class="mx-auto px-4">
                  <div class="flex justify-between h-8">
                      <!-- Settings Dropdown -->
                      <div class="hidden sm:flex sm:items-center sm:ml-6">
                          <x-dropdown align="right" width="48">
                              <x-slot name="trigger">
                                  <button class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none focus:text-whitetransition duration-150 ease-in-out">
                                      <div>{{ Auth::user()->name }}</div>

                                      <div class="ml-1">
                                          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                          </svg>
                                      </div>
                                  </button>
                              </x-slot>

                              <x-slot name="content">
                                  <!-- Authentication -->
                                  <form method="POST" action="{{ route('admin.logout') }}">
                                      @csrf

                                      <x-dropdown-link :href="route('admin.logout')"
                                              onclick="event.preventDefault();
                                                          this.closest('form').submit();">
                                          {{ __('Deslogar') }}
                                      </x-dropdown-link>
                                  </form>
                              </x-slot>
                          </x-dropdown>
                      </div>
                  </div>
              </div>

              <!-- Responsive Navigation Menu -->
              <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                  <div class="pt-2 pb-3 space-y-1">
                      <x-responsive-nav-link :href="route('empresa.home')" :active="request()->routeIs('empresa.home')">
                          {{ __('Dashboard') }}
                      </x-responsive-nav-link>
                  </div>

                  <!-- Responsive Settings Options -->
                  <div class="pt-4 pb-1 border-t border-gray-200">
                      <div class="px-4">
                          <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                          <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                      </div>

                      <div class="mt-3 space-y-1">
                          <!-- Authentication -->
                          <form method="POST" action="{{ route('empresa.logout') }}">
                              @csrf

                              <x-responsive-nav-link :href="route('empresa.logout')"
                                      onclick="event.preventDefault();
                                                  this.closest('form').submit();">
                                  {{ __('Log Out') }}
                              </x-responsive-nav-link>
                          </form>
                      </div>
                  </div>
              </div>
            </nav>
          </nav>

          <!--Container-->
          <div class="container shadow-lg mx-auto bg-white pt-24 md:pt-18 px-2 mb-5">
              @yield('content')
          </div>
      </div>
  </body>

</html>
