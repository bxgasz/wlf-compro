<?php

namespace App\Http\Controllers;

use App\Models\OurImpact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class OurImpactController extends Controller
{
    public function index()
    {
        $our_impact = OurImpact::first();
        return Inertia::render('OurImpact/Index', [
            'our_impact' => [
                'id' => $our_impact->id ?? null,
                'title_1' => json_decode($our_impact->title_1 ?? null) ?? null,
                'subtitle_1' => json_decode($our_impact->subtitle_1 ?? null) ?? null,
                'title_2' => json_decode($our_impact->title_2 ?? null) ?? null,
                'subtitle_2' => json_decode($our_impact->subtitle_2 ?? null) ?? null,
                'title_3' => json_decode($our_impact->title_3 ?? null) ?? null,
                'subtitle_3' => json_decode($our_impact->subtitle_3 ?? null) ?? null,
                'title_4' => json_decode($our_impact->title_4 ?? null) ?? null,
                'subtitle_4' => json_decode($our_impact->subtitle_4 ?? null) ?? null,
                'sdg_title' => json_decode($our_impact->sdg_title ?? null) ?? null,
                'image' => $our_impact->image ?? null,
                'sub_icons' => json_decode($our_impact->sub_icons ?? null, true) ?? null
            ]
        ]);
    }

    public function updateOrCreate(Request $request, $id = null)
    {
        ini_set('memory_limit', '512M');
        
        $setting = OurImpact::find($id);

        if (!$setting) {
            $setting = new OurImpact();

            $request->validate([
                'title_1_en' => 'required|min:6|max:70',
                'title_1_id' => 'required|min:6|max:70',
                'subtitle_1_en' => 'required|min:6|max:70',
                'subtitle_1_id' => 'required|min:6|max:70',
                'title_2_en' => 'required|min:6|max:70',
                'title_2_id' => 'required|min:6|max:70',
                'subtitle_2_en' => 'required|min:6|max:70',
                'subtitle_2_id' => 'required|min:6|max:70',
                'title_3_en' => 'required|min:6|max:70',
                'title_3_id' => 'required|min:6|max:70',
                'subtitle_3_en' => 'required|min:6|max:70',
                'subtitle_3_id' => 'required|min:6|max:70',
                'title_4_en' => 'required|min:6|max:70',
                'title_4_id' => 'required|min:6|max:70',
                'subtitle_4_en' => 'required|min:6|max:70',
                'subtitle_4_id' => 'required|min:6|max:70',
                'sdg_title_en' => 'required|string',
                'sdg_title_id' => 'required|string',
                'image' => 'required|mimes:jpeg,png,jpg,webp|max:2000',
                // 'sub_icons' => 'required|array|min:1',
                // 'sub_icons.*.icon' => 'required|mimes:jpeg,png,jpg,webp,svg|max:500',
                // 'sub_icons.*.text_en' => 'required|string|max:50',
                // 'sub_icons.*.text_id' => 'required|string|max:50',
            ]);
        }

        $request->validate([
            'title_1_en' => 'required|min:6|max:70',
            'title_1_id' => 'required|min:6|max:70',
            'subtitle_1_en' => 'required|min:6|max:70',
            'subtitle_1_id' => 'required|min:6|max:70',
            'title_2_en' => 'required|min:6|max:70',
            'title_2_id' => 'required|min:6|max:70',
            'subtitle_2_en' => 'required|min:6|max:70',
            'subtitle_2_id' => 'required|min:6|max:70',
            'title_3_en' => 'required|min:6|max:70',
            'title_3_id' => 'required|min:6|max:70',
            'subtitle_3_en' => 'required|min:6|max:70',
            'subtitle_3_id' => 'required|min:6|max:70',
            'title_4_en' => 'required|min:6|max:70',
            'title_4_id' => 'required|min:6|max:70',
            'subtitle_4_en' => 'required|min:6|max:70',
            'subtitle_4_id' => 'required|min:6|max:70',
            'sdg_title_en' => 'required|string',
            'sdg_title_id' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:2000',
            // 'sub_icons' => 'required|array|min:1',
            // 'sub_icons.*.icon' => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:500',
            // 'sub_icons.*.text_en' => 'required|string|max:50',
            // 'sub_icons.*.text_id' => 'required|string|max:50',
        ]);

        try {
            DB::beginTransaction();
                
            if ($request->hasFile('image')) {
                if ($setting->image) {
                    $oldImagePath = str_replace(asset('/storage/'), '', $setting->image);
                    Storage::disk('public')->delete($oldImagePath);
                }
                
                $fileName = time() . '-impact_' . $request->file('image')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/impact', $request->file('image'), $fileName);

                $setting->update([
                    'impact' => asset('/storage/'. $filePath),
                ]);
                
                $setting->image = asset('/storage/' . $filePath);
            }
        
            // $oldSubIcons = json_decode($setting->sub_icons, true) ?? [];
            // $subIcons = [];
            // foreach ($request->sub_icons as $index => $subIcon) {
            //     if (isset($subIcon['icon']) && $request->hasFile("sub_icons.$index.icon")) {
            //         if (!empty($oldSubIcons[$index]['icon'] ?? null)) {
            //             $oldIconPath = str_replace(asset('/storage/'), '', $oldSubIcons[$index]['icon']);
            //             Storage::disk('public')->delete($oldIconPath);
            //         }
        
            //         $subIconFileName = time() . "_subicon_{$index}_" . $subIcon['icon']->getClientOriginalName();
            //         $subIconFilePath = Storage::disk('public')->putFileAs('/our_impacts/sub_icons', $subIcon['icon'], $subIconFileName);
        
            //         $subIcons[] = [
            //             'icon' => asset('/storage/' . $subIconFilePath),
            //             'text' => [
            //                 'en' => $subIcon['text_en'],
            //                 'id' => $subIcon['text_id'],
            //             ],
            //         ];
            //     } else {
            //         $subIcons[] = [
            //             'icon' => $oldSubIcons[$index]['icon'],
            //             'text' => [
            //                 'en' => $subIcon['text_en'],
            //                 'id' => $subIcon['text_id'],
            //             ],
            //         ];
            //     }
            // }
        
            for ($i = 1; $i < 5; $i++) {
                $key = 'title_' . $i;
                $setting->$key = json_encode([
                    'en' => $request->{'title_' . $i . '_en'},
                    'id' => $request->{'title_' . $i . '_id'},
                ]);

                $key2 = 'subtitle_' . $i;
                $setting->$key2 = json_encode([
                    'en' => $request->{'subtitle_' . $i . '_en'},
                    'id' => $request->{'subtitle_' . $i . '_id'},
                ]);
            }

            $setting->sdg_title = json_encode([
                'en' => $request->sdg_title_en,
                'id' => $request->sdg_title_id,
            ]);

            // $setting->sub_icons = json_encode($subIcons);
    
            $setting->save();
    
            DB::commit();
        
            return back()->with('success', 'Data updated successfully');
        
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }        
    }
}
