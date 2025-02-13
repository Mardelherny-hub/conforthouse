<nav class="navbar navbar-custom navbar-fixed-top navbar-transparent" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html">Conforthouse Living</a>
                    </div>
                    <div class="collapse navbar-collapse" id="custom-collapse">
                        <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{  __('messages.propiedades') }}</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">{{ __('messages.prop_residenciales') }}</a></li>
                                <li><a href="#">{{ __('messages.prop_comerciales') }}</a></li>
                                <li><a href="#">{{ __('messages.prop_exclusivas') }}</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{  __('messages.servicios') }}</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">{{ __('messages.serv_tasacion') }}</a></li>
                                <li><a href="#">{{ __('messages.serv_consultoria') }}</a></li>
                                <li><a href="#">{{ __('messages.serv_inversion') }}</a></li>
                            </ul>
                        </li>

                            <li><a href="#">{{  __('messages.about_us') }}</a></li>
                            <li><a href="#">{{  __('messages.contacto') }}</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{ __('messages.sel_lang') }}</a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('home', ['locale' => 'es']) }}">{{  __('messages.lang_es') }}</a></li>
                                    <li><a href="{{ route('home', ['locale' => 'en']) }}">{{  __('messages.lang_en') }}</a></li>
                                    <li><a href="{{ route('home', ['locale' => 'fr']) }}">{{  __('messages.lang_fr') }}</a></li>
                                    <li><a href="{{ route('home', ['locale' => 'de']) }}">{{  __('messages.lang_de') }}</a></li>                           
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>