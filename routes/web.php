<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\GranteeManagementController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\InstagramPostController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsStoriesController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OurImpactController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProgramCategoryController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\StepCFCNController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\NewsStories;
use App\Models\Program;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->get('/', function () {
    return Inertia::render('Welcome');
});

Route::middleware('auth:web')->prefix('/admin')->group(function () {
    Route::get('/profile', [UserController::class, 'getProfile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('update.password');

    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/data', [InboxController::class, 'data'])->name('inbox.data');
    Route::get('/inbox/{inbox}', [InboxController::class, 'show'])->name('inbox.show');

    Route::resource('/category', CategoryController::class);
    Route::post('/category-update/{category}', [CategoryController::class, 'update'])->name('category.update-data');
    Route::get('/category-list', [CategoryController::class, 'data'])->name('category.data');

    Route::resource('/tag', TagController::class);
    Route::get('/tag-list', [TagController::class, 'data'])->name('tag.data');

    Route::resource('/content-type', ContentTypeController::class);
    Route::get('/content-type-list', [ContentTypeController::class, 'data'])->name('content-type.data');

    Route::resource('/menu', MenuController::class);
    Route::get('/menu-list', [MenuController::class, 'data'])->name('menu.data');

    Route::resource('/career', CareerController::class);
    Route::get('/career-list', [CareerController::class, 'data'])->name('career.data');
    Route::post('/career-update/{career}', [CareerController::class, 'update'])->name('career.update-data');
    Route::post('/career-status/{career}', [CareerController::class, 'updateStatus'])->name('career.status');

    Route::resource('/banner', BannerController::class);
    Route::get('/banner-list', [BannerController::class, 'data'])->name('banner.data');
    Route::post('/banner-update/{banner}', [BannerController::class, 'update'])->name('banner.update');
    Route::post('/banner-status/{banner}', [BannerController::class, 'updateStatus'])->name('banner.status');

    Route::resource('/resource', ResourceController::class);
    Route::post('/resource-update/{resource}', [ResourceController::class, 'update'])->name('resource.update');
    Route::get('/resource-list', [ResourceController::class, 'data'])->name('resource.data');

    Route::resource('/content', NewsStoriesController::class);
    Route::post('/content-update/{content}', [NewsStoriesController::class, 'update'])->name('content.update');
    Route::get('/content-list', [NewsStoriesController::class, 'data'])->name('content.data');

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
    Route::get('/partner-list/{type}', [PartnerController::class, 'data'])->name('partner.data');

    Route::resource('/faq', FAQController::class);
    Route::get('/faq-list', [FAQController::class, 'data'])->name('faq.data');

    Route::resource('/step-cfcn', StepCFCNController::class);
    Route::post('/step-update/{step_cfcn}', [StepCFCNController::class, 'update'])->name('step-cfcn.update-data');
    Route::get('/step-cfcn-list', [StepCFCNController::class, 'data'])->name('step-cfcn.data');

    Route::get('/grantee-partner-management', [PartnerController::class, 'indexGrantee'])->name('grantee.partner');
    Route::get('/grantee-partner-management-create', [PartnerController::class, 'createGrantee'])->name('grantee.partner-create');
    Route::get('/grantee-partner-management/{partner}', [PartnerController::class, 'editGrantee'])->name('grantee.partner-edit');

    Route::resource('/grantee', GranteeManagementController::class);
    Route::post('/grantee-update/{grantee}', [GranteeManagementController::class, 'update'])->name('grantee.update');
    Route::get('/grantee-list', [GranteeManagementController::class, 'data'])->name('grantee.data');

    Route::resource('/management', ManagementController::class);
    Route::post('/management-update/{management}', [ManagementController::class, 'update'])->name('management.update');
    Route::get('/management-list', [ManagementController::class, 'data'])->name('management.data');
    Route::post('/management-status/{management}', [ManagementController::class, 'updateStatus'])->name('management.status');

    Route::get('/organization', [OrganizationController::class, 'index'])->name('organization.index');
    Route::post('/organization', [OrganizationController::class, 'update'])->name('organization.update');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/{setting}', [SettingController::class, 'update'])->name('setting.update');
    Route::post('/setting-cta/{setting}', [SettingController::class, 'updateCta'])->name('setting.cta');

    Route::resource('/user', UserController::class);
    Route::post('/user-status/{user}', [UserController::class, 'updateStatus'])->name('user.status');
    Route::get('/user-list', [UserController::class, 'data'])->name('user.data');

    Route::resource('/location', LocationController::class);
    Route::get('/location-list', [LocationController::class, 'data'])->name('location.data');

    Route::get('/our-impact-management', [OurImpactController::class, 'index'])->name('our-impact-management.index');
    Route::post('/our-impact-management/{id?}', [OurImpactController::class, 'updateOrCreate'])->name('our-impact-management.upstore');

    Route::get('/subscriber', function (Request $request) {
        $search = $request->search;

        $subscriptions = Subscription::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(email) LIKE ?', '%'. $search .'%');
        })->orderBy('created_at', 'desc')
        ->paginate(10);

        return Inertia::render('Subcription/Index', [
            'subscriptions' => $subscriptions
        ]);
    });

    Route::post('/logout', [AuthController::class, 'destroy'])->name('auth.logout');
    Route::post('show-section/{setting}/{section}', [SettingController::class, 'toggleShowSection'])->name('setting.show-section');

    Route::resource('/instagram', InstagramPostController::class);
    Route::post('/instagram-update/{instagram}', [InstagramPostController::class, 'update'])->name('instagram.update');
    Route::get('/instagram-list/{type}', [InstagramPostController::class, 'data'])->name('instagram.data');

    Route::middleware(['role:admin,manager'])->group(function () {});
});

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'auth'])->name('auth.post');
});

