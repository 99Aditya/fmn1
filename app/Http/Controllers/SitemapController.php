<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Test;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // Static pages
        foreach ([
            ['/', '1.0', 'daily'],
            ['/about', '0.6', 'monthly'],
            ['/contact', '0.5', 'monthly'],
            ['/ats', '0.9', 'weekly'],
            ['/community', '0.6', 'weekly'],
            ['/donate', '0.4', 'monthly'],
            ['/tests', '0.9', 'daily'],
            ['/blog', '0.8', 'daily'],
        ] as [$path, $priority, $freq]) {
            $urls[] = $this->url(url($path), null, $priority, $freq);
        }

        // Test categories
        foreach (Category::where('type', 'test')->get() as $cat) {
            $urls[] = $this->url(route('tests.category', $cat->slug), $cat->updated_at, '0.7', 'weekly');
        }

        // Published tests
        foreach (Test::where('status', 'published')->with('category')->get() as $test) {
            if (!$test->category) {
                continue;
            }
            $urls[] = $this->url(
                route('tests.show', [$test->category->slug, $test->slug]),
                $test->updated_at,
                '0.8',
                'weekly'
            );
        }

        // Blog categories
        foreach (Category::where('type', 'blog')->get() as $cat) {
            $urls[] = $this->url(route('blog.category', $cat->slug), $cat->updated_at, '0.6', 'weekly');
        }

        // Published blog posts
        foreach (Blog::where('status', 'published')->get() as $post) {
            $urls[] = $this->url(route('blog.show', $post->slug), $post->updated_at, '0.7', 'monthly');
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= implode('', $urls);
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function url(string $loc, $lastmod, string $priority, string $changefreq): string
    {
        $entry  = "  <url>\n";
        $entry .= '    <loc>' . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        if ($lastmod) {
            $entry .= '    <lastmod>' . $lastmod->toAtomString() . "</lastmod>\n";
        }
        $entry .= '    <changefreq>' . $changefreq . "</changefreq>\n";
        $entry .= '    <priority>' . $priority . "</priority>\n";
        $entry .= "  </url>\n";

        return $entry;
    }
}
