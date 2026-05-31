<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AtsController;
use App\Http\Controllers\AdaptiveController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestAttemptController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BlogController as AdminBlogController;
use App\Http\Controllers\admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\admin\TestController as AdminTestController;
use App\Http\Controllers\admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\admin\BulkUploadController as AdminBulkController;

Route::get('/', [HomeController::class, 'home']);
Route::get('/community', [HomeController::class, 'community']);
Route::get('/ats', [HomeController::class, 'ats'])->name('ats');
Route::post('/ats/upload', [AtsController::class, 'upload'])->name('ats.upload');
Route::get('/ats/process/{id}', [AtsController::class, 'process'])->name('ats.process');
Route::get('/mock', [HomeController::class, 'mock']);
Route::get('/mcq-challenge', [HomeController::class, 'mcqChallenge']);
Route::get('/mcq-test', [HomeController::class, 'mcqTest']);

// MCQ / Test public routes
Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
Route::get('/tests/{category:slug}', [TestController::class, 'category'])->name('tests.category');
Route::get('/tests/{category:slug}/{test:slug}', [TestController::class, 'show'])->name('tests.show');

// Certificate public view
Route::get('/certificates/{certificate_no}', [CertificateController::class, 'show'])->name('certificates.show');

// Public profile (shareable)
Route::get('/u/{username}', [PublicProfileController::class, 'show'])->name('profile.public');
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);

// SEO sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Donations
Route::get('/donate', [DonationController::class, 'show'])->name('donate');
Route::post('/donate/order', [DonationController::class, 'createOrder'])->name('donate.order');
Route::post('/donate/verify', [DonationController::class, 'verify'])->name('donate.verify');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated MCQ routes
Route::middleware('auth')->group(function () {
    Route::post('/tests/{test}/start', [TestAttemptController::class, 'start'])->name('tests.start');
    Route::get('/tests/{test}/attempt/{attempt}', [TestAttemptController::class, 'show'])->name('tests.attempt.show');
    Route::post('/tests/{test}/attempt/{attempt}/submit', [TestAttemptController::class, 'submit'])->name('tests.attempt.submit');
    Route::get('/tests/{test}/result/{attempt}', [TestAttemptController::class, 'result'])->name('tests.attempt.result');

    // Adaptive (paid) MCQ engine — difficulty adjusts per answer
    Route::get('/adaptive/{test}', [AdaptiveController::class, 'show'])->name('adaptive.show');
    Route::post('/adaptive/{test}/start', [AdaptiveController::class, 'start'])->name('adaptive.start');
    Route::post('/adaptive/session/{session}/answer', [AdaptiveController::class, 'answer'])->name('adaptive.answer');
    Route::get('/adaptive/session/{session}/result', [AdaptiveController::class, 'result'])->name('adaptive.result');

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/certificates', [UserDashboardController::class, 'certificates'])->name('dashboard.certificates');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/basic', [ProfileController::class, 'updateBasic'])->name('profile.update.basic');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
    Route::post('/profile/skills', [ProfileController::class, 'storeSkill'])->name('profile.skills.store');
    Route::delete('/profile/skills/{skill}', [ProfileController::class, 'destroySkill'])->name('profile.skills.destroy');
    Route::post('/profile/educations', [ProfileController::class, 'storeEducation'])->name('profile.educations.store');
    Route::delete('/profile/educations/{education}', [ProfileController::class, 'destroyEducation'])->name('profile.educations.destroy');
    Route::post('/profile/experiences', [ProfileController::class, 'storeExperience'])->name('profile.experiences.store');
    Route::delete('/profile/experiences/{experience}', [ProfileController::class, 'destroyExperience'])->name('profile.experiences.destroy');

    // Connections & Follow
    Route::get('/connections', [ConnectionController::class, 'requests'])->name('connections.index');
    Route::post('/connect/{user}', [ConnectionController::class, 'connect'])->name('connections.connect');
    Route::post('/connections/{connection}/accept', [ConnectionController::class, 'accept'])->name('connections.accept');
    Route::post('/connections/{connection}/reject', [ConnectionController::class, 'reject'])->name('connections.reject');
    Route::delete('/connect/{user}', [ConnectionController::class, 'remove'])->name('connections.remove');
    Route::post('/follow/{user}', [ConnectionController::class, 'follow'])->name('follow');
    Route::delete('/follow/{user}', [ConnectionController::class, 'unfollow'])->name('unfollow');
});

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{tag}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/blog', [AdminBlogController::class, 'index'])->name('blog');
        Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('blog.create');
        Route::post('/blog', [AdminBlogController::class, 'store'])->name('blog.store');
        Route::get('/blog/{blog}/edit', [AdminBlogController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{blog}', [AdminBlogController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{blog}', [AdminBlogController::class, 'destroy'])->name('blog.destroy');

        // Test Categories
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // Tests
        Route::get('/tests', [AdminTestController::class, 'index'])->name('tests.index');
        Route::get('/tests/create', [AdminTestController::class, 'create'])->name('tests.create');
        Route::post('/tests', [AdminTestController::class, 'store'])->name('tests.store');
        Route::get('/tests/{test}/edit', [AdminTestController::class, 'edit'])->name('tests.edit');
        Route::put('/tests/{test}', [AdminTestController::class, 'update'])->name('tests.update');
        Route::delete('/tests/{test}', [AdminTestController::class, 'destroy'])->name('tests.destroy');

        // Questions
        Route::get('/tests/{test}/questions', [AdminQuestionController::class, 'index'])->name('tests.questions.index');
        Route::get('/tests/{test}/questions/create', [AdminQuestionController::class, 'create'])->name('tests.questions.create');
        Route::post('/tests/{test}/questions', [AdminQuestionController::class, 'store'])->name('tests.questions.store');
        Route::get('/tests/{test}/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('tests.questions.edit');
        Route::put('/tests/{test}/questions/{question}', [AdminQuestionController::class, 'update'])->name('tests.questions.update');
        Route::delete('/tests/{test}/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('tests.questions.destroy');

        // Bulk Upload
        Route::get('/bulk/questions/{test}', [AdminBulkController::class, 'questionsForm'])->name('bulk.questions.form');
        Route::post('/bulk/questions/{test}', [AdminBulkController::class, 'questionsImport'])->name('bulk.questions.import');
        Route::get('/bulk/questions/{test}/template', [AdminBulkController::class, 'questionsTemplate'])->name('bulk.questions.template');
        Route::get('/bulk/tests', [AdminBulkController::class, 'testsForm'])->name('bulk.tests.form');
        Route::post('/bulk/tests', [AdminBulkController::class, 'testsImport'])->name('bulk.tests.import');
        Route::get('/bulk/tests/template', [AdminBulkController::class, 'testsTemplate'])->name('bulk.tests.template');

    // });
});