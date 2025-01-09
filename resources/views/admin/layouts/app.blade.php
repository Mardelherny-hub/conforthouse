<!DOCTYPE html>
<html lang="es">
<head>
    @include('admin.partials.head')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"> <!-- Asegúrate de que el CSS de Core UI se compila aquí -->
    <title>Panel de Administración</title>
</head>
<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        @include('admin.layouts.sidebar') <!-- Sidebar de Core UI -->
    </div>

    <div class="c-wrapper">
        @include('admin.layouts.navbar') <!-- Navbar de Core UI -->

        <main class="c-main">
            @yield('content') <!-- Aquí va el contenido dinámico de las vistas -->
        </main>
    </div>

    @include('admin.partials.footer')
    <script src="{{ mix('js/app.js') }}"></script> <!-- Scripts generados por Vite -->
</body>
</html>
