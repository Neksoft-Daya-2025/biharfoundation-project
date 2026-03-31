/**
 * Main JavaScript file for dynamic includes and common functionality
 * Works with both local server (http://) and direct file access (file://)
 */

// Check if running from file:// protocol
const isFileProtocol = window.location.protocol === 'file:';

// Load header dynamically
function loadHeader() {
  const headerContainer = document.getElementById('header');
  if (!headerContainer) return;

  // If file:// protocol, load from embedded script or skip
  if (isFileProtocol) {
    // Try to get header from embedded script tag
    const headerScript = document.getElementById('header-content');
    if (headerScript) {
      headerContainer.innerHTML = headerScript.textContent;
      initializeHeader();
      return;
    }
    // If no embedded content, show message
    console.warn('Running from file:// protocol. Header will not load dynamically. Use a local server or embed header content.');
    return;
  }

  // Normal fetch for http:// protocol
  const includesPath = 'includes/header.html';
  fetch(includesPath)
    .then(res => {
      if (!res.ok) throw new Error('Failed to load header');
      return res.text();
    })
    .then(html => {
      headerContainer.innerHTML = html;
      initializeHeader();
    })
    .catch(err => {
      console.error('Error loading header:', err);
    });
}

// Load sticky header dynamically
function loadStickyHeader() {
  const stickyHeaderContainer = document.getElementById('sticky-header');
  if (!stickyHeaderContainer) return;

  // If file:// protocol, load from embedded script or skip
  if (isFileProtocol) {
    // Try to get sticky header from embedded script tag
    const stickyHeaderScript = document.getElementById('sticky-header-content');
    if (stickyHeaderScript) {
      stickyHeaderContainer.innerHTML = stickyHeaderScript.textContent;
      initializeStickyHeader();
      return;
    }
    // If no embedded content, show message
    console.warn('Running from file:// protocol. Sticky header will not load dynamically. Use a local server or embed sticky header content.');
    return;
  }

  // Normal fetch for http:// protocol
  const includesPath = 'includes/sticky-header.html';
  fetch(includesPath)
    .then(res => {
      if (!res.ok) throw new Error('Failed to load sticky header');
      return res.text();
    })
    .then(html => {
      stickyHeaderContainer.innerHTML = html;
      initializeStickyHeader();
    })
    .catch(err => {
      console.error('Error loading sticky header:', err);
    });
}

// Load footer dynamically
function loadFooter() {
  const footerContainer = document.getElementById('footer');
  if (!footerContainer) return;

  // If file:// protocol, load from embedded script or skip
  if (isFileProtocol) {
    // Try to get footer from embedded script tag
    const footerScript = document.getElementById('footer-content');
    if (footerScript) {
      footerContainer.innerHTML = footerScript.textContent;
      return;
    }
    // If no embedded content, show message
    console.warn('Running from file:// protocol. Footer will not load dynamically. Use a local server or embed footer content.');
    return;
  }

  // Normal fetch for http:// protocol
  const includesPath = 'includes/footer.html';
  fetch(includesPath)
    .then(res => {
      if (!res.ok) throw new Error('Failed to load footer');
      return res.text();
    })
    .then(html => {
      footerContainer.innerHTML = html;
    })
    .catch(err => {
      console.error('Error loading footer:', err);
    });
}

// Initialize header functionality
function initializeHeader() {
  // Mobile menu is now handled by mobile-menu.js
  
  // Highlight active navigation link
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('[data-nav-link]');
  navLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPath || (currentPath === '/' && href === '/index.html')) {
      link.classList.add('text-[hsl(var(--gold))]');
      link.classList.remove('text-white');
    }
  });
}

// Initialize sticky header functionality
function initializeStickyHeader() {
  // Mobile menu is now handled by mobile-menu.js
  
  // Highlight active navigation link in sticky header
  const currentPath = window.location.pathname;
  const stickyNavLinks = document.querySelectorAll('[data-sticky-nav-link]');
  stickyNavLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPath || (currentPath === '/' && href === '/index.html')) {
      link.classList.add('text-[#937237]');
      link.classList.remove('text-gray-900');
    }
  });
  
  // Initialize scroll behavior after sticky header is loaded
  initializeScrollBehavior();
}

