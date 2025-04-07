<!-- views/auth/login.blade.php -->
<x-login-layout>
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-xl">
        <!-- Logo -->
        <div class="flex justify-center">
            <a class="navbar-brand" href="{{ route('home', ['locale' => app()->getLocale()]) }}">
                <h1 class="text-3xl font-serif text-gold-600">Conforthouse Living</h1>
            </a>
        </div>

        <h2 class="mt-6 text-center text-2xl font-extrabold text-gray-900 font-serif">
            {{ __('messages.bienvenido') }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ __('messages.portal_exclusivo') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="rounded-md shadow-sm">
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-serif text-sm" />
                    <x-text-input id="email"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-gold-500 focus:border-gold-500 focus:z-10 sm:text-sm"
                        type="email"
                        name="email"
                        :value="old('email')"
                        placeholder="nombre@ejemplo.com"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                </div>
            </div>

            <!-- Password -->
            <div class="rounded-md shadow-sm">
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-serif text-sm" />
                    <x-text-input id="password"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-gold-500 focus:border-gold-500 focus:z-10 sm:text-sm"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                </div>
            </div>

            <div class="flex items-center justify-between">
                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me"
                        type="checkbox"
                        class="h-4 w-4 text-gold-600 focus:ring-gold-500 border-gray-300 rounded"
                        name="remember">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        {{ __('messages.remember_me') }}
                    </label>
                </div>

                <!-- Forgot Password -->
                <div class="text-sm">
                    @if (Route::has('password.request'))
                        <a class="font-medium text-gold-600 hover:text-gold-500" href="{{ route('password.request') }}">
                            {{ __('messages.forgot_password') }}
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all duration-300">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <!-- Lock Icon -->
                        <svg class="h-5 w-5 text-gold-300 group-hover:text-gold-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    {{ __('messages.login') }}
                </button>
            </div>

            <!-- Language Selection -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <p class="text-sm text-center text-gray-600 mb-3">{{ __('messages.sel_lang') }}</p>
                <div class="flex justify-center space-x-6">
                    <a href="{{ route(Route::currentRouteName(), ['locale' => 'es'] + Route::current()->parameters()) }}" class="flex items-center text-sm text-gray-600 hover:text-gold-600">
                        <img src="{{ asset('assets/images/flags/4x3/es.svg') }}" alt="Spanish" class="w-5 h-4 mr-1">
                        <span>ES</span>
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['locale' => 'en'] + Route::current()->parameters()) }}" class="flex items-center text-sm text-gray-600 hover:text-gold-600">
                        <img src="{{ asset('assets/images/flags/4x3/en.svg') }}" alt="English" class="w-5 h-4 mr-1">
                        <span>EN</span>
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['locale' => 'fr'] + Route::current()->parameters()) }}" class="flex items-center text-sm text-gray-600 hover:text-gold-600">
                        <img src="{{ asset('assets/images/flags/4x3/fr.svg') }}" alt="French" class="w-5 h-4 mr-1">
                        <span>FR</span>
                    </a>
                    <a href="{{ route(Route::currentRouteName(), ['locale' => 'de'] + Route::current()->parameters()) }}" class="flex items-center text-sm text-gray-600 hover:text-gold-600">
                        <img src="{{ asset('assets/images/flags/4x3/de.svg') }}" alt="German" class="w-5 h-4 mr-1">
                        <span>DE</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-login-layout>
