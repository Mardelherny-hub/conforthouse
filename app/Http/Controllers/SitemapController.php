<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $locales = ['es', 'en', 'fr', 'de', 'nl'];
        $staticRoutes = ['home', 'properties.index', 'complexes.index', 'services', 'about', 'contact'];

        $properties = Property::query()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->get();

        $complexes = Property::query()
            ->whereNotNull('keypromo')
            ->where('keypromo', '!=', 0)
            ->selectRaw('keypromo, MAX(updated_at) as updated_at')
            ->groupBy('keypromo')
            ->orderBy('keypromo')
            ->get();

        return response()
            ->view('sitemap', compact('locales', 'staticRoutes', 'properties', 'complexes'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
