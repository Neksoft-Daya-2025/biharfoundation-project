import React, { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import { Link } from 'react-router-dom';
import { Search, Calendar, ArrowRight, Images } from 'lucide-react';
import { getUpcomingEvents, getPastEvents } from '../utils/eventUtils';
import EventCard from '../components/EventCard';
import { useEvents } from '../context/EventsContext';

const Events = () => {
  const { events, loading, error } = useEvents();
  const [activeTab, setActiveTab] = useState<'upcoming' | 'past'>('upcoming');
  const [searchQuery, setSearchQuery] = useState('');

  const upcomingEvents = getUpcomingEvents(events);
  const pastEvents = getPastEvents(events);

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
  }, [activeTab, searchQuery]);

  const getFilteredEvents = () => {
    const eventsList = activeTab === 'upcoming' ? upcomingEvents : pastEvents;
    
    if (!searchQuery) return eventsList;
    
    return eventsList.filter(event => 
      event.title.toLowerCase().includes(searchQuery.toLowerCase()) || 
      event.location.toLowerCase().includes(searchQuery.toLowerCase())
    );
  };

  const filteredEvents = getFilteredEvents();

  const tabs = [
    { id: 'upcoming', label: 'Upcoming Events', count: upcomingEvents.length },
    { id: 'past', label: 'Past Events', count: pastEvents.length },
  ];

  return (
    <div className="bg-background min-h-screen">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[80vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Events" 
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
            The Calendar
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Foundation <span className="italic font-light text-saffron">Events.</span>
          </motion.h1>
          
          <motion.div 
            initial={{ opacity: 0, scaleX: 0 }}
            animate={{ opacity: 1, scaleX: 1 }}
            transition={{ delay: 0.6 }}
            className="hidden md:block w-24 h-1 bg-saffron mx-auto mb-8"
          ></motion.div>
          
          <motion.p 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.8 }}
            className="text-sm md:text-lg text-white/80 max-w-3xl mx-auto leading-relaxed"
          >
            Discover our upcoming celebrations and revisit the memories from our past gatherings.
          </motion.p>
        </div>
      </section>

      {/* Filter Section */}
      <section className="py-12 px-6 lg:px-12 max-w-7xl mx-auto scroll-reveal">
        <div className="flex flex-col lg:flex-row justify-between items-center gap-8 border-b border-slate-100 pb-12">
          {/* Tabs */}
          <div className="flex gap-8 overflow-x-auto w-full lg:w-auto pb-4 lg:pb-0">
            {tabs.map(tab => (
              <button
                key={tab.id}
                onClick={() => setActiveTab(tab.id as 'upcoming' | 'past')}
                className={`text-sm uppercase tracking-widest font-bold transition-all relative py-4 whitespace-nowrap flex items-center gap-2 ${activeTab === tab.id ? 'text-saffron' : 'text-slate-400 hover:text-ink'}`}
              >
                {tab.label}
                <span className={`text-xs px-2 py-0.5 rounded-full ${activeTab === tab.id ? 'bg-saffron text-white' : 'bg-slate-100 text-slate-500'}`}>
                  {tab.count}
                </span>
                {activeTab === tab.id && (
                  <motion.div layoutId="activeTab" className="absolute bottom-0 left-0 w-full h-0.5 bg-saffron" />
                )}
              </button>
            ))}
          </div>

          {/* Search */}
          <div className="relative w-full lg:w-96">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={18} />
            <input
              type="text"
              placeholder="Search events..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="w-full pl-12 pr-6 py-4 bg-paper border-none outline-none focus:ring-1 focus:ring-saffron transition-all text-sm font-medium"
            />
          </div>
        </div>
      </section>

      {/* Events Grid */}
      <section className="px-6 lg:px-12 max-w-7xl mx-auto pb-24">
        {error && (
          <div className="py-16 text-center text-red-600">
            {error}
          </div>
        )}
        {loading && !error && (
          <div className="py-24 text-center text-slate-500">Loading events…</div>
        )}
        {!loading && !error && filteredEvents.length > 0 ? (
          activeTab === 'upcoming' ? (
            <div className="space-y-8">
              {filteredEvents.map((event, index) => (
                <motion.div 
                  key={event.id}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: index * 0.1 }}
                >
                  <EventCard event={event} />
                </motion.div>
              ))}
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {filteredEvents.map((event, index) => (
                <motion.div 
                  key={event.id}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: index * 0.05 }}
                >
                  <Link 
                    to={`/events/${event.id}`}
                    className="group block bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all"
                  >
                    <div className="relative h-48 overflow-hidden">
                      <img 
                        src={event.image} 
                        alt={event.title} 
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                      />
                      {event.gallery && event.gallery.length > 0 && (
                        <div className="absolute bottom-3 right-3 bg-ink/70 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                          <Images size={12} />
                          {event.gallery.length} Photos
                        </div>
                      )}
                    </div>
                    <div className="p-5">
                      <h3 className="font-serif font-bold text-ink text-lg mb-2 line-clamp-2 group-hover:text-saffron transition-colors">
                        {event.title}
                      </h3>
                      <p className="text-slate-500 text-sm line-clamp-2 mb-4">
                        {event.description}
                      </p>
                      <div className="flex items-center justify-between">
                        <span className="text-xs text-slate-400">
                          {new Date(event.date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })}
                        </span>
                        <span className="text-saffron text-xs font-bold uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">
                          View Gallery <ArrowRight size={12} />
                        </span>
                      </div>
                    </div>
                  </Link>
                </motion.div>
              ))}
            </div>
          )
        ) : !loading && !error ? (
          <div className="py-32 text-center">
            <div className="w-24 h-24 bg-paper rounded-full flex items-center justify-center mx-auto mb-8 text-slate-300">
              <Calendar size={40} />
            </div>
            <h3 className="text-2xl font-serif font-bold text-ink mb-2">
              {activeTab === 'upcoming' ? 'No upcoming events' : 'No past events found'}
            </h3>
            <p className="text-slate-400">
              {activeTab === 'upcoming' 
                ? 'Check back soon for new events!' 
                : 'Try adjusting your search.'}
            </p>
          </div>
        ) : null}
      </section>

      {/* Newsletter CTA */}
      <section className="mt-32 py-24 bg-ink text-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12 text-center scroll-reveal">
          <h2 className="text-3xl md:text-5xl font-serif font-bold mb-8">Never Miss a <span className="text-saffron italic font-light">Moment.</span></h2>
          <p className="text-slate-400 max-w-xl mx-auto mb-12">Get notified about upcoming festivals, workshops, and community meetups directly in your inbox.</p>
          <div className="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
            <input 
              type="email" 
              placeholder="Email address" 
              className="flex-grow px-6 py-4 bg-white/10 border-none outline-none focus:ring-1 focus:ring-saffron transition-all text-sm"
            />
            <button className="btn-primary bg-saffron hover:bg-white hover:text-ink">Subscribe</button>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Events;
