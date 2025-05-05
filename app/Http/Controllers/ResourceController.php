<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $resources = $this->data($request);
        return Inertia::render('Resource/Index', [
            'resources' => $resources
        ]); 
    }

    public function data(Request $request) {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $resources = Resource::when($search, function ($q) use($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        return $resources->setCollection(
            $resources->getCollection()->map(function ($resource) {
                return [
                    ...$resource->toArray(),
                    'title' => json_decode($resource->title, true)
                ];
            }) 
        );
    }

    public function create()
    {
        return Inertia::render('Resource/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_id' => 'required|string',
            'type' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx|max:10124',
        ]); 

        try {
            DB::beginTransaction();

            $storeData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'type' => $request->type,
                'created_by' => Auth::user()->id
            ];

            if ($request->hasFile('file')) {
                $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/resources/' . $storeData['type'], $request->file('file'), $fileName);

                $storeData['file'] = asset('/storage/' . $filePath);
    
            } 

            Resource::create($storeData);

            DB::commit();

            return redirect(route('resource.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function edit(Resource $resource)
    {
        return Inertia::render('Resource/Edit', [
            'resource' => [
                'id' => $resource->id,
                'title' => json_decode($resource->title),
                'type' => $resource->type,
                'file' => $resource->file,
            ]
        ]);
    }

    public function update(Request $request, Resource $resource) 
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_id' => 'required|string',
            'type' => 'required|string',
            'file' => 'nullable|mimes:pdf,doc,docx|max:10124',
        ]);  

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'type' => $request->type
            ];

            if ($request->hasFile('file')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $resource->file);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/resources/' . $updateData['type'], $request->file('file'), $fileName);

                $updateData['file'] = asset('/storage/' . $filePath);
    
            }

            $resource->update($updateData);

            DB::commit();

            return redirect(route('resource.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th);
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function  destroy(Resource $resource) {
        try {
            if ($resource->file) {
                $oldMediaPath = str_replace(url('/storage/'), '', $resource->file);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            $resource->delete();

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
