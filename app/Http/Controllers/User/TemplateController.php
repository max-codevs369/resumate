<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\{CvTemplate, Resume};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TemplateController extends Controller
{
    public function index()
    {   
        $user = Auth::user();

        if(Auth::check()){
            if ($user->role === 'admin') {
                return abort(404);
            }
        }

        $columns = array_diff(
            Schema::getColumnListing((new CvTemplate)->getTable()),
            ['layout_schema', 'global_settings']
        );

        $templates = CvTemplate::where('is_active', true)->select($columns)->latest()->get();

        return view('pages.templates', compact('templates'));
    }

    public function detail($slug)
    {
        $user = Auth::user();

        if(Auth::check()){
            if ($user->role === 'admin') {
                return abort(404);
            }
        }

        $template = CvTemplate::where('slug', $slug)->firstOrFail();

        if (!$template || !$template->is_active) {
            abort(404);
        }

        if($template->type === 'pro' && (!Auth::check() || $template->type === 'pro' && (Auth::check() && $user->is_premium == 0))) {
            return abort(404);
        }

        return view('pages.resume.template-detail', compact('template'));
    }

    public function editor($slug)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return abort(404);
        }

        $template = CvTemplate::where('is_active', true)->where('slug', $slug)->firstOrFail();

        if ($template->type === 'pro') {
            if (!Auth::check() || Auth::user()->is_premium == 0) {
                return abort(404); 
            }
        }

        $resume = new Resume();
        $resume->cv_template_id = $template->id;
        $resume->user_id = Auth::check() ? Auth::id() : null; 
        
        $resume->layout_schema = $template->layout_schema;
        $resume->global_settings = $template->global_settings;


        $resume->setRelation('template', $template);

        return view('pages.resume.editor', compact('resume'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'cv_template_id'  => 'required|exists:cv_templates,id',
            'layout_schema'   => 'required|array',
            'global_settings' => 'nullable|array',
            'status'          => 'required|in:draft,completed',
            'title'           => 'nullable|string|max:255',
        ], [
            'cv_template_id.required' => 'Template tidak boleh kosong.',
            'cv_template_id.exists'   => 'Template yang dipilih tidak valid.',
            'layout_schema.required'  => 'Layout schema tidak boleh kosong.',
            'layout_schema.array'     => 'Layout schema harus berupa array.',
            'global_settings.array'   => 'Global settings harus berupa array.',
            'status.required'        => 'Status tidak boleh kosong.',
            'status.in'              => 'Status harus bernilai draft atau completed.',
            'title.string'           => 'Title harus berupa string.',
            'title.max'              => 'Title maksimal 255 karakter.',
        ]);

        if ($request->filled('resume_id')) {
            $resume = Resume::findOrFail($request->resume_id);
            
            if (Auth::check()) {
                if ($resume->user_id !== Auth::id()) {
                    return abort(403);
                }
            } else {
                if (session('guest_resume_id') != $resume->id) {
                    return abort(403);
                }
            }

        } else {
            $resume = new Resume();
            $resume->cv_template_id = $request->cv_template_id;
            $resume->user_id = Auth::check() ? Auth::id() : null; 
        }

        $resume->title = $request->input('title', 'Untitled Resume');
        $resume->layout_schema = $request->layout_schema;
        $resume->global_settings = $request->global_settings ?? [];
        $resume->status = $request->status;
        $resume->save();

        if (!Auth::check()) {
            session(['guest_resume_id' => $resume->id]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Resume berhasil disimpan.',
            'resume_id' => $resume->id
        ]);
    }

    public function editResume($id)
    {
        $resume = Resume::with('template')->findOrFail($id);

        if (!Auth::check() || $resume->user_id !== Auth::id()) {
            return abort(404);
        }

        return view('pages.resume.editor', compact('resume'));
    }

    public function incrementDownload($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $resume = Resume::with('template')->findOrFail($id);

                $resume->increment('downloads');

                if ($resume->template) {
                    $resume->template->increment('total_downloads');
                }
            });

            return response()->json(['success' => true, 'message' => 'Statistik diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function renderView($id)
    {
        $resume = Resume::with('template')->findOrFail($id);

        if (Auth::check() && $resume->user_id !== Auth::id()) {
            abort(404);
        }

        return view('pages.resume.render', compact('resume'));
    }

    public function submitRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $resume = Resume::findOrFail($id);

        $resume->rating = $request->rating;
        $resume->save();

        if ($resume->cv_template_id) {
            $template = CvTemplate::find($resume->cv_template_id);
            
            if ($template) {
                $stats = Resume::where('cv_template_id', $template->id)
                    ->whereNotNull('rating')
                    ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total_count')
                    ->first();

                $template->update([
                    'average_rating' => round($stats->avg_rating, 1),
                    'rating_count' => $stats->total_count
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil disimpan!'
        ]);
    }
}
