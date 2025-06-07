<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = $this->data($request);

        return Inertia::render('Banner/Index', [
            'banners' => $banners
        ]);
    }
    
    public function data(Request $request)
    {
        $perPage = $request->perpage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $banners = Banner::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        return $banners->setCollection(
            $banners->getCollection()->map(function ($banner) {
                return [
                    ...$banner->toArray(),
                    'title' => json_decode($banner->title, true),
                    'description' => json_decode($banner->description, true),
                ];
            })
        );
    }

    public function create()
    {   
        $total = Banner::count();
        return Inertia::render('Banner/Create', [
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', '512M');

        $request->validate([
            'title_en' => 'required|min:6|max:70',
            'title_id' => 'required|min:6|max:70',
            'desc_en' => 'sometimes|nullable|string',
            'desc_id' => 'sometimes|nullable|string',
            'media' => 'required|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv,webp|max:51200',
            'type' => 'required',
            'link_01' => 'sometimes|nullable|url',
            'link_02' => 'sometimes|nullable|url',
        ]);

        try {
            DB::beginTransaction();

            if ($request->has('media')) {
                $fileName = time() . '_' . $request->file('media')->getClientOriginalName();
                $filePath = '';

                if ($request->type == 'video') {
                    $filePath = Storage::disk('public')->putFileAs('/banner/video', $request->file('media'), $fileName);
                    
                } else {
                    $filePath = Storage::disk('public')->putFileAs('/banner/img', $request->file('media'), $fileName);
                }

                $banner = Banner::create([
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'desc' => json_encode([
                        'en' => $request->desc_en,
                        'id' => $request->desc_id,
                    ]),
                    'type' => $request->type,
                    'order_num' => $request->order_num,
                    'is_active' => $request->is_active,
                    'media' => asset('/storage/' . $filePath),
                    'link_01' => $request->link_01,
                    'link_02' => $request->link_02,
                    'created_by' => Auth::user()->id
                ]);
    
            }

            DB::commit();

            return redirect(route('banner.index'));

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(Banner $banner)
    {
        $total = Banner::count();
        return Inertia::render('Banner/Edit', [
            'banner' => [
                'id' => $banner->id,
                'title' => json_decode($banner->title, true),
                'desc' => json_decode($banner->desc),
                'is_active' => $banner->is_active,
                'type' => $banner->type,
                'media' => $banner->media,
                'order_num' => $banner->order_num,
                'link_01' => $banner->link_01,
                'link_02' => $banner->link_02,
            ],
            'total' => $total
        ]); 
    }

    public function update(Request $request, Banner $banner)
    {
        ini_set('memory_limit', '512M');
        
        $request->validate([
            'title_en' => 'required|min:6|max:70',
            'title_id' => 'required|min:6|max:70',
            'desc_en' => 'sometimes|nullable|string',
            'desc_id' => 'sometimes|nullable|string',
            'media' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv,webp|max:51200',
            'type' => 'required',
            'link_01' => 'sometimes|nullable|url',
            'link_02' => 'sometimes|nullable|url',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('media')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $banner->media);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('media')->getClientOriginalName();
                $filePath = '';

                if ($request->type == 'video') {
                    $filePath = Storage::disk('public')->putFileAs('/banner/video', $request->file('media'), $fileName);
                    
                } else {
                    $filePath = Storage::disk('public')->putFileAs('/banner/img', $request->file('media'), $fileName);
                }

                $banner->update([
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'desc' => json_encode([
                        'en' => $request->desc_en,
                        'id' => $request->desc_id,
                    ]),
                    'is_active' => $request->is_active,
                    'type' => $request->type,
                    'order_num' => $request->order_num,
                    'media' => asset('/storage/' . $filePath),
                    'link_01' => $request->link_01,
                    'link_02' => $request->link_02,
                ]);
    
            } else {
                $banner->update([
                    'title' => json_encode([
                        'en' => $request->title_en,
                        'id' => $request->title_id,
                    ]),
                    'desc' => json_encode([
                        'en' => $request->desc_en,
                        'id' => $request->desc_id,
                    ]),
                    'is_active' => $request->is_active,
                    'type' => $request->type,
                    'order_num' => $request->order_num,
                    'link_01' => $request->link_01,
                    'link_02' => $request->link_02,
                ]);
            }

            DB::commit();

            return redirect(route('banner.index'));

        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function destroy(Banner $banner)
    {
        try {
            if ($banner->type == 'video' || $banner->type == 'img') {
                $oldMediaPath = str_replace(url('/storage/'), '', $banner->media);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
                
            } 

            $banner->delete();

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

    public function updateStatus(Banner $banner)
    {
        try {
            $banner->is_active = !$banner->is_active;
            $banner->update();

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
