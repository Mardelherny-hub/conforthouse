<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Modificación en app.blade.php -->
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}

                    <!-- Breadcrumb -->
                    @if (isset($breadcrumbs))
                        <nav class="text-sm mt-2" aria-label="Breadcrumb">
                            <ol class="list-none p-0 inline-flex">

                                @foreach ($breadcrumbs as $breadcrumb)
                                    @if ($loop->last)
                                        <li class="text-gray-700 font-medium" aria-current="page">
                                            {{ $breadcrumb['title'] }}
                                        </li>
                                    @else
                                        <li class="flex items-center">
                                            <a href="{{ $breadcrumb['url'] }}"
                                                class="text-gray-500 hover:text-gray-700">
                                                {{ $breadcrumb['title'] }}
                                            </a>
                                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 320 512">
                                                <path
                                                    d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                                            </svg>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                    @endif
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script src="{{ asset('js/contact-forms.js') }}"></script>
</body>

</html>
