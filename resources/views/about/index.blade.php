<x-public-layout>

    <x-slot name="backgroundImage">{{ asset('assets/images/about/about-bg.jpeg') }}</x-slot>

    <!-- Sección Historia y Misión -->
    <section class="py-20 bg-white">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h5 class="text-amber-500 font-luxury-sans uppercase tracking-wider mb-3">
                        {{ __('messages.about_subtitle') }}</h5>
                    <h1 class="text-4xl font-luxury font-bold text-gray-900 mb-6">{{ __('messages.about_title') }}</h1>
                    <div class="w-20 h-px bg-amber-400 mb-8"></div>
                    <p class="text-gray-600 font-luxury-sans mb-6">{{ __('messages.about_desc_1') }}</p>
                    <p class="text-gray-600 font-luxury-sans mb-6">{{ __('messages.about_desc_2') }}</p>

                    <!-- Valores de la empresa -->
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="flex items-start">
                            <div class="text-amber-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury font-semibold text-gray-900 mb-1">
                                    {{ __('messages.value_1_title') }}</h4>
                                <p class="text-sm text-gray-600 font-luxury-sans">{{ __('messages.value_1_desc') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-amber-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury font-semibold text-gray-900 mb-1">
                                    {{ __('messages.value_2_title') }}</h4>
                                <p class="text-sm text-gray-600 font-luxury-sans">{{ __('messages.value_2_desc') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-amber-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury font-semibold text-gray-900 mb-1">
                                    {{ __('messages.value_3_title') }}</h4>
                                <p class="text-sm text-gray-600 font-luxury-sans">{{ __('messages.value_3_desc') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-amber-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury font-semibold text-gray-900 mb-1">
                                    {{ __('messages.value_4_title') }}</h4>
                                <p class="text-sm text-gray-600 font-luxury-sans">{{ __('messages.value_4_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="relative z-10 w-3/4 aspect-[4/3] overflow-hidden">
                        <img src="{{ asset('assets/images/about/about-main.jpeg') }}"
                            alt="Confort House Team"
                            class="w-full h-full object-cover rounded-sm shadow-lg">
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-3/4 aspect-[4/3] border-2 border-amber-400 rounded-sm z-0"></div>
                </div>


        </div>
    </section>

   <!-- Sección Estadísticas -->
    <section class="py-16 bg-dark/95 relative">
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
            style="background-image: url('{{ asset('assets/images/about/stats-bg.jpeg') }}')"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

                <!-- Años de Experiencia -->
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-amber-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12h20M12 2v20" />
                            <path d="M8 22h8M9 2h6" />
                        </svg>
                    </div>
                    <div class="text-amber-400 text-4xl font-luxury font-bold">{{ __('messages.stats_years') }}</div>
                    <p class="text-white font-luxury-sans text-sm uppercase tracking-wider">
                        {{ __('messages.stats_years_label') }}
                    </p>
                </div>

                <!-- Propiedades -->
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-amber-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7" />
                            <path d="M9 22V12h6v10" />
                            <path d="M21 22V10" />
                            <path d="M3 22V10" />
                        </svg>
                    </div>
                    <div class="text-amber-400 text-4xl font-luxury font-bold">{{ __('messages.stats_properties') }}</div>
                    <p class="text-white font-luxury-sans text-sm uppercase tracking-wider">
                        {{ __('messages.stats_properties_label') }}
                    </p>
                </div>

                <!-- Clientes -->
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-amber-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="7" r="4" />
                            <path d="M17 11a4 4 0 1 0-6 3.46" />
                            <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </div>
                    <div class="text-amber-400 text-4xl font-luxury font-bold">{{ __('messages.stats_clients') }}</div>
                    <p class="text-white font-luxury-sans text-sm uppercase tracking-wider">
                        {{ __('messages.stats_clients_label') }}
                    </p>
                </div>

                <!-- Premios -->
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-amber-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 21h8M12 17v4" />
                            <path d="M7 3h10l-1 8H8z" />
                            <path d="M12 17l-3-3m3 3l3-3" />
                        </svg>
                    </div>
                    <div class="text-amber-400 text-4xl font-luxury font-bold">{{ __('messages.stats_awards') }}</div>
                    <p class="text-white font-luxury-sans text-sm uppercase tracking-wider">
                        {{ __('messages.stats_awards_label') }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Sección Equipo -->
    {{-- <section class="py-20 bg-gray-50">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-luxury font-bold text-gray-900 mb-4">{{ __('messages.team_title') }}</h2>
                <div class="w-20 h-px mx-auto bg-amber-400 mb-6"></div>
                <p class="max-w-3xl mx-auto text-gray-600 font-luxury-sans">{{ __('messages.team_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Miembro 1 -->
                <div class="group">
                    <div class="relative overflow-hidden mb-6">
                        <img src="{{ asset('assets/images/about/team1.jpeg') }}" alt="Team Member"
                            class="w-full h-auto rounded-sm">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-6">
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-1">
                        {{ __('messages.team_member_1_name') }}</h3>
                    <p class="text-amber-500 font-luxury-sans mb-3">{{ __('messages.team_member_1_position') }}</p>
                    <p class="text-gray-600 font-luxury-sans">{{ __('messages.team_member_1_desc') }}</p>
                </div>

                <!-- Miembro 2 -->
                <div class="group">
                    <div class="relative overflow-hidden mb-6">
                        <img src="{{ asset('assets/images/about/team2.jpeg') }}" alt="Team Member"
                            class="w-full h-auto rounded-sm">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-6">
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-1">
                        {{ __('messages.team_member_2_name') }}</h3>
                    <p class="text-amber-500 font-luxury-sans mb-3">{{ __('messages.team_member_2_position') }}</p>
                    <p class="text-gray-600 font-luxury-sans">{{ __('messages.team_member_2_desc') }}</p>
                </div>

                <!-- Miembro 3 -->
                <div class="group">
                    <div class="relative overflow-hidden mb-6">
                        <img src="{{ asset('assets/images/about/team3.jpeg') }}" alt="Team Member"
                            class="w-full h-auto rounded-sm">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-6">
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="text-white hover:text-amber-400 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-1">
                        {{ __('messages.team_member_3_name') }}</h3>
                    <p class="text-amber-500 font-luxury-sans mb-3">{{ __('messages.team_member_3_position') }}</p>
                    <p class="text-gray-600 font-luxury-sans">{{ __('messages.team_member_3_desc') }}</p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Sección Historia de la empresa -->
    <section class="py-20 bg-white">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-luxury font-bold text-gray-900 mb-4">{{ __('messages.history_title') }}</h2>
                <div class="w-20 h-px mx-auto bg-amber-400 mb-6"></div>
                <p class="max-w-3xl mx-auto text-gray-600 font-luxury-sans">{{ __('messages.history_subtitle') }}</p>
            </div>

            <!-- Timeline -->
            <div class="relative">
                <!-- Línea central -->
                <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-px bg-amber-300/30"></div>

                <!-- Eventos de la timeline -->
                <div class="space-y-16">
                    <!-- Evento 1 -->
                    <div class="relative flex items-center justify-between">
                        <div class="w-5/12 pr-10 text-right">
                            <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-2">
                                {{ __('messages.history_year_1') }}</h3>
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.history_desc_1') }}</p>
                        </div>
                        <div
                            class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 rounded-full bg-amber-400 z-10">
                        </div>
                        <div class="w-5/12 pl-10">
                            <img src="{{ asset('assets/images/history/history1.jpeg') }}" alt="History"
                                class="w-full h-auto rounded-sm shadow-md">
                        </div>
                    </div>

                    <!-- Evento 2 -->
                    <div class="relative flex items-center justify-between">
                        <div class="w-5/12 pr-10">
                            <img src="{{ asset('assets/images/history/history2.jpeg') }}" alt="History"
                                class="w-full h-auto rounded-sm shadow-md">
                        </div>
                        <div
                            class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 rounded-full bg-amber-400 z-10">
                        </div>
                        <div class="w-5/12 pl-10 text-left">
                            <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-2">
                                {{ __('messages.history_year_2') }}</h3>
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.history_desc_2') }}</p>
                        </div>
                    </div>

                    <!-- Evento 3 -->
                    <div class="relative flex items-center justify-between">
                        <div class="w-5/12 pr-10 text-right">
                            <h3 class="text-xl font-luxury font-semibold text-gray-900 mb-2">
                                {{ __('messages.history_year_3') }}</h3>
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.history_desc_3') }}</p>
                        </div>
                        <div
                            class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 rounded-full bg-amber-400 z-10">
                        </div>
                        <div class="w-5/12 pl-10">
                            <img src="{{ asset('assets/images/history/history3.jpeg') }}" alt="History"
                                class="w-full h-auto rounded-sm shadow-md">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección CTA -->
    <section class="py-16 bg-dark/95 relative">
        <div class="absolute inset-0 bg-cover bg-center opacity-30"
            style="background-image: url('{{ asset('assets/images/contact/cta-bg.jpeg') }}')"></div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h2 class="text-3xl font-luxury font-bold text-white mb-6">{{ __('messages.cta_about_title') }}</h2>
            <p class="max-w-2xl mx-auto text-gray-300 font-luxury-sans mb-8">{{ __('messages.cta_about_desc') }}</p>
            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                class="inline-block bg-amber-400 hover:bg-amber-500 text-gray-900 font-luxury-sans font-medium px-8 py-3 rounded-sm transition duration-300 transform hover:scale-105">
                {{ __('messages.contact_us_button') }}
            </a>
        </div>
    </section>
</x-public-layout>
