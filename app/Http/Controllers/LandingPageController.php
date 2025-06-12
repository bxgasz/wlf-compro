<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Program;
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

        return Inertia::render('LandingPage/Home/Index', [
            'banners' => $banners
        ]);
    }

    public function aboutUs()
    {
        return Inertia::render('LandingPage/About/Index');
    }

    public function  ourProgram() 
    {
        return Inertia::render('LandingPage/OurProgram/Index');
    }

    public function  ourImpact() 
    {
        return Inertia::render('LandingPage/OurImpact/Index');
    }

    public function subProgram($categories) 
    {
        //programcategories with program
        return Inertia::render('LandingPage/OurProgram/SubProgram');
    }

    public function programDetail($categories, Program $program) 
    {
        return Inertia::render('LandingPage/OurProgram/ProgramDetail');
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
        return Inertia::render('LandingPage/GrandOpputurnities/Career');
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
