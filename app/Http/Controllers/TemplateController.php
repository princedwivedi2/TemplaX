<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|super-admin');
    }

    /**
     * Display a listing of templates.
     */
    public function index()
    {
        $templates = Template::with('creator')
            ->withCount('businessCards')
            ->ordered()
            ->get();

        return view('templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        return view('templates.create');
    }

    /**
     * Store a newly created template.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:templates,slug',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|in:business,personal,creative',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->except(['preview_image']);
        $data['created_by'] = Auth::id();
        $data['slug'] = Str::slug($request->slug);

        // Handle preview image upload
        if ($request->hasFile('preview_image')) {
            $path = $request->file('preview_image')->store('template-previews', 'public');
            $data['preview_image'] = $path;
        }

        $template = Template::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Template created successfully!',
            'data' => $template
        ]);
    }

    /**
     * Display the specified template.
     */
    public function show(Template $template)
    {
        $template->load(['creator', 'businessCards']);
        return view('templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(Template $template)
    {
        return view('templates.edit', compact('template'));
    }

    /**
     * Update the specified template.
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('templates')->ignore($template->id)],
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|in:business,personal,creative',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->except(['preview_image']);
        $data['slug'] = Str::slug($request->slug);

        // Handle preview image upload
        if ($request->hasFile('preview_image')) {
            // Delete old image if exists
            if ($template->preview_image) {
                Storage::disk('public')->delete($template->preview_image);
            }

            $path = $request->file('preview_image')->store('template-previews', 'public');
            $data['preview_image'] = $path;
        }

        $template->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Template updated successfully!',
            'data' => $template
        ]);
    }

    /**
     * Remove the specified template.
     */
    public function destroy(Template $template)
    {
        // Check if template is in use
        if ($template->isInUse()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete template that is currently in use by business cards.'
            ], 422);
        }

        // Delete preview image if exists
        if ($template->preview_image) {
            Storage::disk('public')->delete($template->preview_image);
        }

        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully!'
        ]);
    }

    /**
     * Toggle template active status.
     */
    public function toggleStatus(Template $template)
    {
        $template->update(['is_active' => !$template->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Template status updated successfully!',
            'is_active' => $template->is_active
        ]);
    }

    /**
     * Get available templates for API/AJAX calls.
     */
    public function getAvailable()
    {
        $templates = Template::active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => $templates->map(function ($template) {
                return $template->config;
            })
        ]);
    }

    /**
     * Preview a template with sample data.
     */
    public function preview(Template $template)
    {
        $sampleData = [
            'full_name' => 'John Doe',
            'job_title' => 'Software Engineer',
            'company_name' => 'Tech Company',
            'email' => 'john@example.com',
            'phone' => '+1 234 567 8900',
            'website' => 'www.example.com',
            'address' => '123 Main St, City',
            'linkedin' => 'linkedin.com/in/johndoe',
            'twitter' => 'twitter.com/johndoe',
            'logoUrl' => null
        ];

        return view($template->view_path, $sampleData);
    }
}
