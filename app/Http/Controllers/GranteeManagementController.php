<?php

namespace App\Http\Controllers;

use App\Models\GranteeManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class GranteeManagementController extends Controller
{
    public function index(Request $request)
    {
        $grantees = $this->data($request);
        return Inertia::render('Grantee/Index', [
            'grantees' => $grantees
        ]);
    }

    public function data(Request $request)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $grantee = GranteeManagement::when($search, function ($q) use($search) {
            $q->whereRaw('LOWER(name) LIKE ?', '%'. $search .'%');
        })
        ->orderBy($sort, $order)
        ->paginate($perPage);

        return $grantee;
    }

    public function create()
    {
        return Inertia::render('Grantee/Create', [
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:grantee_management|email',
            'foundation' => 'required',
            'password' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $storeData = [
                'name' => $request->name,
                'email' => $request->email,
                'foundation' => $request->foundation,
                'password' => Hash::make($request->password),
            ];

            $grantee = GranteeManagement::create($storeData);

            DB::commit();

            return redirect(route('grantee.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(GranteeManagement $grantee)
    {
        return Inertia::render('Grantee/Edit', [
            'grantee' => [
                'id' => $grantee->id,
                'name' => $grantee->name,
                'email' => $grantee->email,
                'foundation' => $grantee->foundation,
            ],
        ]);
    }

    public function update(Request $request, GranteeManagement $grantee)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'foundation' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'foundation' => $request->foundation,
                'password' => Hash::make($grantee->password),
            ];

            $grantee->update($updateData);

            DB::commit();

            return redirect(route('grantee.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(GranteeManagement $grantee)
    {
        try {
            $grantee->delete();

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
