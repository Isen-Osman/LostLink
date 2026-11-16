<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoapifyService
{
    public function suggest(string $query, int $limit = 5): array
    {
        $query = trim($query);

        if (mb_strlen($query) < 3) {
            return [];
        }

        return Cache::remember('geoapify:'.md5($query), now()->addHour(), function () use ($query, $limit) {
            try {
                $response = Http::timeout(5)->get('https://api.geoapify.com/v1/geocode/autocomplete', [
                    'text' => $query,
                    'limit' => $limit,
                    'filter' => 'countrycode:mk',
                    'lang' => 'en',
                    'apiKey' => config('services.geoapify.key'),
                ]);
            } catch (\Throwable $e) {
                report($e);

                return [];
            }

            if (! $response->successful()) {
                return [];
            }

            $suggestions = [];

            foreach ($response->json('features', []) as $feature) {
                $label = $feature['properties']['formatted'] ?? null;

                if (filled($label)) {
                    $suggestions[] = ['label' => $label];
                }
            }

            return $suggestions;
        });
    }
}
