<x-public-layout>

    <x-slot name="backgroundImage">{{ asset('assets/images/contact/contact-bg.jpeg') }}</x-slot>

    <!-- Sección de contacto -->
    <section class="py-16 bg-gray-50">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <!-- Encabezado de la sección -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-luxury font-semibold text-gray-900 mb-4">{{ __('messages.contact_us') }}</h2>
                <div class="w-24 h-px mx-auto bg-amber-300 mb-6"></div>
                <p class="max-w-2xl mx-auto text-gray-600 font-luxury-sans">{{ __('messages.contact_description') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Información de contacto -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl p-8 border border-amber-200/20 h-full">
                        <h3 class="text-2xl font-luxury text-gray-900 mb-6">{{ __('messages.contact_info') }}</h3>

                        <!-- Dirección -->
                        <div class="flex items-start mb-8">
                            <div class="text-amber-500 mr-4 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury-sans font-medium text-gray-900 mb-1">{{ __('messages.address') }}
                                </h4>
                                <div class="text-gray-600 font-luxury-sans">Plaza del Ayuntamiento Nº19 3° A <br>
                                    Valencia 46002, Spain</div>
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="flex items-start mb-8">
                            <div class="text-amber-500 mr-4 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury-sans font-medium text-gray-900 mb-1">{{ __('messages.phone') }}
                                </h4>
                                <p class="text-gray-600 font-luxury-sans">696 649 243 <br> 963 805 030</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start mb-8">
                            <div class="text-amber-500 mr-4 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury-sans font-medium text-gray-900 mb-1">{{ __('messages.email') }}
                                </h4>
                                <p class="text-gray-600 font-luxury-sans">conforthouseliving@rbconforthouse.com.com</p>
                            </div>
                        </div>

                        <!-- Horario -->
                        <div class="flex items-start">
                            <div class="text-amber-500 mr-4 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-luxury-sans font-medium text-gray-900 mb-1">{{ __('messages.hours') }}
                                </h4>
                                <p class="text-gray-600 font-luxury-sans">{{ __('messages.weekdays') }}: {{ __('messages.business_hours') }}</p>
                                </p>
                                <p class="text-gray-600 font-luxury-sans">{{ __('messages.weekends') }}: {{ __('messages.weekend_hours') }}</p>
                                </p>
                            </div>
                        </div>

                        <!-- Redes sociales -->
                        <div class="mt-10">
                            <h4 class="font-luxury-sans font-medium text-gray-900 mb-4">{{ __('messages.follow_us') }}
                            </h4>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="w-10 h-10 rounded-full flex items-center justify-center border border-amber-300/40 text-amber-500 hover:bg-amber-500 hover:text-white transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 rounded-full flex items-center justify-center border border-amber-300/40 text-amber-500 hover:bg-amber-500 hover:text-white transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 rounded-full flex items-center justify-center border border-amber-300/40 text-amber-500 hover:bg-amber-500 hover:text-white transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de contacto -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-xl p-8 border border-amber-200/20">
                        <h3 class="text-2xl font-luxury text-gray-900 mb-6">{{ __('messages.send_message') }}</h3>

                        <form action="#" method="POST"
                            class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nombre -->
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 mb-1 font-luxury-sans">{{ __('messages.name') }}
                                        *</label>
                                    <input type="text" name="name" id="name" required
                                        class="w-full px-4 py-3 border border-gray-300 focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 rounded-sm shadow-sm font-luxury-sans"
                                        placeholder="{{ __('messages.your_name') }}">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-1 font-luxury-sans">{{ __('messages.email') }}
                                        *</label>
                                    <input type="email" name="email" id="email" required
                                        class="w-full px-4 py-3 border border-gray-300 focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 rounded-sm shadow-sm font-luxury-sans"
                                        placeholder="{{ __('messages.your_email') }}">
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="phone"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-luxury-sans">{{ __('messages.phone') }}</label>
                                <input type="tel" name="phone" id="phone"
                                    class="w-full px-4 py-3 border border-gray-300 focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 rounded-sm shadow-sm font-luxury-sans"
                                    placeholder="{{ __('messages.your_phone') }}">
                            </div>

                            <!-- Asunto -->
                            <div>
                                <label for="subject"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-luxury-sans">{{ __('messages.subject') }}
                                    *</label>
                                <input type="text" name="subject" id="subject" required
                                    class="w-full px-4 py-3 border border-gray-300 focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 rounded-sm shadow-sm font-luxury-sans"
                                    placeholder="{{ __('messages.your_subject') }}">
                            </div>

                            <!-- Interés en -->
                            <div>
                                <label for="interest"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-luxury-sans">{{ __('messages.interested_in') }}</label>
                                <select name="interest" id="interest"
                                    class="w-full px-4 py-3 border border-gray-300 focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 rounded-sm shadow-sm font-luxury-sans">
                                    <option value="">{{ __('messages.select_interest') }}</option>
                                    <option value="buy">{{ __('messages.buying_property') }}</option>
                                    <option value="sell">{{ __('messages.selling_property') }}</option>
                                    <option value="rent">{{ __('messages.renting_property') }}</option>
                                    <option value="invest">{{ __('messages.investment') }}</option>
                                    <option value="other">{{ __('messages.other') }}</option>
                                </select>
                            </div>

                            <!-- Mensaje -->
                            <div>
                                <label for="message"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-luxury-sans">{{ __('messages.message') }}
                                    *</label>
                                <textarea name="message" id="message" rows="5" required
                                    class="w-full px-4 py-3 border border-gray-300 focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 rounded-sm shadow-sm font-luxury-sans resize-none"
                                    placeholder="{{ __('messages.your_message') }}"></textarea>
                            </div>

                            <!-- Política de privacidad -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="privacy" name="privacy" type="checkbox" required
                                        class="h-4 w-4 text-amber-500 border-gray-300 rounded focus:ring-amber-400">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="privacy" class="font-luxury-sans text-gray-600">
                                        {{ __('messages.privacy_agreement') }} <a href="{{ route('privacy', ['locale' =>app()->getlocale()]) }}"
                                            class="text-amber-500 hover:text-amber-600">{{ __('messages.privacy_policy') }}</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Botón enviar -->
                            <div>
                                <button type="submit"
                                    class="w-full bg-amber-400 hover:bg-amber-500 text-gray-900 px-6 py-3 rounded-sm text-sm font-medium transition duration-300 font-luxury-sans uppercase tracking-wider shadow-md hover:shadow-lg">
                                    {{ __('messages.send_message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de mapa -->
    <section class="py-16 bg-gray-100">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <div class="bg-white shadow-xl p-4 border border-amber-200/20">
                <div class="aspect-w-16 aspect-h-9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.67890!2d-3.70379!3d40.416775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422997800a3c81%3A0xc436dec1618c2269!2sMadrid%2C%20Spain!5e0!3m2!1sen!2ses!4v1616603897565!5m2!1sen!2ses"
                        class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de agentes inmobiliarios destacados -->
    {{-- <section class="py-16 bg-gray-50">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <!-- Encabezado de la sección -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-luxury font-semibold text-gray-900 mb-4">{{ __('messages.our_agents') }}</h2>
                <div class="w-24 h-px mx-auto bg-amber-300 mb-6"></div>
                <p class="max-w-2xl mx-auto text-gray-600 font-luxury-sans">{{ __('messages.agents_description') }}
                </p>
            </div>

            <!-- Grid de agentes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Agente 1 -->
                <div class="bg-white shadow-xl group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/images/contact/agent1.jpeg') }}" alt="Agent 1"
                            class="w-full h-80 object-cover object-center transform group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                            <div class="flex space-x-3">
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-luxury font-medium text-gray-900 mb-1">{{ __('messages.agent_1_name') }}</h3>
                        <p class="text-amber-500 font-luxury-sans text-sm mb-4">{{ __('messages.luxury_specialist') }}
                        </p>
                        <div class="flex items-center text-gray-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="font-luxury-sans">{{ __('messages.agent_1_phone') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="font-luxury-sans">{{ __('messages.agent_1_email') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Agente 2 -->
                <div class="bg-white shadow-xl group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/images/contact/agent2.jpeg') }}" alt="Agent 2"
                            class="w-full h-80 object-cover object-center transform group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                            <div class="flex space-x-3">
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-luxury font-medium text-gray-900 mb-1">{{ __('messages.agent_2_name') }}</h3>
                        <p class="text-amber-500 font-luxury-sans text-sm mb-4">{{ __('messages.sales_director') }}
                        </p>
                        <div class="flex items-center text-gray-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="font-luxury-sans">{{ __('messages.agent_2_phone') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="font-luxury-sans">{{ __('messages.agent_2_email') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Agente 3 -->
                <div class="bg-white shadow-xl group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/images/contact/agent3.jpeg') }}" alt="Agent 3"
                            class="w-full h-80 object-cover object-center transform group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                            <div class="flex space-x-3">
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-amber-400 text-gray-900 hover:bg-amber-500 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-luxury font-medium text-gray-900 mb-1">{{ __('messages.agent_3_name') }}</h3>
                        <p class="text-amber-500 font-luxury-sans text-sm mb-4">
                            {{ __('messages.international_consultant') }}</p>
                        <div class="flex items-center text-gray-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="font-luxury-sans">{{ __('messages.agent_3_phone') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="font-luxury-sans">{{ __('messages.agent_3_email') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón final para ver todos los agentes -->
            <div class="mt-12 text-center">
                <a href="#"
                    class="inline-flex items-center bg-amber-400 hover:bg-amber-500 text-gray-900 px-6 py-3 rounded-sm text-sm font-medium transition duration-300 font-luxury-sans uppercase tracking-wider shadow-md hover:shadow-lg">
                    {{ __('messages.view_all_agents') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section> --}}

    <!-- Sección de preguntas frecuentes -->
    <section class="py-16 bg-gray-100">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <!-- Encabezado de la sección -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-luxury font-semibold text-gray-900 mb-4">{{ __('messages.faq') }}</h2>
                <div class="w-24 h-px mx-auto bg-amber-300 mb-6"></div>
                <p class="max-w-2xl mx-auto text-gray-600 font-luxury-sans">{{ __('messages.faq_description') }}</p>
            </div>

            <!-- Acordeón de FAQ -->
            <div class="max-w-3xl mx-auto">
                <div x-data="{ openFaq: null }">
                    <!-- Pregunta 1 -->
                    <div class="mb-4 border border-amber-200/20 bg-white shadow-sm">
                        <button @click="openFaq = (openFaq === 1 ? null : 1)"
                            class="flex justify-between items-center w-full px-6 py-4 text-left">
                            <span class="text-lg font-luxury text-gray-900">{{ __('messages.faq_q1') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500"
                                :class="{ 'transform rotate-180': openFaq === 1 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 1" x-collapse class="px-6 pb-4">
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.faq_a1') }}</p>
                        </div>
                    </div>

                    <!-- Pregunta 2 -->
                    <div class="mb-4 border border-amber-200/20 bg-white shadow-sm">
                        <button @click="openFaq = (openFaq === 2 ? null : 2)"
                            class="flex justify-between items-center w-full px-6 py-4 text-left">
                            <span class="text-lg font-luxury text-gray-900">{{ __('messages.faq_q2') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500"
                                :class="{ 'transform rotate-180': openFaq === 2 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 2" x-collapse class="px-6 pb-4">
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.faq_a2') }}</p>
                        </div>
                    </div>

                    <!-- Pregunta 3 -->
                    <div class="mb-4 border border-amber-200/20 bg-white shadow-sm">
                        <button @click="openFaq = (openFaq === 3 ? null : 3)"
                            class="flex justify-between items-center w-full px-6 py-4 text-left">
                            <span class="text-lg font-luxury text-gray-900">{{ __('messages.faq_q3') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500"
                                :class="{ 'transform rotate-180': openFaq === 3 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 3" x-collapse class="px-6 pb-4">
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.faq_a3') }}</p>
                        </div>
                    </div>

                    <!-- Pregunta 4 -->
                    <div class="mb-4 border border-amber-200/20 bg-white shadow-sm">
                        <button @click="openFaq = (openFaq === 4 ? null : 4)"
                            class="flex justify-between items-center w-full px-6 py-4 text-left">
                            <span class="text-lg font-luxury text-gray-900">{{ __('messages.faq_q4') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500"
                                :class="{ 'transform rotate-180': openFaq === 4 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 4" x-collapse class="px-6 pb-4">
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.faq_a4') }}</p>
                        </div>
                    </div>

                    <!-- Pregunta 5 -->
                    <div class="mb-4 border border-amber-200/20 bg-white shadow-sm">
                        <button @click="openFaq = (openFaq === 5 ? null : 5)"
                            class="flex justify-between items-center w-full px-6 py-4 text-left">
                            <span class="text-lg font-luxury text-gray-900">{{ __('messages.faq_q5') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500"
                                :class="{ 'transform rotate-180': openFaq === 5 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openFaq === 5" x-collapse class="px-6 pb-4">
                            <p class="text-gray-600 font-luxury-sans">{{ __('messages.faq_a5') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner CTA -->
    <section class="py-20 bg-cover bg-center relative"
        style="background-image: url('{{ asset('assets/images/contact/cta-bg.jpeg') }}')">
        <div class="absolute inset-0 bg-gray-900/75"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-luxury font-semibold text-white mb-6">{{ __('messages.cta_title') }}</h2>
                <p class="text-lg text-gray-200 font-luxury-sans mb-8">{{ __('messages.cta_description') }}</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                        class="bg-amber-400 hover:bg-amber-500 text-gray-900 px-8 py-3 rounded-sm text-sm font-medium transition duration-300 font-luxury-sans uppercase tracking-wider shadow-md hover:shadow-lg">
                        {{ __('messages.contact_us') }}
                    </a>
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                        class="bg-transparent hover:bg-white/10 text-white border border-white/30 px-8 py-3 rounded-sm text-sm font-medium transition duration-300 font-luxury-sans uppercase tracking-wider shadow-md hover:shadow-lg">
                        {{ __('messages.explore_properties') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>