// Initialize scroll behavior for header switching
let scrollBehaviorInitialized = false;
function initializeScrollBehavior() {
  // Prevent multiple initializations
  if (scrollBehaviorInitialized) return;
  
  const mainHeader = document.querySelector('[data-main-header]');
  const stickyHeader = document.querySelector('[data-sticky-header]');
  
  // Wait for main header to be loaded (sticky header is optional)
  if (!mainHeader) {
    // Retry after a short delay if header isn't ready
    setTimeout(initializeScrollBehavior, 100);
    return;
  }
  
  scrollBehaviorInitialized = true;
  let lastScroll = 0;
  let scrollTimeout;
  
  function handleScroll() {
    const mainHeader = document.querySelector('[data-main-header]');
    const stickyHeader = document.querySelector('[data-sticky-header]');
    
    if (!mainHeader) {
      console.warn('Main header not found');
      return;
    }
    
    const currentScroll = window.pageYOffset || window.scrollY || document.documentElement.scrollTop;
    
    // Make main header sticky with white background when scrolling
    if (currentScroll > 100) {
      console.log('Scroll > 100, making header white. Current scroll:', currentScroll);
      // Add sticky class
      mainHeader.classList.add('is-sticky');
      
      // Remove transparent background class FIRST - this is critical!
      if (mainHeader.classList.contains('bg-white/10')) {
        mainHeader.classList.remove('bg-white/10');
      }
      
      // Also try removing any bg-white variant classes
      Array.from(mainHeader.classList).forEach(cls => {
        if (cls.startsWith('bg-white')) {
          mainHeader.classList.remove(cls);
        }
      });
      
      // Get current style attribute
      let currentStyle = mainHeader.getAttribute('style') || '';
      
      // Remove any existing background styles from inline style
      currentStyle = currentStyle.replace(/background[^;]*;?/gi, '');
      currentStyle = currentStyle.replace(/background-color[^;]*;?/gi, '');
      
      // Add white background with !important
      currentStyle += ' background-color: #ffffff !important; background: #ffffff !important; background-image: none !important;';
      
      // Set the style attribute directly
      mainHeader.setAttribute('style', currentStyle.trim());
      
      // Also set via style object as backup
      mainHeader.style.setProperty('background-color', '#ffffff', 'important');
      mainHeader.style.setProperty('background', '#ffffff', 'important');
      mainHeader.style.setProperty('background-image', 'none', 'important');
      
      // Force a reflow to ensure styles are applied
      void mainHeader.offsetHeight;
      
      // Ensure header is visible
      mainHeader.style.transform = 'translateY(0)';
      mainHeader.style.opacity = '1';
      mainHeader.style.pointerEvents = 'auto';
      mainHeader.style.visibility = 'visible';
      mainHeader.style.backdropFilter = 'none';
      mainHeader.style.webkitBackdropFilter = 'none';
      
      // Change text colors to dark for visibility on white background
      const mainNavLinks = mainHeader.querySelectorAll('nav a, nav a[data-nav-link], nav li a');
      mainNavLinks.forEach(link => {
        link.style.cssText += 'color: #1b1b18 !important;';
      });
      
      const mainButtons = mainHeader.querySelectorAll('button:not([style*="background-color"])');
      mainButtons.forEach(button => {
        button.style.cssText += 'color: #1b1b18 !important;';
      });
      
      const mainSvgIcons = mainHeader.querySelectorAll('svg:not([class*="text-white"])');
      mainSvgIcons.forEach(svg => {
        if (!svg.closest('a[style*="background-color"]')) {
          svg.style.cssText += 'color: #1b1b18 !important;';
        }
      });
      
      // Hide sticky header (not needed since main header becomes sticky)
      if (stickyHeader) {
        stickyHeader.style.display = 'none';
        stickyHeader.style.visibility = 'hidden';
        stickyHeader.style.opacity = '0';
        stickyHeader.style.transform = 'translateY(-100%)';
      }
    } else {
      console.log('Scroll <= 100, making header transparent. Current scroll:', currentScroll);
      // Remove sticky class
      mainHeader.classList.remove('is-sticky');
      
      // Reset header to transparent
      mainHeader.style.cssText += 'background-color: rgba(255, 255, 255, 0.1) !important; background: rgba(255, 255, 255, 0.1) !important;';
      mainHeader.classList.add('bg-white/10');
      
      // Ensure header is visible
      mainHeader.style.transform = 'translateY(0)';
      mainHeader.style.opacity = '1';
      mainHeader.style.pointerEvents = 'auto';
      mainHeader.style.visibility = 'visible';
      
      // Reset text colors to white for visibility on transparent background
      const mainNavLinks = mainHeader.querySelectorAll('nav a, nav a[data-nav-link], nav li a');
      mainNavLinks.forEach(link => {
        link.style.cssText += 'color: #ffffff !important;';
      });
      
      const mainButtons = mainHeader.querySelectorAll('button:not([style*="background-color"])');
      mainButtons.forEach(button => {
        button.style.cssText += 'color: #ffffff !important;';
      });
      
      const mainSvgIcons = mainHeader.querySelectorAll('svg:not([class*="text-white"])');
      mainSvgIcons.forEach(svg => {
        if (!svg.closest('a[style*="background-color"]')) {
          svg.style.cssText += 'color: #ffffff !important;';
        }
      });
      
      // Hide sticky header
      if (stickyHeader) {
        stickyHeader.style.display = 'none';
        stickyHeader.style.visibility = 'hidden';
        stickyHeader.style.opacity = '0';
        stickyHeader.style.transform = 'translateY(-100%)';
        stickyHeader.style.pointerEvents = 'none';
      }
    }
    
    lastScroll = currentScroll;
  }
  
  // Use requestAnimationFrame for better performance
  window.addEventListener('scroll', function() {
    if (!scrollTimeout) {
      window.requestAnimationFrame(() => {
        handleScroll();
        scrollTimeout = null;
      });
      scrollTimeout = true;
    }
  }, { passive: true });
  
  // Also use direct scroll listener as backup
  window.addEventListener('scroll', handleScroll, { passive: true });
  
  // Initial check
  handleScroll();
  
  // Debug: Log that scroll handler is initialized
  console.log('Scroll handler initialized for header sticky behavior');
}

