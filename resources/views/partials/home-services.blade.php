<!-- Services Section -->
<section class="section-luxury bg-white relative overflow-hidden">
    <!-- Elementos decorativos -->
    <div class="absolute top-24 right-24 w-32 h-32 rounded-full bg-gold-100 opacity-10 blur-2xl"></div>
    <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-champagne-100 opacity-15 blur-3xl"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <div class="inline-block mb-4">
                <div class="flex items-center justify-center">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-gold-400"></div>
                    <span class="mx-4 text-gold-600 text-sm font-body uppercase tracking-widest font-light">
                        {{ __('messages.servicios') }}
                    </span>
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-gold-400"></div>
                </div>
            </div>
            <h2 class="section-title">
                {{ __('messages.nuestros') }} 
                <span class="text-gold-600">{{ __('messages.servicios') }}</span>
                {{ __('messages.exclusivos') }}
            </h2>
            <p class="section-subtitle">
                {{ __('messages.ofrecemos_servicios_personalizados') }}
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1: Consultoría Inmobiliaria -->
            <div class="group bg-neutral-50 rounded-lg p-8 hover:bg-white transition-all duration-500 hover:shadow-luxury relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-gold-100 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-4 group-hover:text-gold-700 transition-colors duration-300">
                        {{ __('messages.consultoria_inmobiliaria') }}
                    </h3>
                    
                    <p class="text-neutral-600 text-sm leading-relaxed mb-6">
                        {{ __('messages.asesoramiento_personalizado_desc') }}
                    </p>
                    
                    <div class="flex items-center text-gold-600 text-sm font-body font-medium group-hover:text-gold-700 transition-colors duration-300">
                        <span>{{ __('messages.conocer_mas') }}</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service 2: Gestión Integral -->
            <div class="group bg-neutral-50 rounded-lg p-8 hover:bg-white transition-all duration-500 hover:shadow-luxury relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-gold-100 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-4 group-hover:text-gold-700 transition-colors duration-300">
                        {{ __('messages.gestion_integral') }}
                    </h3>
                    
                    <p class="text-neutral-600 text-sm leading-relaxed mb-6">
                        {{ __('messages.gestion_integral_desc') }}
                    </p>
                    
                    <div class="flex items-center text-gold-600 text-sm font-body font-medium group-hover:text-gold-700 transition-colors duration-300">
                        <span>{{ __('messages.conocer_mas') }}</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service 3: Marketing Premium -->
            <div class="group bg-neutral-50 rounded-lg p-8 hover:bg-white transition-all duration-500 hover:shadow-luxury relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-gold-100 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1h2a1 1 0 011-1z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7h4m0 0v4m0-4l-4 4-3-3-4 4"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-4 group-hover:text-gold-700 transition-colors duration-300">
                        {{ __('messages.marketing_premium') }}
                    </h3>
                    
                    <p class="text-neutral-600 text-sm leading-relaxed mb-6">
                        {{ __('messages.marketing_premium_desc') }}
                    </p>
                    
                    <div class="flex items-center text-gold-600 text-sm font-body font-medium group-hover:text-gold-700 transition-colors duration-300">
                        <span>{{ __('messages.conocer_mas') }}</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service 4: Valoraciones Profesionales -->
            <div class="group bg-neutral-50 rounded-lg p-8 hover:bg-white transition-all duration-500 hover:shadow-luxury relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-gold-100 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-4 group-hover:text-gold-700 transition-colors duration-300">
                        {{ __('messages.valoraciones_profesionales') }}
                    </h3>
                    
                    <p class="text-neutral-600 text-sm leading-relaxed mb-6">
                        {{ __('messages.valoraciones_profesionales_desc') }}
                    </p>
                    
                    <div class="flex items-center text-gold-600 text-sm font-body font-medium group-hover:text-gold-700 transition-colors duration-300">
                        <span>{{ __('messages.conocer_mas') }}</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service 5: Financiamiento -->
            <div class="group bg-neutral-50 rounded-lg p-8 hover:bg-white transition-all duration-500 hover:shadow-luxury relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-gold-100 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-4 group-hover:text-gold-700 transition-colors duration-300">
                        {{ __('messages.financiamiento') }}
                    </h3>
                    
                    <p class="text-neutral-600 text-sm leading-relaxed mb-6">
                        {{ __('messages.financiamiento_desc') }}
                    </p>
                    
                    <div class="flex items-center text-gold-600 text-sm font-body font-medium group-hover:text-gold-700 transition-colors duration-300">
                        <span>{{ __('messages.conocer_mas') }}</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service 6: Servicios Legales -->
            <div class="group bg-neutral-50 rounded-lg p-8 hover:bg-white transition-all duration-500 hover:shadow-luxury relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-gold-100 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-4 group-hover:text-gold-700 transition-colors duration-300">
                        {{ __('messages.servicios_legales') }}
                    </h3>
                    
                    <p class="text-neutral-600 text-sm leading-relaxed mb-6">
                        {{ __('messages.servicios_legales_desc') }}
                    </p>
                    
                    <div class="flex items-center text-gold-600 text-sm font-body font-medium group-hover:text-gold-700 transition-colors duration-300">
                        <span>{{ __('messages.conocer_mas') }}</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-16">
            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" 
               class="btn-luxury-primary">
                {{ __('messages.solicitar_consultoria') }}
            </a>
        </div>
    </div>
</section>