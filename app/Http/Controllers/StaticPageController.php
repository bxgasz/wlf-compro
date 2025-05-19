<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        $staticPage = $this->data($request);
        return Inertia::render('StaticPage/Index', [
            'staticPage' => $staticPage
        ]);
    }

    public function data(Request $request)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $staticPage = StaticPage::when($search, function ($q) use($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })
        ->orderBy($sort, $order)
        ->paginate($perPage);

        return $staticPage->setCollection(
            $staticPage->getCollection()->map(function ($new) {
                return [
                    ...$new->toArray(),
                    'title_page' => json_decode($new->title_page, true),
                    'content' => json_decode($new->content),
                ];
            })
        );
    }

    public function create()
    {
        return Inertia::render('StaticPage/Create', [
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_page_id' => 'required|string|min:5',
            'title_page_en' => 'required|string|min:5',
            'content_en' => 'required',
            'content_id' => 'required',
            'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'unique:news_stories,slug',
            ],
            'meta_head' => 'required|string', 
            'meta_description' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,webp|max:1584',
        ]);

        try {
            DB::beginTransaction();

            $storeData = [
                'title_page' => json_encode([
                    'en' => $request->title_page_en,
                    'id' => $request->title_page_id,
                ]),
                'slug' => $request->slug,
                'meta_head' => $request->meta_head,
                'meta_description' => $request->meta_description,
                'content' => json_encode([
                    'en' => $request->content_en,
                    'id' => $request->content_id,
                ]),
            ];

            if ($request->hasFile('image')) {
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/static_page/img', $request->file('image'), $fileName);

                $storeData['image'] = asset('/storage/'. $filePath);
            }

            $staticPage = StaticPage::create($storeData);

            DB::commit();

            return redirect(route('static-page.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(StaticPage $static_page)
    {
        return Inertia::render('StaticPage/Edit', [
            'staticPage' => [
                'id' => $static_page->id,
                'title_page' => json_decode($static_page->title_page, true),
                'meta_head' => $static_page->meta_head,
                'meta_description' => $static_page->meta_description,
                'image' => $static_page->image,
                'slug' => $static_page->slug,
                'content' => json_decode($static_page->content, true),
            ],
        ]);
    }

    public function update(Request $request, StaticPage $static_page)
    {
        $request->validate([
            'title_page_id' => 'required|string|min:5',
            'title_page_en' => 'required|string|min:5',
            'content_en' => 'required',
            'content_id' => 'required',
            'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                // 'unique:news_stories,slug',
            ],
            'meta_head' => 'required|string', 
            'meta_description' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title_page' => json_encode([
                    'en' => $request->title_page_en,
                    'id' => $request->title_page_id,
                ]),
                'slug' => $request->slug,
                'meta_head' => $request->meta_head,
                'meta_description' => $request->meta_description,
                'content' => json_encode([
                    'en' => $request->content_en,
                    'id' => $request->content_id,
                ]),
            ];

            if ($request->hasFile('image')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $static_page->image);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/static_page/img', $request->file('image'), $fileName);

                $updateData['image'] = asset('/storage/'. $filePath);
            }

            $static_page->update($updateData);

            DB::commit();

            return redirect(route('static-page.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(StaticPage $static_page)
    {
        try {
            if ($static_page->image) {
                $oldMediaPath = str_replace(url('/storage/'), '', $static_page->image);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            $static_page->delete();

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
