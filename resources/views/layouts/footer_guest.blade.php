<!-- resources/views/layouts/footer_guest.blade.php -->
<footer class="bg-neutral-900 text-neutral-300">
    <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12 py-12">
        
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="luxury-logo text-gold-500 text-2xl font-luxury mb-4">
                    ConfortHouse Living
                </div>
                <p class="font-body text-neutral-400 mb-6 max-w-md leading-relaxed">
                    {{ __('messages.footer_about_description') }}
                </p>
                <div class="flex space-x-4"> 
                       
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/RBCONFORTHOUSE" target="_blank"
                    class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center hover:bg-gold-600 transition-colors duration-200" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/conforthouseliving/" target="_blank" 
                    class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center hover:bg-gold-600 transition-colors duration-200" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                    </a>
                    <!-- youTube -->
                    <a href="https://www.youtube.com/@ConforthouseLiving" target="_blank"
                    class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center hover:bg-gold-600 transition-colors duration-200" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                    </svg>
                    </a>
                   
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-body font-medium text-white mb-4">{{ __('messages.footer_enlaces') }}</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.footer_inicio') }}</a></li>
                    <li><a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.propiedades') }}</a></li>
                    <li><a href="{{ route('services', ['locale' => app()->getLocale()]) }}" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.servicios') }}</a></li>
                    <li><a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.about_us') }}</a></li>
                    <li><a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.footer_contacto') }}</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h4 class="font-body font-medium text-white mb-4">{{ __('messages.footer_contacto') }}</h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <svg class="w-4 h-4 text-gold-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <div class="font-body text-sm">
                            <div>Plaza del Ayuntamiento Nº19 3º A</div>
                            <div>Valencia 46002, España</div>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-4 h-4 text-gold-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <div class="font-body text-sm">
                            <a href="tel:+34696649243" class="hover:text-gold-400 transition-colors duration-200 block">+34 696 649 243</a>
                            <a href="tel:+34963805030" class="hover:text-gold-400 transition-colors duration-200 block">+34 963 805 030</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <a href="mailto:conforthouseliving@rbconforthouse.com" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">conforthouseliving@rbconforthouse.com</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-neutral-800 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="font-body text-sm text-neutral-500">
                    © 2025 ConfortHouse Living. {{ __('messages.derechos') }}.
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('privacy', ['locale' => app()->getLocale()]) }}" class="font-body text-sm text-neutral-500 hover:text-gold-400 transition-colors duration-200">
                        {{ __('messages.privacy_policy') }}
                    </a>
                    <a href="{{ route('legal', ['locale' => app()->getLocale()]) }}" class="font-body text-sm text-neutral-500 hover:text-gold-400 transition-colors duration-200">
                        {{ __('messages.legal_notice') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>