<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class InstagramPostController extends Controller
{
    public function index(Request $request)
    {
        $instagrams = $this->data($request, 'instagram');
        return Inertia::render('Instagram/Index', [
            'instagrams' => $instagrams
        ]);
    }

    public function data(Request $request, $type)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $instagram = InstagramPost::orderBy($sort, $order)
        ->paginate($perPage);

        return $instagram;
    }

    public function create()
    {
        return Inertia::render('Instagram/Create', [
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url',
            'media' => 'required|mimes:jpeg,png,jpg,webp|max:1584',
        ]);

        try {
            DB::beginTransaction();

            $storeData = [
                'link' => $request->link,
            ];

            if ($request->hasFile('media')) {
                $fileName = time() . '_' . $request->file('media')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/instagram/img', $request->file('media'), $fileName);

                $storeData['media'] = asset('/storage/'. $filePath);
            }

            $instagram = InstagramPost::create($storeData);

            DB::commit();

            return redirect(route('instagram.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(InstagramPost $instagram)
    {
        return Inertia::render('Instagram/Edit', [
            'instagram' => [
                'id' => $instagram->id,
                'media' => $instagram->media,
                'link' => $instagram->link,
            ],
        ]);
    }

    public function update(Request $request, InstagramPost $instagram)
    {
        $request->validate([
            'link' => 'required|url',
            'media' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'link' => $request->link,
            ];

            if ($request->hasFile('media')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $instagram->media);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('media')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/instagram/img', $request->file('media'), $fileName);

                $updateData['media'] = asset('/storage/'. $filePath);
            }

            $instagram->update($updateData);

            DB::commit();

            return redirect(route('instagram.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(InstagramPost $instagram)
    {
        try {
            if ($instagram->logo) {
                $oldMediaPath = str_replace(url('/storage/'), '', $instagram->logo);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            $instagram->delete();

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
