<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class CvTemplateController extends Controller
{

    public function index(Request $request)
    {
       $columns = array_diff(
            Schema::getColumnListing((new CvTemplate)->getTable()),
            ['layout_schema', 'global_settings']
        );

        $templates = CvTemplate::select($columns)
            ->latest()
            ->get();

        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required'         => 'Nama template wajib diisi.',
            'thumbnail.required'    => 'Gambar preview wajib diupload.',
            'thumbnail.image'       => 'File harus berupa gambar (jpg, jpeg, png, webp).',
            'thumbnail.max'         => 'Ukuran gambar maksimal 2MB.',
            'category.required'     => 'Kategori wajib dipilih.',
            'type.required'         => 'Tipe akses (Free/Pro) wajib dipilih.',
            'layout_schema.required'  => 'Struktur Layout Builder tidak boleh kosong.',
            'layout_schema.json'      => 'Terjadi kesalahan pada format data Layout.',
            'global_settings.required'=> 'Setting Global tidak boleh kosong.',
            'global_settings.json'    => 'Terjadi kesalahan pada format data Settings.',
        ];

        $request->validate([
            'name'            => 'required|string|max:255',
            'thumbnail'       => 'required|image|max:2048|mimes:jpg,jpeg,png,webp', 
            'category'        => 'required|string',
            'type'            => 'required|in:free,pro',
            'layout_schema'   => 'required|json', 
            'global_settings' => 'required|json', 
        ], $messages);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        
        while (CvTemplate::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $path = $request->file('thumbnail')->store('templates', 'public');

        $tagsArray = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        $layoutArray = json_decode($request->layout_schema, true);
        $globalArray = json_decode($request->global_settings, true);

        CvTemplate::create([
            'name'            => $request->name,
            'slug'            => $slug,
            'description'     => $request->description,
            'thumbnail'       => $path,
            'category'        => $request->category,
            'type'            => $request->type,
            'tags'            => $tagsArray, 
            'layout_schema'   => $layoutArray, 
            'global_settings' => $globalArray, 
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil dibuat dan diterbitkan!');
    }

    public function edit($id)
    {
        $template = CvTemplate::findOrFail($id);
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = CvTemplate::findOrFail($id);
        
        $messages = [
            'name.required'             => 'Nama template wajib diisi.',
            'thumbnail.image'           => 'File harus berupa gambar (jpg, jpeg, png, webp).',
            'thumbnail.max'             => 'Ukuran gambar maksimal 2MB.',
            'category.required'         => 'Kategori wajib dipilih.',
            'type.required'             => 'Tipe akses (Free/Pro) wajib dipilih.',
            'layout_schema.required'    => 'Struktur Layout Canvas tidak boleh kosong.',
            'layout_schema.json'        => 'Terjadi kesalahan pada format data Layout.',
            'global_settings.required'  => 'Setting Font Global tidak boleh kosong.',
            'global_settings.json'      => 'Terjadi kesalahan pada format data Settings.',
        ];
        
        $request->validate([
            'name'            => 'required|string|max:255',
            'thumbnail'       => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'category'        => 'required|string',
            'type'            => 'required|in:free,pro',
            
            'layout_schema'   => 'required|json',
            'global_settings' => 'required|json',
        ], $messages);

        $dataToUpdate = [
            'name'        => $request->name,
            'description' => $request->description,
            'category'    => $request->category,
            'type'        => $request->type,
            'is_active'   => $request->has('is_active'),
        ];

        if ($request->name !== $template->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;

            while (CvTemplate::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $dataToUpdate['slug'] = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            if ($template->thumbnail) {
                Storage::disk('public')->delete($template->thumbnail);
            }
            $dataToUpdate['thumbnail'] = $request->file('thumbnail')->store('templates', 'public');
        }

        if ($request->has('tags')) {
            $dataToUpdate['tags'] = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        }

        if ($request->filled('layout_schema')) {
            $dataToUpdate['layout_schema'] = json_decode($request->layout_schema, true);
        }

        if ($request->filled('global_settings')) {
            $dataToUpdate['global_settings'] = json_decode($request->global_settings, true);
        }

        $template->update($dataToUpdate);

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $template = CvTemplate::findOrFail($id);
        
        if ($template->thumbnail) {
            Storage::disk('public')->delete($template->thumbnail);
        }
        
        $template->delete();

        return redirect()->back()->with('success', 'Template berhasil dihapus!');
    }
}