<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home', ['locale' => app()->getLocale()]) }}">Conforthouse Living</a>
        </div>
        <div class="collapse navbar-collapse" id="custom-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#"
                        data-toggle="dropdown">{{ __('messages.propiedades') }}</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{ __('messages.alquiler') }}</a></li>
                        <li><a href="#">{{ __('messages.venta') }}</a></li>
                        <li><a href="#">{{ __('messages.obra_nueva') }}</a></li>
                        <li><a href="#">{{ __('messages.viviendas_de_lujo') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{ __('messages.servicios') }}</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{ __('messages.serv_valoracion') }}</a></li>
                        <li><a href="#">{{ __('messages.serv_consultoria') }}</a></li>
                        <li><a href="#">{{ __('messages.serv_inversion') }}</a></li>
                    </ul>
                </li>

                <li><a href="#">{{ __('messages.about_us') }}</a></li>
                <li><a href="#">{{ __('messages.contacto') }}</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"
                        style="display: flex; align-items: center;">
                        {{ __('messages.sel_lang') }}
                        <img src="{{ asset('assets/images/flags/4x3/' . app()->getLocale() . '.svg') }}"
                            alt="{{ app()->getLocale() }}" style="width: 20px; height: 15px; margin-left: 5px;">
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'es'] + Route::current()->parameters()) }}"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                {{ __('messages.lang_es') }}
                                <img src="{{ asset('assets/images/flags/4x3/es.svg') }}" alt="Spanish"
                                    style="width: 20px; height: 15px;">
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'en'] + Route::current()->parameters()) }}"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                {{ __('messages.lang_en') }}
                                <img src="{{ asset('assets/images/flags/4x3/en.svg') }}" alt="English"
                                    style="width: 20px; height: 15px;">
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'fr'] + Route::current()->parameters()) }}"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                {{ __('messages.lang_fr') }}
                                <img src="{{ asset('assets/images/flags/4x3/fr.svg') }}" alt="French"
                                    style="width: 20px; height: 15px;">
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'de'] + Route::current()->parameters()) }}"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                {{ __('messages.lang_de') }}
                                <img src="{{ asset('assets/images/flags/4x3/de.svg') }}" alt="German"
                                    style="width: 20px; height: 15px;">
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
