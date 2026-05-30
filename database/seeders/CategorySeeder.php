<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('blog_category')->truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $php = Category::create([
            'name' => 'PHP',
            'slug' => 'php',
            'description' => 'PHP Programming Language',
            'parent_id' => null,
        ]);

        $java = Category::create([
            'name' => 'Java',
            'slug' => 'java',
            'description' => 'Java Programming Language',
            'parent_id' => null,
        ]);

        $python = Category::create([
            'name' => 'Python',
            'slug' => 'python',
            'description' => 'Python Programming Language',
            'parent_id' => null,
        ]);

        $javascript = Category::create([
            'name' => 'JavaScript',
            'slug' => 'javascript',
            'description' => 'JavaScript Programming Language',
            'parent_id' => null,
        ]);

        Category::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'description' => 'Laravel PHP Framework',
            'parent_id' => $php->id,
        ]);

        Category::create([
            'name' => 'CodeIgniter',
            'slug' => 'codeigniter',
            'description' => 'CodeIgniter PHP Framework',
            'parent_id' => $php->id,
        ]);

        Category::create([
            'name' => 'Symfony',
            'slug' => 'symfony',
            'description' => 'Symfony PHP Framework',
            'parent_id' => $php->id,
        ]);

        Category::create([
            'name' => 'Guzzle',
            'slug' => 'guzzle',
            'description' => 'PHP HTTP Client Library',
            'parent_id' => $php->id,
        ]);

        Category::create([
            'name' => 'PHPUnit',
            'slug' => 'phpunit',
            'description' => 'PHP Testing Library',
            'parent_id' => $php->id,
        ]);

        Category::create([
            'name' => 'Spring Boot',
            'slug' => 'spring-boot',
            'description' => 'Java Spring Boot Framework',
            'parent_id' => $java->id,
        ]);

        Category::create([
            'name' => 'Hibernate',
            'slug' => 'hibernate',
            'description' => 'Java ORM Framework',
            'parent_id' => $java->id,
        ]);

        Category::create([
            'name' => 'Struts',
            'slug' => 'struts',
            'description' => 'Java Web Framework',
            'parent_id' => $java->id,
        ]);

        Category::create([
            'name' => 'Log4j',
            'slug' => 'log4j',
            'description' => 'Java Logging Library',
            'parent_id' => $java->id,
        ]);

        Category::create([
            'name' => 'Apache Commons',
            'slug' => 'apache-commons',
            'description' => 'Java Utility Library',
            'parent_id' => $java->id,
        ]);

        Category::create([
            'name' => 'Django',
            'slug' => 'django',
            'description' => 'Python Django Framework',
            'parent_id' => $python->id,
        ]);

        Category::create([
            'name' => 'Flask',
            'slug' => 'flask',
            'description' => 'Python Flask Framework',
            'parent_id' => $python->id,
        ]);

        Category::create([
            'name' => 'FastAPI',
            'slug' => 'fastapi',
            'description' => 'Python FastAPI Framework',
            'parent_id' => $python->id,
        ]);

        Category::create([
            'name' => 'NumPy',
            'slug' => 'numpy',
            'description' => 'Python Numerical Library',
            'parent_id' => $python->id,
        ]);

        Category::create([
            'name' => 'Pandas',
            'slug' => 'pandas',
            'description' => 'Python Data Analysis Library',
            'parent_id' => $python->id,
        ]);

        Category::create([
            'name' => 'TensorFlow',
            'slug' => 'tensorflow',
            'description' => 'Python Machine Learning Library',
            'parent_id' => $python->id,
        ]);

        Category::create([
            'name' => 'React.js',
            'slug' => 'react-js',
            'description' => 'JavaScript React Framework',
            'parent_id' => $javascript->id,
        ]);

        Category::create([
            'name' => 'Angular',
            'slug' => 'angular',
            'description' => 'JavaScript Angular Framework',
            'parent_id' => $javascript->id,
        ]);

        Category::create([
            'name' => 'Vue.js',
            'slug' => 'vue-js',
            'description' => 'JavaScript Vue Framework',
            'parent_id' => $javascript->id,
        ]);

        Category::create([
            'name' => 'Next.js',
            'slug' => 'next-js',
            'description' => 'React Fullstack Framework',
            'parent_id' => $javascript->id,
        ]);

        Category::create([
            'name' => 'Node.js',
            'slug' => 'node-js',
            'description' => 'JavaScript Runtime',
            'parent_id' => $javascript->id,
        ]);

        Category::create([
            'name' => 'jQuery',
            'slug' => 'jquery',
            'description' => 'JavaScript Library',
            'parent_id' => $javascript->id,
        ]);

        Category::create([
            'name' => 'Axios',
            'slug' => 'axios',
            'description' => 'JavaScript HTTP Client',
            'parent_id' => $javascript->id,
        ]);
    }
}
