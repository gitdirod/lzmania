<?php

namespace App\Services;

use App\Models\AdsYoutube;

class AdsYoutubeService
{
    public function createAdsYoutube($name, $url)
    {
        return createAdsYoutube::create([
            'name' => $name,
            'url' => $url
        ]);
    }

    public function updateAdsYoutube($id, $name, $url)
    {
        $group = createAdsYoutube::findOrFail($id);
        $group->url = $url;
        $group->name = $name;
        $group->save();
        return $group;
    }
}
