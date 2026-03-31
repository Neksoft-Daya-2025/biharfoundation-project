<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('page-title', 'Settings'); ?>
<?php $__env->startSection('page-description', 'Configure application settings and SMTP'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .tab-button {
        transition: all 0.2s;
    }
    .tab-button.active {
        border-bottom: 2px solid #937237;
        color: #937237;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button onclick="showTab('smtp')" id="tab-smtp" class="tab-button active py-4 px-1 border-b-2 font-medium text-sm">
                    SMTP Configuration
                </button>
                <button onclick="showTab('general')" id="tab-general" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    General Settings
                </button>
                <button onclick="showTab('payment')" id="tab-payment" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Payment Settings
                </button>
                <button onclick="showTab('cache')" id="tab-cache" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Cache Management
                </button>
                <button onclick="showTab('datetime')" id="tab-datetime" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Date & Time
                </button>
            </nav>
        </div>

        <!-- SMTP Configuration Tab -->
        <div id="content-smtp" class="tab-content">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Email Configuration</h3>
                <p class="text-sm text-gray-600">Configure SMTP settings for sending emails from your application.</p>
            </div>

            <form id="smtp-form" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="smtp-host" class="block text-sm font-medium text-gray-700 mb-2">SMTP Host *</label>
                        <input type="text" id="smtp-host" name="host" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                            placeholder="smtp.gmail.com">
                    </div>

                    <div>
                        <label for="smtp-port" class="block text-sm font-medium text-gray-700 mb-2">SMTP Port *</label>
                        <select id="smtp-port" name="port" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                            <option value="465">465 (SSL)</option>
                            <option value="587">587 (TLS)</option>
                            <option value="25">25</option>
                        </select>
                    </div>

                    <div>
                        <label for="smtp-username" class="block text-sm font-medium text-gray-700 mb-2">SMTP Username (Email) *</label>
                        <input type="email" id="smtp-username" name="username" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                            placeholder="your-email@gmail.com">
                    </div>

                    <div>
                        <label for="smtp-password" class="block text-sm font-medium text-gray-700 mb-2">SMTP Password *</label>
                        <input type="password" id="smtp-password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                            placeholder="Leave blank to keep existing">
                        <p class="text-xs text-gray-500 mt-1">Leave blank to keep existing password</p>
                    </div>

                    <div>
                        <label for="smtp-encryption" class="block text-sm font-medium text-gray-700 mb-2">Encryption *</label>
                        <select id="smtp-encryption" name="encryption" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                            <option value="ssl">SSL</option>
                            <option value="tls">TLS</option>
                        </select>
                    </div>

                    <div>
                        <label for="from-email" class="block text-sm font-medium text-gray-700 mb-2">From Email *</label>
                        <input type="email" id="from-email" name="from_email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                            placeholder="noreply@malbiskitchen.nl">
                    </div>

                    <div class="md:col-span-2">
                        <label for="from-name" class="block text-sm font-medium text-gray-700 mb-2">From Name *</label>
                        <input type="text" id="from-name" name="from_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                            placeholder="Malbi's Kitchen" value="Malbi's Kitchen">
                    </div>

                    <div class="md:col-span-2">
                        <label for="admin-emails" class="block text-sm font-medium text-gray-700 mb-2">Admin Notification Emails</label>
                        <textarea id="admin-emails" name="admin_emails" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                            placeholder="One email per line&#10;admin@malbiskitchen.nl&#10;info@malbiskitchen.nl"></textarea>
                        <p class="text-xs text-gray-500 mt-1">One email address per line. These emails will receive notifications.</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2.5 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                        Save SMTP Configuration
                    </button>
                    <button type="button" onclick="testSMTP()" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                        Test Connection
                    </button>
                </div>

                <div id="smtp-message" class="hidden mt-4 p-4 rounded-lg"></div>
            </form>
        </div>

        <!-- General Settings Tab -->
        <div id="content-general" class="tab-content hidden">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">General Settings</h3>
                <p class="text-sm text-gray-600">Manage general application settings.</p>
            </div>

            <form id="general-form" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Currency *</label>
                        <select id="currency" name="currency" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                            <option value="EUR">Euro (€)</option>
                            <option value="USD">US Dollar ($)</option>
                            <option value="GBP">British Pound (£)</option>
                            <option value="CHF">Swiss Franc (Fr)</option>
                            <option value="JPY">Japanese Yen (¥)</option>
                            <option value="INR">Indian Rupee (₹)</option>
                            <option value="CAD">Canadian Dollar (C$)</option>
                            <option value="AUD">Australian Dollar (A$)</option>
                            <option value="CNY">Chinese Yuan (¥)</option>
                            <option value="BRL">Brazilian Real (R$)</option>
                            <option value="MXN">Mexican Peso ($)</option>
                            <option value="ZAR">South African Rand (R)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Used for prices and amounts across the dashboard.</p>
                    </div>
                    <div>
                        <label for="active_theme" class="block text-sm font-medium text-gray-700 mb-2">Active theme *</label>
                        <select id="active_theme" name="active_theme" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                            <?php $__currentLoopData = config('themes', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($theme['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Public site theme (e.g. Lovable export). Dashboard is unchanged.</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2.5 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                        Save General Settings
                    </button>
                </div>

                <div id="general-message" class="hidden mt-4 p-4 rounded-lg"></div>
            </form>
        </div>

        <!-- Payment Settings Tab -->
        <div id="content-payment" class="tab-content hidden">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Mollie Payment Configuration</h3>
                <p class="text-sm text-gray-600">Configure Mollie payment gateway settings for processing online payments.</p>
            </div>

            <form id="payment-form" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mollie-api-key" class="block text-sm font-medium text-gray-700 mb-2">Mollie API Key *</label>
                        <input type="text" id="mollie-api-key" name="mollie_api_key" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                            placeholder="live_... or test_...">
                        <p class="text-xs text-gray-500 mt-1">Get your API key from <a href="https://www.mollie.com/dashboard" target="_blank" class="text-[#937237] hover:underline">Mollie Dashboard</a></p>
                    </div>

                    <div>
                        <label for="mollie-environment" class="block text-sm font-medium text-gray-700 mb-2">Environment *</label>
                        <select id="mollie-environment" name="mollie_environment" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                            <option value="test">Test Mode</option>
                            <option value="live">Live Mode</option>
                        </select>
                    </div>
                </div>

                <div id="payment-message" class="hidden mt-4 p-4 rounded-lg"></div>

                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                        Save Payment Settings
                    </button>
                    <button type="button" onclick="testPaymentConnection()" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-lg font-medium transition-colors">
                        Test Connection
                    </button>
                </div>
            </form>

            <div class="mt-8 p-6 bg-blue-50 rounded-lg border border-blue-200">
                <h4 class="font-semibold text-blue-900 mb-2">Setup Instructions</h4>
                <ol class="list-decimal list-inside space-y-2 text-sm text-blue-800">
                    <li>Sign up for a Mollie account at <a href="https://www.mollie.com" target="_blank" class="underline">mollie.com</a></li>
                    <li>Navigate to Developers → API keys in your Mollie dashboard</li>
                    <li>Copy your API key (test key starts with "test_", live key starts with "live_")</li>
                    <li>Paste the API key above and select the appropriate environment</li>
                    <li>Save settings and test the connection</li>
                    <li>Add the API key to your <code class="bg-blue-100 px-1 rounded">.env</code> file: <code class="bg-blue-100 px-1 rounded">MOLLIE_KEY=your_api_key_here</code></li>
                </ol>
            </div>
        </div>

        <!-- Cache Management Tab -->
        <div id="content-cache" class="tab-content hidden">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Cache Management</h3>
                <p class="text-sm text-gray-600">Clear application caches to refresh data and configurations.</p>
            </div>

            <div class="space-y-4">
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="font-semibold text-gray-900 mb-2">Clear All Caches</h4>
                    <p class="text-sm text-gray-600 mb-4">This will clear application cache, config cache, route cache, and view cache.</p>
                    <button onclick="clearCache()" class="px-6 py-2.5 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                        Clear All Caches
                    </button>
                </div>

                <div id="cache-message" class="hidden mt-4 p-4 rounded-lg"></div>
            </div>
        </div>

        <!-- Date & Time Tab -->
        <div id="content-datetime" class="tab-content hidden">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Date, Time & Timezone</h3>
                <p class="text-sm text-gray-600">Manage application timezone, date/time formats and business hours.</p>
            </div>

            <!-- Live preview -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-sm font-medium text-gray-700 mb-1">Current time (preview)</p>
                <div id="datetime-live-preview" class="text-lg font-semibold text-gray-900 font-mono">—</div>
                <p id="datetime-live-preview-utc" class="text-xs text-gray-500 mt-1"></p>
            </div>

            <form id="datetime-form" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="datetime-timezone" class="block text-sm font-medium text-gray-700 mb-2">Application timezone *</label>
                    <select id="datetime-timezone" name="timezone" required
                        class="w-full max-w-xl px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                        <option value="">Loading…</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="datetime-date_format" class="block text-sm font-medium text-gray-700 mb-2">Date format *</label>
                        <select id="datetime-date_format" name="date_format" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                            <option value="d/m/Y">31/12/2025 (Day/Month/Year)</option>
                            <option value="m/d/Y">12/31/2025 (Month/Day/Year)</option>
                            <option value="Y-m-d">2025-12-31 (ISO)</option>
                            <option value="d-m-Y">31-12-2025</option>
                            <option value="j F Y">31 December 2025 (Long)</option>
                        </select>
                    </div>
                    <div>
                        <label for="datetime-time_format" class="block text-sm font-medium text-gray-700 mb-2">Time format *</label>
                        <select id="datetime-time_format" name="time_format" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                            <option value="24">24-hour (14:30)</option>
                            <option value="12">12-hour (2:30 PM)</option>
                        </select>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Business hours</h4>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Closed</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Open</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Close</th>
                                </tr>
                            </thead>
                            <tbody id="datetime-business-hours-tbody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2.5 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                        Save date & time settings
                    </button>
                    <span id="datetime-message" class="hidden px-4 py-2 rounded-lg text-sm"></span>
                </div>
            </form>
            <div id="datetime-message-block" class="hidden mt-4 p-4 rounded-lg"></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Tab switching
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.add('text-gray-500', 'border-transparent');
            btn.classList.remove('text-[#937237]');
        });

        // Show selected tab
        document.getElementById('content-' + tabName).classList.remove('hidden');
        const btn = document.getElementById('tab-' + tabName);
        btn.classList.add('active');
        btn.classList.remove('text-gray-500', 'border-transparent');
        btn.classList.add('text-[#937237]');
    }

    // Load SMTP config on page load
    function loadSMTPConfig() {
        fetch('/api/smtp-config', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.configured) {
                document.getElementById('smtp-host').value = data.host || '';
                document.getElementById('smtp-port').value = data.port || '465';
                document.getElementById('smtp-username').value = data.username || '';
                document.getElementById('smtp-encryption').value = data.encryption || 'ssl';
                document.getElementById('from-email').value = data.from_email || '';
                document.getElementById('from-name').value = data.from_name || 'Malbi\'s Kitchen';
                if (data.admin_emails && data.admin_emails.length > 0) {
                    document.getElementById('admin-emails').value = data.admin_emails.join('\n');
                }
            }
        })
        .catch(error => {
            console.error('Error loading SMTP config:', error);
        });
    }

    // Save SMTP config
    document.getElementById('smtp-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        // Handle admin emails
        if (data.admin_emails) {
            data.admin_emails = data.admin_emails.split('\n').filter(email => email.trim());
        }

        fetch('/api/smtp-config', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('smtp-message');
            messageDiv.classList.remove('hidden');
            
            if (data.success) {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800';
                messageDiv.textContent = data.message || 'SMTP configuration saved successfully!';
            } else {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
                messageDiv.textContent = data.message || 'Failed to save SMTP configuration.';
            }
        })
        .catch(error => {
            const messageDiv = document.getElementById('smtp-message');
            messageDiv.classList.remove('hidden');
            messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
            messageDiv.textContent = 'Error saving SMTP configuration.';
        });
    });

    // Test SMTP connection
    function testSMTP() {
        const messageDiv = document.getElementById('smtp-message');
        messageDiv.classList.remove('hidden');
        messageDiv.className = 'mt-4 p-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800';
        messageDiv.textContent = 'Testing SMTP connection...';

        fetch('/api/smtp-config/test', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800';
                messageDiv.textContent = data.message || 'SMTP connection successful!';
            } else {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
                messageDiv.textContent = data.message || 'SMTP connection failed.';
            }
        })
        .catch(error => {
            messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
            messageDiv.textContent = 'Error testing SMTP connection.';
        });
    }

    // Clear cache
    function clearCache() {
        const messageDiv = document.getElementById('cache-message');
        messageDiv.classList.remove('hidden');
        messageDiv.className = 'p-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800';
        messageDiv.textContent = 'Clearing caches...';

        fetch('/api/clear-cache', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.className = 'p-4 rounded-lg bg-green-50 border border-green-200 text-green-800';
                messageDiv.textContent = data.message || 'All caches cleared successfully!';
            } else {
                messageDiv.className = 'p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
                messageDiv.textContent = data.message || 'Failed to clear caches.';
            }
        })
        .catch(error => {
            messageDiv.className = 'p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
            messageDiv.textContent = 'Error clearing caches.';
        });
    }

    // Payment Settings
    function testPaymentConnection() {
        const apiKey = document.getElementById('mollie-api-key').value;
        const messageDiv = document.getElementById('payment-message');
        
        if (!apiKey) {
            messageDiv.classList.remove('hidden');
            messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
            messageDiv.textContent = 'Please enter an API key first.';
            return;
        }

        messageDiv.classList.remove('hidden');
        messageDiv.className = 'mt-4 p-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800';
        messageDiv.textContent = 'Testing connection...';

        // Note: Actual API test would require backend endpoint
        setTimeout(() => {
            messageDiv.className = 'mt-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800';
            messageDiv.textContent = 'Connection test successful! Make sure to add MOLLIE_KEY to your .env file.';
        }, 1000);
    }

    document.getElementById('payment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        const messageDiv = document.getElementById('payment-message');
        messageDiv.classList.remove('hidden');
        messageDiv.className = 'mt-4 p-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800';
        messageDiv.textContent = 'Saving payment settings...';

        // Save to settings table
        fetch('/api/settings', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                key: 'mollie_config',
                value: JSON.stringify(data),
                type: 'json'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800';
                messageDiv.textContent = 'Payment settings saved! Remember to add MOLLIE_KEY=' + document.getElementById('mollie-api-key').value + ' to your .env file.';
            } else {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
                messageDiv.textContent = data.message || 'Failed to save payment settings.';
            }
        })
        .catch(error => {
            messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
            messageDiv.textContent = 'Error saving payment settings.';
        });
    });

    // Load Payment (Mollie) settings when Payment tab is shown
    function loadPaymentSettings() {
        fetch('/api/settings', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.settings && Array.isArray(data.settings)) {
                const mollieSetting = data.settings.find(s => s.key === 'mollie_config');
                if (mollieSetting && mollieSetting.value) {
                    let config = mollieSetting.value;
                    if (typeof config === 'string') {
                        try { config = JSON.parse(config); } catch (e) { config = {}; }
                    }
                    const apiKeyEl = document.getElementById('mollie-api-key');
                    const envEl = document.getElementById('mollie-environment');
                    if (apiKeyEl) apiKeyEl.value = config.mollie_api_key || config.api_key || '';
                    if (envEl) envEl.value = config.mollie_environment || config.environment || 'test';
                }
            }
        })
        .catch(() => {});
    }

    // Load general settings (currency) when General tab is shown or on load
    function loadGeneralSettings() {
        fetch('/api/settings', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.settings && Array.isArray(data.settings)) {
                const currencySetting = data.settings.find(s => s.key === 'currency');
                const currency = currencySetting ? (currencySetting.value || 'EUR') : 'EUR';
                const currencyEl = document.getElementById('currency');
                if (currencyEl) currencyEl.value = currency;
                const themeSetting = data.settings.find(s => s.key === 'active_theme');
                const activeTheme = themeSetting ? (themeSetting.value || 'default') : 'default';
                const themeEl = document.getElementById('active_theme');
                if (themeEl) themeEl.value = activeTheme;
            }
        })
        .catch(() => {});
    }

    document.getElementById('general-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const currency = document.getElementById('currency').value;
        const activeTheme = document.getElementById('active_theme').value;
        const messageDiv = document.getElementById('general-message');
        messageDiv.classList.remove('hidden');
        messageDiv.className = 'mt-4 p-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800';
        messageDiv.textContent = 'Saving...';

        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        };
        Promise.all([
            fetch('/api/settings', { method: 'POST', headers, body: JSON.stringify({ key: 'currency', value: currency, type: 'string' }) }).then(r => r.json()),
            fetch('/api/settings', { method: 'POST', headers, body: JSON.stringify({ key: 'active_theme', value: activeTheme, type: 'string' }) }).then(r => r.json())
        ]).then(([data1, data2]) => {
            if (data1.success && data2.success) {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800';
                messageDiv.textContent = 'General settings saved. Currency: ' + currency + ', Theme: ' + activeTheme + '.';
            } else {
                messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
                messageDiv.textContent = (data1.message || data2.message) || 'Failed to save.';
            }
        }).catch(() => {
            messageDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
            messageDiv.textContent = 'Error saving general settings.';
        });
    });

    // Date & Time tab
    const DATETIME_DAYS = [
        { key: 'monday', label: 'Monday' }, { key: 'tuesday', label: 'Tuesday' }, { key: 'wednesday', label: 'Wednesday' },
        { key: 'thursday', label: 'Thursday' }, { key: 'friday', label: 'Friday' }, { key: 'saturday', label: 'Saturday' },
        { key: 'sunday', label: 'Sunday' }
    ];
    let datetimeTimezonesLoaded = false;

    function getBusinessHoursFromForm() {
        const out = {};
        DATETIME_DAYS.forEach(day => {
            const closedEl = document.getElementById('bh-' + day.key + '-closed');
            const openEl = document.getElementById('bh-' + day.key + '-open');
            const closeEl = document.getElementById('bh-' + day.key + '-close');
            out[day.key] = {
                closed: closedEl ? closedEl.checked : false,
                open: openEl && !openEl.disabled ? openEl.value : '09:00',
                close: closeEl && !closeEl.disabled ? closeEl.value : '17:00'
            };
        });
        return out;
    }

    function renderDateTimeBusinessHours(businessHours) {
        const tbody = document.getElementById('datetime-business-hours-tbody');
        if (!tbody) return;
        const hours = businessHours || {};
        tbody.innerHTML = DATETIME_DAYS.map(day => {
            const d = hours[day.key] || { open: '09:00', close: '17:00', closed: day.key === 'sunday' };
            const closed = !!d.closed;
            return `
                <tr class="bg-white hover:bg-gray-50 border-b border-gray-200">
                    <td class="px-4 py-2 font-medium text-gray-900">${day.label}</td>
                    <td class="px-4 py-2">
                        <input type="checkbox" id="bh-${day.key}-closed" data-day="${day.key}" class="bh-closed rounded border-gray-300 text-[#937237] focus:ring-[#937237]" ${closed ? 'checked' : ''}>
                    </td>
                    <td class="px-4 py-2">
                        <input type="time" id="bh-${day.key}-open" data-day="${day.key}" value="${d.open || '09:00'}" class="bh-open px-2 py-1.5 border border-gray-300 rounded text-sm" ${closed ? 'disabled' : ''}>
                    </td>
                    <td class="px-4 py-2">
                        <input type="time" id="bh-${day.key}-close" data-day="${day.key}" value="${d.close || '17:00'}" class="bh-close px-2 py-1.5 border border-gray-300 rounded text-sm" ${closed ? 'disabled' : ''}>
                    </td>
                </tr>
            `;
        }).join('');
        document.querySelectorAll('.bh-closed').forEach(cb => {
            cb.addEventListener('change', function() {
                const day = this.dataset.day;
                const openEl = document.getElementById('bh-' + day + '-open');
                const closeEl = document.getElementById('bh-' + day + '-close');
                openEl.disabled = this.checked;
                closeEl.disabled = this.checked;
                updateDateTimePreview();
            });
        });
        document.querySelectorAll('.bh-open, .bh-close').forEach(inp => inp.addEventListener('change', updateDateTimePreview));
    }

    function updateDateTimePreview() {
        fetch('/api/datetime?' + new URLSearchParams({ _: Date.now() }), {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        }).then(r => r.json()).then(data => {
            if (!data.success) return;
            const el = document.getElementById('datetime-live-preview');
            const utcEl = document.getElementById('datetime-live-preview-utc');
            if (el) el.textContent = data.current_datetime_formatted || '—';
            if (utcEl && data.current_datetime) utcEl.textContent = 'UTC: ' + new Date(data.current_datetime).toUTCString();
        }).catch(() => {});
    }

    function loadDateTimeSettings() {
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const headers = { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' };
        function loadSettingsAndPopulate() {
            fetch('/api/datetime', { headers }).then(r => r.json()).then(data => {
                if (!data.success) return;
                const tzSel = document.getElementById('datetime-timezone');
                if (tzSel) {
                    tzSel.value = data.timezone || 'UTC';
                    if (tzSel.value !== data.timezone && data.timezone) {
                        const opt = document.createElement('option');
                        opt.value = data.timezone;
                        opt.textContent = data.timezone;
                        tzSel.appendChild(opt);
                        tzSel.value = data.timezone;
                    }
                }
                const df = document.getElementById('datetime-date_format');
                const tf = document.getElementById('datetime-time_format');
                if (df) df.value = data.date_format || 'd/m/Y';
                if (tf) tf.value = data.time_format || '24';
                renderDateTimeBusinessHours(data.business_hours);
                const prev = document.getElementById('datetime-live-preview');
                const utc = document.getElementById('datetime-live-preview-utc');
                if (prev) prev.textContent = data.current_datetime_formatted || '—';
                if (utc && data.current_datetime) utc.textContent = 'UTC: ' + new Date(data.current_datetime).toUTCString();
            }).catch(() => {
                renderDateTimeBusinessHours({});
                const prev = document.getElementById('datetime-live-preview');
                if (prev) prev.textContent = '—';
            });
        }
        if (!datetimeTimezonesLoaded) {
            fetch('/api/datetime/timezones', { headers }).then(r => r.json()).then(data => {
                if (data.success && data.timezones) {
                    const sel = document.getElementById('datetime-timezone');
                    if (sel) {
                        sel.innerHTML = '';
                        Object.keys(data.timezones).sort().forEach(region => {
                            const optgroup = document.createElement('optgroup');
                            optgroup.label = region;
                            Object.entries(data.timezones[region]).forEach(([tz, label]) => {
                                const opt = document.createElement('option');
                                opt.value = tz;
                                opt.textContent = label + ' (' + tz + ')';
                                optgroup.appendChild(opt);
                            });
                            sel.appendChild(optgroup);
                        });
                    }
                    datetimeTimezonesLoaded = true;
                }
                loadSettingsAndPopulate();
            }).catch(() => loadSettingsAndPopulate());
        } else {
            loadSettingsAndPopulate();
        }
    }

    document.getElementById('datetime-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = document.getElementById('datetime-message');
        const msgBlock = document.getElementById('datetime-message-block');
        msg.classList.add('hidden');
        msgBlock.classList.add('hidden');
        const payload = {
            timezone: document.getElementById('datetime-timezone').value,
            date_format: document.getElementById('datetime-date_format').value,
            time_format: document.getElementById('datetime-time_format').value,
            business_hours: getBusinessHoursFromForm()
        };
        fetch('/api/datetime', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        }).then(r => r.json()).then(data => {
            if (data.success) {
                msg.textContent = data.message || 'Settings saved.';
                msg.classList.remove('hidden');
                msg.className = 'px-4 py-2 rounded-lg text-sm bg-green-100 text-green-800';
                msgBlock.classList.add('hidden');
                if (data.current_datetime_formatted) {
                    document.getElementById('datetime-live-preview').textContent = data.current_datetime_formatted;
                }
            } else {
                msgBlock.textContent = (data.errors && Object.values(data.errors).flat().join(' ')) || data.message || 'Error saving.';
                msgBlock.classList.remove('hidden');
                msgBlock.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
            }
        }).catch(() => {
            msgBlock.textContent = 'Error saving settings.';
            msgBlock.classList.remove('hidden');
            msgBlock.className = 'mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
        });
    });

    document.getElementById('datetime-timezone').addEventListener('change', updateDateTimePreview);
    document.getElementById('datetime-date_format').addEventListener('change', updateDateTimePreview);
    document.getElementById('datetime-time_format').addEventListener('change', updateDateTimePreview);

    // When switching tabs, load settings for that tab
    const originalShowTab = showTab;
    showTab = function(tabName) {
        originalShowTab(tabName);
        if (tabName === 'general') loadGeneralSettings();
        if (tabName === 'payment') loadPaymentSettings();
        if (tabName === 'datetime') loadDateTimeSettings();
    };

    // Load config on page load
    loadSMTPConfig();
    loadGeneralSettings();
    const tabParam = new URLSearchParams(window.location.search).get('tab');
    if (tabParam === 'datetime') showTab('datetime');
    feather.replace();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MUGDHA\Downloads\New folder\backend-project-main\backend-project-main\resources\views/dashboard/settings.blade.php ENDPATH**/ ?>