<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Blog categories
        $cats = [
            ['name' => 'PHP & Laravel', 'description' => 'Tutorials, tips and best practices for PHP and the Laravel framework.'],
            ['name' => 'JavaScript',    'description' => 'Frontend and Node.js guides, frameworks, and modern JS patterns.'],
            ['name' => 'Career Tips',   'description' => 'Resume writing, interview prep, and navigating the tech job market.'],
            ['name' => 'Database',      'description' => 'SQL, MySQL, database design, and query optimization guides.'],
        ];

        $catModels = [];
        foreach ($cats as $c) {
            $catModels[$c['name']] = Category::firstOrCreate(
                ['slug' => Str::slug($c['name']), 'type' => 'blog'],
                ['name' => $c['name'], 'description' => $c['description']]
            );
        }

        $author = User::first();

        // Demo blog post — Laravel REST API tutorial
        $content = <<<'HTML'
<h2>Introduction</h2>
<p>Building a RESTful API with Laravel is one of the most common tasks for backend developers today. In this comprehensive tutorial, we'll build a fully functional REST API from scratch — including authentication, resource controllers, validation, and proper JSON responses.</p>

<p>By the end of this guide you will have a production-ready API structure that you can use as a boilerplate for your next project.</p>

<h2>Prerequisites</h2>
<ul>
  <li>PHP 8.2+ installed</li>
  <li>Composer installed globally</li>
  <li>MySQL or SQLite database</li>
  <li>Basic knowledge of PHP and OOP</li>
</ul>

<h2>Step 1: Create a New Laravel Project</h2>
<p>Open your terminal and run the following command to scaffold a fresh Laravel application:</p>

<pre><code class="language-bash">composer create-project laravel/laravel api-tutorial
cd api-tutorial
php artisan serve</code></pre>

<p>Your app will be available at <code>http://127.0.0.1:8000</code>.</p>

<h2>Step 2: Configure the Database</h2>
<p>Open the <code>.env</code> file and update your database credentials:</p>

<pre><code class="language-bash">DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_tutorial
DB_USERNAME=root
DB_PASSWORD=</code></pre>

<h2>Step 3: Create the Post Model &amp; Migration</h2>

<pre><code class="language-bash">php artisan make:model Post -m</code></pre>

<p>Open the generated migration file and define the schema:</p>

<pre><code class="language-php">Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('body');
    $table->enum('status', ['draft', 'published'])->default('draft');
    $table->timestamps();
});</code></pre>

<p>Run the migration:</p>
<pre><code class="language-bash">php artisan migrate</code></pre>

<h2>Step 4: Create the API Resource Controller</h2>

<pre><code class="language-bash">php artisan make:controller Api/PostController --api --model=Post</code></pre>

<p>This generates a controller with <code>index</code>, <code>store</code>, <code>show</code>, <code>update</code>, and <code>destroy</code> methods.</p>

<h2>Step 5: Define API Routes</h2>
<p>Open <code>routes/api.php</code> and register the resource routes:</p>

<pre><code class="language-php">use App\Http\Controllers\Api\PostController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
});</code></pre>

<h2>Step 6: Implement the Controller</h2>
<p>Here is the full implementation of the <code>PostController</code>:</p>

<pre><code class="language-php"><?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return Post::where('status', 'published')
            ->latest()
            ->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'  => 'required|string|max:255',
            'body'   => 'required|string',
            'status' => 'nullable|in:draft,published',
        ]);

        $post = Post::create([
            ...$data,
            'user_id' => auth()->id(),
            'slug'    => Str::slug($data['title']),
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validate([
            'title'  => 'sometimes|string|max:255',
            'body'   => 'sometimes|string',
            'status' => 'sometimes|in:draft,published',
        ]);

        $post->update($data);

        return $post;
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->noContent();
    }
}</code></pre>

<h2>Step 7: Add Sanctum Authentication</h2>
<p>Install and configure Sanctum for token-based API auth:</p>

<pre><code class="language-bash">composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate</code></pre>

<p>Create a login endpoint in <code>routes/api.php</code>:</p>

<pre><code class="language-php">Route::post('/login', function (Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = auth()->user()->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token]);
});</code></pre>

<h2>Step 8: Test Your API</h2>
<p>Use cURL or Postman to test:</p>

<pre><code class="language-bash"># Login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Get all posts (replace TOKEN)
curl http://127.0.0.1:8000/api/posts \
  -H "Authorization: Bearer TOKEN"

# Create a post
curl -X POST http://127.0.0.1:8000/api/posts \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"Hello World","body":"My first post","status":"published"}'</code></pre>

<h2>Common API Response Patterns</h2>
<p>Always wrap responses in a consistent format. Here's a helper trait:</p>

<pre><code class="language-php">trait ApiResponse
{
    protected function success($data, string $message = 'OK', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function error(string $message, int $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}</code></pre>

<h2>Conclusion</h2>
<p>You now have a fully functional Laravel REST API with:</p>
<ul>
  <li>✅ Sanctum token authentication</li>
  <li>✅ Resource controller with CRUD operations</li>
  <li>✅ Request validation</li>
  <li>✅ Authorization policies</li>
  <li>✅ Consistent JSON responses</li>
</ul>

<p>In the next part, we'll add API versioning, rate limiting, and a proper JSON:API-compliant response structure. Stay tuned!</p>

<blockquote>
  <p><strong>Pro Tip:</strong> Always version your APIs from day one. Use <code>/api/v1/</code> prefixes in your route groups so you can evolve the API without breaking existing clients.</p>
</blockquote>
HTML;

        Blog::create([
            'title'            => 'Building a REST API with Laravel 12 — Complete Tutorial',
            'slug'             => 'building-rest-api-laravel-12-complete-tutorial',
            'category_id'      => $catModels['PHP & Laravel']->id,
            'author_id'        => $author?->id,
            'content'          => $content,
            'excerpt'          => 'Learn how to build a fully functional REST API with Laravel 12 — covering authentication with Sanctum, resource controllers, validation, and consistent JSON responses. A complete step-by-step guide for backend developers.',
            'hashtags'         => 'php, laravel, rest-api, sanctum, backend, tutorial',
            'meta_title'       => 'Build a REST API with Laravel 12 — Step-by-Step Tutorial',
            'meta_description' => 'Complete guide to building a production-ready REST API with Laravel 12. Covers Sanctum auth, CRUD controllers, validation, and proper JSON responses.',
            'status'           => 'published',
            'published_at'     => now(),
            'read_time'        => Blog::calcReadTime($content),
            'views'            => 142,
        ]);

        $this->command->info('Blog seeder done: 4 categories + 1 demo post.');
    }
}
