<x-guest-layout>
    <!-- enlace a formulario de contacto al final de la página -->
    <section class="module-extra-small bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-8 col-lg-6 col-lg-offset-2">
                    <div class="callout-text font-alt">
                        <h4 style="margin-top: 0px;">{{ __('messages.home_callout_title') }}</h4>
                        <p style="margin-bottom: 0px;">{{ __('messages.home_callout_subtitle') }}</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-2">
                    <div class="callout-btn-box">
                        <a class="btn btn-w btn-round" href="#">{{ __('messages.home_callout_button') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Buscador de propiedades -->
    <section class="module-medium">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ __('messages.search_property_placeholder') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-dark btn-round" type="button">{{ __('messages.search_button') }}</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Servicios ofrecidos -->
    <section class="module-medium">
        <div class="container">
            <div class="row multi-columns-row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="content-box">
                        <div class="content-box-image"><img src="assets/images/finance/finance1.jpg"
                                alt="{{ __('messages.services_card1_alt') }}"></div>
                        <h3 class="content-box-title font-serif">{{ __('messages.services_card1_title') }}</h3>
                        <p>{{ __('messages.services_card1_description') }}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="content-box">
                        <div class="content-box-image"><img src="assets/images/finance/finance2.jpg"
                                alt="{{ __('messages.services_card2_alt') }}"></div>
                        <h3 class="content-box-title font-serif">{{ __('messages.services_card2_title') }}</h3>
                        <p>{{ __('messages.services_card2_description') }}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="content-box">
                        <div class="content-box-image"><img src="assets/images/finance/finance3.jpg"
                                alt="{{ __('messages.services_card3_alt') }}"></div>
                        <h3 class="content-box-title font-serif">{{ __('messages.services_card3_title') }}</h3>
                        <p>{{ __('messages.services_card3_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Estadísticas -->
    <section class="module bg-dark-60 parallax-bg" data-background="assets/images/real_state/real_state_header_bg.avif"
        style="background-position: 50% 15%;">
        <div class="container">
            <div class="row multi-columns-row">
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="count-item mb-sm-40">
                        <div class="count-icon"><span class="icon-target"></span></div>
                        <h3 class="count-to font-alt" data-countto="85">85</h3>
                        <h5 class="count-title font-serif">{{ __('messages.stats_successful_projects') }}</h5>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="count-item mb-sm-40">
                        <div class="count-icon"><span class="icon-bargraph"></span></div>
                        <h3 class="count-to font-alt" data-countto="134">134</h3>
                        <h5 class="count-title font-serif">{{ __('messages.stats_analysis_reports') }}</h5>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="count-item mb-sm-40">
                        <div class="count-icon"><span class="icon-trophy"></span></div>
                        <h3 class="count-to font-alt" data-countto="26">26</h3>
                        <h5 class="count-title font-serif">{{ __('messages.stats_awards_won') }}</h5>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="count-item mb-sm-40">
                        <div class="count-icon"><span class="icon-happy"></span></div>
                        <h3 class="count-to font-alt" data-countto="790">790</h3>
                        <h5 class="count-title font-serif">{{ __('messages.stats_happy_clients') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Servicios exclusivos -->
    <section class="module pt-0 pb-0">
        <div class="row position-relative m-0">
            <div class="col-xs-12 col-md-6 side-image" data-background="assets/images/section-14.jpg"></div>
            <div class="col-xs-12 col-md-6 col-md-offset-6">
                <div class="row finance-image-content">
                    <div class="col-md-10 col-md-offset-1">
                        <h2 class="module-title font-alt align-left">{{ __('messages.exclusive_services_title') }}</h2>
                        <div class="row multi-columns-row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="alt-features-item">
                                    <div class="alt-features-icon"><span class="icon-briefcase"></span></div>
                                    <h3 class="alt-features-title font-alt">{{ __('messages.service_valuation_title') }}</h3>
                                    {{ __('messages.service_valuation_description') }}
                                </div>
                                <div class="alt-features-item">
                                    <div class="alt-features-icon"><span class="icon-puzzle"></span></div>
                                    <h3 class="alt-features-title font-alt">{{ __('messages.service_consulting_title') }}</h3>
                                    {{ __('messages.service_consulting_description') }}
                                </div>
                                <div class="alt-features-item">
                                    <div class="alt-features-icon"><span class="icon-pricetags"></span></div>
                                    <h3 class="alt-features-title font-alt">{{ __('messages.service_tax_title') }}</h3>
                                    {{ __('messages.service_tax_description') }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="alt-features-item">
                                    <div class="alt-features-icon"><span class="icon-wallet"></span></div>
                                    <h3 class="alt-features-title font-alt">{{ __('messages.service_investment_title') }}</h3>
                                    {{ __('messages.service_investment_description') }}
                                </div>
                                <div class="alt-features-item">
                                    <div class="alt-features-icon"><span class="icon-laptop"></span></div>
                                    <h3 class="alt-features-title font-alt">{{ __('messages.service_management_title') }}</h3>
                                    {{ __('messages.service_management_description') }}
                                </div>
                                <div class="alt-features-item">
                                    <div class="alt-features-icon"><span class="icon-linegraph"></span></div>
                                    <h3 class="alt-features-title font-alt">{{ __('messages.service_market_title') }}</h3>
                                    {{ __('messages.service_market_description') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Propiedades destacadas -->
    <section class="module sliding-portfolio">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">{{ __('messages.featured_properties_title') }}</h2>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="owl-carousel text-center" data-items="4" data-pagination="false"
                    data-navigation="false">
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="work-item">
                                <a href="#">
                                    <div class="work-image">
                                        <img src="assets/images/finance/case5.jpg"
                                            alt="Mansión de Lujo con Vista al Mar" />
                                    </div>
                                    <div class="work-caption font-alt">
                                        <h3 class="work-title">Mansión de Lujo con Vista al Mar</h3>
                                        <div class="work-descr">Listado Exclusivo</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="work-item">
                                <a href="#">
                                    <div class="work-image">
                                        <img src="assets/images/finance/case6.jpg"
                                            alt="Ático en el Centro Histórico" />
                                    </div>
                                    <div class="work-caption font-alt">
                                        <h3 class="work-title">Ático en el Centro Histórico</h3>
                                        <div class="work-descr">Vivir con Estilo</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="work-item"><a href="#">
                                    <div class="work-image"><img src="assets/images/finance/case3.jpg"
                                            alt="Villa Contemporánea en Madrid" /></div>
                                    <div class="work-caption font-alt">
                                        <h3 class="work-title">Villa Contemporánea</h3>
                                        <div class="work-descr">Diseño Moderno</div>
                                    </div>
                                </a></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="work-item"><a href="#">
                                    <div class="work-image"><img src="assets/images/finance/case4.jpg"
                                            alt="Finca de Lujo en la Costa" /></div>
                                    <div class="work-caption font-alt">
                                        <h3 class="work-title">Finca de Lujo</h3>
                                        <div class="work-descr">Propiedades Rurales</div>
                                    </div>
                                </a></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="work-item"><a href="#">
                                    <div class="work-image"><img src="assets/images/finance/case5.jpg"
                                            alt="Casa de Diseño en Barcelona" /></div>
                                    <div class="work-caption font-alt">
                                        <h3 class="work-title">Casa de Diseño</h3>
                                        <div class="work-descr">Arquitectura Vanguardista</div>
                                    </div>
                                </a></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="work-item"><a href="#">
                                    <div class="work-image"><img src="assets/images/finance/case6.jpg"
                                            alt="Residencia de Lujo en la Sierra" /></div>
                                    <div class="work-caption font-alt">
                                        <h3 class="work-title">Residencia de Lujo</h3>
                                        <div class="work-descr">Exclusividad Natural</div>
                                    </div>
                                </a></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="text-center"><a class="btn btn-border-d btn-circle mt-50" href="#">{{ __('messages.featured_properties_see') }}</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Formulario para solicitar información -->
    <section class="module bg-dark-60 request-cta" data-background="assets/images/finance/rqst_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h2 class="font-alt">{{ __('messages.request_form_title') }}</h2>
                    <p style="color: #fff;">
                        {{ __('messages.request_form_description') }}
                    </p>
                </div>
                <div class="col-sm-8">
                    <form class="form rqst-form" id="requestInfoForm" role="form" method="post" action="#">
                        <div class="form-group col-sm-6 col-xs-12">
                            <input class="form-control input-lg" type="text" name="name"
                                placeholder="{{ __('messages.request_form_name') }}" />
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <input class="form-control input-lg" type="text" name="phone"
                                placeholder="{{ __('messages.request_form_phone') }}" />
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <button class="btn btn-border-w btn-circle btn-block" type="submit">
                                <i class="fa fa-paper-plane-o"></i> {{ __('messages.request_form_submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog
    <section class="module" id="news">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h2 class="module-title font-alt">Perspectivas del Mercado Inmobiliario de Lujo</h2>
                    <div class="module-subtitle font-serif">
                        Descubre las últimas tendencias en el mercado inmobiliario de lujo y las oportunidades
                        exclusivas.
                    </div>
                </div>
            </div>
            <div class="row multi-columns-row post-columns">
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="post mb-20">
                        <div class="post-thumbnail">
                            <a href="#"><img src="assets/images/post-1.jpg"
                                    alt="Las 5 Mansiones de Lujo en 2024" /></a>
                        </div>
                        <div class="post-header font-alt">
                            <h2 class="post-title"><a href="#">Las 5 Mansiones de Lujo en 2024</a></h2>
                            <div class="post-meta">Por&nbsp;<a href="#">Elite Realty</a>&nbsp;| 23 de Noviembre
                            </div>
                        </div>
                        <div class="post-entry">
                            <p>
                                Explora nuestra selección exclusiva de las mansiones más opulentas y deseables para los
                                compradores más exigentes.
                            </p>
                        </div>
                        <div class="post-more"><a class="more-link" href="#">Leer más</a></div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="post mb-20">
                        <div class="post-thumbnail">
                            <a href="#"><img src="assets/images/post-2.jpg"
                                    alt="La Inversión Inmobiliaria en 2024" /></a>
                        </div>
                        <div class="post-header font-alt">
                            <h2 class="post-title"><a href="#">La Inversión Inmobiliaria en 2024</a></h2>
                            <div class="post-meta">Por&nbsp;<a href="#">Conforthose Living</a>&nbsp;| 30 de
                                Noviembre</div>
                        </div>
                        <div class="post-entry">
                            <p>
                                Conoce las mejores oportunidades de inversión inmobiliaria para este año y cómo
                                maximizar tus rendimientos en el mercado de lujo.
                            </p>
                        </div>
                        <div class="post-more"><a class="more-link" href="#">Leer más</a></div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="post mb-20">
                        <div class="post-thumbnail">
                            <a href="#"><img src="assets/images/post-3.jpg"
                                    alt="Vivir en la Costa: Lujo y Comodidad" /></a>
                        </div>
                        <div class="post-header font-alt">
                            <h2 class="post-title"><a href="#">Vivir en la Costa: Lujo y Comodidad</a></h2>
                            <div class="post-meta">Por&nbsp;<a href="#">Conforthose Living</a>&nbsp;| 5 de
                                Diciembre</div>
                        </div>
                        <div class="post-entry">
                            <p>
                                Descubre las mejores propiedades costeras para disfrutar del lujo y la comodidad todo el
                                año.
                            </p>
                        </div>
                        <div class="post-more"><a class="more-link" href="#">Leer más</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <!-- Branding
    <section class="module-small bg-dark p-0">
        <div class="container">
            <div class="row client">
                <div class="owl-carousel text-center" data-items="6" data-pagination="false"
                    data-navigation="false">
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-1.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-2.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-3.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-4.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-5.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-1.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-2.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-3.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                    <div class="owl-item">
                        <div class="col-sm-12">
                            <div class="client-logo"><img src="assets/images/client-logo-4.png"
                                    alt="Logo del Cliente" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <!-- formulario de contacto -->
    <section class="module pt-0 pb-0" id="contact">
        <div class="row position-relative m-0">
            <div class="col-xs-12 col-md-6">
                <div class="row finance-image-content">
                    <div class="col-md-10 col-md-offset-1">
                        <h2 class="module-title font-alt align-left">{{ __('messages.contact_form_title') }}</h2>
                        <form id="contactForm" role="form" method="post" action="php/contact.php">
                            <div class="form-group">
                                <label class="sr-only" for="name">{{ __('messages.contact_form_name') }}</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    placeholder="{{ __('messages.contact_form_name_placeholder') }}" required="required"
                                    data-validation-required-message="{{ __('messages.contact_form_name_error') }}" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="email">{{ __('messages.contact_form_email') }}</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    placeholder="{{ __('messages.contact_form_email_placeholder') }}" required="required"
                                    data-validation-required-message="{{ __('messages.contact_form_email_error') }}" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="7" id="message" name="message"
                                    placeholder="{{ __('messages.contact_form_message_placeholder') }}"
                                    required="required"
                                    data-validation-required-message="{{ __('messages.contact_form_message_error') }}"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-block btn-round btn-d" id="cfsubmit"
                                    type="submit">{{ __('messages.contact_form_submit') }}</button>
                            </div>
                        </form>
                        <div class="ajax-response font-alt" id="contactFormResponse"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-6 side-image p-0">
                <section id="map-section">
                    <div id="map"></div>
                </section>
            </div>
        </div>
    </section>
</x-guest-layout>
