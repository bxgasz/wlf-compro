<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'location' => 'required',
            'salary_range' => 'required',
            'status' => 'required',
            'type' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $career = Career::create([
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'description' => json_encode([
                    'en' => $request->desc_en,
                    'id' => $request->desc_id,
                ]),
                'slug' => $request->slug,
                'location' => $request->location,
                'salary_range' => $request->salary_range,
                'status' => $request->status,
                'type' => $request->type,
                'created_by' => Auth::user()->id,
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

    public function edit(Career $career)
    {
        $salary = explode('-', $career->salary_range);
        return Inertia::render('Career/Edit', [
            'career' => [
                ...$career->toArray(),
                'title' => json_decode($career->title, true),
                'description' => json_decode($career->description, true),
                'start_salary' => $salary[0],
                'to_salary' => $salary[1],
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
            'location' => 'required',
            'salary_range' => 'required',
            'status' => 'required',
            'type' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $career->update([
                'title' => json_encode([
                    'en' => $request->title_en,
                    'id' => $request->title_id,
                ]),
                'description' => json_encode([
                    'en' => $request->desc_en,
                    'id' => $request->desc_id,
                ]),
                'slug' => $request->slug,
                'location' => $request->location,
                'salary_range' => $request->salary_range,
                'type' => $request->type,
                'status' => $request->status,
            ]);

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