// Hero Slider Functionality
function initializeHeroSlider() {
  const heroSection = document.getElementById('hero-section');
  if (!heroSection) return;

  const slides = heroSection.querySelectorAll('.hero-slide');
  const dots = heroSection.querySelectorAll('.hero-dot');
  let currentSlide = 0;
  let slideInterval;
  let isTransitioning = false;

  // Function to show a specific slide
  function showSlide(index) {
    // Prevent multiple transitions at once
    if (isTransitioning) return;
    
    isTransitioning = true;
    
    // Get the next slide element
    const nextSlide = slides[index];
    const currentSlideElement = slides[currentSlide];
    
    // Crossfade: both slides transition simultaneously (no black screen)
    if (nextSlide && nextSlide !== currentSlideElement) {
      // Make next slide visible first (starts at opacity 0, will fade in)
      nextSlide.style.zIndex = '3'; // Higher z-index for incoming slide
      nextSlide.classList.add('active');
      if (dots[index]) dots[index].classList.add('active');
      
      // Immediately start fading out current slide (both happen at same time)
      currentSlideElement.style.zIndex = '2'; // Lower z-index for outgoing slide
      currentSlideElement.classList.remove('active');
      if (dots[currentSlide]) dots[currentSlide].classList.remove('active');
      
      // Clean up after transition completes
      setTimeout(() => {
        // Remove active from all slides except the new one
        slides.forEach((slide, i) => {
          if (slide !== nextSlide) {
            slide.classList.remove('active');
            slide.style.zIndex = '1'; // Reset z-index
            if (dots[i] && i !== index) dots[i].classList.remove('active');
          }
        });
        
        // Set final z-index for active slide
        nextSlide.style.zIndex = '2';
        currentSlide = index;
        isTransitioning = false;
      }, 800); // Match transition duration
    } else {
      // Fallback for same slide or edge cases
      slides.forEach((slide, i) => {
        slide.classList.remove('active');
        slide.style.zIndex = '1';
        if (dots[i]) dots[i].classList.remove('active');
      });
      if (nextSlide) {
        nextSlide.classList.add('active');
        nextSlide.style.zIndex = '2';
        if (dots[index]) dots[index].classList.add('active');
      }
      currentSlide = index;
      isTransitioning = false;
    }
  }

  // Function to go to next slide
  function nextSlide() {
    if (isTransitioning) return;
    const next = (currentSlide + 1) % slides.length;
    showSlide(next);
  }

  // Auto-slide functionality - continuous loop
  function startAutoSlide() {
    stopAutoSlide(); // Clear any existing interval
    // Continuous loop - slides change every 5 seconds consistently
    slideInterval = setInterval(() => {
      nextSlide();
    }, 5000); // Fixed 5 second interval for consistent looping
  }

  function stopAutoSlide() {
    if (slideInterval) {
      clearInterval(slideInterval);
      slideInterval = null;
    }
  }

  // Dot navigation
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      if (isTransitioning) return;
      showSlide(index);
      stopAutoSlide();
      startAutoSlide(); // Restart auto-slide
    });
  });

  // Pause on hover
  heroSection.addEventListener('mouseenter', stopAutoSlide);
  heroSection.addEventListener('mouseleave', startAutoSlide);

  // Start auto-slide loop immediately - continuous looping
  // The loop will continue automatically: slide 0 -> slide 1 -> slide 0 -> slide 1...
  startAutoSlide();
}

