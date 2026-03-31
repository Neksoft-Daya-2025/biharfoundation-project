<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    /**
     * Show settings dashboard page
     */
    public function index(Request $request)
    {
        return view('dashboard.settings');
    }

    /**
     * Get all settings
     * Note: Requires Setting model
     */
    public function getAll(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!class_exists('App\Models\Setting')) {
            return response()->json([
                'success' => true,
                'settings' => []
            ]);
        }

        $settings = \App\Models\Setting::all();

        return response()->json([
            'success' => true,
            'settings' => $settings
        ]);
    }

    /**
     * Update setting
     * Note: Requires Setting model
     */
    public function updateSetting(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'value' => 'required',
            'type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!class_exists('App\Models\Setting')) {
            return response()->json([
                'success' => false,
                'message' => 'Setting model not found'
            ], 500);
        }

        \App\Models\Setting::set(
            $request->input('key'),
            $request->input('value'),
            $request->input('type', 'string')
        );

        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully'
        ]);
    }

    /**
     * Clear cache
     */
    public function clearCache(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');

        return response()->json([
            'success' => true,
            'message' => 'All caches cleared successfully'
        ]);
    }

    /**
     * Get SMTP configuration
     */
    public function getSMTPConfig(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Read from Laravel config (which reads from .env)
        $mailHost = config('mail.mailers.smtp.host');
        $mailPort = config('mail.mailers.smtp.port');
        $mailUsername = config('mail.mailers.smtp.username');
        $mailPassword = config('mail.mailers.smtp.password');
        $mailEncryption = config('mail.mailers.smtp.encryption');
        $mailFromAddress = config('mail.from.address');
        $mailFromName = config('mail.from.name');
        
        // Check if SMTP is configured in .env
        $isConfigured = !empty($mailHost) && !empty($mailUsername) && !empty($mailPassword);
        
        // Get additional config from settings table if Setting model exists
        $settingsConfig = null;
        if (class_exists('App\Models\Setting')) {
            $settingsConfig = \App\Models\Setting::get('smtp_config', null);
        }
        
        $adminEmails = [];
        if ($settingsConfig && isset($settingsConfig['admin_emails'])) {
            $adminEmails = $settingsConfig['admin_emails'];
        }
        
        if ($isConfigured) {
            return response()->json([
                'success' => true,
                'configured' => true,
                'host' => $mailHost ?? '',
                'port' => $mailPort ?? 465,
                'username' => $mailUsername ?? '',
                'encryption' => $mailEncryption ?? 'ssl',
                'from_email' => (!empty($settingsConfig['from_email'])) ? $settingsConfig['from_email'] : ($mailFromAddress ?? ''),
                'from_name' => (!empty($settingsConfig['from_name'])) ? $settingsConfig['from_name'] : ($mailFromName ?? 'Malbis Kitchen'),
                'admin_emails' => !empty($adminEmails) ? $adminEmails : [],
                'source' => 'env',
                'has_password' => !empty($mailPassword)
            ]);
        }

        // If not in .env, check settings table
        if ($settingsConfig && !empty($settingsConfig['host'])) {
            return response()->json([
                'success' => true,
                'configured' => true,
                'host' => $settingsConfig['host'] ?? '',
                'port' => $settingsConfig['port'] ?? 465,
                'username' => $settingsConfig['username'] ?? '',
                'encryption' => $settingsConfig['encryption'] ?? 'ssl',
                'from_email' => $settingsConfig['from_email'] ?? '',
                'from_name' => $settingsConfig['from_name'] ?? 'Malbis Kitchen',
                'admin_emails' => $settingsConfig['admin_emails'] ?? [],
                'source' => 'settings'
            ]);
        }

        return response()->json([
            'success' => true,
            'configured' => false
        ]);
    }

    /**
     * Save SMTP configuration
     */
    public function saveSMTPConfig(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'host' => 'required|string',
            'port' => 'required|integer',
            'username' => 'required|email',
            'password' => 'nullable|string',
            'encryption' => 'required|in:ssl,tls',
            'from_email' => 'required|email',
            'from_name' => 'required|string',
            'admin_emails' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!class_exists('App\Models\Setting')) {
            return response()->json([
                'success' => false,
                'message' => 'Setting model not found'
            ], 500);
        }

        $adminEmails = [];
        if ($request->has('admin_emails')) {
            $adminEmailsText = is_array($request->admin_emails) 
                ? implode("\n", $request->admin_emails)
                : $request->admin_emails;
            $adminEmails = array_filter(array_map('trim', explode("\n", $adminEmailsText)));
        }

        $password = $request->password;
        $existingConfig = \App\Models\Setting::get('smtp_config', null);
        
        if (empty($password)) {
            if ($existingConfig && isset($existingConfig['password']) && !empty($existingConfig['password'])) {
                $password = $existingConfig['password'];
            } else {
                $envPassword = config('mail.mailers.smtp.password');
                if (!empty($envPassword)) {
                    $password = $envPassword;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Password is required.'
                    ], 422);
                }
            }
        }
        
        $config = [
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $password,
            'encryption' => $request->encryption,
            'from_email' => $request->from_email,
            'from_name' => $request->from_name,
            'admin_emails' => $adminEmails
        ];

        \App\Models\Setting::set('smtp_config', $config, 'json', 'SMTP Email Configuration');

        return response()->json([
            'success' => true,
            'message' => 'SMTP configuration saved successfully',
            'configured' => true
        ]);
    }

    /**
     * Test SMTP connection
     */
    public function testSMTPConnection(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $mailHost = config('mail.mailers.smtp.host');
        $mailUsername = config('mail.mailers.smtp.username');
        $mailPassword = config('mail.mailers.smtp.password');
        
        $useEnvConfig = !empty($mailHost) && !empty($mailUsername);
        
        $settingsConfig = null;
        if (class_exists('App\Models\Setting')) {
            $settingsConfig = \App\Models\Setting::get('smtp_config', null);
        }
        
        if (!$useEnvConfig) {
            if (!$settingsConfig || empty($settingsConfig['host'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'SMTP is not configured. Please configure in .env file or dashboard.'
                ]);
            }
            
            Config::set('mail.mailers.smtp.host', $settingsConfig['host']);
            Config::set('mail.mailers.smtp.port', $settingsConfig['port']);
            Config::set('mail.mailers.smtp.username', $settingsConfig['username']);
            Config::set('mail.mailers.smtp.password', $settingsConfig['password']);
            Config::set('mail.mailers.smtp.encryption', $settingsConfig['encryption']);
            Config::set('mail.from.address', $settingsConfig['from_email']);
            Config::set('mail.from.name', $settingsConfig['from_name']);
            $testEmail = $settingsConfig['to_email'] ?? config('mail.from.address', 'info@malbiskitchen.nl');
        } else {
            if ($settingsConfig) {
                if (!empty($settingsConfig['from_email'])) {
                    Config::set('mail.from.address', $settingsConfig['from_email']);
                }
                if (!empty($settingsConfig['from_name'])) {
                    Config::set('mail.from.name', $settingsConfig['from_name']);
                }
            }
            $testEmail = ($settingsConfig['to_email'] ?? null) ?: config('mail.from.address', 'info@malbiskitchen.nl');
        }

        try {
            Mail::raw('This is a test email from Malbis Kitchen Dashboard. SMTP connection is working!', function ($message) use ($testEmail) {
                $message->to($testEmail)
                    ->subject('SMTP Test - Malbis Kitchen Dashboard');
            });

            return response()->json([
                'success' => true,
                'message' => 'SMTP connection successful! Test email sent to ' . $testEmail
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'SMTP connection failed: ' . $e->getMessage()
            ]);
        }
    }
}
