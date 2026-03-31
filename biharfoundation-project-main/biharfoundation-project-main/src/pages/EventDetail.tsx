import React, { useState } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { motion } from 'motion/react';
import { events } from '../data';
import { getEventCategory } from '../utils/eventUtils';
import { Calendar, MapPin, Clock, ArrowLeft, Plus, Minus, ShoppingCart, Share2, CheckCircle, Camera } from 'lucide-react';
import { useCart } from '../context/CartContext';
import Lightbox from '../components/Lightbox';
import { useLightbox } from '../hooks/useLightbox';

const formatEventContent = (content: string) => {
  const paragraphs = content.split('\n\n');
  
  return paragraphs.map((paragraph, index) => {
    if (paragraph.startsWith('**') && paragraph.includes('**')) {
      const headingMatch = paragraph.match(/^\*\*(.+?)\*\*/);
      if (headingMatch) {
        const heading = headingMatch[1];
        const restContent = paragraph.replace(/^\*\*.+?\*\*\s*/, '');
        return (
          <div key={index} className="mb-8">
            <h3 className="text-xl md:text-2xl font-serif font-bold text-ink mb-3 flex items-center gap-3">
              <span className="w-8 h-1 bg-saffron rounded-full"></span>
              {heading}
            </h3>
            {restContent && <p className="text-ink/70 leading-relaxed text-base md:text-lg">{restContent}</p>}
          </div>
        );
      }
    }
    
    if (paragraph.trim()) {
      return (
        <p key={index} className="text-ink/70 leading-relaxed text-base md:text-lg mb-6">
          {paragraph}
        </p>
      );
    }
    return null;
  });
};

