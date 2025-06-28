<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsStories;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class NewsStoriesController extends Controller
{
    public function index(Request $request)
    {
        $newsStories = $this->data($request);
        return Inertia::render('NewsStories/Index', [
            'newsStories' => $newsStories
        ]);
    }

    public function data(Request $request)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $newsStories = NewsStories::select('id', 'title', 'writter', 'type')->when($search, function ($q) use($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })
        ->with('tags')
        ->orderBy($sort, $order)
        ->paginate($perPage);

        return $newsStories->setCollection(
            $newsStories->getCollection()->map(function ($new) {
                return [
                    ...$new->toArray(),
                    'title' => json_decode($new->title),
                ];
            })
        );
    }

    public function create()
    {
        $tags = Tag::all()->map(function ($tag) {
            $title = json_decode($tag->title, true);
            return [
                'value' => $tag->id,
                'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id']
            ];
        });

        $categories = Category::all()->map(function ($category) {
            $title = json_decode($category->title, true);
            return [
                'value' => $category->id,
                'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id']
            ];
        });

        return Inertia::render('NewsStories/Create', [
            'tags' => $tags,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {


        if ($request->type == 'publication' || $request->type == 'annual_report') {
            $request->validate([
                'title_id' => 'required|string|min:5',
                'title_en' => 'required|string|min:5',
                'banner' => 'required|mimes:jpeg,png,jpg,webp',
                'type' => 'required|string',
                'document' => 'required|mimes:pdf,doc,docx'
            ]);
        } else {
            $request->validate([
                'title_id' => 'required|string|min:5',
                'title_en' => 'required|string|min:5',
                'content_en' => 'required',
                'content_id' => 'required',
                'slug' => [
                    'required',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    'unique:news_stories,slug',
                ],
                'banner' => 'required|mimes:jpeg,png,jpg,webp',
                'type' => 'required|string',
                'tags' => 'required|array',
                '*tags' => 'required',
            ]);
        }

        try {
            DB::beginTransaction();

            if ($request->type == 'publication') {
                $storeData = [
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'slug' => '',
                    'meta_title' => '',
                    'meta_description' => '',
                    'type' => $request->type,
                    'content' => json_encode(''),
                    'writter' => $request->writter ?? '',
                    'status' => 'published',
                    'created_by' => Auth::user()->id,
                ];
            } else {
                $storeData = [
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'slug' => $request->slug,
                    'meta_title' => $request->meta_title ?? '',
                    'meta_description' => $request->meta_description ?? '',
                    'type' => $request->type,
                    'content' => json_encode([
                        'en' => $request->content_en,
                        'id' => $request->content_id,
                    ]),
                    'writter' => $request->writter ?? '',
                    'status' => 'published',
                    'created_by' => Auth::user()->id,
                    'category_id' => $request->category_id,
                ];
            }

            if ($request->hasFile('banner')) {
                $fileName = time() . '_' . $request->file('banner')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/' . $storeData['type'] . '/img', $request->file('banner'), $fileName);

                $storeData['banner'] = asset('/storage/'. $filePath);
            }

            if ($request->hasFile('document') && $request->type == 'publication' || $request->type == 'annual_report') {
                $fileName = time() . '_' . $request->file('document')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/content/' . $storeData['type'], $request->file('document'), $fileName);

                $storeData['document'] = asset('/storage/' . $filePath);
            }

            $newsStories = NewsStories::create($storeData);

            $newsStories->tags()->attach($request->tags);

            DB::commit();

            return redirect(route('content.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(NewsStories $content)
    {
        $tags = Tag::all()->map(function ($tag) {
            $title = json_decode($tag->title, true);
            return [
                'value' => $tag->id,
                'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id']
            ];
        });

        $categories = Category::all()->map(function ($category) {
            $title = json_decode($category->title, true);
            return [
                'value' => $category->id,
                'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id']
            ];
        });

        return Inertia::render('NewsStories/Edit', [
            'newsStories' => [
                'id' => $content->id,
                'title' => json_decode($content->title, true),
                'meta_title' => $content->meta_title,
                'meta_description' => $content->meta_description,
                'banner' => $content->banner,
                'document' => $content->document,
                'slug' => $content->slug,
                'type' => $content->type,
                'content' => json_decode($content->content, true),
                'writter' => $content->writter,
                'status' => $content->status,
                'category_id' => $content->category_id,
                'tags' => $content->tags->pluck('id')
            ],
            'tags' => $tags,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, NewsStories $content)
    {
        if ($request->type == 'publication' || $request->type == 'annual_report') {
            $request->validate([
                'title_id' => 'required|string|min:5',
                'title_en' => 'required|string|min:5',
                'banner' => 'required|mimes:jpeg,png,jpg,webp',
                'type' => 'required|string',
                'document' => 'required|mimes:pdf,doc,docx'
            ]);
        } else {
            $request->validate([
                'title_id' => 'required|string|min:5',
                'title_en' => 'required|string|min:5',
                'content_en' => 'required',
                'content_id' => 'required',
                'slug' => [
                    'required',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    // 'unique:news_stories,slug',
                ],
                'banner' => 'required|mimes:jpeg,png,jpg,webp',
                'type' => 'required|string',
                'tags' => 'required|array',
                '*tags' => 'required',
            ]);
        }

        try {
            DB::beginTransaction();

            if ($request->type == 'publication') {
                $updateData = [
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'slug' => '',
                    'meta_title' => '',
                    'meta_description' => '',
                    'type' => $request->type,
                    'content' => json_encode(''),
                    'writter' => $request->writter ?? '',
                    'status' => 'draft',
                    'created_by' => Auth::user()->id,
                ];
            } else {
                $updateData = [
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'slug' => $request->slug,
                    'meta_title' => $request->meta_title ?? '',
                    'meta_description' => $request->meta_description ?? '',
                    'type' => $request->type,
                    'content' => json_encode([
                        'en' => $request->content_en,
                        'id' => $request->content_id,
                    ]),
                    'writter' => $request->writter ?? '',
                    'status' => 'draft',
                    'created_by' => Auth::user()->id,
                    'category_id' => $request->category_id,
                ];
            }

            if ($request->type == 'story') {
                $oldMediaPath = str_replace(url('/storage/'), '', $content->document);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            if ($request->hasFile('banner')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $content->banner);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('banner')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/' . $updateData['type'] . '/img', $request->file('banner'), $fileName);

                $updateData['banner'] = asset('/storage/'. $filePath);
            }

            if ($request->hasFile('document') && $request->type == 'publication' || $request->hasFile('document') && $request->type == 'annual_report') {
                $oldMediaPath = str_replace(url('/storage/'), '', $content->document);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('document')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/content/' . $updateData['type'], $request->file('document'), $fileName);

                $updateData['document'] = asset('/storage/' . $filePath);
            }

            if ($updateData['status'] == 'published') {
                $updateData['editor_by'] = Auth::user()->id;
            }

            $content->update($updateData);
            $content->tags()->sync($request->tags);


            DB::commit();

            return redirect(route('content.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(NewsStories $content)
    {
        try {
            if ($content->banner) {
                $oldMediaPath = str_replace(url('/storage/'), '', $content->banner);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            $content->delete();

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
