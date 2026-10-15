<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ConfortHouseEvidenceSnapshots;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfortHouseEvidenceController extends Controller
{
    public function show(Request $request, ConfortHouseEvidenceSnapshots $snapshots): JsonResponse
    {
        $enabled = config('maintenance_evidence.enabled') === true ||
            config('maintenance_evidence.enabled') === 'true' ||
            config('maintenance_evidence.enabled') === '1';
        $token = (string) config('maintenance_evidence.read_token', '');
        $provided = (string) $request->header('X-RedByte-Evidence-Token', '');

        // Fail closed, including if the feature is disabled or the configured token is weak.
        abort_unless($enabled && strlen($token) >= 32 && $provided !== '' && hash_equals($token, $provided), 404);

        $evidence = $snapshots->latest();
        abort_if($evidence === null, 404);

        return response()->json($evidence)->withHeaders([
            'Cache-Control' => 'private, no-store, max-age=0',
            'Pragma' => 'no-cache',
            'X-Robots-Tag' => 'noindex, nofollow',
        ]);
    }
}
