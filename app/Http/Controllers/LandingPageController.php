<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Career;
use App\Models\InstagramPost;
use App\Models\Location;
use App\Models\Management;
use App\Models\NewsStories;
use App\Models\Organization;
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

        $programCategories = ProgramCategory::orderBy('order', 'asc')->get()->map(function ($categories) {
            $categories->title = json_decode($categories->title, true);
            $categories->descrption = json_decode($categories->descrption, true);

            return $categories;
        });

        // $locationPoints = Location::orderBy('id', 'DESC')->get();

        $locationPoints = Location::with([
            'programs' => function ($query) {
                $query->where('status', '!=', 'draft'); // hanya program published
            },
            'programs.programCategory'
        ])
        ->orderByDesc('id')
        ->get()
        ->map(function ($loc) {
            $loc->title = json_decode($loc->title, true);

            $loc->program_counts = $loc->programs
                ->groupBy(fn ($p) => $p->programCategory->title ?? 'Uncategorised')
                ->map(fn ($g) => $g->count());

            $loc->program_counts_array = $loc->program_counts
                ->map(fn ($total, $cat) => [
                    'category' => json_decode($cat, true),
                    'total'    => $total,
                ])
                ->values();

            unset($loc->programs);

            return $loc;
        });

        $programs = Program::with('locationMap')->orderBy('id', 'desc')->paginate(10)->map(function ($program) {
            $program->title = json_decode($program->title, true);
            $program->descrption = json_decode($program->descrption, true);

            return $program;
        });

        $newPublications = NewsStories::select('banner', 'title', 'created_at', 'slug', 'document')->where('type', 'publication')->where('status', 'published')->orderBy('created_at', 'desc')->first();
        if ($newPublications != null) {
            $newPublications->title = json_decode($newPublications->title, true);
        }

        $stories = NewsStories::select('id', 'category_id', 'banner', 'type', 'title', 'created_at', 'slug')
        ->where('type', 'story')
        ->orderBy('id', 'desc')->paginate(3)
        ->map(function ($new) {
            $new->title = json_decode($new->title, true);
            return $new;
        });

        $instagramPosts = InstagramPost::orderBy('created_at', 'asc')->get();

        return Inertia::render('LandingPage/Home/Index', [
            'banners' => $banners,
            'programs' => $programs,
            'programCategories' => $programCategories,
            'stories' => $stories,
            'newPublications' => $newPublications,
            'instagramPosts' => $instagramPosts,
            'locationPoints' => $locationPoints,
        ]);
    }

    public function aboutUs()
    {
        $partners = Partner::where('type', 'partner')->orderBy('id', 'desc')->get()->chunk(10);

        $managements = Management::orderBy('id', 'desc')->where('is_active', true)->get()->map(function ($management) {
            $management->title = json_decode($management->title, true);
            $management->position = json_decode($management->position, true);
            $management->description = json_decode($management->description, true);
            return $management;
        });

        $organization = Organization::first();

        return Inertia::render('LandingPage/About/Index', [
            'partners' => $partners,
            'managements' => $managements,
            'organization' => $organization,
        ]);
    }

    public function  ourProgram()
    {
        $programCategories = ProgramCategory::with(['programs' => function ($query) {
            $query->take(3);
        }])->orderBy('order', 'asc')->get()->map(function ($category) {
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
        $programCategories = ProgramCategory::select('title', 'slug')->orderBy('order', 'asc')->get()->map(function ($categories) {
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
        return Program::where('program_category_id', $programCategoryId)->get()
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->description = json_decode($pg->description, true);
        });
    }

    public function programDetail($category, $title)
    {
        if (!$title) {
            return redirect()->back();
        }

        $content = Program::with(['programCategory'])->where('slug', 'LIKE', '%'. $title .'%')->orWhere('title', 'LIKE', '%'. $title .'%')
        ->where('program_category_id', $category)->first();

        if (!$content) {
            return redirect(route('home'));
        }

        $otherContent = Program::whereNot('id', $content->id)
            ->orderByRaw('CASE WHEN program_category_id = ? THEN 1 ELSE 2 END', [$content->program_category_id])
            ->orderBy('program_category_id', 'desc')
            ->paginate(3);

        $otherContent->setCollection(
            $otherContent->getCollection()->map(function ($item) {
                return [
                    ...$item->toArray(),
                    'title' => json_decode($item->title, true),
                ];
            })
        );


        return Inertia::render('LandingPage/Content/ProgramDetail', [
            'content' => [
                'id' => $content->id,
                'title' => json_decode($content->title),
                'slug' => $content->slug,
                'implementing_partner' => $content->implementing_partner,
                'meta_head' => $content->meta_head,
                'sector' => $content->sector,
                'location' => $content->location,
                'start_date' => $content->start_date,
                'end_date' => $content->end_date,
                'youtube_link' => $content->youtube_link,
                'description' => json_decode($content->description, true),
                'banner' => $content->banner,
                'location_id' => $content->location_id,
                'category' => $content->programCategory ? json_decode($content->programCategory->title, true) : null,
                'status' => $content->status,
                'document' => $content->document,
                'program_category_id' => $content->program_category_id,
                'created_at' => $content->created_at,
            ],
            'otherContent' => $otherContent
        ]);
    }

    public function ourImpact()
    {
        $stories = NewsStories::select('title', 'created_at', 'banner', 'status', 'content', 'slug')
            ->where('type', 'story')
            ->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        $stories->getCollection()->transform(function ($pg) {
            $pg->title   = json_decode($pg->title, true);
            $pg->content = json_decode($pg->content, true);
            return $pg;
        });

        $impact = OurImpact::first();

        if ($impact != null) {
            for ($i = 1; $i < 5; $i++) {
                $key = 'title_' . $i;
                $impact->$key = json_decode($impact->$key, true);

                $key2 = 'subtitle_' . $i;
                $impact->$key2 = json_decode($impact->$key2, true);
            }

            $impact->sub_icons = json_decode($impact->sub_icons, true);
        }

        return Inertia::render('LandingPage/OurImpact/Index', [
            'stories' => $stories,
            'impact' => $impact
        ]);
    }

    public function publication(Request $request)
    {
        $type = $request->type ?? 'publication';
        $data = NewsStories::select('banner', 'created_at', 'title', 'document')
        ->where('type', $type)
        ->where('status', 'published')
        ->orderBy('created_at', 'DESC')
        ->paginate(10);

        $data->getCollection()->transform(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->content = json_decode($pg->content, true);

            return $pg;
        });

        return Inertia::render('LandingPage/Publication/Index', [
            'datas' => $data,
            'type' => $type,
        ]);

    }
    public function detailContent($title)
    {
        if (!$title) {
            return redirect()->back();
        }

        $content = NewsStories::with(['category', 'tags'])->where('slug', 'LIKE', '%'. $title .'%')->orWhere('title', 'LIKE', '%'. $title .'%')->first();

        if (!$content) {
            return redirect(route('home'));
        }

        $otherContent = NewsStories::select('slug', 'title', 'banner', 'created_at')->whereNot('id', $content->id)
            ->where('type', $content->type)
            ->orderByRaw('CASE WHEN category_id = ? THEN 1 ELSE 2 END', [$content->category_id])
            ->orderBy('category_id', 'desc')
            ->paginate(3);

        $otherContent->setCollection(
            $otherContent->getCollection()->map(function ($item) {
                return [
                    ...$item->toArray(),
                    'title' => json_decode($item->title, true),
                ];
            })
        );


        return Inertia::render('LandingPage/Content/Detail', [
            'content' => [
                'id' => $content->id,
                'title' => json_decode($content->title),
                'slug' => $content->slug,
                'type' => $content->type,
                'meta_head' => $content->meta_head,
                'meta_desc' => $content->meta_desc,
                'banner' => $content->banner,
                'document' => $content->document,
                'type' => $content->type,
                'thumbnail' => $content->thumbnail,
                'description' => json_decode($content->content, true),
                'author' => $content->author,
                'category_id' => $content->category_id,
                'category' => $content->category ? json_decode($content->category->title, true) : null,
                'tags' =>  $content->tags->map(function ($tag) {
                    return [
                        'value' => $tag->id,
                        'label' => json_decode($tag->title, true)['id'] ?? 'Untitled',
                        'en' => json_decode($tag->title, true)['en'] ?? 'Untitled',
                    ];
                }),
                'created_at' => $content->created_at
            ],
            'otherContent' => $otherContent
        ]);
    }

    public function cfcn()
    {
        $programCategories = ProgramCategory::orderBy('order', 'asc')->get()->map(function ($categories) {
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
        $careers = Career::where('status', 'open')->paginate(10)
        ->map(function ($pg) {
            $pg->title = json_decode($pg->title, true);
            $pg->description = json_decode($pg->description, true);

            return $pg;
        });

        return Inertia::render('LandingPage/GrandOpputurnities/Career', [
            'careers' => $careers
        ]);
    }

    public function careerDetail(Career $career)
    {
        return Inertia::render('LandingPage/Content/CareerDetail', [
            'content' => [
                'id' => $career->id,
                'title' => json_decode($career->title, true),
                'description' => json_decode($career->description, true),
                'type' => $career->type,
                'created_at' => $career->created_at,
                'image' => $career->image,
            ]
        ]);
    }

    public function grantee()
    {
        $granteePartners = Partner::where('type', 'grantee')->get()->map(function ($grantee) {
            $grantee->description = json_decode($grantee->description, true);

            return $grantee;
        });

        return Inertia::render('LandingPage/Grantee/Index', [
            'granteePartners' => $granteePartners
        ]);
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
