<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardTemplateController extends Controller
{
    /**
     * Display a template by name
     */
    public function show($name)
    {
        $validTemplates = ['minimal'];

        if (!in_array($name, $validTemplates)) {
            abort(404, 'Template not found');
        }

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
            'logoUrl' => asset('images/default-profile.svg')
        ];

        return view('cards.templates.' . $name, $sampleData);
    }

    /**
     * Show the template selection page
     */
    public function index()
    {
        return view('cards.templates.index');
    }
}
