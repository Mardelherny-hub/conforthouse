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
                    {{ __('messages.footer_description') }}
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center hover:bg-gold-600 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center hover:bg-gold-600 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center hover:bg-gold-600 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center hover:bg-gold-600 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.219-5.175 1.219-5.175s-.312-.219-.312-1.157c0-1.083.687-1.219 1.406-1.219.219 0 .312.219.312.5 0 .219-.219.687-.219 1.406s.219 1.083.5 1.083c.906 0 1.717-.937 1.717-2.323 0-1.083-.781-1.875-1.968-1.875-1.406 0-2.26 1.031-2.26 2.198 0 .406.156.844.375 1.125.041.041.041.083.031.125-.031.125-.094.375-.125.5-.031.063-.063.083-.125.041-.5-.219-.781-.937-.781-1.5 0-1.406 1.031-2.708 3.031-2.708 1.594 0 2.833 1.125 2.833 2.635 0 1.594-.969 2.854-2.385 2.854-.469 0-.906-.25-1.063-.531 0 0-.219.844-.281 1.063-.094.375-.375 1.031-.531 1.375C9.834 23.593 10.894 24.017 12.017 24.017c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-body font-medium text-white mb-4">{{ __('messages.footer_quick_links') }}</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.propiedades') }}</a></li>
                    <li><a href="#servicios" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.servicios') }}</a></li>
                    <li><a href="#nosotros" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.about_us') }}</a></li>
                    <li><a href="#contacto" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">{{ __('messages.contacto') }}</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h4 class="font-body font-medium text-white mb-4">{{ __('messages.contacto') }}</h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <svg class="w-4 h-4 text-gold-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <div class="font-body text-sm">
                            <div>Plaza del Ayuntamiento Nº19 3° A</div>
                            <div>Valencia 46002, Spain</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <a href="tel:696649243" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">696 649 243</a>
                        <a href="tel:693805030" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">963 805 030</a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <a href="mailto:conforthouseliving@conforthouse.com" class="font-body text-sm hover:text-gold-400 transition-colors duration-200">conforthoauseliving@conforthouse.com</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-neutral-800 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="font-body text-sm text-neutral-500">
                    © 2025 ConfortHouse Living. All rights reserved.
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="font-body text-sm text-neutral-500 hover:text-gold-400 transition-colors duration-200">Privacy Policy</a>
                    <a href="#" class="font-body text-sm text-neutral-500 hover:text-gold-400 transition-colors duration-200">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>