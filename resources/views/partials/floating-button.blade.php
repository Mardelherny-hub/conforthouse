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

<!-- Call Button (alternative option) -->
{{-- <div class="fixed bottom-8 left-8 z-50 hidden lg:block">
    <div class="relative group">
        <!-- Main Button -->
        <a href="tel:+5491123456789" 
           class="flex items-center justify-center w-14 h-14 bg-gold-600 hover:bg-gold-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 group">
            
            <!-- Phone Icon -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
        </a>
        
        <!-- Tooltip -->
        <div class="absolute left-20 top-1/2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none">
            <div class="bg-neutral-900 text-white px-4 py-2 rounded-lg text-sm font-body whitespace-nowrap relative">
                {{ __('messages.llamanos_ahora') }}
                <!-- Arrow -->
                <div class="absolute top-1/2 -left-2 transform -translate-y-1/2 w-0 h-0 border-r-8 border-r-neutral-900 border-t-4 border-b-4 border-t-transparent border-b-transparent"></div>
            </div>
        </div>
    </div>
</div> --}}

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