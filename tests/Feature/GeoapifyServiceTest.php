<?php

use App\Services\GeoapifyService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
});

it('returns formatted suggestions from geoapify', function () {
    Http::fake([
        'api.geoapify.com/*' => Http::response([
            'features' => [
                ['properties' => ['formatted' => 'Partizanski Odredi, 6250 Kichevo, North Macedonia']],
                ['properties' => ['formatted' => 'Partizanski Odredi na Makedonija, 7000 Bitola, North Macedonia']],
            ],
        ]),
    ]);

    $suggestions = app(GeoapifyService::class)->suggest('Partizanski');

    expect($suggestions)->toBe([
        ['label' => 'Partizanski Odredi, 6250 Kichevo, North Macedonia'],
        ['label' => 'Partizanski Odredi na Makedonija, 7000 Bitola, North Macedonia'],
    ]);

    Http::assertSent(fn ($request) => str_contains($request->url(), 'api.geoapify.com/v1/geocode/autocomplete')
        && $request['text'] === 'Partizanski'
        && $request['limit'] === 5
        && $request['filter'] === 'countrycode:mk');
});

it('does not call geoapify for queries shorter than three characters', function () {
    Http::fake();

    expect(app(GeoapifyService::class)->suggest('Pa'))->toBe([]);

    Http::assertNothingSent();
});

it('returns an empty list when geoapify fails', function () {
    Http::fake([
        'api.geoapify.com/*' => Http::response(['message' => 'Unauthorized'], 401),
    ]);

    expect(app(GeoapifyService::class)->suggest('Bitola'))->toBe([]);
});
