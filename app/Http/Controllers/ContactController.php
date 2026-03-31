<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill in all required fields correctly.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $validator->validated();
            
            // Get admin email from settings or use default
            $adminEmail = 'info@malbiskitchen.nl';
            try {
                $setting = \App\Models\Setting::where('key', 'admin_email')->first();
                if ($setting && $setting->value) {
                    $adminEmail = $setting->value;
                }
            } catch (\Exception $e) {
                // Use default if settings table doesn't exist
            }

            // Send email
            Mail::send('emails.contact', ['data' => $data], function ($message) use ($data, $adminEmail) {
                $message->to($adminEmail)
                        ->subject('Contact Form: ' . $data['subject'])
                        ->replyTo($data['email'], $data['first_name'] . ' ' . $data['last_name']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your message has been sent successfully. We will get back to you soon.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again later or contact us directly.'
            ], 500);
        }
    }
}
