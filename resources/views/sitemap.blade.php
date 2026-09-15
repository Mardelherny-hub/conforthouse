@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($locales as $locale)
    @foreach($staticRoutes as $routeName)
        <url>
            <loc>{{ 'https://www.rbconforthouse.com' . route($routeName, ['locale' => $locale], false) }}</loc>
        </url>
    @endforeach
@endforeach
@foreach($properties as $property)
    @foreach($locales as $locale)
        <url>
            <loc>{{ 'https://www.rbconforthouse.com' . route('prop.show', ['locale' => $locale, 'slug' => $property->slug], false) }}</loc>
            @if($property->updated_at)
                <lastmod>{{ $property->updated_at->toAtomString() }}</lastmod>
            @endif
        </url>
    @endforeach
@endforeach
@foreach($complexes as $complex)
    @foreach($locales as $locale)
        <url>
            <loc>{{ 'https://www.rbconforthouse.com' . route('complexes.show', ['locale' => $locale, 'keypromo' => $complex->keypromo], false) }}</loc>
            @if($complex->updated_at)
                <lastmod>{{ $complex->updated_at->toAtomString() }}</lastmod>
            @endif
        </url>
    @endforeach
@endforeach
</urlset>
