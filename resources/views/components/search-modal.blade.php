<!-- resources/views/components/search-modal.blade.php -->
@props(['operations' => collect(), 'propertyTypes' => collect()])

<div x-data="{ 
    searchOpen: false,
    searchQuery: '',
    selectedOperation: '',
    selectedType: '',
    minPrice: '',
    maxPrice: '',
    rooms: '',
    bathrooms: ''
}"
x-on:open-search.window="searchOpen = true"
class="relative z-50">

    <!-- Modal Backdrop -->
    <div x-show="searchOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm z-40"
         @click="searchOpen = false">
    </div>

    <!-- Modal Content -->
    <div x-show="searchOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-4"
         class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl mx-4 z-50">

        <div class="bg-white rounded-lg shadow-luxury overflow-hidden">
            <!-- Header -->
            <div class="bg-luxury-gradient p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-luxury font-semibold text-white">
                            {{ __('messages.search_properties') }}
                        </h3>
                        <p class="text-white/90 text-sm mt-1">
                            {{ __('messages.find_your_dream_property') }}
                        </p>
                    </div>
                    <button @click="searchOpen = false"
                            class="text-white/80 hover:text-white transition-colors duration-200 p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="p-6">
                <form action="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" method="GET" class="space-y-6">
                    
                    <!-- Main Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               x-model="searchQuery"
                               class="w-full pl-10 pr-4 py-4 border-2 border-neutral-200 rounded-lg focus:border-gold-500 focus:ring-0 text-lg placeholder-neutral-500 font-body"
                               placeholder="{{ __('messages.search_property_placeholder') }}">
                    </div>

                    <!-- Filter Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                        <!-- Operation Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-neutral-700 font-body">
                                {{ __('messages.operation') }}
                            </label>
                            <select name="operation_id" 
                                    x-model="selectedOperation"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:border-gold-500 focus:ring-0 font-body">
                                <option value="">{{ __('messages.all_operations') }}</option>
                                @foreach($operations as $operation)
                                    <option value="{{ $operation->id }}">{{ $operation->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Property Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-neutral-700 font-body">
                                {{ __('messages.property_type') }}
                            </label>
                            <select name="type_id" 
                                    x-model="selectedType"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:border-gold-500 focus:ring-0 font-body">
                                <option value="">{{ __('messages.all_types') }}</option>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bedrooms -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-neutral-700 font-body">
                                {{ __('messages.bedrooms') }}
                            </label>
                            <select name="rooms" 
                                    x-model="rooms"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:border-gold-500 focus:ring-0 font-body">
                                <option value="">{{ __('messages.any') }}</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                            </select>
                        </div>

                        <!-- Bathrooms -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-neutral-700 font-body">
                                {{ __('messages.bathrooms') }}
                            </label>
                            <select name="bathrooms" 
                                    x-model="bathrooms"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:border-gold-500 focus:ring-0 font-body">
                                <option value="">{{ __('messages.any') }}</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                            </select>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-neutral-700 font-body">
                            {{ __('messages.price_range') }}
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">€</span>
                                <input type="number" 
                                       name="min_price" 
                                       x-model="minPrice"
                                       class="w-full pl-8 pr-4 py-3 border border-neutral-300 rounded-lg focus:border-gold-500 focus:ring-0 font-body"
                                       placeholder="{{ __('messages.min_price') }}">
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">€</span>
                                <input type="number" 
                                       name="max_price" 
                                       x-model="maxPrice"
                                       class="w-full pl-8 pr-4 py-3 border border-neutral-300 rounded-lg focus:border-gold-500 focus:ring-0 font-body"
                                       placeholder="{{ __('messages.max_price') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-neutral-200">
                        <button type="submit" 
                                class="btn-luxury-primary flex-1 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>{{ __('messages.search_button') }}</span>
                        </button>
                        
                        <button type="button" 
                                @click="searchQuery = ''; selectedOperation = ''; selectedType = ''; minPrice = ''; maxPrice = ''; rooms = ''; bathrooms = ''"
                                class="btn-luxury-secondary flex-1 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>{{ __('messages.clear_button') }}</span>
                        </button>
                    </div>

                    <!-- Popular Searches -->
                    <div class="pt-4 border-t border-neutral-100">
                        <p class="text-sm font-medium text-neutral-700 mb-3 font-body">
                            {{ __('messages.popular_searches') }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" 
                                    @click="searchQuery = 'villa'; selectedType = '3'"
                                    class="px-3 py-1 text-xs bg-gold-100 text-gold-800 rounded-full hover:bg-gold-200 transition-colors duration-200 font-body">
                                {{ __('messages.luxury_villas') }}
                            </button>
                            <button type="button" 
                                    @click="searchQuery = 'apartment'; selectedType = '2'"
                                    class="px-3 py-1 text-xs bg-gold-100 text-gold-800 rounded-full hover:bg-gold-200 transition-colors duration-200 font-body">
                                {{ __('messages.luxury_apartments') }}
                            </button>
                            <button type="button" 
                                    @click="searchQuery = 'penthouse'"
                                    class="px-3 py-1 text-xs bg-gold-100 text-gold-800 rounded-full hover:bg-gold-200 transition-colors duration-200 font-body">
                                {{ __('messages.penthouses') }}
                            </button>
                            <button type="button" 
                                    @click="minPrice = '1000000'"
                                    class="px-3 py-1 text-xs bg-champagne-100 text-champagne-800 rounded-full hover:bg-champagne-200 transition-colors duration-200 font-body">
                                {{ __('messages.premium_properties') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

