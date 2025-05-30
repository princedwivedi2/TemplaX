<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BusinessCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        $cards = Auth::user()->hasRole('super-admin')
            ? BusinessCard::with('user')->get()
            : BusinessCard::where('user_id', Auth::id())->get();

        return view('cards.index', compact('cards'));
    }

    public function create_card()
    {
        $templates = Template::getAvailableTemplates();
        return view('cards.create', compact('templates'));
    }

    public function store(Request $request)
    {
        try {
            // Base validation rules with color regex validation
            $rules = [
                'full_name' => 'required|string|max:255',
                'job_title' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'company_name' => 'required|string|max:255',
                'website' => 'nullable|url|max:255',
                'address' => 'nullable|string|max:500',
                'linkedin' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'template' => 'required|string|exists:templates,slug',
                'primary_color' => 'required|string|max:7',
                'accent_color' => 'required|string|max:7',
                'logo' => 'nullable|image|mimes:jpeg,png|max:2048'
            ];

            // Add user_id validation for super admin
            if (Auth::user()->hasRole('super-admin')) {
                $rules['user_id'] = 'required|exists:users,id';
            }

            $validated = $request->validate($rules);

            $data = collect($validated)->except('logo')->toArray();

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
                }                // Save the card
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
    {
        // Check if the user is authorized to view this card
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cards.show', compact('card'));
    }

    public function edit(BusinessCard $card)
    {
        // Check if the user is authorized to edit this card
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cards.edit', compact('card'));
    }

    public function update(Request $request, BusinessCard $card)
    {
        // Check if the user is authorized to update this card
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
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
            'template' => 'required|string|exists:templates,slug',
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
    {
        // Check if the user is authorized to delete this card
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

    /**
     * Clean up temporary logo files older than 1 hour
     */
    private function cleanupTempLogos()
    {
        $tempDir = storage_path('app/public/temp-logos');
        if (!is_dir($tempDir)) {
            return;
        }

        $files = glob($tempDir . '/*');
        $oneHourAgo = time() - 3600;

        foreach ($files as $file) {
            if (is_file($file) && filemtime($file) < $oneHourAgo) {
                unlink($file);
            }
        }
    }
}
