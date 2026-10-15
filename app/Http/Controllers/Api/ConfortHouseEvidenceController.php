<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ConfortHouseEvidenceSnapshots;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ConfortHouseEvidenceController extends Controller
{
    public function show(Request $request, ConfortHouseEvidenceSnapshots $snapshots): JsonResponse
    {
        $enabled = filter_var(config('maintenance_evidence.enabled', false), FILTER_VALIDATE_BOOLEAN);
        $token = (string) config('maintenance_evidence.read_token', '');
        $provided = (string) $request->header('X-RedByte-Evidence-Token', '');

        // Only authorized Red-Byte collectors can see whether a period exists.
        abort_unless($enabled && strlen($token) >= 32 && $provided !== '' && hash_equals($token, $provided), 404);

        $input = Validator::make($request->query(), [
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d'],
        ])->validate();

        $timezone = 'Europe/Madrid';
        try {
            $from = CarbonImmutable::createFromFormat('!Y-m-d', $input['from'], $timezone);
            $to = CarbonImmutable::createFromFormat('!Y-m-d', $input['to'], $timezone);
        } catch (Throwable $e) {
            return response()->json(['error' => 'invalid_period'], 422);
        }
        if (!$from || !$to || $from->toDateString() !== $input['from'] ||
            $to->toDateString() !== $input['to'] || $from->greaterThan($to) ||
            $from->diffInDays($to) > 62 ||
            $to->greaterThan(CarbonImmutable::now($timezone)->startOfDay())) {
            return response()->json(['error' => 'invalid_period'], 422);
        }

        // Never execute potentially expensive log scans during an HTTP request.
        // Return only the precomputed private snapshot if its exact dates match.
        $evidence = $snapshots->latest();
        abort_unless($evidence !== null &&
            ($evidence['window']['start'] ?? null) === $input['from'] &&
            ($evidence['window']['end'] ?? null) === $input['to'], 404);

        return response()->json($evidence)->withHeaders([
            'Cache-Control' => 'private, no-store, max-age=0',
            'Pragma' => 'no-cache',
            'X-Robots-Tag' => 'noindex, nofollow',
        ]);
    }
}