// Parallax Effect
function initializeParallax() {
  const parallaxElements = document.querySelectorAll('[data-parallax]');
  const heroSection = document.getElementById('hero-section');

  if (!heroSection || parallaxElements.length === 0) return;

  function updateParallax() {
    const scrollTop = window.pageYOffset;
    const heroHeight = heroSection.offsetHeight;
    const heroTop = heroSection.offsetTop;

    if (scrollTop < heroTop + heroHeight) {
      const scrollProgress = Math.max(0, (scrollTop - heroTop) / heroHeight);
      const parallaxOffset = scrollProgress * 30; // Reduced parallax intensity for smoother effect

      parallaxElements.forEach(element => {
        // Only apply parallax to active slide's background
        const slide = element.closest('.hero-slide');
        if (slide && slide.classList.contains('active')) {
          element.style.transform = `translateY(${parallaxOffset}px) scale(1.05)`;
        }
      });
    } else {
      // Reset when scrolled past hero section
      parallaxElements.forEach(element => {
        element.style.transform = 'translateY(0) scale(1.05)';
      });
    }
  }

  // Use requestAnimationFrame for smoother performance
  let ticking = false;
  function onScroll() {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        updateParallax();
        ticking = false;
      });
      ticking = true;
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  updateParallax();
}

// Background Zoom Animation
function initializeBackgroundZoom() {
  const bgImages = document.querySelectorAll('.hero-bg-image');
  
  bgImages.forEach((image, index) => {
    // Only animate active slide initially
    const slide = image.closest('.hero-slide');
    if (slide && slide.classList.contains('active')) {
      // Set initial scale
      image.style.transform = 'scale(1.05)';
      image.style.transition = 'transform 0.3s ease-out';
      
      // Apply faster zoom animation only to active slide (changed from 15s to 8s)
      setTimeout(() => {
        if (slide.classList.contains('active')) {
          image.style.transition = 'transform 8s ease-in-out';
          image.style.transform = 'scale(1.15)';
        }
      }, 500);
    } else {
      // Non-active slides start at normal scale
      image.style.transform = 'scale(1.05)';
      image.style.transition = 'transform 0.3s ease-out';
    }
    
    // Update zoom when slide becomes active
    const observer = new MutationObserver(() => {
      if (slide && slide.classList.contains('active')) {
        // Reset to start position then zoom
        image.style.transition = 'transform 0.3s ease-out';
        image.style.transform = 'scale(1.05)';
        setTimeout(() => {
          if (slide.classList.contains('active')) {
            image.style.transition = 'transform 8s ease-in-out';
            image.style.transform = 'scale(1.15)';
          }
        }, 300);
      } else {
        image.style.transition = 'transform 0.3s ease-out';
        image.style.transform = 'scale(1.05)';
      }
    });
    
    if (slide) {
      observer.observe(slide, { attributes: true, attributeFilter: ['class'] });
    }
  });
}

// Scroll-triggered Animations (AOS-like effect)
function initializeScrollAnimations() {
  const animatedElements = document.querySelectorAll('[data-aos]');
  
  if (animatedElements.length === 0) return;

  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const element = entry.target;
        const animationType = element.getAttribute('data-aos');
        
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
        element.classList.add('aos-animate');
        
        observer.unobserve(element);
      }
    });
  }, observerOptions);

  animatedElements.forEach(element => {
    const animationType = element.getAttribute('data-aos');
    
    // Set initial state based on animation type
    if (animationType === 'slide-up' || animationType === 'fade-in-delay' || animationType === 'fade-in-delay-2') {
      element.style.opacity = '0';
      element.style.transform = 'translateY(30px)';
      element.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
    } else if (animationType === 'fade-in') {
      element.style.opacity = '0';
      element.style.transform = 'translateY(10px)';
      element.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
    }
    
    observer.observe(element);
  });
}

