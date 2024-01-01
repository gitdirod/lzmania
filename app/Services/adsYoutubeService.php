<?php

namespace App\Services;

use App\Models\AdsYoutube;

class AdsYoutubeService
{
    public function createAdsYoutube($name, $url)
    {
        return Group::create([
            'name' => $name,
            'url' => $url
        ]);
    }

    public function updateAdsYoutube($id, $name, $url)
    {
        $group = Group::findOrFail($id);
        $group->url = $url;
        $group->name = $name;
        $group->save();
        return $group;
    }
}
