<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class TvMazeAPI extends Model
{
    use HasFactory;

    public static function fetch($showNumber)
    {
        $episodes = Http::get('http://api.tvmaze.com/shows/' . $showNumber . '/episodes')->json();
        return collect($episodes)->map(function ($episode) use ($showNumber) {
            //We use firstOrCreate to avoid duplicates
            //FirstOrCreate will create a new record if it doesn't exist and if it does exist it will return the existing record
            //Create will always create a new record
            return Episode::firstOrCreate([
                'name' => $episode['name'],
                'image' => $episode['image']['medium'],
                'season' => $episode['season'],
                'episode' => $episode['number'],
                'summary' => strip_tags($episode['summary']),
                'show_number' => $showNumber,
            ]);
        });
    }
}