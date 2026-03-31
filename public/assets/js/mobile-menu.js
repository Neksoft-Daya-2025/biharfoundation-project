/**
 * Mobile Menu Handler
 * Optimized, reusable mobile menu functionality for both main and sticky headers
 */

(function() {
  'use strict';

  // Shared state and handlers (to prevent duplicate event listeners)
  let scrollPosition = 0;
  let globalResizeTimeout = null;
  const openMenus = new Set(); // Track all open menus
  const menuInstances = new Map(); // Store menu close functions for global handlers
  
  /**
   * Save scroll position before locking body
   */
  function saveScrollPosition() {
    scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
  }
  
  /**
   * Restore scroll position after unlocking body
   */
  function restoreScrollPosition() {
    window.scrollTo(0, scrollPosition);
  }
  
  /**
   * Lock body scroll
   */
  function lockBodyScroll() {
    if (openMenus.size === 0) {
      saveScrollPosition();
    }
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.width = '100%';
    document.body.style.top = `-${scrollPosition}px`;
    document.body.classList.add('menu-open');
  }
  
  /**
   * Unlock body scroll
   */
  function unlockBodyScroll() {
    // Save scroll position before clearing styles
    const top = document.body.style.top;
    const savedPosition = top ? parseInt(top.replace('-', '').replace('px', ''), 10) || scrollPosition : scrollPosition;
    
    document.body.style.overflow = '';
    document.body.style.position = '';
    document.body.style.width = '';
    document.body.style.top = '';
    document.body.classList.remove('menu-open');
    
    // Restore scroll position
    scrollPosition = savedPosition;
    restoreScrollPosition();
  }

  /**
   * Initialize mobile menu for a specific header
   * @param {Object} config - Configuration object
   * @param {string} config.toggleId - ID of the toggle button
   * @param {string} config.panelId - ID of the menu panel
   * @param {string} config.iconId - ID of the hamburger icon
   * @param {string} config.closeId - ID of the close icon
   */
  function initMobileMenu(config) {
    const { toggleId, panelId, iconId, closeId } = config;
    
    const toggle = document.getElementById(toggleId);
    const panel = document.getElementById(panelId);
    const icon = document.getElementById(iconId);
    const close = document.getElementById(closeId);
    
    if (!toggle || !panel || !icon || !close) {
      return false;
    }
    
    // Prevent multiple initializations
    if (toggle.hasAttribute('data-menu-initialized')) {
      return true;
    }
    toggle.setAttribute('data-menu-initialized', 'true');
    
    let isMenuOpen = false;
    
    /**
     * Open the mobile menu
     */
    function openMenu() {
      if (isMenuOpen) return;
      
      isMenuOpen = true;
      openMenus.add(panelId);
      
      panel.style.display = 'block';
      // Force reflow to ensure display is applied before transform
      panel.offsetHeight;
      setTimeout(() => {
        panel.classList.remove('translate-x-full');
        panel.classList.add('translate-x-0');
      }, 10);
      icon.classList.add('hidden');
      close.classList.remove('hidden');
      toggle.setAttribute('aria-expanded', 'true');
      lockBodyScroll();
    }
    
    /**
     * Close the mobile menu
     */
    function closeMenu() {
      if (!isMenuOpen) return;
      
      isMenuOpen = false;
      openMenus.delete(panelId);
      
      panel.classList.remove('translate-x-0');
      panel.classList.add('translate-x-full');
      setTimeout(() => {
        panel.style.display = 'none';
      }, 300);
      icon.classList.remove('hidden');
      close.classList.add('hidden');
      toggle.setAttribute('aria-expanded', 'false');
      
      // Only unlock if no other menus are open
      if (openMenus.size === 0) {
        unlockBodyScroll();
      }
    }
    
    /**
     * Toggle menu state
     */
    function toggleMenu(e) {
      if (e) {
        e.stopPropagation();
        e.preventDefault();
      }
      isMenuOpen ? closeMenu() : openMenu();
    }
    
    // Toggle button click handler
    toggle.addEventListener('click', toggleMenu);
    
    // Close menu when clicking on a link
    const links = panel.querySelectorAll('a');
    links.forEach(link => {
      link.addEventListener('click', () => {
        closeMenu();
      });
    });
    
    // Store close function for global handlers
    menuInstances.set(panelId, closeMenu);
    
    return true;
  }
  
  /**
   * Global handlers (only added once)
   */
  function setupGlobalHandlers() {
    // Close menu when clicking outside (only add once)
    if (!document.documentElement.hasAttribute('data-mobile-menu-global-handlers')) {
      document.documentElement.setAttribute('data-mobile-menu-global-handlers', 'true');
      
      document.addEventListener('click', function(e) {
        // Check all menu panels
        menuInstances.forEach((closeFn, panelId) => {
          const panel = document.getElementById(panelId);
          const toggle = document.getElementById(panelId.replace('-panel', '-toggle'));
          
          if (panel && toggle && openMenus.has(panelId)) {
            if (!panel.contains(e.target) && !toggle.contains(e.target)) {
              closeFn();
            }
          }
        });
      }, true); // Use capture phase for better event handling
      
      // Close menu on escape key (only add once)
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && openMenus.size > 0) {
          // Close all open menus
          menuInstances.forEach((closeFn) => {
            closeFn();
          });
        }
      });
      
      // Close menu on window resize to desktop size (only add once)
      window.addEventListener('resize', function() {
        clearTimeout(globalResizeTimeout);
        globalResizeTimeout = setTimeout(() => {
          if (window.innerWidth >= 768 && openMenus.size > 0) {
            // Close all open menus
            menuInstances.forEach((closeFn) => {
              closeFn();
            });
          }
        }, 100);
      });
    }
  }
  
  /**
   * Initialize all mobile menus
   */
  function initAllMobileMenus() {
    // Setup global handlers first (only once)
    setupGlobalHandlers();
    
    // Main header menu
    initMobileMenu({
      toggleId: 'mobile-menu-toggle',
      panelId: 'mobile-menu-panel',
      iconId: 'mobile-menu-icon',
      closeId: 'mobile-menu-close'
    });
    
    // Sticky header menu
    initMobileMenu({
      toggleId: 'sticky-mobile-menu-toggle',
      panelId: 'sticky-mobile-menu-panel',
      iconId: 'sticky-mobile-menu-icon',
      closeId: 'sticky-mobile-menu-close'
    });
  }
  
  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllMobileMenus);
  } else {
    initAllMobileMenus();
  }
  
  // Export for manual initialization if needed
  window.initMobileMenu = initMobileMenu;
  window.initAllMobileMenus = initAllMobileMenus;
})();
