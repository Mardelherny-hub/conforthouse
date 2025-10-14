<x-public-layout>
    <div class="bg-gray-100 py-16">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <!-- Encabezado de la página -->
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-luxury font-semibold text-gray-900 mb-3">{{ __('messages.legal_notice') }}</h1>
                <div class="w-24 h-px mx-auto bg-amber-400 my-4"></div>
                <p class="text-gray-700 font-luxury-sans max-w-3xl mx-auto">
                    {{ __('messages.legal_notice_description') }}
                </p>
            </div>

            <!-- Contenido principal -->
            <div class="max-w-4xl mx-auto bg-white shadow-md rounded-sm overflow-hidden border border-amber-300/10">
                <!-- Sección decorativa superior -->
                <div class="h-2 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-300"></div>

                <!-- Contenido del aviso legal -->
                <div class="p-8">
                    <!-- Última actualización -->
                    <section class="mb-10">
                        <p class="font-luxury-sans text-gray-600 text-sm">
                            <strong>{{ __('messages.last_update') }}:</strong> {{ __('messages.legal_update_date') }}
                        </p>
                    </section>

                    <!-- 1. Identificación del titular -->
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.legal_section_1_title') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.legal_section_1_intro') }}
                        </p>
                        <ul class="space-y-2 font-luxury-sans text-gray-700 pl-4">
                            <li><strong>{{ __('messages.company_name') }}:</strong> Conforthouse Living S.L.</li>
                            <li><strong>{{ __('messages.company_cif') }}:</strong> B75855817</li>
                            <li><strong>{{ __('messages.company_address') }}:</strong> Plaza del Ayuntamiento Nº19, 3-A, C.P. 46002, Valencia</li>
                            <li><strong>{{ __('messages.company_phone') }}:</strong> 696 649 243</li>
                            <li><strong>{{ __('messages.email') }}:</strong> <a href="mailto:conforthouseliving@rbconforthouse.com" class="text-amber-600 hover:underline">conforthouseliving@rbconforthouse.com</a></li>
                            <li><strong>{{ __('messages.company_registry') }}:</strong> {{ __('messages.company_registry_details') }}</li>
                        </ul>
                    </section>

                    <!-- 2. Condiciones de uso -->
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.legal_section_2_title') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.legal_section_2_p1') }}
                        </p>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.legal_section_2_p2') }}
                        </p>
                    </section>

                    <!-- 3. Propiedad intelectual e industrial -->
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.legal_section_3_title') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.legal_section_3_p1') }}
                        </p>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.legal_section_3_p2') }}
                        </p>
                    </section>

                    <!-- 4. Responsabilidad -->
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.legal_section_4_title') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.legal_section_4_text') }}
                        </p>
                    </section>

                    <!-- 5. Enlaces a terceros -->
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.legal_section_5_title') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.legal_section_5_text') }}
                        </p>
                    </section>

                    <!-- 6. Legislación aplicable y jurisdicción -->
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.legal_section_6_title') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.legal_section_6_text') }}
                        </p>
                    </section>

                    <!-- 7. Contacto -->
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.legal_section_7_title') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.legal_section_7_intro') }}
                        </p>
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4">
                            <p class="font-luxury text-xl font-semibold text-gray-900 mb-2">Conforthouse Living S.L.</p>
                            <ul class="space-y-1 font-luxury-sans text-gray-700">
                                <li><strong>{{ __('messages.address') }}:</strong> Plaza del Ayuntamiento Nº19, 3-A, C.P. 46002, Valencia</li>
                                <li><strong>{{ __('messages.phone') }}:</strong> 696 649 243</li>
                                <li><strong>{{ __('messages.email') }}:</strong> <a href="mailto:conforthouseliving@rbconforthouse.com" class="text-amber-600 hover:underline">conforthouseliving@rbconforthouse.com</a></li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>