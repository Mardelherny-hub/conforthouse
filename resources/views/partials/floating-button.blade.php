<!-- Floating Contact Buttons -->
{{-- <div class="fixed bottom-8 right-8 z-50">
    <!-- WhatsApp Button -->
    <div class="relative group">
        <!-- Main Button -->
        <a href="https://wa.me/5491123456789?text={{ urlencode(__('messages.hola_interesado_propiedades')) }}" 
           target="_blank"
           class="flex items-center justify-center w-16 h-16 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 group">
            
            <!-- WhatsApp Icon -->
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
            
            <!-- Pulse Animation -->
            <div class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-75"></div>
        </a>
        
        <!-- Tooltip -->
        <div class="absolute right-20 top-1/2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none">
            <div class="bg-neutral-900 text-white px-4 py-2 rounded-lg text-sm font-body whitespace-nowrap relative">
                {{ __('messages.chatea_whatsapp') }}
                <!-- Arrow -->
                <div class="absolute top-1/2 -right-2 transform -translate-y-1/2 w-0 h-0 border-l-8 border-l-neutral-900 border-t-4 border-b-4 border-t-transparent border-b-transparent"></div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Floating Contact Buttons -->
<!-- Call Button (opens contact modal) -->
<div class="fixed bottom-32 left-8 z-50 hidden lg:block">
    <div class="relative group">
        <!-- Main Button -->
        <button onclick="openContactModal()" 
                class="flex items-center justify-center w-14 h-14 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 group">
            
            <!-- Phone Icon -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
        </button>
        
        <!-- Tooltip -->
        <div class="absolute left-20 top-1/2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none">
            <div class="bg-neutral-900 text-white px-4 py-2 rounded-lg text-sm font-body whitespace-nowrap relative">
                {{ __('messages.contacto') }}
                <!-- Arrow -->
                <div class="absolute top-1/2 -left-2 transform -translate-y-1/2 w-0 h-0 border-r-8 border-r-neutral-900 border-t-4 border-b-4 border-t-transparent border-b-transparent"></div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4 z-[9999] opacity-0 invisible transition-all duration-300">
    <div id="modalContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-90 transition-transform duration-300">
        
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white p-6 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-full p-2 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">{{ __('messages.contactanos') }}</h3>
                        <p class="text-white/80 text-sm">{{ __('messages.estamos_aqui_ayudarte') }}</p>
                    </div>
                </div>
                <button onclick="closeContactModal()" class="text-white/80 hover:text-white transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form id="contactForm" action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.nombre') }} *
                    </label>
                    <input type="text" 
                           id="contact_name" 
                           name="name" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                           placeholder="{{ __('messages.tu_nombre') }}">
                </div>

                <!-- Email Field -->
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.email') }} *
                    </label>
                    <input type="email" 
                           id="contact_email" 
                           name="email" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                           placeholder="{{ __('messages.tu_email') }}">
                </div>

                <!-- Phone Field -->
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.telefono') }}
                    </label>
                    <input type="tel" 
                           id="contact_phone" 
                           name="phone" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                           placeholder="{{ __('messages.tu_telefono') }}">
                </div>

                <!-- Subject Field -->
                <div>
                    <label for="contact_subject" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.asunto') }} *
                    </label>
                    <select id="contact_subject" 
                            name="subject" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                        <option value="">{{ __('messages.selecciona_asunto') }}</option>
                        <option value="informacion_general">{{ __('messages.informacion_general') }}</option>
                        <option value="consulta_propiedad">{{ __('messages.consulta_propiedad') }}</option>
                        <option value="valoracion_inmueble">{{ __('messages.valoracion_inmueble') }}</option>
                        <option value="servicios_inmobiliarios">{{ __('messages.servicios_inmobiliarios') }}</option>
                        <option value="otro">{{ __('messages.otro') }}</option>
                    </select>
                </div>

                <!-- Message Field -->
                <div>
                    <label for="contact_message" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.mensaje') }} *
                    </label>
                    <textarea id="contact_message" 
                              name="message" 
                              rows="4" 
                              required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                              placeholder="{{ __('messages.cuentanos_como_podemos_ayudarte') }}"></textarea>
                </div>

                <!-- Privacy Policy -->
                <div class="flex items-start">
                    <input type="checkbox" 
                           id="privacy_policy" 
                           name="privacy_accepted" 
                           required
                           class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded mt-1">
                    <label for="privacy_policy" class="ml-3 text-sm text-gray-600">
                        {{ __('messages.acepto') }} 
                        <a href="{{ route('privacy', ['locale' => app()->getLocale()]) }}" 
                           target="_blank" 
                           class="text-amber-600 hover:text-amber-700 underline">
                            {{ __('messages.politica_privacidad') }}
                        </a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            id="submitBtn"
                            class="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="btnText">{{ __('messages.enviar_mensaje') }}</span>
                        <span id="btnLoading" class="hidden">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('messages.enviando') }}...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 rounded-b-2xl">
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-600">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <a href="tel:+5491123456789" class="hover:text-amber-600 transition-colors">+54 911 2345 6789</a>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <a href="mailto:info@conforthouse.com" class="hover:text-amber-600 transition-colors">info@conforthouse.com</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<div class="fixed bottom-32 right-8 z-40" id="backToTop" style="display: none;">
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="flex items-center justify-center w-12 h-12 bg-neutral-800 hover:bg-amber-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 group">
        
        <!-- Arrow Up Icon -->
        <svg class="w-5 h-5 transform group-hover:-translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
