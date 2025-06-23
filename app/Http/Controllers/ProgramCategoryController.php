<?php

namespace App\Http\Controllers;

use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProgramCategoryController extends Controller
{
    public function index(Request $request)
    {
        $programCategories = $this->data($request);
        return Inertia::render('ProgramCategories/Index', [
            'programCategories' => $programCategories
        ]);
    }

    public function data(Request $request)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $newsStories = ProgramCategory::when($search, function ($q) use($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })
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
        return Inertia::render('ProgramCategories/Create', [
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_id' => 'required|string|min:5',
            'title_en' => 'required|string|min:5',
            'description_en' => 'required',
            'description_id' => 'required',
            'summary_en' => 'required',
            'summary_id' => 'required',
            'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'unique:program_categories,slug',
            ],
            'image' => 'required|mimes:jpeg,png,jpg,webp|max:1584',
        ]);

        try {
            DB::beginTransaction();

            $storeData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'slug' => $request->slug,
                'description' => json_encode([
                    'en' => $request->description_en,
                    'id' => $request->description_id,
                ]),
                'summary' => json_encode([
                    'en' => $request->summary_en,
                    'id' => $request->summary_id,
                ]),
            ];

            if ($request->hasFile('image')) {
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/program-cat', $request->file('image'), $fileName);

                $storeData['image'] = asset('/storage/'. $filePath);
            }

            $newsStories = ProgramCategory::create($storeData);

            DB::commit();

            return redirect(route('program-categories.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(ProgramCategory $program_category)
    {
        $total = ProgramCategory::count();
        return Inertia::render('ProgramCategories/Edit', [
            'programCategory' => [
                'id' => $program_category->id,
                'title' => json_decode($program_category->title, true),
                'image' => $program_category->image,
                'slug' => $program_category->slug,
                'order' => $program_category->order,
                'description' => json_decode($program_category->description, true),
                'summary' => json_decode($program_category->summary, true),
            ],
            'total' => $total
        ]);
    }

    public function update(Request $request, ProgramCategory $program_category)
    {
        $request->validate([
            'title_id' => 'required|string|min:5',
            'title_en' => 'required|string|min:5',
            'description_en' => 'required',
            'description_id' => 'required',
            'summary_en' => 'required',
            'summary_id' => 'required',
            'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                // 'unique:program_categories,slug',
            ],
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'slug' => $request->slug,
                'description' => json_encode([
                    'en' => $request->description_en,
                    'id' => $request->description_id,
                ]),
                'summary' => json_encode([
                    'en' => $request->summary_en,
                    'id' => $request->summary_id,
                ]),
            ];

            if ($request->hasFile('image')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $program_category->image);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/program-cat', $request->file('image'), $fileName);

                $updateData['image'] = asset('/storage/'. $filePath);
            }

            $program_category->update($updateData);

            DB::commit();

            return redirect(route('program-categories.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(ProgramCategory $program_category)
    {
        try {
            if ($program_category->programs()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'There is data related to this category'
                ], 400);
            }

            if ($program_category->image) {
                $oldMediaPath = str_replace(url('/storage/'), '', $program_category->image);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            $program_category->delete();

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
