/**
 * Dynamic SEO Meta Tags Injection System
 * Fetches page-specific SEO data from JSON files and injects meta tags
 */

(function() {
  'use strict';

  // Get current page name from path
  function getCurrentPageName() {
    const path = window.location.pathname;
    const pathParts = path.split('/').filter(p => p);
    const filename = pathParts[pathParts.length - 1] || 'index.html';
    
    // Map HTML files to SEO JSON files
    const pageMap = {
      'index.html': 'meta-home.json',
      '': 'meta-home.json',
      'about.html': 'meta-about.json',
      'services.html': 'meta-services.json',
      'contact.html': 'meta-contact.json',
      'blog.html': 'meta-blog.json',
      'privacy-policy.html': 'meta-privacy-policy.json',
      'terms-of-service.html': 'meta-terms-of-service.json'
    };

    return pageMap[filename] || pageMap[path] || 'meta-home.json';
  }

  // Load and inject SEO meta tags
  function loadSEO() {
    // Check if running from file:// protocol
    const isFileProtocol = window.location.protocol === 'file:';
    
    // If file:// protocol, try to get SEO from embedded script
    if (isFileProtocol) {
      const seoScript = document.getElementById('seo-data');
      if (seoScript) {
        try {
          const data = JSON.parse(seoScript.textContent);
          injectMetaTags(data);
          return;
        } catch (e) {
          console.error('Error parsing embedded SEO data:', e);
        }
      }
      // Fallback to default SEO for file:// protocol
      injectMetaTags({
        title: "Malbi's Kitchen - Authentic Surinamese Cuisine",
        description: "Experience authentic Surinamese cuisine delivered fresh to your door in Almere.",
        keywords: "Surinamese food, authentic cuisine, Almere, delivery, Malbi's Kitchen"
      });
      return;
    }

    // Normal fetch for http:// protocol
    const seoFile = getCurrentPageName();
    const seoPath = `seo/${seoFile}`;

    fetch(seoPath)
      .then(res => {
        if (!res.ok) {
          throw new Error(`Failed to load SEO data: ${res.status}`);
        }
        return res.json();
      })
      .then(data => {
        injectMetaTags(data);
      })
      .catch(err => {
        console.error('Error loading SEO data:', err);
        // Fallback to default SEO
        injectMetaTags({
          title: "Malbi's Kitchen - Authentic Surinamese Cuisine",
          description: "Experience authentic Surinamese cuisine delivered fresh to your door in Almere.",
          keywords: "Surinamese food, authentic cuisine, Almere, delivery, Malbi's Kitchen"
        });
      });
  }

  // Inject meta tags into document head
  function injectMetaTags(data) {
    const head = document.head;

    // Set page title
    if (data.title) {
      document.title = data.title;
    }

    // Remove existing meta tags if they exist (for dynamic updates)
    const existingMeta = head.querySelectorAll('meta[name="description"], meta[name="keywords"], meta[property^="og:"], meta[name^="twitter:"]');
    existingMeta.forEach(meta => meta.remove());

    // Create and inject meta tags
    const metaTags = [];

    // Description
    if (data.description) {
      metaTags.push(`<meta name="description" content="${escapeHtml(data.description)}">`);
    }

    // Keywords
    if (data.keywords) {
      metaTags.push(`<meta name="keywords" content="${escapeHtml(data.keywords)}">`);
    }

    // Open Graph tags
    if (data.title) {
      metaTags.push(`<meta property="og:title" content="${escapeHtml(data.title)}">`);
    }
    if (data.description) {
      metaTags.push(`<meta property="og:description" content="${escapeHtml(data.description)}">`);
    }
    if (data.image) {
      metaTags.push(`<meta property="og:image" content="${escapeHtml(data.image)}">`);
      metaTags.push(`<meta property="og:image:alt" content="${escapeHtml(data.title || 'Malbi\'s Kitchen')}">`);
    }
    metaTags.push(`<meta property="og:type" content="website">`);
    metaTags.push(`<meta property="og:url" content="${window.location.href}">`);

    // Twitter Card tags
    metaTags.push(`<meta name="twitter:card" content="summary_large_image">`);
    if (data.title) {
      metaTags.push(`<meta name="twitter:title" content="${escapeHtml(data.title)}">`);
    }
    if (data.description) {
      metaTags.push(`<meta name="twitter:description" content="${escapeHtml(data.description)}">`);
    }
    if (data.image) {
      metaTags.push(`<meta name="twitter:image" content="${escapeHtml(data.image)}">`);
    }

    // Additional meta tags
    if (data.author) {
      metaTags.push(`<meta name="author" content="${escapeHtml(data.author)}">`);
    }
    if (data.robots) {
      metaTags.push(`<meta name="robots" content="${escapeHtml(data.robots)}">`);
    }

    // Inject all meta tags
    head.insertAdjacentHTML('beforeend', metaTags.join('\n    '));

    // Inject canonical URL if not already present
    if (!head.querySelector('link[rel="canonical"]')) {
      const canonical = document.createElement('link');
      canonical.rel = 'canonical';
      canonical.href = window.location.href.split('?')[0]; // Remove query params
      head.appendChild(canonical);
    }
  }

  // Escape HTML to prevent XSS
  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  // Initialize SEO on page load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadSEO);
  } else {
    loadSEO();
  }
})();