Route::get('/', [LandingPageController::class, 'home'])->name('home');

Route::get('/about-us', [LandingPageController::class, 'aboutUs'])->name('about-us');

Route::get('/our-program', [LandingPageController::class, 'ourProgram'])->name('our-program');
Route::get('/our-program/{categories}', [LandingPageController::class, 'subProgram'])->name('sub-program');
Route::get('/our-program/{categories}/{program}', [LandingPageController::class, 'programDetail'])->name('detail-program');

Route::get('/our-impact', [LandingPageController::class, 'ourImpact'])->name('our-impact');

Route::get('/publications', [LandingPageController::class, 'publication'])->name('publications');

// content-detail all (stories, annual_report, publication)
Route::get('/publication/{title}', [LandingPageController::class, 'detailContent'])->name('publications-detail');
Route::get('/program/{category}/{title}', [LandingPageController::class, 'programDetail'])->name('program-detail');
Route::get('/career/{career}', [LandingPageController::class, 'careerDetail'])->name('career-detail');

Route::get('/grant-opportunities', [LandingPageController::class, 'cfcn'])->name('cfcn');
Route::get('/career', [LandingPageController::class, 'career'])->name('career');

Route::get('/grantee', [LandingPageController::class, 'grantee'])->name('grantee')->middleware('auth:grantee');
// Route::get('/grantee-custom', [LandingPageController::class, 'granteeTemplatePage'])->name('grantee.custom');

Route::get('/contact-us', [LandingPageController::class, 'contactUs'])->name('contact');
Route::get('/donate', [LandingPageController::class, 'donate'])->name('donate');

Route::post('/subscribe-newsletter', function (Request $request) {
    $request->validate([
        'email' => 'required|email|unique:subscriptions,email'
    ]);

    $subscriptions = Subscription::create([
        'email' => $request->email
    ]);

    return back()->with('success', 'Data created successfully');
})->name('email.subscribe');

Route::get('/login-grantee', [AuthController::class, 'loginGrantee'])->name('auth.login-grantee');
Route::post('/login-grantee', [AuthController::class, 'authGrantee'])->name('auth.post-grantee');
Route::post('/logout-grantee', [AuthController::class, 'destroyGrantee'])->name('grantee.logout');

Route::get('/search', function () {
    return Inertia::render('LandingPage/Search/Index');
})->name('search');

Route::get('/search-data', function (Request $request) {
    $search = $request->search;

    $newsStories = NewsStories::select('id', 'title', 'writter', 'type', 'created_at', 'banner')->when($search, function ($q) use($search) {
        $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($search) . '%']);
    })
    ->where('status', 'published');

    $programs = Program::selectRaw("
        id,
        title,
        '' AS writter,
        'program' AS type,
        created_at,
        banner
    ")
    ->when($search, function ($q) use ($search) {
        $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($search) . '%']);
    });

    $results = $newsStories->unionAll($programs)
    ->orderBy('id', 'desc')
    ->get()->map(function ($new) {
        return [
            ...$new->toArray(),
            'title' => json_decode($new->title),
        ];
    });

    return $results;
})->name('search.post');
