<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $this->data($request);

        return Inertia::render('Category/Index', [
            'categories' => $categories
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $categories =  Category::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        $categories->setCollection(
            $categories->getCollection()->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'title' => json_decode($cat->title, true),
                    'description' => json_decode($cat->description, true),
                ];
            })
        );

        return $categories;
    }

    public function create()
    {
        return Inertia::render('Category/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,webp|max:1584'
        ]);

        try {
            DB::beginTransaction();


            $storeData = [
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
            ];

            if ($request->hasFile('image')) {
                $fileName = time() . '-image_' . $request->file('image')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/categories', $request->file('image'), $fileName);
                
                $storeData['image'] = asset('/storage/' . $filePath);
            }

            $category = Category::create($storeData);

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

    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', [
            'category' => [
                'id' => $category->id,
                'title' => json_decode($category->title, true),
                'description' => json_decode($category->description, true),
                'image' => $category->image
            ]
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
            ];

            if ($request->hasFile('image')) {
                $oldImagePath = str_replace(url('/storage/'), '', $category->image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $fileName = time() . '-image_' . $request->file('image')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/category', $request->file('image'), $fileName);
                
                $updateData['image'] = asset('/storage/' . $filePath);
            }

            $category->update($updateData);

            DB::commit();

            return back()->with('success', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function destroy(Category $category)
    {
        if ($category->news()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'There is data related to this category'
            ], 400);
        }

        try {

            if ($category->image) {
                $oldImagePath = str_replace(url('/storage/'), '', $category->image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $category->delete();

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
