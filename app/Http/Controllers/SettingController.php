<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return Inertia::render('Setting/Index', [
            'setting' => [
                ...$setting->toArray(),
                'footer_notes' => json_decode($setting->footer_notes, true),
                'cta_title' => json_decode($setting->cta_title, true),
            ]
        ]);
    }

    public function update(Request $request, Setting $setting)
    {
        $request->all();

        $request->validate([
            'title' => 'required',
            'email' => 'sometimes|nullable|email',
            'phone_no' => 'sometimes|nullable',
            'favicon' => 'sometimes|nullable|mimes:jpeg,png,jpg|max:1024',
            'logo' => 'sometimes|nullable|mimes:jpeg,png,jpg|max:1024',
            'instagram_url' => 'sometimes|nullable|url',
            'facebook_url' => 'sometimes|nullable|url',
            'linkedin_url' => 'sometimes|nullable|url',
            'x_url' => 'sometimes|nullable|url',
            'tiktok_url' => 'sometimes|nullable|url',
            'youtube_url' => 'sometimes|nullable|url',
            'location' => 'sometimes|nullable|string',
            'gmap_url' => 'sometimes|nullable|url',
            'footer_notes_en' => 'sometimes|nullable',
            'footer_notes_id' => 'sometimes|nullable',
        ]);

        $filePathFavIcon = null;
        $filePathLogo = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('favicon')) {
                $oldImagePath = str_replace(url('/storage/'), '', $setting->favicon);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $fileName = time() . '-favicon_' . $request->file('favicon')->getClientOriginalName();
                $filePathFavIcon = Storage::disk('public')->putFileAs('/setting', $request->file('favicon'), $fileName);

                $setting->update([
                    'favicon' => asset('/storage/' . $filePathFavIcon)
                ]);
            }
            if ($request->hasFile('logo')) {
                $oldImagePath = str_replace(url('/storage/'), '', $setting->logo);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $fileName = time() . '-logo_' . $request->file('logo')->getClientOriginalName();
                $filePathLogo = Storage::disk('public')->putFileAs('/setting', $request->file('logo'), $fileName);

                $setting->update([
                    'logo' => asset('/storage/'. $filePathLogo),
                ]);
            }
            $setting->update([
                'title' => $request->title,
                'instagram_url' => $request->instagram_url,
                'facebook_url' => $request->facebook_url,
                'linkedin_url' => $request->linkedin_url,
                'x_url' => $request->x_url,
                'tiktok_url' => $request->tiktok_url,
                'youtube_url' => $request->youtube_url,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'location' => $request->location,
                'gmap_url' => $request->gmap_url,
                'footer_notes' => json_encode([
                    'en' => $request->footer_notes_en,
                    'id' => $request->footer_notes_id,
                ]),
            ]);

            DB::commit();

            return back()->with('success', 'Setting updated successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Password updated successfully!');
        }
    }

    public function updateCta(Request $request, Setting $setting)
    {
        $request->validate([
            'cta_title_en' => 'required',
            'cta_title_id' => 'required',
            'cta_link' => 'required|url',
        ]);

        try {
            DB::beginTransaction();

            $setting->update([
                'cta_title' => json_encode([
                    'en' => $request->cta_title_en,
                    'id' => $request->cta_title_id,
                ]),
                'cta_link' => $request->cta_link
            ]);

            DB::commit();

            return back()->with('success', 'Setting CTA updated successfully!');

        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Setting failed to update');
        }
    }

    public function toggleShowSection(Setting $setting, $section)
    {
        $setting->update([
            $section => !$setting->$section
        ]);

        return back()->with('success', 'Setting updated successfully!');
    }
}
