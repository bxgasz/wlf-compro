<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = $this->data($request);

        return Inertia::render('Menu/Index', [
            'menus' => $menus
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $menus =  Menu::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->where('parent_id', null)->orderBy($sort, $order)
        ->paginate($perPage);

        $menus->setCollection(
            $menus->getCollection()->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'title' => json_decode($cat->title, true),
                ];
            })
        );

        return $menus;
    }

    public function create()
    {
        // $routes = collect(Route::getRoutes())->filter(function ($route) {
        //     $isWeb = in_array('web', $route->middleware());
        //     $isFrontOffice = !str_starts_with($route->uri(), 'admin') && !str_starts_with($route->uri(), 'dashboard');

        //     return $isWeb && $isFrontOffice && $route->getName();
            
        //     return in_array('web', $route->middleware());
        // })->map(function ($route) {
        //     return [
        //         'value' => $route->getName(),
        //         'label' => $route->getName(),
        //     ];
        // })
        // ->unique()
        // ->values();

        return Inertia::render('Menu/Create', [
            // 'routes' => $routes
        ]);
    }

    public function store(Request $request)
    {
        // $routeNames = collect(Route::getRoutes())
        // ->map(fn($route) => $route->getName())
        // ->filter()
        // ->unique()
        // ->toArray();

        // $request->validate([
        //     'title_en' => 'required|min:6|max:50',
        //     'title_id' => 'required|min:6|max:50',
        //     'slug' => 'required',
        //     'link' => ['required',  Rule::in($routeNames)],
        // ]);

        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'slug' => 'required',
            'link' => 'required',
            'dropdown' => 'sometimes|array',
            'dropdown.*.title_en' => 'required_with:dropdown.*.title_id,dropdown.*.slug,dropdown.*.link|min:3|max:50',
            'dropdown.*.title_id' => 'required_with:dropdown.*.title_en,dropdown.*.slug,dropdown.*.link|min:3|max:50',
            'dropdown.*.slug' => 'required_with:dropdown.*.title_en,dropdown.*.title_id,dropdown.*.link',
            'dropdown.*.link' => 'required_with:dropdown.*.title_en,dropdown.*.title_id,dropdown.*.slug',
        ]);

        try {
            DB::beginTransaction();

            $menu = Menu::create([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'slug' => $request->slug,
                'link' => $request->link,
            ]);

            if ($request->dropdown != null) {
                foreach ($request->dropdown  as $dropdown) {
                    $dropdownMenu = Menu::create([
                        'parent_id' => $menu->id,
                        'title' => json_encode([ 'en' => $dropdown['title_en'], 'id' => $dropdown['title_id'] ]),
                        'slug' => $dropdown['slug'],
                        'link' => $dropdown['link'],
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Data created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function buildMenuTree($menus)
    {
        return $menus->map(function ($menu) {
            $title = json_decode($menu->title, true);
            return [
                ...$menu->toArray(),
                'title_en' => $title['en'],
                'title_id' => $title['id'],
                // 'dropdown' => $this->buildMenuTree($menu->children),
            ];
        });
    }


    public function edit(Menu $menu)
    {
        return Inertia::render('Menu/Edit', [
            'menu' => [
                ...$menu->toArray(),
                'title' => json_decode($menu->title, true),
                'dropdown' => $this->buildMenuTree($menu->children),
            ],
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'slug' => 'required',
            'link' => 'required',
            'dropdown' => 'sometimes|array',
            'dropdown.*.title_en' => 'required_with:dropdown.*.title_id,dropdown.*.slug,dropdown.*.link|min:3|max:50',
            'dropdown.*.title_id' => 'required_with:dropdown.*.title_en,dropdown.*.slug,dropdown.*.link|min:3|max:50',
            'dropdown.*.slug' => 'required_with:dropdown.*.title_en,dropdown.*.title_id,dropdown.*.link',
            'dropdown.*.link' => 'required_with:dropdown.*.title_en,dropdown.*.title_id,dropdown.*.slug',
        ]);

        try {
            DB::beginTransaction();

            $menu->update([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'slug' => $request->slug,
                'link' => $request->link,
            ]);

           $processedIds = [];

           foreach ($request->dropdown as $dropdown) {
                $dropdownData = [
                    'parent_id' => $menu->id,
                    'title' => json_encode([ 'id' => $dropdown['title_id'], 'en' => $dropdown['title_en'] ]),
                    'slug' => $dropdown['slug'],
                    'link' => $dropdown['link'],
                ];

                if (isset($dropdown['id'])) {
                    $child = Menu::updateOrCreate(
                        ['id' => $dropdown['id'], 'parent_id' => $menu->id],
                        $dropdownData
                    );
                } else {
                    $child = Menu::create([
                        'parent_id' => $menu->id,
                        'title' => json_encode([ 'en' => $dropdown['title_en'], 'id' => $dropdown['title_id'] ]),
                        'slug' => $dropdown['slug'],
                        'link' => $dropdown['link'],
                    ]);
                }

                $processedIds[] = $child->id;
            }

            Menu::where('parent_id', $menu->id)->whereNotIn('id', $processedIds)->delete();

            DB::commit();

            return back()->with('success', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function destroy(Menu $menu)
    {
        // if ($menu->news()->exists()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'There is data related to this menu'
        //     ], 400);
        // }

        try {
            $menu->children()->delete();
            $menu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'errors' => $th->getMessage()
            ]);
        }
    }
}
