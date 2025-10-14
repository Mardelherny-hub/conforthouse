<x-public-layout>
    <div class="bg-gray-100 py-16">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-luxury font-semibold text-gray-900 mb-3">{{ __('messages.privacy_policy') }}</h1>
                <div class="w-24 h-px mx-auto bg-amber-400 my-4"></div>
                <p class="text-gray-700 font-luxury-sans max-w-3xl mx-auto">
                    {{ __('messages.privacy_description') }}
                </p>
                
                {{-- Helper para la última actualización. Se usa str_replace para insertar la fecha. --}}
                <p class="text-sm text-gray-500 mt-2">
                    {{ str_replace(':date', '04/09/2025', __('messages.privacy_last_updated')) }}
                </p>
            </div>

            <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden border border-amber-300/10">
                
                <div class="h-2 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-300"></div>

                <div class="p-8 space-y-10">

                    <section class="border-b pb-8 border-gray-100">
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.privacy_introduction') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-6">
                            {{ __('messages.privacy_intro_text') }}
                        </p>

                        {{-- Cláusulas de resumen para formularios --}}
                        <ul class="space-y-3 p-4 bg-gray-50 rounded-lg border border-gray-200 text-sm">
                            <li class="flex"><span class="font-semibold text-gray-800 mr-2">»</span> {{ __('messages.privacy_responsible') }}</li>
                            <li class="flex"><span class="font-semibold text-gray-800 mr-2">»</span> {{ __('messages.privacy_purpose') }}</li>
                            <li class="flex"><span class="font-semibold text-gray-800 mr-2">»</span> {{ __('messages.privacy_legitimation') }}</li>
                            <li class="flex"><span class="font-semibold text-gray-800 mr-2">»</span> {{ __('messages.privacy_recipients') }}</li>
                            <li class="flex"><span class="font-semibold text-gray-800 mr-2">»</span> {{ __('messages.privacy_rights') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">1. {{ __('messages.data_we_collect') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.data_we_collect_intro') }}
                        </p>
                        <ul class="list-disc list-inside space-y-1 ml-4 text-gray-700">
                            <li>{{ __('messages.data_collect_form') }}</li>
                            <li>{{ __('messages.data_collect_newsletter') }}</li>
                            <li>{{ __('messages.data_collect_inquiry') }}</li>
                            <li>{{ __('messages.data_collect_surveys') }}</li>
                        </ul>
                        <p class="font-luxury-sans text-gray-700 mt-4 mb-3">
                            {{ __('messages.data_collect_includes') }}
                        </p>
                        <ul class="list-disc list-inside space-y-1 ml-4 text-gray-700">
                            <li>{{ __('messages.personal_info_details') }}</li>
                            <li>{{ __('messages.data_collect_email') }}</li>
                            <li>{{ __('messages.data_collect_phone') }}</li>
                            <li>{{ __('messages.property_preferences_details') }}</li>
                            <li>{{ __('messages.usage_data') }} ({{ __('messages.usage_data_details') }})</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">2. {{ __('messages.how_we_use_data') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.how_we_use_intro') }}
                        </p>
                        <ul class="list-disc list-inside space-y-1 ml-4 text-gray-700">
                            <li>{{ __('messages.use_provide_service') }}</li>
                            <li>{{ __('messages.use_improve_service') }}</li>
                            <li>{{ __('messages.use_personalize') }}</li>
                            <li>{{ __('messages.use_communication') }}</li>
                            <li>{{ __('messages.use_legal') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">3. {{ __('messages.data_sharing') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.data_sharing_text') }}
                        </p>
                        <ul class="list-disc list-inside space-y-3 ml-4 text-gray-700">
                            <li><span class="font-semibold">{{ __('messages.service_providers') }}:</span> {{ __('messages.service_providers_details') }}</li>
                            <li><span class="font-semibold">{{ __('messages.legal_requirements') }}:</span> {{ __('messages.legal_requirements_details') }}</li>
                            <li><span class="font-semibold">{{ __('messages.business_transfers') }}:</span> {{ __('messages.business_transfers_details') }}</li>
                        </ul>

                        {{-- Cláusulas adicionales --}}
                        <h3 class="text-xl font-medium text-gray-900 mt-6 mb-2">{{ __('messages.international_transfers') }}</h3>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.international_transfers_text') }}
                        </p>
                        <h3 class="text-xl font-medium text-gray-900 mt-6 mb-2">{{ __('messages.children_privacy') }}</h3>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.children_privacy_text') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">4. {{ __('messages.data_security') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.data_security_text') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">5. {{ __('messages.cookies_policy') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.cookies_details') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">{{ __('messages.your_rights') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.your_rights_text') }}
                        </p>
                        <ul class="list-disc list-inside space-y-1 ml-4 text-gray-700">
                            <li>{{ __('messages.right_access') }}</li>
                            <li>{{ __('messages.right_rectification') }}</li>
                            <li>{{ __('messages.right_erasure') }}</li>
                            <li>{{ __('messages.right_restrict') }}</li>
                            <li>{{ __('messages.right_object') }}</li>
                            <li>{{ __('messages.right_data_portability') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">7. {{ __('messages.changes_policy') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700">
                            {{ __('messages.changes_policy_text') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-luxury font-medium text-gray-900 mb-4">8. {{ __('messages.contact_us') }}</h2>
                        <div class="w-16 h-px bg-amber-300 mb-4"></div>
                        <p class="font-luxury-sans text-gray-700 mb-4">
                            {{ __('messages.contact_privacy_text') }}
                        </p>
                        <address class="not-italic space-y-1 text-gray-700">
                            <p class="font-semibold">{{ __('messages.company_name') }}</p>
                            {{-- Dirección y Email tomados del documento ODT --}}
                            <p class="text-sm">
                                {{ __('messages.address') }}: Plaza del Ayuntamiento Nº19, 3-A, C.P. 46002, Valencia, España.
                            </p>
                            <p class="text-sm">
                                {{ __('messages.email') }}: <a href="mailto:conforthouseliving@rbconforthouse.com" class="text-amber-600 hover:text-amber-800 transition-colors">conforthouseliving@rbconforthouse.com</a>
                            </p>
                        </address>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-public-layout>