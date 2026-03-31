<!-- Cookie Consent & Location Permission Popup -->
<div id="cookie-consent-popup" class="fixed bottom-4 left-4 z-50 max-w-md w-full md:w-96 hidden" style="display: none;">
  <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-6">
    <!-- Header -->
    <div class="flex items-start justify-between mb-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-[#937237] rounded-full flex items-center justify-center">
          <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
          </svg>
        </div>
        <h3 class="font-heading text-lg font-semibold text-gray-900">Privacy & Location</h3>
      </div>
      <button id="cookie-consent-close" class="text-gray-400 hover:text-gray-600 transition-colors">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Content -->
    <div class="space-y-4 mb-6">
      <p class="text-sm text-gray-600 leading-relaxed">
        We use cookies to enhance your browsing experience and analyze site traffic. We also request location permission to provide you with personalized content and delivery options.
      </p>

      <!-- Cookie Preferences -->
      <div class="space-y-3">
        <label class="flex items-center gap-3 cursor-pointer">
          <input type="checkbox" id="cookie-essential" checked disabled class="w-4 h-4 text-[#937237] border-gray-300 rounded focus:ring-[#937237]">
          <span class="text-sm text-gray-700">
            <strong>Essential Cookies</strong> (Required)
            <span class="text-gray-500 block text-xs mt-0.5">Necessary for website functionality</span>
          </span>
        </label>
        
        <label class="flex items-center gap-3 cursor-pointer">
          <input type="checkbox" id="cookie-analytics" class="w-4 h-4 text-[#937237] border-gray-300 rounded focus:ring-[#937237]">
          <span class="text-sm text-gray-700">
            <strong>Analytics Cookies</strong>
            <span class="text-gray-500 block text-xs mt-0.5">Help us improve our website</span>
          </span>
        </label>
        
        <label class="flex items-center gap-3 cursor-pointer">
          <input type="checkbox" id="cookie-marketing" class="w-4 h-4 text-[#937237] border-gray-300 rounded focus:ring-[#937237]">
          <span class="text-sm text-gray-700">
            <strong>Marketing Cookies</strong>
            <span class="text-gray-500 block text-xs mt-0.5">Personalized content and ads</span>
          </span>
        </label>
      </div>

      <!-- Location Permission -->
      <div class="pt-3 border-t border-gray-200">
        <label class="flex items-center gap-3 cursor-pointer">
          <input type="checkbox" id="location-permission" class="w-4 h-4 text-[#937237] border-gray-300 rounded focus:ring-[#937237]">
          <span class="text-sm text-gray-700">
            <strong>Allow Location Access</strong>
            <span class="text-gray-500 block text-xs mt-0.5">For personalized delivery options</span>
          </span>
        </label>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-3">
      <button id="cookie-accept-all" class="flex-1 bg-[#937237] hover:bg-[#7a5d2e] text-white py-2.5 px-4 rounded-lg font-semibold text-sm transition-all duration-300" style="background-color: #937237 !important;">
        Accept All
      </button>
      <button id="cookie-save-preferences" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-900 py-2.5 px-4 rounded-lg font-semibold text-sm transition-all duration-300">
        Save Preferences
      </button>
    </div>

    <!-- Learn More Link -->
    <div class="mt-4 text-center">
      <a href="{{ route('privacy') }}" class="text-xs text-[#937237] hover:underline">
        Learn more about our Privacy Policy
      </a>
    </div>
  </div>
</div>

