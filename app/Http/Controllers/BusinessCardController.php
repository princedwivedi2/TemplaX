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
            // Base validation rules
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
                'logo' => 'nullable|image|mimes:jpeg,png|max:2048'
            ];

            // Add user_id validation for super admin
            if (Auth::user()->hasRole('super-admin')) {
                $rules['user_id'] = 'sometimes';
            }

            $validated = $request->validate($rules);

            // Prepare data for saving
            $data = [
                'full_name' => $validated['full_name'],
                'job_title' => $validated['job_title'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company_name' => $validated['company_name'],
                'website' => $validated['website'] ?? null,
                'address' => $validated['address'] ?? null,
                'linkedin' => $validated['linkedin'] ?? null,
                'twitter' => $validated['twitter'] ?? null,
                'template' => $validated['template'],
                'user_id' => Auth::user()->hasRole('super-admin') && $request->has('user_id')
                    ? $request->user_id
                    : Auth::id(),
                'card_id' => Str::uuid(),
                'status' => 'active'
            ];

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

                // Always return JSON for AJAX requests
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Business card created successfully!',
                        'data' => [
                            'id' => $card->id,
                            'card_id' => $card->card_id
                        ]
                    ]);
                }

                return redirect()->route('cards.preview', ['id' => $card->id])
                    ->with('success', 'Business card created successfully!');

            } catch (\Exception $e) {
                // If logo was uploaded but card creation failed, remove the logo
                if (isset($path)) {
                    Storage::disk('public')->delete($path);
                }
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create business card',
                    'error' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to create business card: ' . $e->getMessage())->withInput();
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

    /**
     * Show the A4 preview page for the card
     */
    public function a4Preview(BusinessCard $card)
    {
        // Only allow owner or super-admin
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
            abort(403);
        }
        return view('cards.a4-preview', compact('card'));
    }

    public function preview($id)
    {
        $card = BusinessCard::findOrFail($id);
        
        // Ensure user owns this card
        if (!Auth::user()->hasRole('super-admin') && $card->user_id !== Auth::id()) {
            abort(403);
        }

        // Prepare data for the template
        $data = [
            'full_name' => $card->full_name,
            'job_title' => $card->job_title,
            'company_name' => $card->company_name,
            'email' => $card->email,
            'phone' => $card->phone,
            'website' => $card->website,
            'address' => $card->address,
            'linkedin' => $card->linkedin,
            'twitter' => $card->twitter,
            'logoUrl' => $card->logo_path ? asset('storage/' . $card->logo_path) : null
        ];

        return view('cards.preview', [
            'card' => $card,
            'data' => $data
        ]);
    }
}
