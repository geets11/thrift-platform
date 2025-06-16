<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // For now, just return success message
        // In a real application, you would send an email here
        // Mail::to('info@thriftfashion.com')->send(new ContactFormSubmission($validated));

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}