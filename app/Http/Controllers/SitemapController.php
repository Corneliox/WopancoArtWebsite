<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;
use App\Models\User;
use App\Models\Event;
use App\Models\News;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = config('app.url');

        // 1. Static Pages
        $urls = [
            ['loc' => $baseUrl . '/', 'priority' => '1.0'],
            ['loc' => $baseUrl . '/creative', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/events', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/news', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/marketplace', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/about', 'priority' => '0.5'],
            ['loc' => $baseUrl . '/contact', 'priority' => '0.5'],
        ];

        // 2. Artists
        $artists = User::where('is_artist', true)->whereNotNull('slug')->get();
        foreach ($artists as $artist) {
            $urls[] = [
                'loc' => route('pelukis.show', $artist->slug),
                'priority' => '0.9',
                'lastmod' => $artist->updated_at->toAtomString(),
            ];
        }

        // 3. Artworks
        $artworks = Artwork::whereNotNull('slug')->get();
        foreach ($artworks as $artwork) {
            $urls[] = [
                'loc' => route('artworks.show', $artwork->slug),
                'priority' => '0.8',
                'lastmod' => $artwork->updated_at->toAtomString(),
            ];
        }

        // 4. Events
        $events = Event::whereNotNull('slug')->get();
        foreach ($events as $event) {
            $urls[] = [
                'loc' => route('event.details', $event->slug),
                'priority' => '0.7',
                'lastmod' => $event->updated_at->toAtomString(),
            ];
        }

        // 5. News
        $newsItems = News::whereNotNull('slug')->get();
        foreach ($newsItems as $news) {
            $urls[] = [
                'loc' => route('news.show', $news->slug),
                'priority' => '0.7',
                'lastmod' => $news->updated_at->toAtomString(),
            ];
        }

        // Generate XML
        $content = view('sitemap', compact('urls'));

        return response($content)->header('Content-Type', 'text/xml');
    }
}