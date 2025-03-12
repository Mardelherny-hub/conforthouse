<x-public-layout>
    <section class="module bg-dark-60 shop-page-header" data-background="{{ asset('assets/images/gallery_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h2 class="module-title font-alt">{{  __('messages.properties_title') }}</h2>
                    <div class="module-subtitle font-serif">{{ __('messages.properties_subtitle') }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="module-small">
        <div class="container">
            <form class="row ">
                <div class="col-sm-4 mb-sm-20">
                    <select class="form-control">
                        <option selected>{{ __('messages.ordenar_por') }}</option>
                        <option>{{ __('messages.mas_recientes') }}</option>
                        <option>{{ __('messages.menor_precio') }}</option>
                        <option>{{ __('messages.mayor_precio') }}</option>
                    </select>
                </div>
                <div class="col-sm-3 mb-sm-20">
                    <select class="form-control">
                        <option selected>{{ __('messages.tipo_de_propiedad') }}</option>
                        @foreach($propertyTypes as $type)
                            <option>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 mb-sm-20">
                    <select class="form-control">
                        <option selected>{{ __('messages.ubicacion') }}</option>
                        @foreach($districts as $district)
                            <option>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-block btn-round btn-g" type="submit">{{ __('messages.search_button')}}</button>
                </div>
            </form>
        </div>
    </section>

    <hr class="divider-w">

    <section class="module-small">
        <div class="container">
            <div class="row multi-columns-row">
                @foreach ($properties as $property)
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="shop-item">
                            <div class="shop-item-image">
                                @if ($property->firstImage)
                                    <img src="{{ asset($property->firstImage->image_path) }}" alt="{{ $property->propertyType->name ?? 'Propiedad' }}" />
                                @else
                                    <img src="{{ asset('assets/images/shop/default-property.jpg') }}" alt="Propiedad" />
                                @endif
                                <div class="shop-item-detail">
                                    <a class="btn btn-round btn-b" href="{{ route('prop.show', ['locale' => app()->getLocale(), 'id' => $property->id]) }}">
                                        {{ __('messages.ver_detalles') }}
                                    </a>
                                </div>
                            </div>
                            <h4 class="shop-item-title font-alt">
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'id' => $property->id]) }}">
                                    {{ $property->translations->where('locale', app()->getLocale())->first()->title ?? $property->title }}
                                </a>
                            </h4>
                            <p>
                                {{ $property->address->district->name ?? __('messages.sin_ubicacion') }} -
                                ${{ number_format($property->price, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-sm-12">
                    {{ $properties->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
