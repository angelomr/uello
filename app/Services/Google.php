<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Google
{
    public static function getDistance($destination)
    {
        $params = [
            "origins=" . config('app.GOOGLE_ORIGIN'),
            "destinations={$destination}",
            "mode=driving",
            "language=PT",
            "sensor=false",
            "key=" . config('app.GOOGLE_MAPS_KEY')
        ];

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?" . implode("&", $params);
        $response = Http::get($url);

        return json_decode($response->getBody());
        
    }

    public static function getLatLong($address)
    {
        $url = "https://maps.google.com/maps/api/geocode/json?address={$address}&sensor=false&key=" . config('app.GOOGLE_MAPS_KEY');
        // dd($url);
        $response = Http::get($url);
        $maps = json_decode($response->getBody());
        return $maps;
    }

    public static function getDirections($destinations)
    {
        $last = $destinations->sortByDesc('distance')->first();
        $addresses = $destinations->sortBy('distance')->all();
        array_pop($addresses);
        $waypoints = [];
        foreach ($addresses as $address) {
            $waypoints[] = $address->getFullAddress();
        }

        $params = [
            "origin=" . config('app.GOOGLE_ORIGIN'),
            "destination={$last->getFullAddress()}",
            "waypoints=" . implode('|', $waypoints),
            "language=PT",
            "sensor=false",
            "key=" . config('app.GOOGLE_MAPS_KEY')
        ];

        $url = "https://maps.googleapis.com/maps/api/directions/json?" . implode("&", $params);
        $response = Http::get($url);

        $data = json_decode($response->getBody());

        return $data->routes[0]->legs;
    } 
}
