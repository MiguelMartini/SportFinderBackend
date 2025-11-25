<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeocodeService
{
    public function getLatLonFromCep(string $cep): ?array
    {
        $url = "https://nominatim.openstreetmap.org/search";

        $response = Http::withHeaders([
                'User-Agent' => 'LaravelApp/1.0'
            ])
            ->get($url, [
                'format' => 'json',
                'country' => 'Brazil',
                'postalcode' => $cep
            ]);

        if (!$response->successful() || empty($response[0])) {
            return null;
        }

        return [
            'lat' => (float)$response[0]['lat'],
            'lon' => (float)$response[0]['lon']
        ];
    }
}
