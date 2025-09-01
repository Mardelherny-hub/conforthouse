<x-public-layout>
    <div class="bg-gray-100 py-16">
        <div class="container mx-auto px-6">
            <!-- Encabezado de la página -->
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-luxury font-semibold text-gray-900 mb-3">{{ __('messages.privacy_policy') }}</h1>
                <div class="w-24 h-px mx-auto bg-amber-400 my-4"></div>
                <p class="text-gray-700 font-luxury-sans max-w-3xl mx-auto">
                    {{ __('messages.privacy_description') }}
                </p>
            </div>

            <!-- Contenido principal -->
            <div class="max-w-4xl mx-auto bg-white shadow-md rounded-sm overflow-hidden border border-amber-300/10">
                <!-- Sección decorativa superior -->
                <div class="h-2 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-300"></div>

                <!-- Contenido de la política -->
                <div class="p-8">
                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.privacy_introduction') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.privacy_intro_text') }}
                        </p>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.privacy_last_updated', ['date' => date('d/m/Y')]) }}
                        </p>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.data_we_collect') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <ul class="space-y-3 font-luxury-sans text-gray-700">
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                <span class="font-medium text-gray-900">{{ __('messages.personal_info') }}:</span>
                                {{ __('messages.personal_info_details') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                <span class="font-medium text-gray-900">{{ __('messages.property_preferences') }}:</span>
                                {{ __('messages.property_preferences_details') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                <span class="font-medium text-gray-900">{{ __('messages.usage_data') }}:</span>
                                {{ __('messages.usage_data_details') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                <span class="font-medium text-gray-900">{{ __('messages.cookies') }}:</span>
                                {{ __('messages.cookies_details') }}
                            </li>
                        </ul>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.how_we_use_data') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <ul class="space-y-3 font-luxury-sans text-gray-700">
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.use_provide_service') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.use_improve_service') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.use_personalize') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.use_communication') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.use_legal') }}
                            </li>
                        </ul>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.data_sharing') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.data_sharing_text') }}
                        </p>
                        <ul class="space-y-3 font-luxury-sans text-gray-700">
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                <span class="font-medium text-gray-900">{{ __('messages.service_providers') }}:</span>
                                {{ __('messages.service_providers_details') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                <span class="font-medium text-gray-900">{{ __('messages.legal_requirements') }}:</span>
                                {{ __('messages.legal_requirements_details') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                <span class="font-medium text-gray-900">{{ __('messages.business_transfers') }}:</span>
                                {{ __('messages.business_transfers_details') }}
                            </li>
                        </ul>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.your_rights') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.your_rights_text') }}
                        </p>
                        <ul class="space-y-3 font-luxury-sans text-gray-700">
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.right_access') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.right_rectification') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.right_erasure') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.right_restrict') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.right_object') }}
                            </li>
                            <li class="pl-4 border-l-2 border-amber-300/30">
                                {{ __('messages.right_data_portability') }}
                            </li>
                        </ul>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.data_security') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.data_security_text') }}
                        </p>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.international_transfers') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.international_transfers_text') }}
                        </p>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.children_privacy') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.children_privacy_text') }}
                        </p>
                    </section>

                    <section class="mb-10">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.changes_policy') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.changes_policy_text') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.contact_us') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-6">
                            {{ __('messages.contact_privacy_text') }}
                        </p>
                        <div class="flex items-center">
                            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-6 py-3 bg-amber-400 hover:bg-amber-500 text-gray-900 rounded-sm transition-colors duration-300 font-luxury-sans text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ __('messages.contact_us') }}
                            </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
