@php
    $ga4MeasurementId = config('services.google_analytics.measurement_id');
@endphp

@if ($ga4MeasurementId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4MeasurementId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        window.gtag = function () {
            window.dataLayer.push(arguments);
        };

        window.gtag('js', new Date());
        window.gtag('config', @json($ga4MeasurementId));

        window.trackLeadConversion = function () {
            window.gtag('event', 'generate_lead');
        };
    </script>
@else
    <script>
        window.trackLeadConversion = function () {};
    </script>
@endif
