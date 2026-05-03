<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function confirm(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking dikonfirmasi.');
    }

    public function editSiteContent()
    {
        $site = SiteContent::current();

        return view('admin.site-content', compact('site'));
    }

    public function updateSiteContent(Request $request)
    {
        $site = SiteContent::current();

        $request->validate([
            'hero_badge' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'hero_primary_cta_text' => ['nullable', 'string', 'max:100'],
            'hero_primary_cta_link' => ['nullable', 'string', 'max:255'],
            'hero_secondary_cta_text' => ['nullable', 'string', 'max:100'],
            'hero_secondary_cta_link' => ['nullable', 'string', 'max:255'],
            'hero_highlight_1' => ['nullable', 'string', 'max:255'],
            'hero_highlight_2' => ['nullable', 'string', 'max:255'],
            'hero_highlight_3' => ['nullable', 'string', 'max:255'],
            'about_text' => ['nullable', 'string'],
            'extra_info' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:5120'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer', 'min:0'],
        ]);

        $site->fill($request->only([
            'hero_badge',
            'hero_title',
            'hero_subtitle',
            'hero_description',
            'hero_primary_cta_text',
            'hero_primary_cta_link',
            'hero_secondary_cta_text',
            'hero_secondary_cta_link',
            'hero_highlight_1',
            'hero_highlight_2',
            'hero_highlight_3',
            'about_text',
            'extra_info',
        ]));

        if ($request->hasFile('hero_image')) {
            if ($site->hero_image) {
                Storage::disk('public')->delete($site->hero_image);
            }
            $site->hero_image = $request->file('hero_image')->store('site', 'public');
        }

        $gallery = collect($site->gallery_images ?? []);

        if ($request->filled('remove_gallery')) {
            $indices = collect($request->input('remove_gallery'))
                ->map(fn ($i) => (int) $i)
                ->sortDesc()
                ->values();

            foreach ($indices as $index) {
                $path = $gallery->get($index);
                if ($path) {
                    Storage::disk('public')->delete($path);
                    $gallery->forget($index);
                }
            }
            $gallery = $gallery->values();
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $gallery->push($file->store('site/gallery', 'public'));
                }
            }
        }

        $site->gallery_images = $gallery->all();
        $site->save();

        return back()->with('success', 'Konten situs berhasil diperbarui.');
    }
}
