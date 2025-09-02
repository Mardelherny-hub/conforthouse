<!-- resources/views/components/search-modal.blade.php -->
@props(['types' => collect(), 'operations' => collect()])

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
         class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-40"
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

        <div class="bg-white shadow-2xl overflow-hidden">
            
            <!-- Header - Minimal James Edition Style -->
            <div class="px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-body font-medium text-gray-900">
                        Search Properties
                    </h3>
                    <button @click="searchOpen = false"
                            class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="p-8">
                <form action="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" method="GET" class="space-y-8">
                    
                    <!-- Main Search Bar -->
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               x-model="searchQuery"
                               class="w-full px-4 py-4 text-lg border border-gray-200 hover:border-gray-300 focus:border-gray-900 focus:ring-0 transition-colors duration-200 font-body placeholder-gray-500"
                               placeholder="{{ __('messages.que_esta_bunscando') }}">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        <!-- Operation Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-body font-medium text-gray-700">
                                {{ __('messages.Operación') }}
                            </label>
                            <select name="operation_id" 
                                    x-model="selectedOperation"
                                    class="w-full px-4 py-3 border border-gray-200 hover:border-gray-300 focus:border-gray-900 focus:ring-0 transition-colors duration-200 font-body bg-white">
                                <option value="">All Operations</option>
                                @foreach($operations as $operation)
                                    <option value="{{ $operation->id }}">{{ $operation->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Property Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-body font-medium text-gray-700">
                                {{ __('messages.tipo_de_propiedad') }}
                            </label>
                            <select name="type_id" 
                                    x-model="selectedType"
                                    class="w-full px-4 py-3 border border-gray-200 hover:border-gray-300 focus:border-gray-900 focus:ring-0 transition-colors duration-200 font-body bg-white">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bedrooms -->
                        <div class="space-y-2">
                            <label class="block text-sm font-body font-medium text-gray-700">
                                Bedrooms
                            </label>
                            <select name="rooms" 
                                    x-model="rooms"
                                    class="w-full px-4 py-3 border border-gray-200 hover:border-gray-300 focus:border-gray-900 focus:ring-0 transition-colors duration-200 font-body bg-white">
                                <option value="">Any</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                            </select>
                        </div>

                        <!-- Bathrooms -->
                        <div class="space-y-2">
                            <label class="block text-sm font-body font-medium text-gray-700">
                                Bathrooms
                            </label>
                            <select name="bathrooms" 
                                    x-model="bathrooms"
                                    class="w-full px-4 py-3 border border-gray-200 hover:border-gray-300 focus:border-gray-900 focus:ring-0 transition-colors duration-200 font-body bg-white">
                                <option value="">Any</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                            </select>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="space-y-4">
                        <label class="block text-sm font-body font-medium text-gray-700">
                            Price Range
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">€</span>
                                <input type="number" 
                                       name="min_price" 
                                       x-model="minPrice"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-200 hover:border-gray-300 focus:border-gray-900 focus:ring-0 transition-colors duration-200 font-body"
                                       placeholder="Min price">
                            </div>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">€</span>
                                <input type="number" 
                                       name="max_price" 
                                       x-model="maxPrice"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-200 hover:border-gray-300 focus:border-gray-900 focus:ring-0 transition-colors duration-200 font-body"
                                       placeholder="Max price">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                        <button type="submit" 
                                class="james-btn-primary flex-1 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>{{ __('messages.search_button') }}</span>
                        </button>
                        
                        <button type="button" 
                                @click="searchQuery = ''; selectedOperation = ''; selectedType = ''; minPrice = ''; maxPrice = ''; rooms = ''; bathrooms = ''"
                                class="james-btn-secondary flex-1 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>{{ __('messages.clear_button') }}</span>
                        </button>
                    </div>

                    <!-- Popular Searches -->
                    <div class="pt-6 border-t border-gray-50">
                        <p class="text-sm font-body font-medium text-gray-700 mb-4">
                            Popular Searches
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <button type="button" 
                                    @click="searchQuery = 'villa'"
                                    class="px-4 py-2 text-sm bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors duration-200 font-body border border-gray-200">
                                Luxury Villas
                            </button>
                            <button type="button" 
                                    @click="searchQuery = 'apartment'"
                                    class="px-4 py-2 text-sm bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors duration-200 font-body border border-gray-200">
                                Premium Apartments
                            </button>
                            <button type="button" 
                                    @click="searchQuery = 'penthouse'"
                                    class="px-4 py-2 text-sm bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors duration-200 font-body border border-gray-200">
                                Penthouses
                            </button>
                            <button type="button" 
                                    @click="minPrice = '1000000'"
                                    class="px-4 py-2 text-sm bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors duration-200 font-body border border-gray-200">
                                €1M+ Properties
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>