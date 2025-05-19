<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\GranteeManagementController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsStoriesController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProgramCategoryController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->get('/', function () {
    return Inertia::render('Welcome');
});

Route::middleware('auth')->prefix('/admin')->group(function () {
    Route::get('/profile', [UserController::class, 'getProfile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('update.password');
    
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/data', [InboxController::class, 'data'])->name('inbox.data');
    Route::get('/inbox/{inbox}', [InboxController::class, 'show'])->name('inbox.show');

    Route::resource('/category', CategoryController::class);
    Route::get('/category-list', [CategoryController::class, 'data'])->name('category.data');

    Route::resource('/tag', TagController::class);
    Route::get('/tag-list', [TagController::class, 'data'])->name('tag.data');

    Route::resource('/content-type', ContentTypeController::class);
    Route::get('/content-type-list', [ContentTypeController::class, 'data'])->name('content-type.data');

    Route::resource('/menu', MenuController::class);
    Route::get('/menu-list', [MenuController::class, 'data'])->name('menu.data');

    Route::resource('/career', CareerController::class);
    Route::get('/career-list', [CareerController::class, 'data'])->name('career.data');
    Route::post('/career-status/{career}', [CareerController::class, 'updateStatus'])->name('career.status');

    Route::resource('/resource', ResourceController::class);
    Route::post('/resource-update/{resource}', [ResourceController::class, 'update'])->name('resource.update');
    Route::get('/resource-list', [ResourceController::class, 'data'])->name('resource.data');

    Route::resource('/news-stories', NewsStoriesController::class);
    Route::post('/news-stories-update/{news_story}', [NewsStoriesController::class, 'update'])->name('news-stories.update');
    Route::get('/news-stories-list', [NewsStoriesController::class, 'data'])->name('news-stories.data');

    Route::resource('/program-categories', ProgramCategoryController::class);
    Route::post('/program-categories-update/{program_category}', [ProgramCategoryController::class, 'update'])->name('program-categories.update');
    Route::get('/program-categories-list', [ProgramCategoryController::class, 'data'])->name('program-categories.data');

    Route::resource('/program', ProgramController::class);
    Route::post('/program-update/{program}', [ProgramController::class, 'update'])->name('program.update');
    Route::get('/program-list', [ProgramController::class, 'data'])->name('program.data');

    Route::resource('/static-page', StaticPageController::class);
    Route::post('/static-page-update/{static_page}', [StaticPageController::class, 'update'])->name('static-page.update');
    Route::get('/static-page-list', [StaticPageController::class, 'data'])->name('static-page.data');

    Route::resource('/partner', PartnerController::class);
    Route::post('/partner-update/{partner}', [PartnerController::class, 'update'])->name('partner.update');
    Route::get('/partner-list', [PartnerController::class, 'data'])->name('partner.data');

    Route::resource('/grantee', GranteeManagementController::class);
    Route::post('/grantee-update/{grantee}', [GranteeManagementController::class, 'update'])->name('grantee.update');
    Route::get('/grantee-list', [GranteeManagementController::class, 'data'])->name('grantee.data');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/{setting}', [SettingController::class, 'update'])->name('setting.update');
    Route::post('/setting-cta/{setting}', [SettingController::class, 'updateCta'])->name('setting.cta');

    Route::resource('/user', UserController::class);
    Route::post('/user-status/{user}', [UserController::class, 'updateStatus'])->name('user.status');
    Route::get('/user-list', [UserController::class, 'data'])->name('user.data');

    Route::post('/logout', [AuthController::class, 'destroy'])->name('auth.logout');

    Route::middleware(['role:admin,manager'])->group(function () {});
});

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'auth'])->name('auth.post');
});
