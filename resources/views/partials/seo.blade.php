@php
    $seoBrand = 'ConfortHouse Living';
    $seoBaseUrl = 'https://www.rbconforthouse.com';
    $seoLocale = app()->getLocale();
    $seoRoute = request()->route();
    $seoRouteName = $seoRoute?->getName();
    $seoRouteParameters = $seoRoute?->parameters() ?? [];

    unset($seoRouteParameters['locale']);

    if (!empty($seoSlug)) {
        $seoRouteParameters['slug'] = trim((string) $seoSlug);
    }

    $seoDefaults = match ($seoRouteName) {
        'home' => [
            'title' => __('messages.slide_title_1') . ' | ' . $seoBrand,
            'description' => __('messages.explora_seleccion_propiedades'),
        ],
        'properties.index' => [
            'title' => __('messages.properties_title') . ' | ' . $seoBrand,
            'description' => __('messages.properties_subtitle'),
        ],
        'complexes.index' => [
            'title' => __('messages.complejos_residenciales') . ' | ' . $seoBrand,
            'description' => __('messages.descubre_exclusivos_complejos'),
        ],
        'services' => [
            'title' => __('messages.services_title') . ' | ' . $seoBrand,
            'description' => __('messages.services_subtitle'),
        ],
        'about' => [
            'title' => __('messages.about_title') . ' | ' . $seoBrand,
            'description' => __('messages.about_desc_1'),
        ],
        'contact' => [
            'title' => __('messages.contact_us') . ' | ' . $seoBrand,
            'description' => __('messages.contact_description'),
        ],
        'privacy' => [
            'title' => __('messages.privacy_policy') . ' | ' . $seoBrand,
            'description' => __('messages.privacy_description'),
        ],
        'legal' => [
            'title' => __('messages.legal_notice') . ' | ' . $seoBrand,
            'description' => __('messages.legal_notice_description'),
        ],
        default => [
            'title' => $seoBrand,
            'description' => __('messages.footer_about_description'),
        ],
    };

    $resolvedSeoTitle = trim((string) ($seoTitle ?? $seoDefaults['title']));
    $resolvedSeoDescription = trim((string) ($seoDescription ?? $seoDefaults['description']));
    $resolvedSeoDescription = html_entity_decode(strip_tags($resolvedSeoDescription), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $resolvedSeoDescription = preg_replace('/\s+/u', ' ', $resolvedSeoDescription) ?? $resolvedSeoDescription;
    $resolvedSeoDescription = \Illuminate\Support\Str::limit($resolvedSeoDescription, 160, '');

    $resolvedSeoImage = trim((string) ($seoImage ?? ''));
    if ($resolvedSeoImage === '') {
        $resolvedSeoImage = asset('assets/images/home/hero.webp');
    } elseif (!str_starts_with($resolvedSeoImage, 'http://') && !str_starts_with($resolvedSeoImage, 'https://')) {
        $resolvedSeoImage = asset(ltrim($resolvedSeoImage, '/'));
    }

    $resolvedSeoCanonical = trim((string) ($seoCanonical ?? ''));
    if ($resolvedSeoCanonical === '' && $seoRouteName) {
        $canonicalParameters = array_merge(['locale' => $seoLocale], $seoRouteParameters);
        $canonicalPath = route($seoRouteName, $canonicalParameters, false);
        $resolvedSeoCanonical = rtrim($seoBaseUrl, '/') . '/' . ltrim($canonicalPath, '/');

        if (in_array($seoRouteName, ['properties.index', 'complexes.index'], true) && request()->integer('page') > 1) {
            $resolvedSeoCanonical .= '?page=' . request()->integer('page');
        }
    }

    if ($resolvedSeoCanonical === '') {
        $resolvedSeoCanonical = $seoBaseUrl;
    }

    $resolvedSeoRobots = trim((string) ($seoRobots ?? ''));
    if ($resolvedSeoRobots === '') {
        $resolvedSeoRobots = 'index,follow,max-image-preview:large';

        if (in_array($seoRouteName, ['properties.index', 'complexes.index'], true)) {
            $filterQuery = request()->query();
            foreach (['page', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'] as $ignoredParameter) {
                unset($filterQuery[$ignoredParameter]);
            }

            if (!empty($filterQuery)) {
                $resolvedSeoRobots = 'noindex,follow,max-image-preview:large';
            }
        }
    }

    $seoLanguages = ['es', 'en', 'fr', 'de', 'nl'];
    $seoLocalizedRoutes = [
        'home',
        'properties.index',
        'prop.show',
        'complexes.index',
        'complexes.show',
        'services',
        'about',
        'contact',
        'privacy',
        'legal',
    ];
@endphp

<title>{{ $resolvedSeoTitle }}</title>
<meta name="description" content="{{ $resolvedSeoDescription }}">
<meta name="robots" content="{{ $resolvedSeoRobots }}">
<link rel="canonical" href="{{ $resolvedSeoCanonical }}">

@if($seoRouteName && in_array($seoRouteName, $seoLocalizedRoutes, true))
    @foreach($seoLanguages as $alternateLocale)
        @php
            $alternateParameters = array_merge(['locale' => $alternateLocale], $seoRouteParameters);
            $alternatePath = route($seoRouteName, $alternateParameters, false);
            $alternateUrl = rtrim($seoBaseUrl, '/') . '/' . ltrim($alternatePath, '/');
        @endphp
        <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}">
    @endforeach
@endif

<meta property="og:site_name" content="{{ $seoBrand }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $resolvedSeoTitle }}">
<meta property="og:description" content="{{ $resolvedSeoDescription }}">
<meta property="og:url" content="{{ $resolvedSeoCanonical }}">
<meta property="og:image" content="{{ $resolvedSeoImage }}">
<meta property="og:image:alt" content="{{ $resolvedSeoTitle }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $resolvedSeoTitle }}">
<meta name="twitter:description" content="{{ $resolvedSeoDescription }}">
<meta name="twitter:image" content="{{ $resolvedSeoImage }}">
