<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = $this->data($request);

        return Inertia::render('Location/Index', [
            'locations' => $locations
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $locations =  Location::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        $locations->setCollection(
            $locations->getCollection()->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'title' => json_decode($cat->title, true),
                ];
            })
        );

        return $locations;
    }

    public function create()
    {
        return Inertia::render('Location/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|min:3|max:50',
            'title_id' => 'required|min:3|max:50',
            'top' => 'required|numeric|min:0.01',
            'left' => 'required|numeric|min:0.01',
            'address' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $location = Location::create([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'address' => $request->address,
                'top' => $request->top,
                'left' => $request->left,
                'created_by' => Auth::user()->id
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

    public function edit(Location $location)
    {
        return Inertia::render('Location/Edit', [
            'location' => [
                'id' => $location->id,
                'title' => json_decode($location->title, true),
                'address' => $location->address,
                'top' => $location->top,
                'left' => $location->left,
            ]
        ]);
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'title_en' => 'required|min:3|max:50',
            'title_id' => 'required|min:3|max:50',
            'top' => 'required',
            'left' => 'required',
            'address' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $location->update([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'address' => $request->address,
                'top' => $request->top,
                'left' => $request->left,
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

    public function destroy(Location $location)
    {
        try {
            $location->delete();

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
