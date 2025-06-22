<?php

namespace App\Http\Controllers;

use App\Models\Management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ManagementController extends Controller
{
    public function index(Request $request)
    {
        $managements = $this->data($request);

        return Inertia::render('Management/Index', [
            'managements' => $managements
        ]);
    }
    
    public function data(Request $request)
    {
        $perPage = $request->perpage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $managements = Management::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        return $managements->setCollection(
            $managements->getCollection()->map(function ($management) {
                return [
                    ...$management->toArray(),
                    'title' => json_decode($management->title, true),
                    'description' => json_decode($management->description, true),
                ];
            })
        );
    }

    public function create()
    {   
        return Inertia::render('Management/Create');
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', '512M');
        
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'desc_en' => 'required|string',
            'desc_id' => 'required|string',
            'position_en' => 'required|string',
            'position_id' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,webp|max:1536',
            'link_fb' => 'sometimes|nullable|url',
            'link_ig' => 'sometimes|nullable|url',
            'link_linkedin' => 'sometimes|nullable|url',
        ]);

        try {
            DB::beginTransaction();

            if ($request->has('image')) {
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();

                $filePath = Storage::disk('public')->putFileAs('/management', $request->file('image'), $fileName);

                $management = Management::create([
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_en,
                    ]),
                    'description' => json_encode([
                        'en' => $request->desc_en,
                        'id' => $request->desc_id,
                    ]),
                    'position' => json_encode([
                        'en' => $request->position_en,
                        'id' => $request->position_id,
                    ]),
                    'image' => asset('/storage/' . $filePath),
                    'link_fb' => $request->link_fb,
                    'link_ig' => $request->link_ig,
                    'link_linkedin' => $request->link_linkedin,
                    'is_active' => true
                ]);
    
            }

            DB::commit();

            return redirect(route('management.index'));

        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th);
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(Management $management)
    {
        return Inertia::render('Management/Edit', [
            'management' => [
                'id' => $management->id,
                'title' => json_decode($management->title, true),
                'description' => json_decode($management->description, true),
                'image' => $management->image,
                'position' => json_decode($management->position, true),
                'link_fb' => $management->link_fb,
                'link_ig' => $management->link_ig,
                'link_linkedin' => $management->link_linkedin,
            ]
        ]);
    }

    public function update(Request $request, Management $management)
    {
        ini_set('memory_limit', '512M');

        $request->validate([
            'title_en' => 'required|min:6|max:50',
            // 'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required|string',
            'desc_id' => 'required|string',
            'position_en' => 'required|string',
            'position_id' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:1536',
            'link_fb' => 'sometimes|nullable|url',
            'link_ig' => 'sometimes|nullable|url',
            'link_linkedin' => 'sometimes|nullable|url',
            'link_web' => 'sometimes|nullable|url',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $management->image);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
                
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();

                $filePath = Storage::disk('public')->putFileAs('/management', $request->file('image'), $fileName);

                $management->update([
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_en,
                    ]),
                    'description' => json_encode([
                        'en' => $request->desc_en,
                        'id' => $request->desc_id,
                    ]),
                    'position' => json_encode([
                        'en' => $request->position_en,
                        'id' => $request->position_id,
                    ]),
                    'image' => asset('/storage/' . $filePath),
                    'link_fb' => $request->link_fb,
                    'link_ig' => $request->link_ig,
                    'link_linkedin' => $request->link_linkedin,
                ]);
    
            } else {
                $management->update([
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'description' => json_encode([
                        'en' => $request->desc_en,
                        'id' => $request->desc_id,
                    ]),
                    'position' => json_encode([
                        'en' => $request->position_en,
                        'id' => $request->position_id,
                    ]),
                    'link_ig' => $request->link_ig,
                    'link_fb' => $request->link_fb,
                    'link_linkedin' => $request->link_linkedin,
                ]);
            }

            DB::commit();

            return redirect(route('management.index'));

        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function destroy(Management $management)
    {
        try {
            if ($management->image) {
                $oldMediaPath = str_replace(url('/storage/'), '', $management->image);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
                
            } 

            $management->delete();

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

    public function updateStatus(Management $management)
    {
        try {
            $management->is_active = !$management->is_active;
            $management->update();

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
