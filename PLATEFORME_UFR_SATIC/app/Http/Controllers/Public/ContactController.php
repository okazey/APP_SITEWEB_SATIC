<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'     => 'required|string|max:100',
            'email'   => 'required|email',
            'sujet'   => 'required|string|max:200',
            'message' => 'required|string|min:20',
        ], [
            'nom.required'     => 'Votre nom est obligatoire.',
            'email.required'   => 'Votre email est obligatoire.',
            'email.email'      => 'L\'email n\'est pas valide.',
            'sujet.required'   => 'Le sujet est obligatoire.',
            'message.required' => 'Le message est obligatoire.',
            'message.min'      => 'Le message doit contenir au moins 20 caractères.',
        ]);

        Contact::create($request->only('nom', 'email', 'sujet', 'message'));

        return redirect()->route('contact')
                         ->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
    }
}