<script>
(function() {
  'use strict';
  
  // Check if consent has been given
  const cookieConsent = localStorage.getItem('cookieConsent');
  const locationConsent = localStorage.getItem('locationConsent');
  
  const popup = document.getElementById('cookie-consent-popup');
  const closeBtn = document.getElementById('cookie-consent-close');
  const acceptAllBtn = document.getElementById('cookie-accept-all');
  const savePreferencesBtn = document.getElementById('cookie-save-preferences');
  const analyticsCheckbox = document.getElementById('cookie-analytics');
  const marketingCheckbox = document.getElementById('cookie-marketing');
  const locationCheckbox = document.getElementById('location-permission');
  
  // Show popup if consent hasn't been given
  if (!cookieConsent) {
    setTimeout(() => {
      popup.style.display = 'block';
      popup.classList.remove('hidden');
    }, 1000); // Show after 1 second
  }
  
  // Close button
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      hidePopup();
      // Save minimal consent (only essential cookies)
      localStorage.setItem('cookieConsent', JSON.stringify({
        essential: true,
        analytics: false,
        marketing: false,
        timestamp: new Date().toISOString()
      }));
    });
  }
  
  // Accept All button
  if (acceptAllBtn) {
    acceptAllBtn.addEventListener('click', () => {
      // Accept all cookies
      const consent = {
        essential: true,
        analytics: true,
        marketing: true,
        timestamp: new Date().toISOString()
      };
      localStorage.setItem('cookieConsent', JSON.stringify(consent));
      
      // Request location if checkbox is checked or if accepting all
      if (locationCheckbox && locationCheckbox.checked) {
        requestLocationPermission();
      }
      
      hidePopup();
      initializeCookies(consent);
    });
  }
  
  // Save Preferences button
  if (savePreferencesBtn) {
    savePreferencesBtn.addEventListener('click', () => {
      const consent = {
        essential: true,
        analytics: analyticsCheckbox ? analyticsCheckbox.checked : false,
        marketing: marketingCheckbox ? marketingCheckbox.checked : false,
        timestamp: new Date().toISOString()
      };
      localStorage.setItem('cookieConsent', JSON.stringify(consent));
      
      // Request location if checkbox is checked
      if (locationCheckbox && locationCheckbox.checked) {
        requestLocationPermission();
      }
      
      hidePopup();
      initializeCookies(consent);
    });
  }
  
  // Location checkbox change
  if (locationCheckbox) {
    locationCheckbox.addEventListener('change', (e) => {
      if (e.target.checked && !locationConsent) {
        // Don't request immediately, wait for save/accept
      }
    });
  }
  
  function hidePopup() {
    popup.style.display = 'none';
    popup.classList.add('hidden');
  }
  
  function requestLocationPermission() {
    if ('geolocation' in navigator) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          localStorage.setItem('locationConsent', 'granted');
          localStorage.setItem('userLocation', JSON.stringify({
            latitude: position.coords.latitude,
            longitude: position.coords.longitude,
            timestamp: new Date().toISOString()
          }));
          console.log('Location permission granted');
        },
        (error) => {
          localStorage.setItem('locationConsent', 'denied');
          console.log('Location permission denied:', error.message);
        },
        {
          enableHighAccuracy: false,
          timeout: 5000,
          maximumAge: 3600000 // 1 hour
        }
      );
    } else {
      console.log('Geolocation is not supported by this browser');
    }
  }
  
  function initializeCookies(consent) {
    // Initialize analytics if consented
    if (consent.analytics) {
      // Add Google Analytics or other analytics code here
      console.log('Analytics cookies enabled');
    }
    
    // Initialize marketing if consented
    if (consent.marketing) {
      // Add marketing/remarketing code here
      console.log('Marketing cookies enabled');
    }
  }
  
  // Load saved preferences
  if (cookieConsent) {
    try {
      const consent = JSON.parse(cookieConsent);
      if (analyticsCheckbox) analyticsCheckbox.checked = consent.analytics || false;
      if (marketingCheckbox) marketingCheckbox.checked = consent.marketing || false;
      initializeCookies(consent);
    } catch (e) {
      console.error('Error parsing cookie consent:', e);
    }
  }
  
  // Check location consent
  if (locationConsent === 'granted') {
    if (locationCheckbox) locationCheckbox.checked = true;
    // Optionally get location again
    requestLocationPermission();
  }
})();
</script>

<style>
#cookie-consent-popup {
  animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

#cookie-consent-popup input[type="checkbox"]:checked {
  background-color: #937237;
  border-color: #937237;
}

#cookie-consent-popup input[type="checkbox"]:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
