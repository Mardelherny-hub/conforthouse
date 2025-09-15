<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConfortHouse Living</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap');

        @theme {
            --color-gold: #e8d4b8;
            --color-dark: #333333;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: #333333;
            background-color: #f8f8f8;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Playfair Display', serif;
        }

        .cream-text {
            color: #e8d4b8;
        }

        .dark-text {
            color: #333333;
        }



        .nav-item {
            position: relative;
        }

        .nav-item:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #e8d4b8;
            transition: width 0.3s;
        }

        .nav-item:hover:after {
            width: 100%;
        }

        .hover-underline::after {
            content: "";
            display: block;
            height: 3px;
            background-color: #f5deb3;
            /* Color Cream */
            width: 100%;
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }

        .hover-underline:hover::after {
            transform: scaleX(1);
        }

        .luxury-card {
            transition: transform 0.3s ease-in-out;
        }

        .luxury-card:hover {
            transform: translateY(-10px);
        }

        .btn-cream {
            background-color: #e8d4b8;
            color: #333333;
            transition: all 0.3s ease;
        }

        .btn-cream:hover {
            background-color: #333333;
            color: #e8d4b8;
            border: 1px solid #e8d4b8;
        }

        .testimonial-card {
            background-color: #ffffff;
            border-left: 4px solid #e8d4b8;
            color: #333333;
        }



        .bg-light {
            background-color: #f8f8f8;
        }

        .bg-medium {
            background-color: #f0f0f0;
        }

        .bg-dark {
            background-color: #2c2c2c;
        }

        .property-card {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <!-- Header Navigation -->
    <header class="relative hero-section min-h-[600px] flex flex-col">
        <!-- Carrusel de imágenes de fondo -->
        <div x-data="{
                activeSlide: 0,
                slides: [
                    {
                        image: '../public/assets/images/gallery/big/big_2.jpg',
                        title: 'Propiedades Exclusivas',
                        subtitle: 'Descubre residencias únicas en las mejores ubicaciones'
                    },
                    {
                        image: '../public/assets/images/gallery/big/big_2.jpg',
                        title: 'Villas de Ensueño',
                        subtitle: 'Espacios diseñados para experiencias extraordinarias'
                    },
                    {
                        image: '../public/assets/images/gallery/big/big_4.jpg',
                        title: 'Inversiones Premium',
                        subtitle: 'Oportunidades inmobiliarias con alto potencial'
                    }
                ],
                loop() {
                    setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides.length }, 5000);
                }
            }" x-init="loop()" class="absolute inset-0 w-full h-full overflow-hidden">

            <!-- Overlay oscuro para mejorar legibilidad -->
            <div class="absolute inset-0 bg-black opacity-50 z-10"></div>

            <!-- Slides del carrusel -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 transform scale-105"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" :style="`background-image: url('${slide.image}');`"
                    class="absolute inset-0 w-full h-full bg-cover bg-center">
                </div>
            </template>

            <!-- Indicadores del carrusel -->
            <div class="absolute bottom-10 left-0 right-0 z-20 flex justify-center space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index"
                        :class="{'bg-amber-300': activeSlide === index, 'bg-white bg-opacity-50': activeSlide !== index}"
                        class="w-3 h-3 rounded-full focus:outline-none transition duration-300"></button>
                </template>
            </div>

            <!-- Flechas de navegación -->
            <div class="absolute inset-y-0 left-0 z-20 flex items-center">
                <button @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length"
                    class="bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-2 rounded-r-md focus:outline-none ml-4 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <div class="absolute inset-y-0 right-0 z-20 flex items-center">
                <button @click="activeSlide = (activeSlide + 1) % slides.length"
                    class="bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-2 rounded-l-md focus:outline-none mr-4 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Estructura principal del header con menú y contenido hero -->
        <div class="relative w-full h-full flex flex-col z-30">
            <!-- Menú de navegación -->
            <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-2xl font-bold">
                        <img src="../public/assets/images/rb/logo-gold.png" alt="ConfortHouse" class="w-48">
                    </div>
                </div>

                <!-- Menú de navegación para desktop -->
                <div class="hidden md:flex space-x-8">
                    <div x-data="{ open: false }" class="relative group">
                        <button @click="open = !open"
                            class="flex items-center text-white hover:text-amber-300 transition duration-300">
                            Propiedades
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            class="absolute z-10 mt-2 bg-white bg-opacity-95 shadow-xl rounded-md p-2 w-60">
                            <div class="flex flex-col space-y-2 py-2">
                                <a href="#"
                                    class="px-4 py-2 text-amber-300 hover:gold hover:bg-gray-200 rounded-md transition duration-300">Alquiler</a>
                                <a href="#"
                                    class="px-4 py-2 text-amber-300 hover:text-amber-300 hover:bg-gray-200 rounded-md transition duration-300">Venta</a>
                                <a href="#"
                                    class="px-4 py-2 text-amber-300 hover:text-amber-300 hover:bg-gray-200 rounded-md transition duration-300">Promociones
                                    Obra Nueva</a>
                                <a href="#"
                                    class="px-4 py-2 text-amber-300 hover:text-amber-300 hover:bg-gray-200 rounded-md transition duration-300">Viviendas
                                    de lujo</a>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="text-white hover:text-amber-300 transition duration-300">Servicios
                        Adicionales</a>
                    <a href="#" class="text-white hover:text-amber-300 transition duration-300">Empresa</a>
                    <a href="#" class="text-white hover:text-amber-300 transition duration-300">Contacto</a>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="#"
                        class="border-2 border-white px-4 py-2 rounded-full text-white hover:bg-white hover:text-gray-800 transition">Login</a>
                </div>

                <!-- Botón de menú móvil -->
                <div class="md:hidden relative z-20" x-data="{ open: false }">
                    <button @click="open = !open" class="text-white hover:text-amber-300 focus:outline-none">
                        <svg x-show="!open" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"></path>
                        </svg>
                        <svg x-show="open" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M18.278 16.864a1 1 0 01-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 01-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 011.414-1.414l4.829 4.828 4.828-4.828a1 1 0 111.414 1.414l-4.828 4.829 4.828 4.828z">
                            </path>
                        </svg>
                    </button>

                    <!-- Menú móvil desplegable -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-2">

                        <div x-data="{ subMenu: false }" class="relative">
                            <button @click="subMenu = !subMenu"
                                class="w-full text-left px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700 flex justify-between items-center">
                                <span>Propiedades</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path x-show="!subMenu" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                    <path x-show="subMenu" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                            <div x-show="subMenu" class="pl-4 pb-1">
                                <a href="#"
                                    class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Alquiler</a>
                                <a href="#"
                                    class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Venta</a>
                                <a href="#"
                                    class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Obra
                                    Nueva</a>
                                <a href="#"
                                    class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Lujo</a>
                            </div>
                        </div>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Servicios</a>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Empresa</a>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Contacto</a>
                        <div class="border-t border-gray-700 my-2"></div>
                        <a href="#" class="block px-4 py-2 text-white hover:text-amber-300 hover:bg-gray-700">Login</a>
                        <a href="#" class="block px-4 py-2 text-amber-300 hover:text-amber-400">Registro</a>
                    </div>
                </div>
            </nav>

            <!-- Hero Content -->
            <div class="container mx-auto px-6 flex flex-col justify-center items-center flex-grow text-center">
                <div class="max-w-4xl mx-auto">
                    <div x-data="{ activeSlide: 0 }"
                        x-init="setInterval(() => { activeSlide = (activeSlide + 1) % 3 }, 5000)" class="mb-6">
                        <template x-for="(slide, index) in [
                            { title: 'Conforthouse <span class=\'text-amber-300\'>Living</span> Marketplace' },
                            { title: 'Propiedades <span class=\'text-amber-300\'>Exclusivas</span> para Ti' },
                            { title: 'El Arte de Vivir con <span class=\'text-amber-300\'>Elegancia</span>' }
                        ]" :key="index">
                            <h1 x-show="activeSlide === index" x-transition:enter="transition ease-out duration-1000"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                x-html="slide.title"
                                class="text-4xl md:text-6xl font-bold tracking-tighter leading-tight text-white">
                            </h1>
                        </template>
                    </div>

                    <p class="text-xl md:text-2xl mb-8 max-w-3xl text-white">
                        Descubre la colección más exclusiva de propiedades de lujo, con un servicio personalizado
                        inigualable.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="#"
                            class="bg-amber-300 hover:bg-amber-400 px-8 py-3 text-lg font-semibold rounded-md text-amber-400 transition duration-300">
                            Explorar propiedades
                        </a>
                        <a href="#"
                            class="bg-transparent border-2 rounded-full border-white hover:border-amber-300 hover:text-amber-300 px-8 py-3 text-lg font-semibold text-white transition duration-300">
                            Contactar ahora
                        </a>
                    </div>
                </div>
            </div>

            <!-- Barra de búsqueda flotante -->
            <div class="container mx-auto px-6 relative z-30 -mb-16">
                <div class="bg-gray-200 rounded-lg shadow-xl p-6 max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300">
                                <option>Comprar</option>
                                <option>Alquilar</option>
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                            <input type="text" placeholder="Ciudad, zona..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Precio máximo</label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300">
                                <option>Cualquier precio</option>
                                <option>500.000 €</option>
                                <option>1.000.000 €</option>
                                <option>2.000.000 €</option>
                                <option>5.000.000 €</option>
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                            <button
                                class="w-full bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 px-4 rounded-full transition duration-300">
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>



    <!-- Main Content -->
    <main>
        <!-- Category Section -->
        <section class="py-16 bg-light mt-20">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <h2 class="text-3xl font-bold mb-12 text-center dark-text">Premium <span
                        class="cream-text">Categories</span></h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Homes -->
                    <div class="luxury-card relative overflow-hidden rounded-sm h-80 cursor-pointer shadow-lg">
                        <img src="../app/public/assets/images/photography/architecture.jpg" alt="Luxury Home"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Homes</h3>
                            <p class="text-sm mt-2 text-gray-200">Explore 2,548 properties</p>
                        </div>
                    </div>

                    <!-- Cars -->
                    <div class="luxury-card relative overflow-hidden rounded-sm h-80 cursor-pointer shadow-lg">
                        <img src="../app/public/assets/images/photography/image2.jpg" alt="Luxury"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Apartaments</h3>
                            <p class="text-sm mt-2 text-gray-200">Explore 1,324 apartaments</p>
                        </div>
                    </div>

                    <!-- Yachts -->
                    <div class="luxury-card relative overflow-hidden rounded-sm h-80 cursor-pointer shadow-lg">
                        <img src="../app/public/assets/images/photography/image4.jpg" alt="Luxury"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Atics</h3>
                            <p class="text-sm mt-2 text-gray-200">Explore 478 Atics</p>
                        </div>
                    </div>

                    <!-- Jets -->
                    <div class="luxury-card relative overflow-hidden rounded-sm h-80 cursor-pointer shadow-lg">
                        <img src="../app/public/assets/images/photography/image3.jpg" alt="Private"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">New Build</h3>
                            <p class="text-sm mt-2 text-gray-200">Explore 196 new builds</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de Propiedad Destacada -->
        <section class="py-16 bg-medium">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <div class="flex flex-col md:flex-row items-center bg-white rounded-sm overflow-hidden shadow-lg">
                    <div class="md:w-1/2">
                        <img src="../app/public/assets/images/gallery/thumbnail/full_2/29.jpg" alt="Propiedad Destacada"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-8 md:p-12">
                        <span
                            class="text-xs uppercase bg-e8d4b8 text-gray-800 px-3 py-1 rounded-sm mb-4 inline-block">Propiedad
                            Destacada</span>
                        <h2 class="text-3xl font-bold mb-2 dark-text">Villa <span class="cream-text">Serenidad</span>
                        </h2>
                        <p class="text-gray-700 mb-2 font-medium">Beverly Hills, California</p>
                        <p class="text-gray-600 mb-6">Exclusiva propiedad de 850m² con vistas panorámicas al océano
                            Pacífico. Cinco habitaciones, piscina infinita, bodega y cine privado.</p>
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center mr-4">
                                <i class="icon-size-fullscreen text-gray-500 mr-2"></i>
                                <span class="text-gray-700">850m²</span>
                            </div>
                            <div class="flex items-center mr-4">
                                <i class="icon-home text-gray-500 mr-2"></i>
                                <span class="text-gray-700">5 Habitaciones</span>
                            </div>
                            <div class="flex items-center">
                                <i class="icon-drop text-gray-500 mr-2"></i>
                                <span class="text-gray-700">6 Baños</span>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" class="btn-cream px-6 py-3 rounded-sm">Ver Detalles</a>
                            <a href="#"
                                class="px-6 py-3 border border-gray-300 rounded-sm text-gray-600 hover:border-cream-text transition duration-300">Contactar</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Trending Products Section -->
        <section class="py-16 bg-light">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold dark-text">Trending <span class="cream-text">Properties</span></h2>
                    <a href="#" class="text-sm cream-text hover:underline">View All Properties</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Property 1 -->
                    <div class="luxury-card property-card rounded-sm overflow-hidden">
                        <div class="relative">
                            <img src="../app/public/assets/images/gallery/big/big_2.jpg" alt="Luxury Property"
                                class="w-full h-64 object-cover">
                            <div class="absolute top-4 left-4 bg-e8d4b8 bg-opacity-90 px-3 py-1 rounded-sm">
                                <span class="text-sm font-medium text-gray-800">Featured</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="cream-text font-semibold">$12,500,000</span>
                                <span class="text-gray-600 text-sm">Beverly Hills, CA</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 dark-text">Modern Hillside Villa</h3>
                            <p class="text-gray-600 text-sm mb-4">5 bedrooms • 7 bathrooms • 8,200 sq ft</p>
                            <a href="#" class="text-sm cream-text hover:underline">View Details</a>
                        </div>
                    </div>

                    <!-- Property 2 -->
                    <div class="luxury-card property-card rounded-sm overflow-hidden">
                        <div class="relative">
                            <img src="../app/public/assets/images/gallery/big/big_5.jpg" alt="Luxury Property"
                                class="w-full h-64 object-cover">
                            <div class="absolute top-4 left-4 bg-e8d4b8 bg-opacity-90 px-3 py-1 rounded-sm">
                                <span class="text-sm font-medium text-gray-800">New Listing</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="cream-text font-semibold">$8,950,000</span>
                                <span class="text-gray-600 text-sm">Miami Beach, FL</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 dark-text">Oceanfront Penthouse</h3>
                            <p class="text-gray-600 text-sm mb-4">4 bedrooms • 5 bathrooms • 5,400 sq ft</p>
                            <a href="#" class="text-sm cream-text hover:underline">View Details</a>
                        </div>
                    </div>

                    <!-- Property 3 -->
                    <div class="luxury-card property-card rounded-sm overflow-hidden">
                        <div class="relative">
                            <img src="../app/public/assets/images/gallery/big/big_26.jpg" alt="Luxury Property"
                                class="w-full h-64 object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="cream-text font-semibold">$17,200,000</span>
                                <span class="text-gray-600 text-sm">Aspen, CO</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 dark-text">Alpine Luxury Lodge</h3>
                            <p class="text-gray-600 text-sm mb-4">6 bedrooms • 8 bathrooms • 10,800 sq ft</p>
                            <a href="#" class="text-sm cream-text hover:underline">View Details</a>
                        </div>
                    </div>

                    <!-- Property 4 -->
                    <div class="luxury-card property-card rounded-sm overflow-hidden">
                        <div class="relative">
                            <img src="../app/public/assets/images/gallery/big/big_28.jpg" alt="Luxury Property"
                                class="w-full h-64 object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="cream-text font-semibold">$9,475,000</span>
                                <span class="text-gray-600 text-sm">Hamptons, NY</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 dark-text">Coastal Estate</h3>
                            <p class="text-gray-600 text-sm mb-4">5 bedrooms • 6 bathrooms • 7,500 sq ft</p>
                            <a href="#" class="text-sm cream-text hover:underline">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--  Servicios Exclusivos -->
        <section class="py-16 bg-medium">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold dark-text">Servicios <span class="cream-text">Exclusivos</span></h2>
                    <a href="#" class="text-sm cream-text hover:underline">Ver Todos los Servicios</a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Servicio Principal -->
                    <div class="luxury-card lg:col-span-2 relative overflow-hidden rounded-sm h-96 shadow-lg">
                        <img src="../app/public/assets/images/section-14.jpg" alt="Servicios Exclusivos"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <span
                                class="text-xs uppercase bg-e8d4b8 text-gray-800 px-3 py-1 rounded-sm">Destacado</span>
                            <h3 class="text-2xl font-bold mt-3 mb-2 text-white">
                                Property Valuation</h3>
                            <p class="text-gray-200 mb-3">We accurately value each property, offering a detailed and
                                objective analysis of the luxury real estate market. </p>
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 rounded-full overflow-hidden mr-3 flex items-center justify-center bg-white">
                                    <span class="icon-wallet text-gray-800"></span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">Servicio Premium</p>
                                    <p class="text-xs text-gray-300">Consulta disponibilidad</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios Laterales -->
                    <div class="space-y-6">
                        <!-- Servicio Lateral 1 -->
                        <div class="luxury-card flex bg-white rounded-sm overflow-hidden shadow-lg">
                            <div class="w-1/3 flex items-center justify-center bg-gray-100">
                                <span class="icon-briefcase text-3xl text-gray-700"></span>
                            </div>
                            <div class="w-2/3 p-4">
                                <span class="text-xs cream-text">Legales</span>
                                <h4 class="text-lg font-semibold my-1 dark-text"> Servicio Jurídico Gratuito</h4>
                                <p class="text-xs text-gray-500">Ponemos gratuitamente a su servicio un abogado
                                    especializado en derecho inmobiliario. </p>
                            </div>
                        </div>

                        <!-- Servicio Lateral 2 -->
                        <div class="luxury-card flex bg-white rounded-sm overflow-hidden shadow-lg">
                            <div class="w-1/3 flex items-center justify-center bg-gray-100">
                                <span class="icon-puzzle text-3xl text-gray-700"></span>
                            </div>
                            <div class="w-2/3 p-4">
                                <span class="text-xs cream-text">Estrategia</span>
                                <h4 class="text-lg font-semibold my-1 dark-text">Personalized Consulting</h4>
                                <p class="text-xs text-gray-500">Comprehensive advice adapted to the specific needs of
                                    each client in the high-end real estate market. </p>
                            </div>
                        </div>

                        <!-- Servicio Lateral 3 -->
                        <div class="luxury-card flex bg-white rounded-sm overflow-hidden shadow-lg">
                            <div class="w-1/3 flex items-center justify-center bg-gray-100">
                                <span class="icon-laptop text-3xl text-gray-700"></span>
                            </div>
                            <div class="w-2/3 p-4">
                                <span class="text-xs cream-text">Tecnología</span>
                                <h4 class="text-lg font-semibold my-1 dark-text">Property Management</h4>
                                <p class="text-xs text-gray-500">Comprehensive administration and management services
                                    for luxury properties. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 podcast-banner">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-bold mb-4 text-white">Servicios <span class="cream-text">Exclusivos</span>
                    </h2>
                    <p class="text-gray-200 mb-6">Nuestros Servicios Exclusivos para clientes que buscan soluciones
                        personalizadas y de alta calidad en gestión patrimonial y asesoramiento financiero.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#" class="btn-cream px-6 py-3 rounded-full text-center">Solicitar Información</a>
                        <a href="#"
                            class="px-6 py-3 border border-gray-300 rounded-full text-white hover:border-cream-text transition duration-300 text-center">Ver
                            Servicios</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de Contacto -->
        <section class="py-16 bg-light">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <h2 class="text-3xl font-bold mb-12 text-center dark-text">Contáctese con <span
                        class="cream-text">Nosotros</span></h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                    <!-- Formulario de Contacto -->
                    <div class="bg-white p-8 shadow-lg rounded-sm">
                        <h3 class="text-xl font-bold mb-6 dark-text">Envíenos un mensaje</h3>
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nombre
                                        completo</label>
                                    <input type="text" id="name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-cream-text"
                                        placeholder="Su nombre">
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Correo
                                        electrónico</label>
                                    <input type="email" id="email"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-cream-text"
                                        placeholder="Su email">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="tel" id="phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-cream-text"
                                    placeholder="Su teléfono">
                            </div>
                            <div class="mb-6">
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">Asunto</label>
                                <select id="subject"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-cream-text">
                                    <option value="">Seleccione un asunto</option>
                                    <option value="property">Consulta sobre una propiedad</option>
                                    <option value="service">Servicios exclusivos</option>
                                    <option value="partnership">Colaboraciones</option>
                                    <option value="other">Otros</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="message"
                                    class="block mb-2 text-sm font-medium text-gray-700">Mensaje</label>
                                <textarea id="message" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:border-cream-text"
                                    placeholder="Su mensaje"></textarea>
                            </div>
                            <button type="submit" class="btn-cream px-6 py-3 rounded-sm w-full">Enviar mensaje</button>
                        </form>
                    </div>

                    <!-- Información de Contacto -->
                    <div>
                        <div class="bg-white p-8 shadow-lg rounded-sm mb-8">
                            <h3 class="text-xl font-bold mb-6 dark-text">Información de contacto</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="icon-location-pin text-cream-text text-xl mr-4 mt-1"></i>
                                    <div>
                                        <p class="font-medium dark-text">Dirección</p>
                                        <p class="text-gray-600">Avenida Diagonal 640, 08017 Barcelona, España</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="icon-envelope text-cream-text text-xl mr-4 mt-1"></i>
                                    <div>
                                        <p class="font-medium dark-text">Email</p>
                                        <p class="text-gray-600">info@luxeproperties.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="icon-phone text-cream-text text-xl mr-4 mt-1"></i>
                                    <div>
                                        <p class="font-medium dark-text">Teléfono</p>
                                        <p class="text-gray-600">+34 932 000 000</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial -->
                        <div class="testimonial-card p-8 shadow-lg">
                            <p class="text-lg italic mb-6">"LUXE ha sido nuestro aliado estratégico en la búsqueda de
                                propiedades exclusivas. Su servicio personalizado y su conocimiento del mercado son
                                excepcionales."</p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                                    <img src="../app/public/assets/images/photography/image4.jpg" alt="Cliente"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium dark-text">María González</p>
                                    <p class="text-sm text-gray-600">Directora General, Inversiones Premium</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colaboraciones/Logos (Versión reducida) -->
                <div class="mt-16">
                    <p class="text-center text-gray-600 mb-8">Empresas que confían en nosotros</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 items-center">
                        <div class="flex justify-center">
                            <img src="../app/public/assets/images/photography/image4.jpg" alt="Logo 1"
                                class="h-6 opacity-70 hover:opacity-100 transition duration-300">
                        </div>
                        <div class="flex justify-center">
                            <img src="../app/public/assets/images/photography/image4.jpg" alt="Logo 2"
                                class="h-6 opacity-70 hover:opacity-100 transition duration-300">
                        </div>
                        <div class="flex justify-center">
                            <img src="../app/public/assets/images/photography/image4.jpg" alt="Logo 3"
                                class="h-6 opacity-70 hover:opacity-100 transition duration-300">
                        </div>
                        <div class="flex justify-center">
                            <img src="../app/public/assets/images/photography/image4.jpg" alt="Logo 4"
                                class="h-6 opacity-70 hover:opacity-100 transition duration-300">
                        </div>
                        <div class="flex justify-center">
                            <img src="../app/public/assets/images/photography/image4.jpg" alt="Logo 5"
                                class="h-6 opacity-70 hover:opacity-100 transition duration-300">
                        </div>
                        <div class="flex justify-center">
                            <img src="../app/public/assets/images/photography/image4.jpg" alt="Logo 6"
                                class="h-6 opacity-70 hover:opacity-100 transition duration-300">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-dark pt-16 pb-8 text-white">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <!-- Footer Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Company Info -->
                <div>
                    <div class="text-2xl font-bold cream-text mb-4">
                        <img src="../app/public/assets/images/rb/logo-gold.png" alt="ConfortHouse" class="w-48">
                    </div>
                    <p class="text-gray-300 mb-6">The world's premier marketplace for luxury homes, vehicles, yachts,
                        and private aircraft.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.
                                348 8.348 0 00-2.35 1.377c.013.155.02.318.02.48 0 2.92-1.493 5.49-3.77 6.99 1.39-.04 2.68-.426 3.82-1.06a4.15 4.15 0 01-3.87 2.88c-.51 0-1.01-.1-1.48-.
                                29.01.02-.03.05-.06.07-.09a4.15 4.15 0 003.32-4.07c0-.02-.01-.04-.01-.06 0-.01.01-.02.01-.03 0-1.71-1.23-3.14-2.86-3.47a4.18 4.18 0 00-1.1-.15c-.27 0-.53.03-.79.08.53-1.7 2.07-2.94 3.87-2.98a8.3 8.3 0 01-2.6 3.15c-.01-.08-.01-.16-.01-.24 0-4.41 3.14-9.51 9.1-9.51 2.68 0 5.05 1.01 6.9 2.64a16.8 16.8 0 005.3-2.03c-.63 2.04-2.04 3.75-3.85 4.85 1.77-.21 3.45-.68 5.01-1.38a17.02 17.02 0 01-4.5 4.66c-1.03-.03-2.01-.31-2.86-.
                                77z"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10 5.52 0 10-4.48 10-10 0-5.52-4.48-10-10-10zm5.5 8.5c0-.41.34-.75.75-.75s.
                                    75.01.75.75-.75.75-.75.75-.75.34-.75.75zm-7 0c0-.41.34-.75.75-.75s.
                                    75.01.75.75-.75.75-.75.75-.75.34-.75.75zm-2.75 3.25c.69 0 1.25-.56 1.25-1.25s-.56-1.25-1.25-1.25-1.25.56-1.25 1.25.56 1.25 1.25 1.25zm7 0c.69 0 1.25-.56 1.25-1.25s-.56-1.25-1.25-1.25-1.25.56-1.25 1.25.56 1.25 1.25 1.25zm-3.25 3.25c0-.41.34-.75.75-.75s.
                                    75.01.75.75-.75.75-.75.75-.75.34-.75.75z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <!-- Navigation Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-cream-text transition duration-300">Inicio</a></li>
                        <li><a href="#" class="hover:text-cream-text transition duration-300">Propiedades</a></li>
                        <li><a href="#" class="hover:text-cream-text transition duration-300">Servicios</a></li>
                        <li><a href="#" class="hover:text-cream-text transition duration-300">Contacto</a></li>
                    </ul>
                </div>
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <p class="text-gray-300">Avenida Diagonal 640, 08017 Barcelona, España</p>
                    <p class="text-gray-300">
                        <a href="mailto:#" class="hover:text-cream-text transition duration-300">
                        <span class=" text-cream-text">info@conforthouse.com</span>
                        </a>
                    </p>
                    <p class="text-gray-300">+34 932 000 000</p>
                </div>
            </div>
            <!-- Footer Bottom -->
            <div class="border-t border-gray-700 pt-6">
                <p class="text-gray-300 text-center">© 2021 ConfortHouse. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    <!-- Scripts -->

</body>

</html>
