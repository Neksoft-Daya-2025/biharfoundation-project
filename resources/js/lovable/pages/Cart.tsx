import React, { useEffect, useState } from 'react';
import { motion, AnimatePresence } from 'motion/react';
import { Trash2, ShoppingBag, ArrowRight, Minus, Plus, CreditCard } from 'lucide-react';
import { useCart } from '../context/CartContext';
import { Link, useNavigate } from 'react-router-dom';
import { bookEvent, ApiError } from '../lib/api';

const Cart = () => {
  const navigate = useNavigate();
  const { cart, removeFromCart, updateQuantity, totalPrice, clearCart } = useCart();
  const [customerName, setCustomerName] = useState('');
  const [customerEmail, setCustomerEmail] = useState('');
  const [customerPhone, setCustomerPhone] = useState('');
  const [notes, setNotes] = useState('');
  const [checkoutLoading, setCheckoutLoading] = useState(false);
  const [checkoutError, setCheckoutError] = useState<string | null>(null);

  useEffect(() => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
    return () => observer.disconnect();
  }, []);

  if (cart.length === 0) {
    return (
      <div className="pt-32 pb-24 bg-background min-h-screen flex items-center justify-center">
        <div className="text-center px-6 scroll-reveal">
          <div className="w-24 h-24 bg-paper rounded-full flex items-center justify-center mx-auto mb-8 text-slate-300">
            <ShoppingBag size={40} />
          </div>
          <h1 className="text-4xl font-serif font-bold text-ink mb-6">Your bag is empty.</h1>
          <p className="text-slate-500 mb-12 max-w-md mx-auto">Explore our upcoming events and cultural programs to find something that inspires you.</p>
          <Link to="/events" className="btn-primary inline-flex items-center gap-4">
            Browse Events <ArrowRight size={18} />
          </Link>
        </div>
      </div>
    );
  }

  const handleCheckout = async (e: React.FormEvent) => {
    e.preventDefault();
    setCheckoutError(null);
    const missingId = cart.find((i) => !i.numericEventId);
    if (missingId) {
      setCheckoutError('Your bag contains an outdated item. Remove it and add the event again.');
      return;
    }
    setCheckoutLoading(true);
    try {
      for (const item of cart) {
        await bookEvent(item.numericEventId, {
          customer_name: customerName,
          customer_email: customerEmail,
          customer_phone: customerPhone || null,
          notes: notes || null,
          quantity: item.quantity,
        });
      }
      clearCart();
      navigate('/events', { replace: true });
    } catch (err) {
      if (err instanceof ApiError) {
        const msg =
          (err.body.message as string) ||
          (err.body.errors ? JSON.stringify(err.body.errors) : err.message);
        setCheckoutError(msg);
      } else {
        setCheckoutError('Checkout failed.');
      }
    } finally {
      setCheckoutLoading(false);
    }
  };

  return (
    <div className="bg-background min-h-screen">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[80vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Shopping Bag" 
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-ink/90 via-ink/70 to-ink/50"></div>
        </div>
        
        <div className="relative z-10 max-w-7xl mx-auto px-4 lg:px-12 py-4 md:py-16 text-center">
          <motion.span 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="hidden md:inline-block text-saffron font-bold uppercase tracking-[0.3em] text-sm mb-6"
          >
            Your Selection
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Shopping <span className="italic font-light text-saffron">Bag.</span>
          </motion.h1>
        </div>
      </section>

      <section className="px-6 lg:px-12 max-w-7xl mx-auto py-16 mt-8">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-24">
          {/* Cart Items */}
          <div className="lg:col-span-2 space-y-12 scroll-reveal">
            <AnimatePresence mode="popLayout">
              {cart.map((item) => (
                <motion.div 
                  key={item.eventId}
                  layout
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  exit={{ opacity: 0, x: -20 }}
                  className="flex flex-col md:flex-row gap-8 pb-12 border-b border-slate-100 group"
                >
                  <div className="w-full md:w-48 h-48 bg-paper overflow-hidden">
                    <img 
                      src={item.image} 
                      alt={item.title} 
                      className="w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                      referrerPolicy="no-referrer"
                    />
                  </div>
                  <div className="flex-1 flex flex-col justify-between">
                    <div>
                      <div className="flex justify-between items-start mb-4">
                        <div>
                          <span className="text-[10px] uppercase tracking-widest font-bold text-saffron mb-2 block">Event Ticket</span>
                          <h3 className="text-2xl font-serif font-bold text-ink">{item.title}</h3>
                        </div>
                        <p className="text-xl font-medium text-ink">€{(item.price * item.quantity).toFixed(2)}</p>
                      </div>
                      <p className="text-slate-500 text-sm mb-6">General Admission Ticket</p>
                    </div>
                    
                    <div className="flex items-center justify-between">
                      <div className="flex items-center gap-6 bg-paper px-4 py-2">
                        <button 
                          onClick={() => updateQuantity(item.eventId, Math.max(1, item.quantity - 1))}
                          className="text-slate-400 hover:text-ink transition-colors"
                        >
                          <Minus size={16} />
                        </button>
                        <span className="text-sm font-bold text-ink w-4 text-center">{item.quantity}</span>
                        <button 
                          onClick={() => updateQuantity(item.eventId, item.quantity + 1)}
                          className="text-slate-400 hover:text-ink transition-colors"
                        >
                          <Plus size={16} />
                        </button>
                      </div>
                      <button 
                        onClick={() => removeFromCart(item.eventId)}
                        className="flex items-center gap-2 text-[10px] uppercase tracking-widest font-bold text-slate-400 hover:text-red-500 transition-colors"
                      >
                        <Trash2 size={14} /> Remove
                      </button>
                    </div>
                  </div>
                </motion.div>
              ))}
            </AnimatePresence>
          </div>

          {/* Summary */}
          <div className="scroll-reveal">
            <div className="bg-paper p-12 lg:p-16 sticky top-32">
              <h2 className="text-2xl font-serif font-bold text-ink mb-12">Order Summary</h2>
              <div className="space-y-6 mb-12">
                <div className="flex justify-between text-sm">
                  <span className="text-slate-400">Subtotal</span>
                  <span className="text-ink font-medium">€{totalPrice.toFixed(2)}</span>
                </div>
                <div className="flex justify-between text-sm">
                  <span className="text-slate-400">Processing Fee</span>
                  <span className="text-ink font-medium">€0.00</span>
                </div>
                <div className="pt-6 border-t border-slate-200 flex justify-between items-end">
                  <span className="text-lg font-serif font-bold text-ink">Total</span>
                  <span className="text-3xl font-medium text-ink">€{totalPrice.toFixed(2)}</span>
                </div>
              </div>

              <form className="space-y-6" onSubmit={handleCheckout}>
                <div>
                  <label className="block text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-2">
                    Full name *
                  </label>
                  <input
                    required
                    className="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm"
                    value={customerName}
                    onChange={(e) => setCustomerName(e.target.value)}
                  />
                </div>
                <div>
                  <label className="block text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-2">
                    Email *
                  </label>
                  <input
                    required
                    type="email"
                    className="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm"
                    value={customerEmail}
                    onChange={(e) => setCustomerEmail(e.target.value)}
                  />
                </div>
                <div>
                  <label className="block text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-2">
                    Phone
                  </label>
                  <input
                    className="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm"
                    value={customerPhone}
                    onChange={(e) => setCustomerPhone(e.target.value)}
                  />
                </div>
                <div>
                  <label className="block text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-2">
                    Notes
                  </label>
                  <textarea
                    className="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm resize-none"
                    rows={2}
                    value={notes}
                    onChange={(e) => setNotes(e.target.value)}
                  />
                </div>
                {checkoutError && (
                  <p className="text-sm text-red-600">{checkoutError}</p>
                )}
                <button
                  type="submit"
                  disabled={checkoutLoading}
                  className="w-full btn-primary flex items-center justify-center gap-4 py-6 disabled:opacity-50"
                >
                  {checkoutLoading ? 'Submitting…' : (
                    <>Checkout <CreditCard size={18} /></>
                  )}
                </button>
                <p className="text-[10px] text-center text-slate-400 uppercase tracking-widest leading-relaxed">
                  Bookings are sent to the foundation. Payment steps may follow by email.
                </p>
              </form>

              <div className="mt-12 pt-12 border-t border-slate-200">
                <Link to="/events" className="flex items-center gap-4 text-[10px] uppercase tracking-widest font-bold text-ink hover:text-saffron transition-colors">
                  Continue Shopping <ArrowRight size={14} />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Cart;
