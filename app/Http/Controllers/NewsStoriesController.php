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

        $newsStories = NewsStories::when($search, function ($q) use($search) {
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
            'meta_title' => 'required|string', 
            'meta_description' => 'required|string',
            'banner' => 'required|mimes:jpeg,png,jpg,webp|max:1584',
            'type' => 'required|string',
            'writter' => 'required|string',
            'tags' => 'required|array',
            '*tags' => 'required',
            'category_id' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $storeData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'slug' => $request->slug,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'type' => $request->type,
                'content' => json_encode([
                    'en' => $request->content_en,
                    'id' => $request->content_id,
                ]),
                'writter' => $request->writter,
                'status' => 'draft',
                'created_by' => Auth::user()->id,
                'category_id' => $request->category_id,
            ];

            if ($request->hasFile('banner')) {
                $fileName = time() . '_' . $request->file('banner')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/' . $storeData['type'] . '/img', $request->file('banner'), $fileName);

                $storeData['banner'] = asset('/storage/'. $filePath);
            }

            $newsStories = NewsStories::create($storeData);

            $newsStories->tags()->attach($request->tags);

            DB::commit();

            return redirect(route('news-stories.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(NewsStories $news_story)
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
                'id' => $news_story->id,
                'title' => json_decode($news_story->title, true),
                'meta_title' => $news_story->meta_title,
                'meta_description' => $news_story->meta_description,
                'banner' => $news_story->banner,
                'slug' => $news_story->slug,
                'type' => $news_story->type,
                'content' => json_decode($news_story->content, true),
                'writter' => $news_story->writter,
                'status' => $news_story->status,
                'category_id' => $news_story->category_id,
                'tags' => $news_story->tags->pluck('id')
            ],
            'tags' => $tags,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, NewsStories $news_story)
    {
        $request->validate([
            'title_id' => 'required|string|min:5',
            'title_en' => 'required|string|min:5',
            'content_en' => 'required',
            'content_id' => 'required',
            'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                // Rule::unique('news_stories', 'slug')->ignore($news_story->id),
            ],
            'meta_title' => 'required|string', 
            'meta_description' => 'required|string',
            'banner' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584',
            'type' => 'required|string',
            'writter' => 'required|string',
            'status' => 'required|string',
            'tags' => 'required|array',
            '*tags' => 'required',
            'category_id' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'slug' => $request->slug,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'type' => $request->type,
                'content' => json_encode([
                    'en' => $request->content_en,
                    'id' => $request->content_id,
                ]),
                'writter' => $request->writter,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
                'category_id' => $request->category_id,
            ];

            if ($request->hasFile('banner')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $news_story->banner);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('banner')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/' . $updateData['type'] . '/img', $request->file('banner'), $fileName);

                $updateData['banner'] = asset('/storage/'. $filePath);
            }

            if ($updateData['status'] == 'published') {
                $updateData['editor_by'] = Auth::user()->id;
            }

            $news_story->update($updateData);
            $news_story->tags()->sync($request->tags);

            DB::commit();

            return redirect(route('news-stories.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(NewsStories $news_story)
    {
        try {
            if ($news_story->banner) {
                $oldMediaPath = str_replace(url('/storage/'), '', $news_story->banner);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            $news_story->delete();

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
