<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = $this->data($request);

        return Inertia::render('Tag/Index', [
            'tags' => $tags
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $tags =  Tag::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        $tags->setCollection(
            $tags->getCollection()->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'title' => json_decode($cat->title, true),
                    'description' => json_decode($cat->description, true),
                ];
            })
        );

        return $tags;
    }

    public function create()
    {
        return Inertia::render('Tag/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $tag = Tag::create([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
            ]);

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

    public function edit(Tag $tag)
    {
        return Inertia::render('Tag/Edit', [
            'tag' => [
                'id' => $tag->id,
                'title' => json_decode($tag->title, true),
                'description' => json_decode($tag->description, true),
            ]
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $tag->update([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
            ]);

            DB::commit();

            return back()->with('success', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function destroy(Tag $tag)
    {
        if ($tag->news()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'There is data related to this tag'
            ], 400);
        }

        try {
            $tag->delete();

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
