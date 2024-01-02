<?php

namespace App\Services;

use App\Models\AdsYoutube;

class AdsYoutubeService
{
    public function createAdsYoutube($name, $url)
    {
        return AdsYoutube::create([
            'name' => $name,
            'url' => $url
        ]);
    }

    public function updateAdsYoutube($id, $name, $url)
    {
        $ads_youtube = AdsYoutube::findOrFail($id);
        $ads_youtube->url = $url;
        $ads_youtube->name = $name;
        $ads_youtube->save();
        return $ads_youtube;
    }
}
