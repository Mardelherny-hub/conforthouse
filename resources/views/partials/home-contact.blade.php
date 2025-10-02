<!-- Contact Section -->
<section class="section-luxury bg-neutral-50 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-20 left-20 w-40 h-40 rounded-full bg-gold-100 opacity-20 blur-2xl"></div>
    <div class="absolute -bottom-20 -right-20 w-60 h-60 rounded-full bg-champagne-200 opacity-15 blur-3xl"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-4">
                <div class="flex items-center justify-center">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-gold-400"></div>
                    <span class="mx-4 text-gold-600 text-sm font-body uppercase tracking-widest font-light">
                        {{ __('messages.contactanos') }}
                    </span>
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-gold-400"></div>
                </div>
            </div>
            <h2 class="section-title">
                {{ __('messages.hablemos_de') }} 
                <span class="text-gold-600">{{ __('messages.tu_propiedad') }}</span>
                {{ __('messages.ideal') }}
            </h2>
            <p class="section-subtitle">
                {{ __('messages.nuestro_equipo_experto_contacto') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Contact Form -->
            <div class="bg-white rounded-lg p-8 shadow-lg relative overflow-hidden">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-gold-100 rounded-full opacity-30"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-luxury font-semibold text-neutral-800 mb-6">
                        {{ __('messages.envianos_mensaje') }}
                    </h3>
                    
                    <form action="{{ route('home.contact.store', ['locale' => app()->getLocale()]) }}" 
                        method="POST" 
                        class="space-y-6"
                        data-contact-form>
                        
                        @csrf
                        
                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="first_name" class="block text-sm font-body font-medium text-neutral-700">
                                    {{ __('messages.nombre') }}*
                                </label>
                                <input type="text" 
                                       id="first_name" 
                                       name="first_name" 
                                       required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-md focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors duration-200 font-body">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="last_name" class="block text-sm font-body font-medium text-neutral-700">
                                    {{ __('messages.apellidos') }}*
                                </label>
                                <input type="text" 
                                       id="last_name" 
                                       name="last_name" 
                                       required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-md focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors duration-200 font-body">
                            </div>
                        </div>
                        
                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-body font-medium text-neutral-700">
                                    {{ __('messages.email') }}*
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-md focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors duration-200 font-body">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-body font-medium text-neutral-700">
                                    {{ __('messages.telefono') }}
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone"
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-md focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors duration-200 font-body">
                            </div>
                        </div>
                        
                        <!-- Subject -->
                        <div class="space-y-2">
                            <label for="subject" class="block text-sm font-body font-medium text-neutral-700">
                                {{ __('messages.asunto') }}*
                            </label>
                            <select id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-md focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors duration-200 font-body">
                                <option value="">{{ __('messages.selecciona_asunto') }}</option>
                                <option value="comprar">{{ __('messages.quiero_comprar') }}</option>
                                <option value="vender">{{ __('messages.quiero_vender') }}</option>
                                <option value="alquilar">{{ __('messages.quiero_alquilar') }}</option>
                                <option value="valoracion">{{ __('messages.valoracion_propiedad') }}</option>
                                <option value="consultoria">{{ __('messages.consultoria_inmobiliaria') }}</option>
                                <option value="otro">{{ __('messages.otro') }}</option>
                            </select>
                        </div>
                        
                        <!-- Message -->
                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-body font-medium text-neutral-700">
                                {{ __('messages.mensaje') }}*
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required
                                      placeholder="{{ __('messages.cuentanos_necesidades') }}"
                                      class="w-full px-4 py-3 border border-neutral-300 rounded-md focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors duration-200 font-body resize-none"></textarea>
                        </div>
                        
                        <!-- Privacy Policy -->
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" 
                                   id="privacy" 
                                   name="privacy" 
                                   required
                                   class="mt-1 h-4 w-4 text-gold-600 focus:ring-gold-500 border-neutral-300 rounded">
                            <label for="privacy" class="text-sm text-neutral-600 font-body leading-relaxed">
                                {{ __('messages.acepto') }} 
                                <a href="#" class="text-gold-600 hover:text-gold-700 underline">
                                    {{ __('messages.politica_privacidad') }}
                                </a> 
                                {{ __('messages.y_tratamiento_datos') }}
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full btn-luxury-primary py-4 text-base font-medium group">
                            <span>{{ __('messages.enviar_mensaje') }}</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <!-- Office Info -->
                <div class="bg-white rounded-lg p-8 shadow-lg relative overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                    <div class="absolute -top-6 -right-6 w-20 h-20 bg-gold-100 rounded-full opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-3">
                            {{ __('messages.nuestra_oficina') }}
                        </h3>
                        <p class="text-neutral-600 font-body mb-2">
                            Av. Principal 123, Piso 5
                        </p>
                        <p class="text-neutral-600 font-body mb-4">
                            Mar del Plata, Buenos Aires
                        </p>
                        <div class="text-sm text-gold-600 font-body font-medium">
                            {{ __('messages.horarios') }}: {{ __('messages.lun_vie_9_18') }}
                        </div>
                    </div>
                </div>

                <!-- Phone Contact -->
                <div class="bg-white rounded-lg p-8 shadow-lg relative overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                    <div class="absolute -top-6 -right-6 w-20 h-20 bg-gold-100 rounded-full opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-3">
                            {{ __('messages.llamanos') }}
                        </h3>
                        <a href="tel:+5402234567890" class="text-lg text-neutral-800 font-body font-medium hover:text-gold-600 transition-colors duration-200 block mb-2">
                            +54 (0223) 456-7890
                        </a>
                        <a href="tel:+5491123456789" class="text-lg text-neutral-800 font-body font-medium hover:text-gold-600 transition-colors duration-200 block mb-4">
                            +54 (911) 234-56789
                        </a>
                        <div class="text-sm text-neutral-600 font-body">
                            {{ __('messages.disponible_24_7') }}
                        </div>
                    </div>
                </div>

                <!-- Email Contact -->
                <div class="bg-white rounded-lg p-8 shadow-lg relative overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                    <div class="absolute -top-6 -right-6 w-20 h-20 bg-gold-100 rounded-full opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-gradient-to-br from-gold-500 to-gold-700 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-3">
                            {{ __('messages.escribenos') }}
                        </h3>
                        <a href="mailto:info@conforthouse.com" class="text-lg text-neutral-800 font-body font-medium hover:text-gold-600 transition-colors duration-200 block mb-2">
                            info@conforthouse.com
                        </a>
                        <a href="mailto:ventas@conforthouse.com" class="text-lg text-neutral-800 font-body font-medium hover:text-gold-600 transition-colors duration-200 block mb-4">
                            ventas@conforthouse.com
                        </a>
                        <div class="text-sm text-neutral-600 font-body">
                            {{ __('messages.respuesta_24_horas') }}
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white rounded-lg p-8 shadow-lg relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-20 h-20 bg-gold-100 rounded-full opacity-30"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl font-luxury font-semibold text-neutral-800 mb-6">
                            {{ __('messages.siguenos') }}
                        </h3>
                        
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-gold-600 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            
                            <a href="#" class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-gold-600 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            
                            <a href="#" class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-gold-600 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.223.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.758-1.378l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.99C24.007 5.367 18.641.001.012.001z.017 0z"/>
                                </svg>
                            </a>
                            
                            <a href="#" class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-gold-600 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.007 0C5.383 0 .02 5.362.02 11.986c0 2.104.554 4.08 1.524 5.789L.020 24l6.335-1.663C8.07 23.239 9.972 23.8 12.007 23.8c6.624 0 11.99-5.362 11.99-11.986C24.007 5.362 18.641.02 12.007.02zm.013 21.98c-1.804 0-3.57-.487-5.11-1.404l-.367-.218-3.789.994.994-3.634-.218-.367c-.917-1.54-1.404-3.306-1.404-5.11 0-5.517 4.503-10.02 10.02-10.02 2.677 0 5.204 1.044 7.113 2.954 1.91 1.91 2.954 4.436 2.954 7.113-.02 5.517-4.503 10.02-10.02 10.02z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>