const EventDetail = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const event = events.find(e => e.id === id);
  const { addToCart } = useCart();
  const [quantity, setQuantity] = useState(1);
  
  const galleryImages = event?.gallery || [];
  const { isOpen, currentIndex, openLightbox, closeLightbox, goToNext, goToPrev } = useLightbox(galleryImages);

  if (!event) {
    return (
      <div className="pt-40 pb-20 text-center">
        <h2 className="text-2xl font-bold mb-4">Event not found</h2>
        <Link to="/events" className="btn-primary inline-flex">Back to Events</Link>
      </div>
    );
  }

  const eventCategory = getEventCategory(event.date);
  const isPastEvent = eventCategory === 'past';

  const handleAddToCart = () => {
    addToCart({
      eventId: event.id,
      title: event.title,
      price: event.price,
      quantity: quantity,
      image: event.image
    });
    navigate('/cart');
  };

  return (
    <div className="pt-20 pb-24 bg-slate-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <Link to="/events" className="inline-flex items-center gap-2 text-slate-500 hover:text-saffron mb-8 transition-colors">
          <ArrowLeft size={20} /> Back to Events
        </Link>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-12">
            <motion.div 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100"
            >
              <div className="relative h-[400px] overflow-hidden">
                <img 
                  src={event.image} 
                  alt={event.title} 
                  className={`w-full h-full object-cover ${isPastEvent ? 'grayscale-[30%]' : ''}`}
                  referrerPolicy="no-referrer"
                />
                {isPastEvent && (
                  <div className="absolute top-6 left-6 bg-ink/90 text-white px-5 py-2.5 rounded-full text-sm font-bold uppercase tracking-wider flex items-center gap-2">
                    <CheckCircle size={16} />
                    Event Completed
                  </div>
                )}
              </div>
              <div className="p-8 md:p-12">
                <div className="flex flex-wrap gap-4 mb-6">
                  <div className="flex items-center gap-2 text-sm font-medium text-slate-500 bg-slate-50 px-4 py-2 rounded-full">
                    <Calendar size={16} className="text-saffron" />
                    {new Date(event.date).toLocaleDateString('en-NL', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}
                  </div>
                  <div className="flex items-center gap-2 text-sm font-medium text-slate-500 bg-slate-50 px-4 py-2 rounded-full">
                    <Clock size={16} className="text-saffron" />
                    {event.time}
                  </div>
                </div>
                <h1 className="text-4xl md:text-5xl font-serif font-bold text-slate-900 mb-8">{event.title}</h1>
                
                {/* Introduction */}
                <div className="bg-gradient-to-r from-saffron/5 to-transparent border-l-4 border-saffron pl-6 py-4 mb-8 rounded-r-lg">
                  <p className="text-lg md:text-xl text-ink/80 leading-relaxed font-medium">{event.description}</p>
                </div>
                
                {/* Formatted Content */}
                <div className="space-y-2">
                  {formatEventContent(event.longDescription)}
                </div>
              </div>
            </motion.div>

            {/* Gallery */}
            {event.gallery && event.gallery.length > 0 && (
              <section>
                <div className="flex items-center gap-3 mb-6">
                  <Camera size={24} className="text-saffron" />
                  <h2 className="text-2xl font-serif font-bold text-slate-900">
                    {isPastEvent ? 'Event Highlights' : 'Event Gallery'}
                  </h2>
                  <span className="text-sm text-slate-400 ml-auto">Click to enlarge</span>
                </div>
                <div className="columns-2 md:columns-3 gap-4 space-y-4">
                  {event.gallery.map((img, idx) => (
                    <div 
                      key={idx} 
                      className="break-inside-avoid rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow cursor-pointer group"
                      onClick={() => openLightbox(idx)}
                    >
                      <img 
                        src={img} 
                        alt={`Gallery ${idx}`} 
                        className="w-full h-auto object-contain group-hover:scale-105 transition-transform duration-500"
                        referrerPolicy="no-referrer"
                      />
                    </div>
                  ))}
                </div>
              </section>
            )}

            {/* Lightbox */}
            <Lightbox
              images={galleryImages}
              currentIndex={currentIndex}
              isOpen={isOpen}
              onClose={closeLightbox}
              onNext={goToNext}
              onPrev={goToPrev}
            />
          </div>

          {/* Sidebar - Booking or Event Info */}
          <div className="lg:col-span-1">
            <div className="sticky top-32 space-y-8">
              <motion.div 
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                className="bg-white rounded-3xl p-8 shadow-xl border border-slate-100"
              >
                {isPastEvent ? (
                  <>
                    <div className="flex items-center gap-3 mb-6">
                      <div className="w-12 h-12 bg-ink/10 rounded-full flex items-center justify-center">
                        <CheckCircle size={24} className="text-ink" />
                      </div>
                      <div>
                        <p className="font-bold text-slate-900">Event Completed</p>
                        <p className="text-sm text-slate-500">This event has ended</p>
                      </div>
                    </div>

                    <div className="space-y-6 mb-8">
                      <div className="flex items-start gap-4">
                        <Calendar size={20} className="text-saffron shrink-0 mt-1" />
                        <div>
                          <p className="font-bold text-slate-900">Date Held</p>
                          <p className="text-sm text-slate-500">
                            {new Date(event.date).toLocaleDateString('en-NL', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}
                          </p>
                        </div>
                      </div>
                      <div className="flex items-start gap-4">
                        <MapPin size={20} className="text-saffron shrink-0 mt-1" />
                        <div>
                          <p className="font-bold text-slate-900">Location</p>
                          <p className="text-sm text-slate-500">{event.location}</p>
                        </div>
                      </div>
                    </div>

                    <div className="bg-slate-50 rounded-2xl p-6 text-center">
                      <p className="text-slate-600 mb-4">Thank you to everyone who attended this event!</p>
                      <Link 
                        to="/events" 
                        className="inline-flex items-center justify-center gap-2 bg-ink text-white font-bold uppercase tracking-widest text-sm px-8 py-4 rounded-full hover:bg-ink/80 transition-all w-full"
                      >
                        View Upcoming Events
                      </Link>
                    </div>
                  </>
                ) : (
                  <>
                    <div className="flex justify-between items-center mb-8">
                      <span className="text-slate-500 font-medium">Ticket Price</span>
                      <span className="text-3xl font-bold text-slate-900">
                        {event.price === 0 ? 'Free' : `€${event.price}`}
                      </span>
                    </div>

                    <div className="space-y-6 mb-8">
                      <div className="flex items-start gap-4">
                        <MapPin size={20} className="text-saffron shrink-0 mt-1" />
                        <div>
                          <p className="font-bold text-slate-900">Location</p>
                          <p className="text-sm text-slate-500">{event.location}</p>
                        </div>
                      </div>
                    </div>

                    {event.price > 0 && (
                      <div className="space-y-4 mb-8">
                        <label className="block text-sm font-bold text-slate-700">Select Quantity</label>
                        <div className="flex items-center justify-between bg-slate-50 p-2 rounded-2xl border border-slate-100">
                          <button 
                            onClick={() => setQuantity(Math.max(1, quantity - 1))}
                            className="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-saffron transition-colors"
                          >
                            <Minus size={18} />
                          </button>
                          <span className="text-xl font-bold">{quantity}</span>
                          <button 
                            onClick={() => setQuantity(quantity + 1)}
                            className="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-saffron transition-colors"
                          >
                            <Plus size={18} />
                          </button>
                        </div>
                      </div>
                    )}

                    <button 
                      onClick={handleAddToCart}
                      className="btn-primary w-full py-4 text-lg"
                    >
                      {event.price === 0 ? (
                        <>Register Now</>
                      ) : (
                        <><ShoppingCart size={20} /> Add to Cart</>
                      )}
                    </button>

                    <div className="mt-6 pt-6 border-t border-slate-50 flex items-center justify-center gap-4 text-slate-400">
                      <button className="hover:text-saffron transition-colors flex items-center gap-2 text-sm">
                        <Share2 size={16} /> Share Event
                      </button>
                    </div>
                  </>
                )}
              </motion.div>

              <div className="bg-orange-50 rounded-3xl p-8 border border-orange-100">
                <h3 className="font-bold text-slate-900 mb-2">Need Help?</h3>
                <p className="text-sm text-slate-600 mb-4">If you have any questions regarding this event, please contact our support team.</p>
                <Link to="/contact" className="text-saffron font-bold text-sm">Contact Support</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default EventDetail;
