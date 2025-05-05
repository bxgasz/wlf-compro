<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ContentTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = $this->data($request);

        return Inertia::render('ContentType/Index', [
            'types' => $types
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $types =  ContentType::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        $types->setCollection(
            $types->getCollection()->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'title' => json_decode($cat->title, true),
                    'description' => json_decode($cat->description, true),
                ];
            })
        );

        return $types;
    }

    public function create()
    {
        return Inertia::render('ContentType/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $type = ContentType::create([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
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

    public function edit(ContentType $content_type)
    {
        return Inertia::render('ContentType/Edit', [
            'type' => [
                'id' => $content_type->id,
                'title' => json_decode($content_type->title, true),
                'description' => json_decode($content_type->description, true),
            ]
        ]);
    }

    public function update(Request $request, ContentType $content_type)
    {
        $request->validate([
            'title_en' => 'required|min:6|max:50',
            'title_id' => 'required|min:6|max:50',
            'desc_en' => 'required',
            'desc_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $content_type->update([
                'title' => json_encode([ 'en' => $request->title_en, 'id' => $request->title_id ]),
                'description' => json_encode([ 'en' => $request->desc_en, 'id' => $request->desc_id ]),
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

    public function destroy(ContentType $content_type)
    {
        // if ($content_type->news()->exists()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'There is data related to this content_type'
        //     ], 400);
        // }

        try {
            $content_type->delete();

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
