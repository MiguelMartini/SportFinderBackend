<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeoLocationService
{
    public function getCoordinates(string $city): ?array
    {
        $url = "https://nominatim.openstreetmap.org/search?city="
            . urlencode($city)
            . "&country=Brazil&format=json&limit=1";

        $response = Http::withHeaders([
            'User-Agent' => 'SportFinder/1.0'
        ])->get($url);

        // Falha da req
        if (!$response->ok() || empty($response->json())) {
            return null;
        }

        $data = $response->json();

        return [
            'lat' => $data[0]['lat'],
            'lon' => $data[0]['lon']
        ];
    }
}
