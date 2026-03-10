<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|min:10',
        ]);

        $to = Setting::get('contact_email', config('mail.from.address'));

        Mail::to($to)->send(new ContactMail($request->all()));

        return back()->with('success', 'Your message has been sent. I\'ll get back to you soon!');
    }
}
