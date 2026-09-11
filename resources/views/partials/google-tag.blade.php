@php
    $ga4MeasurementId = config('services.google_analytics.measurement_id');
    $googleAdsConversionId = config('services.google_ads.conversion_id');
    $googleAdsConversionLabel = config('services.google_ads.conversion_label');
    $googleTagId = $ga4MeasurementId ?: $googleAdsConversionId;
@endphp

@if ($googleTagId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleTagId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        window.gtag = function () {
            window.dataLayer.push(arguments);
        };

        window.gtag('js', new Date());

        @if ($ga4MeasurementId)
            window.gtag('config', @json($ga4MeasurementId));
        @endif

        @if ($googleAdsConversionId)
            window.gtag('config', @json($googleAdsConversionId));
        @endif

        window.trackLeadConversion = function () {
            @if ($ga4MeasurementId)
                window.gtag('event', 'generate_lead');
            @endif

            @if ($googleAdsConversionId && $googleAdsConversionLabel)
                window.gtag('event', 'conversion', {
                    send_to: @json($googleAdsConversionId . '/' . $googleAdsConversionLabel)
                });
            @endif
        };
    </script>
@else
    <script>
        window.trackLeadConversion = function () {};
    </script>
@endif
