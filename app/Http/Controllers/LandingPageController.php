<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Career;
use App\Models\NewsStories;
use App\Models\Partner;
use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingPageController extends Controller
{
    public function home()
    {
        $banners = Banner::select('title', 'type', 'desc', 'media', 'link_01', 'link_02')->where('is_active', true)
        ->orderBy('order_num', 'asc')
        ->get()->map(function ($banner) {
            $banner->title = json_decode($banner->title, true);
            $banner->desc = json_decode($banner->desc, true);
            return $banner;
        });

        $programCategories = ProgramCategory::orderBy('id', 'desc')->get()->map(function ($categories) {
            $categories->title = json_decode($categories->title, true);
            $categories->descrption = json_decode($categories->descrption, true);
        });

        $stories = NewsStories::select('id', 'category_id', 'banner', 'type', 'thumbnail', 'title', 'created_at')->orderBy('id', 'desc')->paginate(3)
        ->map(function ($new) {
            $new->title = json_decode($new->title, true);
            return $new;
        });

        return Inertia::render('LandingPage/Home/Index', [
            'banners' => $banners,
            'programCategories' => $programCategories,
            'stories' => $stories
        ]);
    }

    public function aboutUs()
    {
        $partners = Partner::orderBy('id', 'desc')->get();

        return Inertia::render('LandingPage/About/Index', [
            'partners' => $partners
        ]);
    }

    public function  ourProgram() 
    {
        $programCategories = ProgramCategory::orderBy('id', 'desc')->get()->map(function ($categories) {
            $categories->title = json_decode($categories->title, true);
            $categories->descrption = json_decode($categories->descrption, true);
        });

        return Inertia::render('LandingPage/OurProgram/Index', [
            'programCategories' => $programCategories
        ]);
    }

    public function subProgram($categories) 
    {
        $programCategories = ProgramCategory::select('title', 'slug')->orderBy('id', 'desc')->get()->map(function ($categories) {
            $categories->title = json_decode($categories->title, true);
        });

        $programCategory = ProgramCategory::where('slug', $categories)->firstOrFail();

        return Inertia::render('LandingPage/OurProgram/SubProgram', [
            'programCategories' => $programCategories,
            'programCategory' => $programCategory
        ]);
    }

    public function getPrograms ($programCategoryId) 
    {
        return Program::where('program_category_id', $programCategoryId)->latest()->paginate(10)
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->description = json_decode($pg->description, true);
        });
    }

    public function programDetail($categories, Program $program) 
    {
        return Inertia::render('LandingPage/OurProgram/ProgramDetail', [
            'program' => $program
        ]);
    }

    public function  ourImpact() 
    {
        $stories = NewsStories::where('status', 'published')->latest()->paginate(10)
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->content = json_decode($pg->content, true);
        });

        return Inertia::render('LandingPage/OurImpact/Index', [
            'stories' => $stories
        ]);
    }

    public function publication() 
    {
        return Inertia::render('LandingPage/Publication/Index');
    
    }
    public function detailPublication($title) 
    {
        return Inertia::render('LandingPage/NewsStories/Detail');
    }

    public function cfcn()
    {
        return Inertia::render('LandingPage/GrandOpputurnities/CFCN');
    }

    public function career()
    {
        $careers = Career::where('status', 'open')->latest()->paginate(10)
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->description = json_decode($pg->description, true);
        });

        return Inertia::render('LandingPage/GrandOpputurnities/Career', [
            'careers' => $careers
        ]);
    }

    public function grantee()
    {
        return Inertia::render('LandingPage/Grantee/Index');
    }

    public function granteeTemplatePage()
    {
        return Inertia::render('LandingPage/Grantee/TemplatePage');
    }

    public function contactUs()
    {
        return Inertia::render('LandingPage/Contact/Index');
    }
    
    public function donate()
    {
        return Inertia::render('LandingPage/Donate/Index');
    }
}
