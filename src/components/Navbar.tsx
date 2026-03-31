import React, { useState, useEffect } from 'react';
import { Link, NavLink, useLocation } from 'react-router-dom';
import { Menu, X, ShoppingCart, Heart, ChevronUp, ChevronDown } from 'lucide-react';
import { useCart } from '../context/CartContext';
import { motion, AnimatePresence } from 'motion/react';

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);
  const [showScrollTop, setShowScrollTop] = useState(false);
  const [aboutDropdownOpen, setAboutDropdownOpen] = useState(false);
  const [mobileAboutOpen, setMobileAboutOpen] = useState(false);
  const { totalItems } = useCart();
  const location = useLocation();

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
      setShowScrollTop(window.scrollY > 500);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  useEffect(() => {
    setIsOpen(false);
    setAboutDropdownOpen(false);
    setMobileAboutOpen(false);
  }, [location]);

  const navLinks = [
    { name: 'Home', path: '/' },
    { name: 'Events', path: '/events' },
    { name: 'Membership', path: '/membership' },
    { name: 'Donations', path: '/donations' },
    { name: 'News', path: '/blog' },
    { name: 'Gallery', path: '/gallery' },
    { name: 'Contact', path: '/contact' },
  ];

  const aboutSubLinks = [
    { name: 'About Us', path: '/about' },
    { name: 'Executive Committee', path: '/about/executive-committee' },
  ];

  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const isAboutActive = location.pathname.startsWith('/about');

  return (
    <>
      <nav className={`fixed top-0 left-0 w-full z-50 transition-all duration-500 ${isScrolled ? 'bg-white py-0.5 shadow-2xl' : 'bg-white py-1'}`}>
        <div className="max-w-full mx-auto px-6 lg:px-16">
          <div className="flex justify-between items-center">
            <Link to="/" className="flex items-center group">
              <img 
                src="/images/Untitled-2.webp" 
                alt="Bihar Foundation Netherlands Logo" 
                className="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
              />
            </Link>

            {/* Desktop Nav */}
            <div className="hidden lg:flex items-center gap-6">
              <NavLink 
                to="/"
                className={({ isActive }) => `nav-link ${isActive ? 'active text-saffron' : 'text-ink'}`}
              >
                Home
              </NavLink>

              {/* About Dropdown */}
              <div 
                className="relative"
                onMouseEnter={() => setAboutDropdownOpen(true)}
                onMouseLeave={() => setAboutDropdownOpen(false)}
              >
                <button 
                  className={`nav-link flex items-center gap-1 ${isAboutActive ? 'active text-saffron' : 'text-ink'}`}
                >
                  About
                  <ChevronDown size={14} className={`transition-transform ${aboutDropdownOpen ? 'rotate-180' : ''}`} />
                </button>
                
                <AnimatePresence>
                  {aboutDropdownOpen && (
                    <motion.div
                      initial={{ opacity: 0, y: 10 }}
                      animate={{ opacity: 1, y: 0 }}
                      exit={{ opacity: 0, y: 10 }}
                      transition={{ duration: 0.2 }}
                      className="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden"
                    >
                      {aboutSubLinks.map((link) => (
                        <NavLink
                          key={link.path}
                          to={link.path}
                          className={({ isActive }) => 
                            `block px-5 py-3 text-sm font-medium transition-colors ${
                              isActive 
                                ? 'bg-saffron/10 text-saffron' 
                                : 'text-ink hover:bg-slate-50 hover:text-saffron'
                            }`
                          }
                        >
                          {link.name}
                        </NavLink>
                      ))}
                    </motion.div>
                  )}
                </AnimatePresence>
              </div>

              {navLinks.slice(1).map(link => (
                <NavLink 
                  key={link.path} 
                  to={link.path}
                  className={({ isActive }) => `nav-link ${isActive ? 'active text-saffron' : 'text-ink'}`}
                >
                  {link.name}
                </NavLink>
              ))}
              <div className="flex items-center gap-4 ml-4">
                <Link to="/cart" className="relative p-2 text-ink hover:text-saffron transition-colors">
                  <ShoppingCart size={20} strokeWidth={1.5} />
                  {totalItems > 0 && (
                    <span className="absolute -top-1 -right-1 bg-saffron text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                      {totalItems}
                    </span>
                  )}
                </Link>
                <Link to="/donations" className="btn-primary py-3 px-6 text-[10px]">
                  <Heart size={14} strokeWidth={2} />
                  Donate
                </Link>
                <img 
                  src="/images/Magadh-Mandal-Logo-1024x1024.webp" 
                  alt="Magadh Mandal Logo" 
                  className="h-20 w-auto object-contain"
                />
              </div>
            </div>

            {/* Mobile Toggle */}
            <div className="lg:hidden flex items-center gap-6">
              <Link to="/cart" className="relative p-2 text-ink">
                <ShoppingCart size={22} strokeWidth={1.5} />
                {totalItems > 0 && (
                  <span className="absolute -top-1 -right-1 bg-saffron text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                    {totalItems}
                  </span>
                )}
              </Link>
              <button onClick={() => setIsOpen(!isOpen)} className="text-ink p-2">
                {isOpen ? <X size={28} strokeWidth={1.5} /> : <Menu size={28} strokeWidth={1.5} />}
              </button>
            </div>
          </div>
        </div>

        {/* Mobile Menu */}
        <AnimatePresence>
          {isOpen && (
            <motion.div 
              initial={{ opacity: 0, y: -20 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -20 }}
              className="lg:hidden absolute top-full left-0 w-full bg-white border-t border-slate-100 shadow-2xl overflow-hidden"
            >
              <div className="px-6 py-6 space-y-3">
                <NavLink 
                  to="/"
                  className={({ isActive }) => `block text-xs font-medium uppercase tracking-widest ${isActive ? 'text-saffron' : 'text-ink'}`}
                >
                  Home
                </NavLink>

                {/* Mobile About Dropdown */}
                <div>
                  <button
                    onClick={() => setMobileAboutOpen(!mobileAboutOpen)}
                    className={`flex items-center justify-between w-full text-xs font-medium uppercase tracking-widest ${isAboutActive ? 'text-saffron' : 'text-ink'}`}
                  >
                    About
                    <ChevronDown size={14} className={`transition-transform ${mobileAboutOpen ? 'rotate-180' : ''}`} />
                  </button>
                  <AnimatePresence>
                    {mobileAboutOpen && (
                      <motion.div
                        initial={{ height: 0, opacity: 0 }}
                        animate={{ height: 'auto', opacity: 1 }}
                        exit={{ height: 0, opacity: 0 }}
                        className="overflow-hidden"
                      >
                        <div className="pl-4 pt-2 space-y-2">
                          {aboutSubLinks.map((link) => (
                            <NavLink
                              key={link.path}
                              to={link.path}
                              className={({ isActive }) => 
                                `block text-xs font-medium ${isActive ? 'text-saffron' : 'text-ink/70'}`
                              }
                            >
                              {link.name}
                            </NavLink>
                          ))}
                        </div>
                      </motion.div>
                    )}
                  </AnimatePresence>
                </div>

                {navLinks.slice(1).map(link => (
                  <NavLink 
                    key={link.path} 
                    to={link.path}
                    className={({ isActive }) => `block text-xs font-medium uppercase tracking-widest ${isActive ? 'text-saffron' : 'text-ink'}`}
                  >
                    {link.name}
                  </NavLink>
                ))}
                <div className="pt-8">
                  <Link to="/donations" className="btn-primary w-full py-5 text-sm">
                    <Heart size={18} strokeWidth={2} />
                    Support Our Cause
                  </Link>
                </div>
              </div>
            </motion.div>
          )}
        </AnimatePresence>
      </nav>

      {/* Scroll to Top */}
      <AnimatePresence>
        {showScrollTop && (
          <motion.button
            initial={{ opacity: 0, scale: 0.5 }}
            animate={{ opacity: 1, scale: 1 }}
            exit={{ opacity: 0, scale: 0.5 }}
            onClick={scrollToTop}
            className="fixed bottom-10 right-10 z-50 w-14 h-14 bg-ink text-white rounded-full flex items-center justify-center shadow-2xl hover:bg-saffron transition-colors group"
          >
            <ChevronUp size={24} className="group-hover:-translate-y-1 transition-transform" />
          </motion.button>
        )}
      </AnimatePresence>
    </>
  );
};

export default Navbar;
