<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $disk = Storage::disk('local');
        $posts = [];
        $categories = [];

        if ($disk->exists('blog_posts')) {
            $files = $disk->files('blog_posts');
            foreach ($files as $file) {
                try {
                    $json = json_decode($disk->get($file), true);
                    if ($json && isset($json['title']) && isset($json['slug'])) {
                        $posts[] = $json;
                        if (!empty($json['category'])) {
                            $categories[$json['category']] = $json['category'];
                        }
                    }
                } catch (\Throwable $e) {
                    // skip invalid files
                }
            }
        }

        usort($posts, function ($a, $b) {
            return strcmp($b['published_at'] ?? '', $a['published_at'] ?? '');
        });

        $categories = array_values($categories);
        return view('frontend.blog', ['posts' => $posts, 'categories' => $categories]);
    }

    public function category($category)
    {
        $disk = Storage::disk('local');
        $posts = [];

        if ($disk->exists('blog_posts')) {
            $files = $disk->files('blog_posts');
            foreach ($files as $file) {
                try {
                    $json = json_decode($disk->get($file), true);
                    if ($json && isset($json['title']) && isset($json['slug']) && isset($json['category']) && $json['category'] === $category) {
                        $posts[] = $json;
                    }
                } catch (\Throwable $e) {
                    // skip invalid files
                }
            }
        }

        usort($posts, function ($a, $b) {
            return strcmp($b['published_at'] ?? '', $a['published_at'] ?? '');
        });

        return view('frontend.blog', ['posts' => $posts, 'categories' => [$category], 'activeCategory' => $category]);
    }

    public function show($slug)
    {
        $disk = Storage::disk('local');
        $path = "blog_posts/{$slug}.json";

        if (!$disk->exists($path)) {
            abort(404);
        }

        $post = json_decode($disk->get($path), true);
        return view('frontend.blog_detail', ['post' => $post]);
    }
}
