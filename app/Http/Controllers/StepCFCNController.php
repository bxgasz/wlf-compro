<?php

namespace App\Http\Controllers;

use App\Models\StepCFCN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class StepCFCNController extends Controller
{
    public function index(Request $request)
    {
        $steps = $this->data($request);

        return Inertia::render('StepCFCN/Index', [
            'steps' => $steps
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $steps =  StepCFCN::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        $steps->setCollection(
            $steps->getCollection()->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'title' => json_decode($cat->title, true),
                    'description' => json_decode($cat->description, true),
                ];
            })
        );

        return $steps;
    }

    public function create()
    {
        $total = StepCFCN::count();
        return Inertia::render('StepCFCN/Create', [ 'total' => $total ]); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,webp|max:1584',
            'file' => 'required|url',
        ]);

        try {
            DB::beginTransaction();


            $storeData = [
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
                'file' => $request->file
            ];

            if ($request->hasFile('image')) {
                $fileName = time() . '-image_' . $request->file('image')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/steps', $request->file('image'), $fileName);
                
                $storeData['image'] = asset('/storage/' . $filePath);
            }

            // if ($request->hasFile('file')) {
            //     $fileName = time() . '-file_' . $request->file('file')->getClientOriginalName();
            //     $filePath = Storage::disk('public')->putFileAs('/steps', $request->file('file'), $fileName);
                
            //     $storeData['file'] = asset('/storage/' . $filePath);
            // }

            $step_cfcn = StepCFCN::create($storeData);

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

    public function edit(StepCFCN $step_cfcn)
    {
        $total = StepCFCN::count();
        return Inertia::render('StepCFCN/Edit', [
            'step' => [
                'id' => $step_cfcn->id,
                'title' => json_decode($step_cfcn->title, true),
                'description' => json_decode($step_cfcn->description, true),
                'image' => $step_cfcn->image,
                'file' => $step_cfcn->file,
            ],
            'total' => $total
        ]);
    }

    public function update(Request $request, StepCFCN $step_cfcn)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584',
            'file' => 'nullable|url'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
                'order' => $request->order ?? 1,
                'file' => $request->file
            ];

            if ($request->hasFile('image')) {
                $oldImagePath = str_replace(url('/storage/'), '', $step_cfcn->image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $fileName = time() . '-image_' . $request->file('image')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/stStepCFCN', $request->file('image'), $fileName);
                
                $updateData['image'] = asset('/storage/' . $filePath);
            }

            // if ($request->hasFile('file')) {
            //     $oldFilePath = str_replace(url('/storage/'), '', $step_cfcn->file);

            //     if (Storage::disk('public')->exists($oldFilePath)) {
            //         Storage::disk('public')->delete($oldFilePath);
            //     }

            //     $fileName = time() . '-file_' . $request->file('file')->getClientOriginalName();
            //     $filePath = Storage::disk('public')->putFileAs('/stStepCFCN', $request->file('file'), $fileName);
                
            //     $updateData['file'] = asset('/storage/' . $filePath);
            // }

            $step_cfcn->update($updateData);

            DB::commit();

            return back()->with('success', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function destroy(StepCFCN $step_cfcn)
    {
        try {

            if ($step_cfcn->image) {
                $oldImagePath = str_replace(url('/storage/'), '', $step_cfcn->image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            if ($step_cfcn->file) {
                $oldFilePath = str_replace(url('/storage/'), '', $step_cfcn->file);

                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            }

            $step_cfcn->delete();

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
