<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $organization = Organization::first();

        return Inertia::render('Organization/Index', [
            'organization' => $organization
        ]);
    }

    public function update(Request $request)
    {
        ini_set('memory_limit', '512M');
        
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg|max:1536',
        ]);

        $organization = Organization::first();

        try {
            DB::beginTransaction();

            if ($request->has('image')) {
                if ($organization != null) {
                    $oldMediaPath = str_replace(url('/storage/'), '', $organization->image);

                    if (Storage::disk('public')->exists($oldMediaPath)) {
                        Storage::disk('public')->delete($oldMediaPath);
                    }
                }
                
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();

                $filePath = Storage::disk('public')->putFileAs('/organization', $request->image, $fileName);

                if ($organization != null) {
                    $organization->update([
                        'image' => asset('/storage/' . $filePath),
                    ]);
                } else {
                    Organization::create([
                        'image' => asset('/storage/' . $filePath),
                    ]);
                }
    
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }
}
