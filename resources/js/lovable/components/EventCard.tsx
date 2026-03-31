import React from 'react';
import { Link } from 'react-router-dom';
import { Calendar, MapPin, Clock, ArrowRight, CheckCircle } from 'lucide-react';
import { Event } from '../types';
import { motion } from 'motion/react';
import { getEventCategory } from '../utils/eventUtils';

interface EventCardProps {
  event: Event;
}

const EventCard: React.FC<EventCardProps> = ({ event }) => {
  const eventCategory = getEventCategory(event.date);
  const isPastEvent = eventCategory === 'past';
  const locComma = event.location.indexOf(',');
  const venueLine =
    locComma >= 0 ? event.location.slice(0, locComma).trim() : event.location;
  const addressLine =
    locComma >= 0 ? event.location.slice(locComma + 1).trim() : '';

  const formattedDate = new Date(event.date).toLocaleDateString('en-US', { 
    weekday: 'long',
    day: 'numeric', 
    month: 'long', 
    year: 'numeric' 
  });

  return (
    <motion.div 
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      className={`bg-white rounded-3xl overflow-hidden shadow-xl flex flex-col lg:flex-row border border-slate-100 ${isPastEvent ? 'opacity-90' : ''}`}
    >
      {/* Image Side */}
      <div className="relative lg:w-1/2 min-h-[300px] lg:min-h-[500px] bg-slate-100 flex items-center justify-center overflow-hidden">
        <img 
          src={event.image} 
          alt={event.title} 
          className={`w-full h-full object-contain ${isPastEvent ? 'grayscale-[30%]' : ''}`}
          referrerPolicy="no-referrer"
        />
        {isPastEvent && (
          <div className="absolute top-4 left-4 bg-ink/80 text-white px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-2">
            <CheckCircle size={14} />
            Event Completed
          </div>
        )}
      </div>

      {/* Content Side */}
      <div className="lg:w-1/2 p-10 lg:p-12 flex flex-col justify-center">
        {/* Title */}
        <h3 className="text-3xl md:text-4xl font-serif font-bold mb-4 text-ink leading-tight">
          {event.title.split(' ').slice(0, -1).join(' ')} <span className="italic text-saffron">{event.title.split(' ').slice(-1)}</span>
        </h3>
        
        {/* Description */}
        <p className="text-ink/70 mb-8 leading-relaxed">
          {event.description}
        </p>

        {/* Event Details Grid */}
        <div className="grid grid-cols-1 gap-4 mb-8">
          <div className="flex items-start gap-4">
            <div className="w-10 h-10 rounded-full bg-saffron/10 flex items-center justify-center flex-shrink-0">
              <Calendar size={18} className="text-saffron" />
            </div>
            <div>
              <p className="text-xs font-bold uppercase tracking-wider text-ink/50 mb-1">Date</p>
              <p className="text-ink font-medium">{formattedDate}</p>
            </div>
          </div>

          <div className="flex items-start gap-4">
            <div className="w-10 h-10 rounded-full bg-saffron/10 flex items-center justify-center flex-shrink-0">
              <Clock size={18} className="text-saffron" />
            </div>
            <div>
              <p className="text-xs font-bold uppercase tracking-wider text-ink/50 mb-1">Time</p>
              <p className="text-ink font-medium">{event.time}</p>
            </div>
          </div>

          <div className="flex items-start gap-4">
            <div className="w-10 h-10 rounded-full bg-saffron/10 flex items-center justify-center flex-shrink-0">
              <MapPin size={18} className="text-saffron" />
            </div>
            <div>
              <p className="text-xs font-bold uppercase tracking-wider text-ink/50 mb-1">Venue</p>
              <p className="text-ink font-medium">{venueLine}</p>
              {addressLine ? (
                <p className="text-ink/60 text-sm">{addressLine}</p>
              ) : null}
            </div>
          </div>
        </div>

        {/* Action Button */}
        <Link 
          to={`/events/${event.id}`} 
          className={`inline-flex items-center justify-center gap-3 font-bold uppercase tracking-widest text-sm px-8 py-4 rounded-full transition-all hover:gap-4 w-full lg:w-auto ${
            isPastEvent 
              ? 'bg-ink text-white hover:bg-ink/80' 
              : 'bg-saffron text-white hover:bg-saffron/90'
          }`}
        >
          {isPastEvent ? 'View Gallery' : 'Register Now'} <ArrowRight size={18} />
        </Link>
      </div>
    </motion.div>
  );
};

export default EventCard;
