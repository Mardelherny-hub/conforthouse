<x-public-layout>

    <x-slot name="backgroundImage">{{ asset('assets/images/services/service-bg.jpeg') }}</x-slot>

    <!-- Sección de Servicios -->
    <section class="py-20 bg-gray-50">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <!-- Encabezado de sección -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-luxury font-bold text-gray-900 mb-4">{{ __('messages.services_title') }}</h1>
                <div class="w-20 h-px mx-auto bg-amber-400 mb-6"></div>
                <p class="max-w-3xl mx-auto text-gray-600 font-luxury-sans">{{ __('messages.services_subtitle') }}</p>
            </div>

            <!-- Grid principal -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                <!-- Primera columna: Grid de 4 cards (2x2) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    <!-- Servicio 1: Compra de Propiedades -->
                    <div class="group bg-white border border-gray-200 hover:border-amber-300 p-8 rounded-sm transition-all duration-300 hover:shadow-lg flex flex-col">
                        <div class="mb-6 text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-3 group-hover:text-amber-600 transition-colors duration-300">{{ __('messages.buying_properties') }}</h3>
                        <p class="text-gray-600 font-luxury-sans mb-6 flex-grow">{{ __('messages.buying_properties_desc') }}</p>
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'operation_id' => 1]) }}" class="inline-flex items-center text-amber-600 font-luxury-sans group-hover:text-amber-700">
                            <span>{{ __('messages.learn_more') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Servicio 2: Alquiler de Propiedades -->
                    <div class="group bg-white border border-gray-200 hover:border-amber-300 p-8 rounded-sm transition-all duration-300 hover:shadow-lg flex flex-col">
                        <div class="mb-6 text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-3 group-hover:text-amber-600 transition-colors duration-300">{{ __('messages.renting_properties') }}</h3>
                        <p class="text-gray-600 font-luxury-sans mb-6 flex-grow">{{ __('messages.renting_properties_desc') }}</p>
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'operation_id' => 2]) }}" class="inline-flex items-center text-amber-600 font-luxury-sans group-hover:text-amber-700">
                            <span>{{ __('messages.learn_more') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Servicio 4: Valoración de Propiedades -->
                    <div class="group bg-white border border-gray-200 hover:border-amber-300 p-8 rounded-sm transition-all duration-300 hover:shadow-lg flex flex-col">
                        <div class="mb-6 text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-3 group-hover:text-amber-600 transition-colors duration-300">{{ __('messages.property_valuation') }}</h3>
                        <p class="text-gray-600 font-luxury-sans mb-6 flex-grow">{{ __('messages.property_valuation_desc') }}</p>
                        <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-amber-600 font-luxury-sans group-hover:text-amber-700">
                            <span>{{ __('messages.learn_more') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Servicio 5: Diseño de Interiores -->
                    <div class="group bg-white border border-gray-200 hover:border-amber-300 p-8 rounded-sm transition-all duration-300 hover:shadow-lg flex flex-col">
                        <div class="mb-6 text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-3 group-hover:text-amber-600 transition-colors duration-300">{{ __('messages.interior_design') }}</h3>
                        <p class="text-gray-600 font-luxury-sans mb-6 flex-grow">{{ __('messages.interior_design_desc') }}</p>
                        <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-amber-600 font-luxury-sans group-hover:text-amber-700">
                            <span>{{ __('messages.learn_more') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                </div>

                <!-- Segunda columna: Card grande de Asesoría Legal -->
                <div class="group bg-white border border-gray-200 hover:border-amber-300 p-8 rounded-sm transition-all duration-300 hover:shadow-lg flex flex-col h-full">
                    <div class="mb-6 text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2M3 16V6a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-3 group-hover:text-amber-600 transition-colors duration-300">{{ __('messages.legal_advice') }}</h3>
                    <p class="text-gray-600 font-luxury-sans mb-6 flex-grow leading-relaxed">{!! __('messages.legal_advice_desc') !!}</p>
                    <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-amber-600 font-luxury-sans group-hover:text-amber-700 mt-auto">
                        <span>{{ __('messages.learn_more') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </section>
</x-public-layout>