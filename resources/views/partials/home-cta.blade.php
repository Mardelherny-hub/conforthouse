<!-- CTA Section -->
<section class="section-luxury bg-neutral-900 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="luxury-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <circle cx="50" cy="50" r="2" fill="#B8731A" opacity="0.3"/>
                    <circle cx="25" cy="25" r="1" fill="#B8731A" opacity="0.2"/>
                    <circle cx="75" cy="75" r="1" fill="#B8731A" opacity="0.2"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#luxury-pattern)"/>
        </svg>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-gold-400 opacity-5 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-gold-300 opacity-3 blur-3xl"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Badge -->
            <div class="inline-block mb-6">
                <div class="flex items-center justify-center">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-gold-400"></div>
                    <span class="mx-4 text-gold-400 text-sm font-body uppercase tracking-widest font-light">
                        {{ __('messages.comienza_hoy') }}
                    </span>
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-gold-400"></div>
                </div>
            </div>
            
            <!-- Main Headline -->
            <h2 class="font-luxury text-4xl md:text-5xl lg:text-6xl font-semibold text-white mb-6 leading-tight">
                {{ __('messages.encuentra_la') }} 
                <span class="text-gold-400">{{ __('messages.propiedad') }}</span>
                <br>
                {{ __('messages.de_tus_suenos') }}
            </h2>
            
            <!-- Subtext -->
            <p class="text-neutral-300 text-lg md:text-xl font-body font-light leading-relaxed mb-10 max-w-2xl mx-auto">
                {{ __('messages.cta_subtitle') }}
            </p>
            
            <!-- Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="text-center group">
                    <div class="text-3xl md:text-4xl font-luxury font-bold text-gold-400 mb-2 group-hover:text-gold-300 transition-colors duration-300">
                        500+
                    </div>
                    <p class="text-neutral-400 font-body text-sm uppercase tracking-wider">
                        {{ __('messages.propiedades_exclusivas') }}
                    </p>
                </div>
                
                <div class="text-center group">
                    <div class="text-3xl md:text-4xl font-luxury font-bold text-gold-400 mb-2 group-hover:text-gold-300 transition-colors duration-300">
                        98%
                    </div>
                    <p class="text-neutral-400 font-body text-sm uppercase tracking-wider">
                        {{ __('messages.satisfaccion_cliente') }}
                    </p>
                </div>
                
                <div class="text-center group">
                    <div class="text-3xl md:text-4xl font-luxury font-bold text-gold-400 mb-2 group-hover:text-gold-300 transition-colors duration-300">
                        15+
                    </div>
                    <p class="text-neutral-400 font-body text-sm uppercase tracking-wider">
                        {{ __('messages.anos_experiencia') }}
                    </p>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                   class="btn-luxury-primary group px-8 py-4 text-base">
                    <span>{{ __('messages.explorar_propiedades') }}</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" 
                   class="btn-luxury-secondary group px-8 py-4 text-base bg-transparent border-2 border-gold-400 text-gold-400 hover:bg-gold-400 hover:text-neutral-900">
                    <span>{{ __('messages.hablar_experto') }}</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </a>
            </div>
            
            <!-- Trust Indicators -->
            <div class="flex flex-wrap justify-center items-center gap-6 opacity-60">
                <div class="flex items-center text-neutral-400 text-sm font-body">
                    <svg class="w-5 h-5 text-gold-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('messages.sin_comisiones_ocultas') }}
                </div>
                
                <div class="flex items-center text-neutral-400 text-sm font-body">
                    <svg class="w-5 h-5 text-gold-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('messages.asesoramiento_gratuito') }}
                </div>
                
                <div class="flex items-center text-neutral-400 text-sm font-body">
                    <svg class="w-5 h-5 text-gold-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('messages.atencion_24_7') }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bottom Wave -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden">
        <svg class="relative block w-full h-12" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="currentColor" class="text-neutral-50"></path>
        </svg>
    </div>
</section>