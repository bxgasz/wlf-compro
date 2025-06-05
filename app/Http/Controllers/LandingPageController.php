<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingPageController extends Controller
{
    public function home()
    {
        return Inertia::render('LandingPage/Home/Index');
    }

    public function aboutUs()
    {
        return Inertia::render('LandingPage/About/Index');
    }

    public function  ourProgram() 
    {
        return Inertia::render('LandingPage/OurProgram/Index');
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

    public function grantee()
    {
        return Inertia::render('LandingPage/Grantee/Index');
    }
}