</div>

<!-- JavaScript for Contact Modal and Back to Top -->
<script>
    // Contact Modal Functions
    function openContactModal() {
        const modal = document.getElementById('contactModal');
        const content = document.getElementById('modalContent');
        
        modal.classList.remove('invisible', 'opacity-0');
        setTimeout(() => {
            content.classList.remove('scale-90');
            content.classList.add('scale-100');
        }, 10);
        
        // Focus first input
        setTimeout(() => {
            document.getElementById('contact_name').focus();
        }, 300);
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeContactModal() {
        const modal = document.getElementById('contactModal');
        const content = document.getElementById('modalContent');
        
        content.classList.remove('scale-100');
        content.classList.add('scale-90');
        
        setTimeout(() => {
            modal.classList.add('opacity-0', 'invisible');
        }, 200);
        
        // Restore body scroll
        document.body.style.overflow = '';
        
        // Reset form if needed
        resetContactForm();
    }

    function resetContactForm() {
        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');
        
        form.reset();
        submitBtn.disabled = false;
        btnText.classList.remove('hidden');
        btnLoading.classList.add('hidden');
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('contactModal');
            if (!modal.classList.contains('invisible')) {
                closeContactModal();
            }
        }
    });

    // Close modal clicking outside
    document.getElementById('contactModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeContactModal();
        }
    });

    // Form submission handling
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        
        // Get form data
        const formData = new FormData(this);
        
        // Submit form via fetch
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('success', '{{ __("messages.mensaje_enviado_correctamente") }}');
                closeContactModal();
            } else {
                throw new Error(data.message || '{{ __("messages.error_enviar_mensaje") }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', error.message || '{{ __("messages.error_enviar_mensaje") }}');
        })
        .finally(() => {
            // Reset loading state
            submitBtn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
        });
    });

    // Notification function
    function showNotification(type, message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-[10000] p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' 
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' 
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
                    }
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }

    // Show/Hide Back to Top button
    window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (window.scrollY > 300) {
            backToTop.style.display = 'block';
            backToTop.style.opacity = '0';
            setTimeout(() => {
                backToTop.style.opacity = '1';
            }, 10);
        } else {
            backToTop.style.opacity = '0';
            setTimeout(() => {
                if (window.scrollY <= 300) {
                    backToTop.style.display = 'none';
                }
            }, 300);
        }
    });
</script>

<!-- Back to Top Button -->
<div class="fixed bottom-32 right-8 z-40" id="backToTop" style="display: none;">
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="flex items-center justify-center w-12 h-12 bg-neutral-800 hover:bg-gold-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 group">
        
        <!-- Arrow Up Icon -->
        <svg class="w-5 h-5 transform group-hover:-translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
</div>

<!-- JavaScript for Back to Top Button -->
<script>
    // Show/Hide Back to Top button
    window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (window.scrollY > 300) {
            backToTop.style.display = 'block';
            backToTop.style.opacity = '0';
            setTimeout(() => {
                backToTop.style.opacity = '1';
            }, 10);
        } else {
            backToTop.style.opacity = '0';
            setTimeout(() => {
                if (window.scrollY <= 300) {
                    backToTop.style.display = 'none';
                }
            }, 300);
        }
    });

    // Smooth scroll for back to top
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

<!-- Floating Menu Toggle (Optional - for multiple actions) -->
<div class="fixed bottom-24 right-8 z-40 hidden" id="floatingMenu">
    <div class="flex flex-col space-y-3">
        <!-- Email Button -->
        <div class="relative group">
            <a href="mailto:info@conforthouse.com" 
               class="flex items-center justify-center w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </a>
            
            <!-- Tooltip -->
            <div class="absolute right-16 top-1/2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none">
                <div class="bg-neutral-900 text-white px-3 py-1 rounded text-xs font-body whitespace-nowrap relative">
                    {{ __('messages.email') }}
                    <div class="absolute top-1/2 -right-1 transform -translate-y-1/2 w-0 h-0 border-l-4 border-l-neutral-900 border-t-2 border-b-2 border-t-transparent border-b-transparent"></div>
                </div>
            </div>
        </div>

        <!-- Location Button -->
        <div class="relative group">
            <a href="https://maps.google.com/?q=Mar+del+Plata+Buenos+Aires" 
               target="_blank"
               class="flex items-center justify-center w-12 h-12 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </a>
            
            <!-- Tooltip -->
            <div class="absolute right-16 top-1/2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none">
                <div class="bg-neutral-900 text-white px-3 py-1 rounded text-xs font-body whitespace-nowrap relative">
                    {{ __('messages.ubicacion') }}
                    <div class="absolute top-1/2 -right-1 transform -translate-y-1/2 w-0 h-0 border-l-4 border-l-neutral-900 border-t-2 border-b-2 border-t-transparent border-b-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</div>