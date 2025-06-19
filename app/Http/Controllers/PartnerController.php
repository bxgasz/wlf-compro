<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $partners = $this->data($request, 'partner');
        return Inertia::render('Partner/Index', [
            'partners' => $partners
        ]);
    }

    public function indexGrantee(Request $request)
    {
        $partners = $this->data($request, 'grantee');
        return Inertia::render('PartnerGrantee/Index', [
            'partners' => $partners
        ]);
    }

    public function data(Request $request, $type)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $partner = Partner::when($search, function ($q) use($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })
        ->where('type', $type)
        ->orderBy($sort, $order)
        ->paginate($perPage);

        return $partner->setCollection(
            $partner->getCollection()->map(function ($new) {
                return [
                    ...$new->toArray(),
                    'description' => json_decode($new->description, true),
                ];
            })
        );
    }

    public function create()
    {
        return Inertia::render('Partner/Create', [
        ]);
    }
    

    public function createGrantee()
    {
        return Inertia::render('PartnerGrantee/Create', [
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description_en' => 'required',
            'description_id' => 'required',
            'link' => 'required|url',
            'logo' => 'required|mimes:jpeg,png,jpg,webp|max:1584',
            'type' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $storeData = [
                'title' => $request->title,
                'link' => $request->link,
                'description' => json_encode([
                    'en' => $request->description_en,
                    'id' => $request->description_id,
                ]),
                'type' => $request->type
            ];

            if ($request->hasFile('logo')) {
                $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/partner/img', $request->file('logo'), $fileName);

                $storeData['logo'] = asset('/storage/'. $filePath);
            }

            $partner = Partner::create($storeData);

            DB::commit();

            return redirect(route('partner.index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function edit(Partner $partner)
    {
        return Inertia::render('Partner/Edit', [
            'partner' => [
                'id' => $partner->id,
                'title' => $partner->title,
                'logo' => $partner->logo,
                'link' => $partner->link,
                'type' => $partner->type,
                'description' => json_decode($partner->description, true),
            ],
        ]);
    }

    public function editGrantee(Partner $partner)
    {
        return Inertia::render('PartnerGrantee/Edit', [
            'partner' => [
                'id' => $partner->id,
                'title' => $partner->title,
                'logo' => $partner->logo,
                'link' => $partner->link,
                'type' => $partner->type,
                'description' => json_decode($partner->description, true),
            ],
        ]);
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'title' => 'required|string',
            'description_en' => 'required',
            'description_id' => 'required',
            'link' => 'required|url',
            'logo' => 'nullable|mimes:jpeg,png,jpg,webp|max:1584',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => $request->title,
                'link' => $request->link,
                'description' => json_encode([
                    'en' => $request->description_en,
                    'id' => $request->description_id,
                ]),
            ];

            if ($request->hasFile('logo')) {
                $oldMediaPath = str_replace(url('/storage/'), '', $partner->logo);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }

                $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $filePath = '';
                $filePath = Storage::disk('public')->putFileAs('/partner/img', $request->file('logo'), $fileName);

                $updateData['logo'] = asset('/storage/'. $filePath);
            }

            $partner->update($updateData);

            DB::commit();

            return redirect(route('partner.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(Partner $partner)
    {
        try {
            if ($partner->logo) {
                $oldMediaPath = str_replace(url('/storage/'), '', $partner->logo);

                if (Storage::disk('public')->exists($oldMediaPath)) {
                    Storage::disk('public')->delete($oldMediaPath);
                }
            }

            $partner->delete();

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
