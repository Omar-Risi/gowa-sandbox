<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GowaClient
{
    public function post(string $path, array $payload, ?string $deviceId = null): Response
    {
        $request = Http::baseUrl(config('services.gowa.base_url'));

        if (config('services.gowa.username')) {
            $request = $request->withBasicAuth(
                config('services.gowa.username'),
                config('services.gowa.password'),
            );
        }

        $deviceId ??= config('services.gowa.device_id');

        if ($deviceId) {
            $request = $request->withHeaders(['X-Device-Id' => $deviceId]);
        }

        return $request->post($path, $payload);
    }
}
