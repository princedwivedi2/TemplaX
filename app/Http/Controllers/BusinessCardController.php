<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BusinessCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // For methods that need verified email
        $this->middleware('verified')->only(['store', 'update', 'destroy']);
    }    public function index()
    {
        $cards = Auth::user()->hasRole('super-admin') 
            ? BusinessCard::with('user')->get() // Super admin can see all cards
            : BusinessCard::where('user_id', Auth::id())->get(); // Others see only their cards
        
        return view('cards.index', compact('cards'));
    }

  public function create_card()
{
    $templates = ['modern', 'classic', 'minimal'];
    return view('cards.create', compact('templates'));
}

       public function store(Request $request)
    {
        try {
            // Base validation rules with color regex validation
            $rules = [
                'full_name' => 'required|string|max:255',
                'roles' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'company_name' => 'required|string|max:255',
                'website' => 'nullable|url|max:255',
                'address' => 'nullable|string|max:500',
                'linkedin' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'template' => 'required|string|in:modern,classic,minimal',
                'logo' => 'nullable|image|mimes:jpeg,png|max:2048'
            ];
            
            // Add user_id validation for super admin
            if (Auth::user()->hasRole('super-admin')) {
                $rules['user_id'] = 'required|exists:users,id';
            }
            
            $validated = $request->validate($rules);$data = collect($validated)->except('logo')->toArray();
            
            // Allow super admin to create cards for other users
            $data['user_id'] = Auth::user()->hasRole('super-admin') && $request->has('user_id') 
                ? $request->user_id 
                : Auth::id();
                
            $data['card_id'] = Str::uuid();

            try {
                // Handle logo upload if present
                if ($request->hasFile('logo')) {
                    $path = $request->file('logo')->store('card-logos', 'public');
                    if (!$path) {
                        throw new \Exception('Failed to upload logo file');
                    }
                    $data['logo_path'] = $path;
                }

                // Save the card
                $card = BusinessCard::create($data);

                return response()->json([
                    'success' => true,
                    'message' => 'Business card created successfully!',
                    'data' => $card
                ]);
            } catch (\Exception $e) {
                // If logo was uploaded but card creation failed, remove the logo
                if (isset($path)) {
                    Storage::disk('public')->delete($path);
                }
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create business card',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(BusinessCard $card)
    {        // Check if the user is authorized to view this card
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cards.show', compact('card'));
    }

    public function edit(BusinessCard $card)
    {        // Check if the user is authorized to edit this card
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cards.edit', compact('card'));
    }

    public function update(Request $request, BusinessCard $card)
    {
        // Check if the user is authorized to update this card
        if ($card->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'template' => 'required|string|in:modern,classic,minimal',
            'primary_color' => 'required|string|max:7',
            'accent_color' => 'required|string|max:7',
            'logo' => 'nullable|image|mimes:jpeg,png|max:2048'
        ]);

        try {
            $data = $request->except(['_token', '_method', 'logo']);

            // Handle logo upload if present
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($card->logo_path) {
                    Storage::disk('public')->delete($card->logo_path);
                }
                
                $logoPath = $request->file('logo')->store('card-logos', 'public');
                $data['logo_path'] = $logoPath;
            }

            // Update the card
            $card->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Business card updated successfully!',
                'data' => $card
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update business card',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(BusinessCard $card)
    {        // Check if the user is authorized to delete this card
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            // Delete logo if exists
            if ($card->logo_path) {
                Storage::disk('public')->delete($card->logo_path);
            }

            $card->delete();

            return response()->json([
                'success' => true,
                'message' => 'Business card deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete business card',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function download(BusinessCard $card)
    {
      
        // You could generate a PDF here using a library like dompdf
        
        return response()->json([
            'success' => true,
            'message' => 'Card download functionality will be implemented here',
            'data' => $card
        ]);
    }

  public function previewTemplate(Request $request)
{
    // Validate optional color formats
    $request->validate([
        'primary_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        'accent_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        'template' => 'required|in:modern,classic,minimal'
    ]);

    $logoUrl = null;
    if ($request->hasFile('logo')) {
        try {
            $file = $request->file('logo');
            $tmpPath = $file->store('temp-logos', 'public');
            $logoUrl = asset('storage/' . $tmpPath);
        } catch (\Exception $e) {
            \Log::error('Logo upload failed for preview: ' . $e->getMessage());
            $logoUrl = null;
        }
    }

    // Clean up old temp logos occasionally
    try {
        $this->cleanupTempLogos();
    } catch (\Exception $e) {
        \Log::error('Failed to cleanup temp logos: ' . $e->getMessage());
    }

    // Extract template name (modern, classic, minimal)
    $template = $request->input('template', 'modern');

    // Dynamically load Blade template from resources/views/templates/{template}.blade.php
    return view('templates.' . $template, [
        'full_name'      => $request->input('full_name'),
        'job_title'      => $request->input('job_title'),
        'company_name'   => $request->input('company_name'),
        'email'          => $request->input('email'),
        'phone'          => $request->input('phone'),
        'website'        => $request->input('website'),
        'address'        => $request->input('address'),
        'linkedin'       => $request->input('linkedin'),
        'twitter'        => $request->input('twitter'),
        'logoUrl'        => $logoUrl,
        'primary_color'  => $request->input('primary_color', '#000000'),
        'accent_color'   => $request->input('accent_color', '#333333'),
    ]);
}

 
}