// Testimonials Carousel Functionality
function initializeTestimonialsCarousel() {
  const track = document.getElementById('testimonials-track');
  const prevBtn = document.getElementById('testimonial-prev');
  const nextBtn = document.getElementById('testimonial-next');
  const dots = document.querySelectorAll('.testimonial-dot');
  const indicator = document.getElementById('testimonial-indicator');
  
  if (!track || !prevBtn || !nextBtn) return;
  
  let currentSlide = 0;
  const slides = track.querySelectorAll('.testimonial-slide');
  const totalSlides = slides.length;
  let autoSlideInterval;
  
  function updateCarousel() {
    const slideWidth = slides[0].offsetWidth;
    track.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
    
    // Update indicator bar position
    if (indicator) {
      const dotsContainer = indicator.parentElement;
      const dotsArray = Array.from(dotsContainer.querySelectorAll('.testimonial-dot'));
      const activeDot = dotsArray[currentSlide];
      if (activeDot && dotsContainer) {
        const containerRect = dotsContainer.getBoundingClientRect();
        const dotRect = activeDot.getBoundingClientRect();
        const relativePosition = dotRect.left - containerRect.left;
        indicator.style.left = `${relativePosition}px`;
        indicator.style.transform = 'translateY(-50%)';
      }
    }
    
    // Update dots
    dots.forEach((dot, index) => {
      if (index === currentSlide) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }
  
  function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  }
  
  function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
  }
  
  function goToSlide(index) {
    currentSlide = index;
    updateCarousel();
  }
  
  function startAutoSlide() {
    stopAutoSlide();
    autoSlideInterval = setInterval(nextSlide, 5000);
  }
  
  function stopAutoSlide() {
    if (autoSlideInterval) {
      clearInterval(autoSlideInterval);
      autoSlideInterval = null;
    }
  }
  
  // Event listeners
  nextBtn.addEventListener('click', () => {
    nextSlide();
    stopAutoSlide();
    startAutoSlide();
  });
  
  prevBtn.addEventListener('click', () => {
    prevSlide();
    stopAutoSlide();
    startAutoSlide();
  });
  
  // Hover effects for arrows
  prevBtn.addEventListener('mouseenter', () => {
    prevBtn.style.backgroundColor = '#937237';
    prevBtn.querySelector('svg').style.color = '#ffffff';
  });
  prevBtn.addEventListener('mouseleave', () => {
    prevBtn.style.backgroundColor = 'transparent';
    prevBtn.querySelector('svg').style.color = '#937237';
  });
  
  nextBtn.addEventListener('mouseenter', () => {
    nextBtn.style.backgroundColor = '#937237';
    nextBtn.querySelector('svg').style.color = '#ffffff';
  });
  nextBtn.addEventListener('mouseleave', () => {
    nextBtn.style.backgroundColor = 'transparent';
    nextBtn.querySelector('svg').style.color = '#937237';
  });
  
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      goToSlide(index);
      stopAutoSlide();
      startAutoSlide();
    });
  });
  
  // Pause on hover
  const carouselContainer = track.closest('.relative');
  if (carouselContainer) {
    carouselContainer.addEventListener('mouseenter', stopAutoSlide);
    carouselContainer.addEventListener('mouseleave', startAutoSlide);
  }
  
  // Initialize
  updateCarousel();
  startAutoSlide();
  
  // Handle window resize
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      updateCarousel();
    }, 250);
  });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
  // Order Form Tab Switching
  function initializeOrderTabs() {
    const tabs = document.querySelectorAll('.order-tab');
    if (tabs.length === 0) return;
    
    tabs.forEach(tab => {
      tab.addEventListener('click', function() {
        const tabType = this.getAttribute('data-tab');
        
        // Remove active class from all tabs
        tabs.forEach(t => {
          t.classList.remove('active');
          if (t.getAttribute('data-tab') === 'deliver') {
            t.style.backgroundColor = '#e5e7eb';
            t.style.color = '#4b5563';
          } else {
            t.style.backgroundColor = '#e5e7eb';
            t.style.color = '#4b5563';
          }
        });
        
        // Add active class to clicked tab
        this.classList.add('active');
        if (tabType === 'deliver') {
          this.style.backgroundColor = '#937237';
          this.style.color = 'white';
        } else {
          this.style.backgroundColor = '#937237';
          this.style.color = 'white';
        }
      });
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    loadHeader();
    loadStickyHeader(); // Load sticky header
    loadFooter();
    initializeHeroSlider();
    initializeParallax();
    initializeBackgroundZoom();
    initializeScrollAnimations();
    initializeOrderTabs();
    initializeTestimonialsCarousel();
  });
} else {
  loadHeader();
  loadStickyHeader(); // Load sticky header
  loadFooter();
  initializeHeroSlider();
  initializeParallax();
  initializeBackgroundZoom();
  initializeScrollAnimations();
  initializeOrderTabs();
  initializeTestimonialsCarousel();
}

