<!-- Footer -->
<footer class="bg-dark pt-16 pb-8 text-white">
    <div class="container mx-auto px-6">
        <!-- Footer Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Company Info -->
            <div>
                <div class="text-2xl font-bold mb-4">
                    <img src="{{ asset('assets/images/rb/logo-gold.png') }}" alt="ConfortHouse Living}}" class="w-48">
                </div>
                <p class="text-sm text-gray-300 mb-6">{{ __('messages.footer_about_description') }}</p>
                <div class="flex space-x-4">
                    <!-- Redes Sociales con efecto de lujo similar a menu-link -->
                    <a href="#" class="text-gray-300 hover:text-cream-text transition duration-300 relative menu-link" aria-label="{{ __('Instagram') }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-cream-text transition duration-300 relative menu-link" aria-label="{{ __('Twitter') }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.348 8.348 0 00-2.35 1.377c.013.155.02.318.02.48 0 2.92-1.493 5.49-3.77 6.99 1.39-.04 2.68-.426 3.82-1.06a4.15 4.15 0 01-3.87 2.88c-.51 0-1.01-.1-1.48-.29.01.02-.03.05-.06.07-.09a4.15 4.15 0 003.32-4.07c0-.02-.01-.04-.01-.06 0-.01.01-.02.01-.03 0-1.71-1.23-3.14-2.86-3.47a4.18 4.18 0 00-1.1-.15c-.27 0-.53.03-.79.08.53-1.7 2.07-2.94 3.87-2.98a8.3 8.3 0 01-2.6 3.15c-.01-.08-.01-.16-.01-.24 0-4.41 3.14-9.51 9.1-9.51 2.68 0 5.05 1.01 6.9 2.64a16.8 16.8 0 005.3-2.03c-.63 2.04-2.04 3.75-3.85 4.85 1.77-.21 3.45-.68 5.01-1.38a17.02 17.02 0 01-4.5 4.66c-1.03-.03-2.01-.31-2.86-.77z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-cream-text transition duration-300 relative menu-link" aria-label="{{ __('Other Social') }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10 5.52 0 10-4.48 10-10 0-5.52-4.48-10-10-10zm5.5 8.5c0-.41.34-.75.75-.75s.75.01.75.75-.75.75-.75.75-.75.34-.75.75zm-7 0c0-.41.34-.75.75-.75s.75.01.75.75-.75.75-.75.75-.75.34-.75.75zm-2.75 3.25c.69 0 1.25-.56 1.25-1.25s-.56-1.25-1.25-1.25-1.25.56-1.25 1.25.56 1.25 1.25 1.25zm7 0c.69 0 1.25-.56 1.25-1.25s-.56-1.25-1.25-1.25-1.25.56-1.25 1.25.56 1.25 1.25 1.25zm-3.25 3.25c0-.41.34-.75.75-.75s.75.01.75.75-.75.75-.75.75-.75.34-.75.75z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- Navigation Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4 relative inline-block after:content-[''] after:absolute after:w-12 after:h-px after:bg-gradient-to-r after:from-transparent after:via-[#FFC107] after:to-transparent after:bottom-[-4px] after:left-0">{{ __('messages.footer_enlaces') }}</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="menu-link relative hover:text-cream-text transition duration-300">{{ __('messages.footer_inicio') }}</a></li>
                    <li><a href="#" class="menu-link relative hover:text-cream-text transition duration-300">{{ __('messages.propiedades') }}</a></li>
                    <li><a href="#" class="menu-link relative hover:text-cream-text transition duration-300">{{ __('messages.servicios') }}</a></li>
                    <li><a href="#" class="menu-link relative hover:text-cream-text transition duration-300">{{ __('messages.contacto') }}</a></li>
                </ul>
            </div>
            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4 relative inline-block after:content-[''] after:absolute after:w-12 after:h-px after:bg-gradient-to-r after:from-transparent after:via-[#FFC107] after:to-transparent after:bottom-[-4px] after:left-0">{{ __('messages.footer_contacto') }}</h4>
                <div class="space-y-3">
                    <p class="text-gray-300 flex items-start">
                        <span class="text-cream-text mr-2 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        {{ __('Avenida Diagonal 640, 08017 Barcelona, España') }}
                    </p>
                    <p class="text-gray-300 flex items-start">
                        <span class="text-cream-text mr-2 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <a href="mailto:info@conforthouse.com" class="menu-link hover:text-cream-text transition duration-300">info@conforthouse.com</a>
                    </p>
                    <p class="text-gray-300 flex items-start">
                        <span class="text-cream-text mr-2 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </span>
                        +34 932 000 000
                    </p>
                </div>
            </div>
            <!-- Newsletter (nueva sección) -->
            <div>
                <h4 class="text-lg font-semibold mb-4 relative inline-block after:content-[''] after:absolute after:w-12 after:h-px after:bg-gradient-to-r after:from-transparent after:via-[#FFC107] after:to-transparent after:bottom-[-4px] after:left-0">{{ __('Newsletter') }}</h4>
                <p class="text-gray-300 mb-4">{{ __('messages.footer_newsletter_title') }}</p>
                <form class="flex flex-col space-y-3">
                    <input type="email" placeholder="{{ __('messages.su correo electrónico') }}" class="bg-gray-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-1 focus:ring-cream-text">
                    <button type="submit" class="btn-luxury bg-gradient-to-r from-[#a67c00] to-[#d4af37] text-white px-4 py-2 rounded hover:from-[#d4af37] hover:to-[#a67c00] transition duration-300">{{ __('messages.suscribirse') }}</button>
                </form>
            </div>
        </div>

                <!-- Línea decorativa antes del copyright -->
        <div class="relative py-6">
            <!-- Línea decorativa con gradiente -->
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent opacity-40"></div>

            <!-- Copyright text -->
            <p class="text-gray-300 text-center">
                {!! __('&copy; :year ConfortHouse. ', ['year' => date('Y')]) !!} {{ __('messages.derechos') }}
            </p>
        </div>
    </div>
</footer>
