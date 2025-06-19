<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Career;
use App\Models\NewsStories;
use App\Models\OurImpact;
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

            return $categories;
        });

        $programs = Program::with('locationMap')->orderBy('id', 'desc')->paginate(10)->map(function ($program) {
            $program->title = json_decode($program->title, true);
            $program->descrption = json_decode($program->descrption, true);

            return $program;
        });

        $stories = NewsStories::select('id', 'category_id', 'banner', 'type', 'thumbnail', 'title', 'created_at', 'slug')
        ->where('type', 'story')
        ->orderBy('id', 'desc')->paginate(3)
        ->map(function ($new) {
            $new->title = json_decode($new->title, true);
            return $new;
        });

        return Inertia::render('LandingPage/Home/Index', [
            'banners' => $banners,
            'programs' => $programs,
            'programCategories' => $programCategories,
            'stories' => $stories
        ]);
    }

    public function aboutUs()
    {
        $partners = Partner::orderBy('id', 'desc')->get()->chunk(10);

        return Inertia::render('LandingPage/About/Index', [
            'partners' => $partners
        ]);
    }

    public function  ourProgram() 
    {
        $programCategories = ProgramCategory::with(['programs' => function ($query) {
            $query->latest()->take(3);
        }])->orderBy('id', 'desc')->get()->map(function ($category) {
            // Decode milik kategori
            $category->title = json_decode($category->title, true);
            $category->descrption = json_decode($category->descrption, true);

            // Decode milik setiap program
            $category->programs->transform(function ($program) {
                $program->title = json_decode($program->title, true);
                $program->description = json_decode($program->description, true);
                return $program;
            });

            return $category;
        });

        return Inertia::render('LandingPage/OurProgram/Index', [
            'programCategories' => $programCategories
        ]);
    }

    public function subProgram($categories) 
    {
        $programCategories = ProgramCategory::select('title', 'slug')->orderBy('id', 'desc')->get()->map(function ($categories) {
            $categories->title = json_decode($categories->title, true);

            return $categories;
        });

        $programCategory = ProgramCategory::with('programs')->where('slug', $categories)->first();
    
        $programCategory->title = json_decode($programCategory->title, true);
        $programCategory->description = json_decode($programCategory->description, true);
        
        $programCategory->programs->transform(function ($program) {
            $program->title = json_decode($program->title, true);
            $program->description = json_decode($program->description, true);
            return $program;
        });

        return Inertia::render('LandingPage/OurProgram/SubProgram', [
            'programCategories' => $programCategories,
            'programCategory' => $programCategory,
            'category' => $categories
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

    public function ourImpact() 
    {
        $stories = NewsStories::where('type', 'story')->where('status', 'published')->latest()->paginate(10)
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->content = json_decode($pg->content, true);

            return $pg;
        });

        $impact = OurImpact::first();

        for ($i = 1; $i < 5; $i++) {
            $key = 'title_' . $i;
            $impact->$key = json_decode($impact->$key, true);

            $key2 = 'subtitle_' . $i;
            $impact->$key2 = json_decode($impact->$key2, true);
        }

        $impact->sub_icons = json_decode($impact->sub_icons, true);

        return Inertia::render('LandingPage/OurImpact/Index', [
            'stories' => $stories,
            'impact' => $impact
        ]);
    }

    public function publication(Request $request) 
    {
        $type = $request->type ?? 'publication';
        $data = NewsStories::where('type', $type)->where('status', 'published')->latest()->paginate(10)
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->content = json_decode($pg->content, true);

            return $pg;
        });

        return Inertia::render('LandingPage/Publication/Index', [
            'datas' => $data,
            'type' => $type,
        ]);
    
    }
    public function detailPublication($title) 
    {
        return Inertia::render('LandingPage/NewsStories/Detail');
    }

    public function cfcn()
    {
        $programCategories = ProgramCategory::orderBy('id', 'desc')->get()->map(function ($categories) {
            $categories->title = json_decode($categories->title, true);
            $categories->descrption = json_decode($categories->descrption, true);

            return $categories;
        });

        return Inertia::render('LandingPage/GrandOpputurnities/CFCN', [
            'programCategories' => $programCategories
        ]);
    }

    public function career()
    {
        $careers = Career::where('status', 'open')->latest()->paginate(10)
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->description = json_decode($pg->description, true);

            return $pg;
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
