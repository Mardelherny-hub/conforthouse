<x-public-layout>
    <section class="module">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 mb-sm-40">
                    <!-- Imagen principal -->
                    <div class="property-main-image mb-3">
                        <a href="{{ asset($property->images->first()->image_path) }}" data-fancybox="property-gallery" data-caption="{{ $property->property_type }}">
                            <img src="{{ asset($property->images->first()->image_path) }}" alt="{{ $property->property_type }}" class="img-fluid rounded" />
                        </a>
                    </div>

                    <!-- Galería de miniaturas -->
                    <div class="property-thumbnails">
                        <div class="row g-2">
                            @foreach ($property->images as $key => $image)
                                <div class="col-3 col-md-2">
                                    <a href="{{ asset($image->image_path) }}" data-fancybox="property-gallery" data-caption="{{ $property->property_type }} - Imagen {{ $key + 1 }}">
                                        <img src="{{ asset($image->image_path) }}" alt="{{ $property->property_type }} - Imagen {{ $key + 1 }}" class="img-fluid rounded thumbnail-img" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="product-title font-alt">{{ $property->property_type }}</h1>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-sm-12"><span><i class="fa fa-star star"></i></span><span><i
                                    class="fa fa-star star"></i></span><span><i
                                    class="fa fa-star star"></i></span><span><i
                                    class="fa fa-star star"></i></span><span><i
                                    class="fa fa-star star-off"></i></span><a class="open-tab section-scroll"
                                href="#reviews">-2customer reviews</a>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-sm-12">
                            <div class="price font-alt"><span class="amount">€ {{ $property->price }}</span></div>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-sm-12">
                            <div class="description">
                                <p>{{ $property->description }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mt-70">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs font-alt" role="tablist">
                        <li class="active"><a href="#description" data-toggle="tab"><span
                                    class="icon-tools-2"></span>Descripción</a></li>
                        <li><a href="#details" data-toggle="tab"><span class="icon-tools-2"></span>Características</a>
                        </li>
                        <li><a href="#specifications" data-toggle="tab"><span
                                    class="icon-tools-2"></span>Especificaciones</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Pestaña de Descripción -->
                        <div class="tab-pane active" id="description">
                            <h4 class="font-alt">Ref: {{ $property->reference }} - {{ $property->property_type }} en
                                {{ $property->zone }}</h4>
                            <p>{{ $property->description }}</p>
                            <div class="row mt-20">
                                <div class="col-sm-6">
                                    <p><strong>Operación:</strong> {{ $property->operation }}</p>
                                    <p><strong>Estado:</strong> {{ $property->status }}</p>
                                    <p><strong>Precio:</strong> €{{ number_format($property->price, 2) }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>Superficie:</strong> {{ $property->built_area }} m²</p>
                                    <p><strong>Habitaciones:</strong> {{ $property->rooms }}</p>
                                    <p><strong>Baños:</strong> {{ $property->bathrooms }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña de Características -->
                        <div class="tab-pane" id="details">
                            <table class="table table-striped ds-table table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Característica</th>
                                        <th>Detalle</th>
                                    </tr>
                                    <tr>
                                        <td>Tipo de propiedad</td>
                                        <td>{{ $property->property_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Régimen</td>
                                        <td>{{ $property->regime }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estado</td>
                                        <td>{{ $property->condition }}</td>
                                    </tr>
                                    <tr>
                                        <td>Año de construcción</td>
                                        <td>{{ $property->year_built }}</td>
                                    </tr>
                                    <tr>
                                        <td>Planta</td>
                                        <td>{{ $property->floor }} de {{ $property->floors }}</td>
                                    </tr>
                                    <tr>
                                        <td>Plazas de parking</td>
                                        <td>{{ $property->parking_spaces }}</td>
                                    </tr>
                                    <tr>
                                        <td>Orientación</td>
                                        <td>{{ ucfirst($property->orientation) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Distancia al mar</td>
                                        <td>{{ $property->distance_to_sea }} metros</td>
                                    </tr>
                                    <tr>
                                        <td>Gastos de comunidad</td>
                                        <td>€{{ number_format($property->community_expenses, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pestaña de Especificaciones -->
                        <div class="tab-pane" id="specifications">
                            <table class="table table-striped ds-table table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Especificación</th>
                                        <th>Detalle</th>
                                    </tr>
                                    <tr>
                                        <td>Tipo de exterior</td>
                                        <td>{{ $property->exterior_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de cocina</td>
                                        <td>{{ $property->kitchen_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de calefacción</td>
                                        <td>{{ $property->heating_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Carpintería interior</td>
                                        <td>{{ $property->interior_carpentry }}</td>
                                    </tr>
                                    <tr>
                                        <td>Carpintería exterior</td>
                                        <td>{{ $property->exterior_carpentry }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de suelo</td>
                                        <td>{{ $property->flooring_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Vistas</td>
                                        <td>{{ $property->views }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="divider-w">
    <section class="module-small">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h2 class="module-title font-alt">Related Products</h2>
                </div>
            </div>
            <div class="row multi-columns-row">
                @foreach ($rel_properties as $related)
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <div class="shop-item">
                            <div class="shop-item-image"><img src="{{ asset($related->images->first()->image_path) }}"
                                    alt="{{ $related->property_type }}" />
                                <div class="shop-item-detail"><a class="btn btn-round btn-b"><span
                                            class="icon-basket">Visitar</span></a></div>
                            </div>
                            <h4 class="shop-item-title font-alt">
                                <a href="#">{{ $property->reference }} - {{ $property->property_type }}</a>
                            </h4>
                            € {{ number_format($property->price, 2) }}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>


</x-public-layout>
