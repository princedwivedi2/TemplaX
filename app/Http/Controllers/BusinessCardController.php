<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class BusinessCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
        $this->authorizeResource(BusinessCard::class, 'card');
    }

    /**
     * Display a listing of the business cards.
     */
    public function index()
    {
        $cards = auth()->user()->hasRole('super-admin') 
            ? BusinessCard::with('user')->latest()->paginate(10)
            : auth()->user()->businessCards()->latest()->paginate(10);

        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new business card.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created business card.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'template' => 'required|in:portrait,landscape,elegant',
            'logo' => 'nullable|image|max:2048',
            'background_image' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'navigate' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $validated['user_id'] = auth()->id();

        $card = BusinessCard::create($validated);

        return redirect()->route('cards.preview', $card)
            ->with('success', 'Business card created successfully.');
    }

    /**
     * Display the specified business card.
     */
    public function show(BusinessCard $card)
    {
        return view('cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified business card.
     */
    public function edit(BusinessCard $card)
    {
        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified business card.
     */
    public function update(Request $request, BusinessCard $card)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'template' => 'required|in:portrait,landscape,elegant',
            'logo' => 'nullable|image|max:2048',
            'background_image' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'navigate' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($card->logo_path) {
                Storage::disk('public')->delete($card->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $card->update($validated);

        return redirect()->route('cards.preview', $card)
            ->with('success', 'Business card updated successfully.');
    }

    /**
     * Remove the specified business card.
     */
    public function destroy(BusinessCard $card)
    {
        if ($card->logo_path) {
            Storage::disk('public')->delete($card->logo_path);
        }

        $card->delete();

        return redirect()->route('cards.index')
            ->with('success', 'Business card deleted successfully.');
    }

    /**
     * Preview the business card.
     */
    public function preview(BusinessCard $card)
    {
        return view('cards.preview', [
            'card' => $card,
            'data' => $card->getTemplateData()
        ]);
    }

    /**
     * Download the business card as PDF.
     */
    public function download(BusinessCard $card)
    {
        $data = $card->getTemplateData();
        $pdf = PDF::loadView("cards.templates.{$card->template}", $data)
            ->setPaper('a4', 'landscape');
        
        return $pdf->download("{$card->full_name}-business-card.pdf");
    }
}
