<div>
    @if($isEdit && $this->selectedLocationData)
        <div class="mb-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-600">
                Ubicación actual: {{ $this->selectedLocationData['community'] }} >
                {{ $this->selectedLocationData['province'] }} >
                {{ $this->selectedLocationData['city'] }}
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Comunidad Autónoma</label>
            <select wire:model.live="autonomous_community_id" class="w-full border p-2 rounded">
                <option value="">Seleccione...</option>
                @foreach ($autonomousCommunities as $community)
                    <option value="{{ $community->id }}"
                        {{ $autonomous_community_id == $community->id ? 'selected' : '' }}>
                        {{ $community->name }}
                    </option>
                @endforeach
            </select>
            @error('autonomous_community_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
            <select wire:model.live="province_id" class="w-full border p-2 rounded"
                {{ !$autonomous_community_id ? 'disabled' : '' }}>
                <option value="">Seleccione...</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}"
                        {{ $province_id == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
            @error('province_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
            <select wire:model.live="city_id" class="w-full border p-2 rounded"
                {{ !$province_id ? 'disabled' : '' }}>
                <option value="">Seleccione...</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}"
                        {{ $city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('city_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
