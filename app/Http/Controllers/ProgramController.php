<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Program;
use App\Models\ProgramCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProgramController extends Controller
{
   public function index(Request $request)
   {
       $programs = $this->data($request);
       return Inertia::render('Program/Index', [
           'programs' => $programs
       ]);
   }

   public function data(Request $request)
   {
       $search = $request->search;
       $perPage = $request->perPage ?? 10;
       $sort = $request->sort ?? 'id';
       $order = $request->order ?? 'desc';

       $newsStories = Program::when($search, function ($q) use($search) {
           $q->whereRaw('LOWER(title) LIKE ?', '%'. $search .'%');
       })
       ->orderBy($sort, $order)
       ->paginate($perPage);

       return $newsStories->setCollection(
           $newsStories->getCollection()->map(function ($new) {
               return [
                   ...$new->toArray(),
                   'title' => json_decode($new->title),
               ];
           })
       );
   }

   public function create()
   {
    $locations = Location::all()->map(function ($category) {
        $title = json_decode($category->title, true);
        return [
        'value' => $category->id, 
        'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id'] 
        ];
    });

      $categoriess = ProgramCategory::all()->map(function ($category) {
         $title = json_decode($category->title, true);
         return [
            'value' => $category->id, 
            'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id'] 
         ];
      });

      return Inertia::render('Program/Create', [
         'categories' => $categoriess,
         'locations' => $locations
      ]);
   }

   public function store(Request $request)
   {
       $request->validate([
           'title_id' => 'required|string|min:5',
           'title_en' => 'required|string|min:5',
           'description_en' => 'required',
           'description_id' => 'required',
           'location_id' => 'required',
           'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'unique:programs,slug',
            ],
           'sector' => 'required',
           'type' => 'required',
           'banner' => 'required_if:type,media|nullable|mimes:jpeg,png,jpg,webp',
           'youtube_link' => 'required_if:type,link|nullable|url',
           'program_category_id' => 'required',
           'document' => 'nullable|mimes:pdf,doc,docx|max:10124',
         ]);

       try {
           DB::beginTransaction();

           $storeData = [
               'title' => json_encode([
                   'en' => $request->title_en,
                   'id' => $request->title_id,
               ]),
               'description' => json_encode([
                   'en' => $request->description_en,
                   'id' => $request->description_id,
               ]),
               'implementing_partner' => $request->implementing_partner,
               'slug' => $request->slug,
               'sector' => $request->sector,
               'status' => 'draft',
               'location_id' => $request->location_id,
               'location' => $request->location,
               'start_date' => $request->start_date . '-01',
               'end_date' => Carbon::createFromFormat('Y-m', $request->end_date)->endOfMonth()->format('Y-m-d'),
               'program_category_id' => $request->program_category_id,
           ];

            if ($request->type == 'link') {
                  $storeData['youtube_link'] = $request->youtube_link;
            } else {
               if ($request->hasFile('banner')) {
                  $fileName = time() . '_' . $request->file('banner')->getClientOriginalName();
                  $filePath = Storage::disk('public')->putFileAs('/programs/banner/img', $request->file('banner'), $fileName);

                  $storeData['banner'] = asset('/storage/' . $filePath);
               } 
            }

            if ($request->hasFile('document')) {
                  $fileName = time() . '_' . $request->file('document')->getClientOriginalName();
                  $filePath = Storage::disk('public')->putFileAs('/programs/document', $request->file('document'), $fileName);

                  $storeData['document'] = asset('/storage/'. $filePath);
            }

           $program = Program::create($storeData);

           DB::commit();

           return redirect(route('program.index'));
       } catch (\Throwable $th) {
           DB::rollBack();

           dd($th->getMessage());

           throw ValidationException::withMessages([
               'error' => 'Something went wrong'
           ]);;
       }
   }

   public function edit(Program $program)
   {
        $categoriess = ProgramCategory::all()->map(function ($category) {
            $title = json_decode($category->title, true);
            return [
            'value' => $category->id, 
            'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id'] 
            ];
        });

        $locations = Location::all()->map(function ($category) {
            $title = json_decode($category->title, true);
            return [
            'value' => $category->id, 
            'label' => 'en : ' . $title['en'] . ' | ' . 'id : ' . $title['id'] 
            ];
        });
        
        return Inertia::render('Program/Edit', [
            'program' => [
                'id' => $program->id,
                'title' => json_decode($program->title, true),
                'description' => json_decode($program->description, true),
                'banner' => $program->banner,
                'implementing_partner' => $program->implementing_partner,
                'sector' => $program->sector,
                'location_id' => $program->location_id,
                'location' => $program->location,
                'start_date' => $program->start_date,
                'end_date' => $program->end_date,
                'youtube_link' => $program->youtube_link,
                'document' => $program->document,
                'status' => $program->status,
                'slug' => $program->slug,
                'program_category_id' => $program->program_category_id,
            ],
            'categories' => $categoriess,
            'locations' => $locations
        ]);
   }

   public function update(Request $request, Program $program)
   {
        if ($request->type == 'link') {
            $request->validate([
                'youtube_link' => 'required_if:type,link|url',
            ]);
        } 

       $request->validate([
           'title_id' => 'required|string|min:5',
           'title_en' => 'required|string|min:5',
           'description_en' => 'required',
           'description_id' => 'required',
           'location_id' => 'required',
           'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                // 'unique:programs,slug',
            ],
           'sector' => 'required',
           'banner' => 'required_if:type,img|nullable|mimes:jpeg,png,jpg,webp',
           'document' => 'nullable|mimes:pdf,doc,docx|max:10124',
           'program_category_id' => 'required',
       ]);

       try {
           DB::beginTransaction();

           $updateData = [
               'title' => json_encode([
                   'en' => $request->title_en,
                   'id' => $request->title_id,
               ]),
               'description' => json_encode([
                   'en' => $request->description_en,
                   'id' => $request->description_id,
               ]),
               'implementing_partner' => $request->implementing_partner,
               'slug' => $request->slug,
               'sector' => $request->sector,
               'status' => $request->status,
               'location' => $request->location,
               'location_id' => $request->location_id,
               'start_date' => $request->start_date,
               'end_date' => $request->end_date,
               'program_category_id' => $request->program_category_id,
           ];

            if ($request->type == 'link') {
                  $oldMediaPath = str_replace(url('/storage/'), '', $program->banner);

                  if (Storage::disk('public')->exists($oldMediaPath)) {
                     Storage::disk('public')->delete($oldMediaPath);
                  }
                  
                  $updateData['youtube_link'] = $request->youtube_link;
                  $updateData['banner'] = null;
            } else {
               if ($request->hasFile('banner')) {
                  $oldMediaPath = str_replace(url('/storage/'), '', $program->banner);

                  if (Storage::disk('public')->exists($oldMediaPath)) {
                     Storage::disk('public')->delete($oldMediaPath);
                  }
                  
                  $fileName = time() . '_' . $request->file('banner')->getClientOriginalName();
                  $filePath = Storage::disk('public')->putFileAs('/programs/banner/img', $request->file('banner'), $fileName);

                  $updateData['banner'] = asset('/storage/' . $filePath);
                  $updateData['youtube_link'] = null;
               } 
            }

            if ($request->hasFile('document')) {
                  $fileName = time() . '_' . $request->file('document')->getClientOriginalName();
                  $filePath = Storage::disk('public')->putFileAs('/programs/document', $request->file('document'), $fileName);

                  $updateData['document'] = asset('/storage/'. $filePath);
            }


           $program->update($updateData);

           DB::commit();

           return redirect(route('program.index'));
       } catch (\Throwable $th) {
           DB::rollBack();
           dd($th->getMessage());
           throw ValidationException::withMessages([
               'error' => 'Something went wrong'
           ]);
       }
   }

   public function destroy(Program $program)
   {
       try {
           if ($program->image) {
               $oldMediaPath = str_replace(url('/storage/'), '', $program->image);

               if (Storage::disk('public')->exists($oldMediaPath)) {
                   Storage::disk('public')->delete($oldMediaPath);
               }
           }

           $program->delete();

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
