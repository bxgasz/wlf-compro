<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $careers = $this->data($request);

        return Inertia::render('Career/Index', [
            'careers' => $careers
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $careers = Career::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        return $careers->setCollection(
            $careers->getCollection()->map(function ($career) {
                return [
                    ...$career->toArray(),
                    'title' => json_decode($career->title, true),
                    'description' => json_decode($career->description, true),
                ];
            })
        );
    }

    public function create()
    {
        return Inertia::render('Career/Create', [
           
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'type' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,webp|max:1584'
        ]);

        try {
            DB::beginTransaction();

            $storeData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'description' => json_encode([
                    'en' => $request->desc_en,
                    'id' => $request->desc_id,
                ]),
                'slug' => $request->slug,
                'status' => $request->status,
                'type' => $request->type,
                'created_by' => Auth::user()->id,
            ];

            
            if ($request->hasFile('image')) {
                $fileName = time() . '-image_' . $request->file('image')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/career', $request->file('image'), $fileName);
                
                $storeData['image'] = asset('/storage/' . $filePath);
            }

            $career = Career::create($storeData);
            
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

    public function edit(Career $career)
    {
        return Inertia::render('Career/Edit', [
            'career' => [
                ...$career->toArray(),
                'title' => json_decode($career->title, true),
                'description' => json_decode($career->description, true),
            ],
        ]);
    }

    public function update(Request $request, Career $career)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'type' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'description' => json_encode([
                    'en' => $request->desc_en,
                    'id' => $request->desc_id,
                ]),
                'slug' => $request->slug,
                'type' => $request->type,
                'status' => $request->status,
            ];

            if ($request->hasFile('image')) {
                $oldImagePath = str_replace(url('/storage/'), '', $career->image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $fileName = time() . '-image_' . $request->file('image')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/career', $request->file('image'), $fileName);
                
                $updateData['image'] = asset('/storage/' . $filePath);
            }

            $career->update($updateData);

            DB::commit();

            return back()->with('success', 'Data created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(Career $career)
    {
        try {
            if ($career->image) {
                $oldImagePath = str_replace(url('/storage/'), '', $career->image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $career->delete();

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

    public function updateStatus(Request $request, Career $career)
    {
        try {
            $career->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
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
