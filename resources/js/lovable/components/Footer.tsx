import React, { useMemo } from 'react';
import { Link } from 'react-router-dom';
import { Facebook, Instagram } from 'lucide-react';
import { useEvents } from '../context/EventsContext';
import { useSite } from '../context/SiteContext';

const Footer = () => {
  const { events } = useEvents();
  const { displayName, contactEmail, phoneDisplay, phoneTel, address } = useSite();
  const featuredEvents = useMemo(() => {
    return [...events]
      .sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime())
      .slice(0, 3);
  }, [events]);

  return (
    <footer className="bg-slate-900 text-slate-300 pt-16 pb-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 mb-12">
          {/* About */}
          <div className="lg:col-span-4 space-y-6">
            <Link to="/" className="inline-block mb-4">
              <img 
                src="/images/Untitled-2.webp" 
                alt="Bihar Foundation Netherlands" 
                className="h-14 object-contain rounded-[7px]"
              />
            </Link>
            <p className="text-sm leading-relaxed">
              {displayName} is a community organization in the Netherlands that brings together people from the Indian state of Bihar.
            </p>
            <div className="space-y-3 text-sm">
              <p>
                <span className="font-bold text-white block mb-1">Contact</span>
                <a href={`mailto:${contactEmail}`} className="text-saffron hover:underline">
                  {contactEmail}
                </a>
              </p>
              <p>
                <a href={`tel:${phoneTel}`} className="hover:text-saffron transition-colors">
                  {phoneDisplay}
                </a>
              </p>
              {address ? (
                <p className="text-slate-400 whitespace-pre-line">{address}</p>
              ) : null}
            </div>
            <div className="space-y-3">
              <p className="text-sm">
                <span className="font-bold text-white">Bank Account Number:</span> NL54 BUNQ 2153 6914 51
              </p>
              <p className="text-sm">
                <span className="font-bold text-white">KVK Number:</span> 97340294
              </p>
            </div>
            <div className="flex gap-4 pt-2">
              <a 
                href="https://www.facebook.com/biharfoundationnl" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-saffron transition-colors"
              >
                <Facebook size={18} />
              </a>
              <a 
                href="https://www.instagram.com/biharfoundationnl/" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-saffron transition-colors"
              >
                <Instagram size={18} />
              </a>
              <a 
                href="https://chat.whatsapp.com/EFbZVSXvJPp63pnOiz8r3l" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-saffron transition-colors"
              >
                <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              </a>
            </div>
          </div>

          {/* News | Events */}
          <div className="lg:col-span-3">
            <h4 className="text-white font-serif font-bold text-lg mb-6">News | Events</h4>
            <ul className="space-y-4 text-sm">
              {featuredEvents.length === 0 ? (
                <li>
                  <Link to="/events" className="hover:text-saffron transition-colors">
                    View all events
                  </Link>
                </li>
              ) : (
                featuredEvents.map((ev) => (
                  <li key={ev.id}>
                    <Link
                      to={`/events/${ev.slug}`}
                      className="flex gap-3 group hover:text-saffron transition-colors"
                    >
                      <img
                        src={ev.image}
                        alt=""
                        className="w-16 h-16 object-cover rounded-md shrink-0"
                      />
                      <span className="leading-relaxed line-clamp-3">{ev.title}</span>
                    </Link>
                  </li>
                ))
              )}
            </ul>
          </div>

          {/* Quick Links */}
          <div className="lg:col-span-2">
            <h4 className="text-white font-serif font-bold text-lg mb-6">Quick Links</h4>
            <ul className="space-y-4 text-sm">
              <li><Link to="/" className="hover:text-saffron transition-colors">Home</Link></li>
              <li><Link to="/about" className="hover:text-saffron transition-colors">About Us</Link></li>
              <li><Link to="/membership" className="hover:text-saffron transition-colors">Join Us</Link></li>
              <li><Link to="/blog" className="hover:text-saffron transition-colors">News</Link></li>
              <li><Link to="/events" className="hover:text-saffron transition-colors">Events</Link></li>
              <li><Link to="/contact" className="hover:text-saffron transition-colors">Contact Us</Link></li>
            </ul>
          </div>

          {/* Become a Member */}
          <div className="lg:col-span-3 text-left lg:text-center">
            <h4 className="text-white font-serif font-bold text-lg mb-6">Become a Member</h4>
            <Link to="/membership" className="inline-block">
              <img 
                src="/images/Untitled-1-1.webp" 
                alt="Become a Member" 
                className="w-32 lg:w-full lg:max-w-[200px] lg:mx-auto rounded-lg hover:opacity-90 transition-opacity"
              />
            </Link>
          </div>
        </div>

        <div className="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs">
          <p>© {new Date().getFullYear()} {displayName}. All Rights Reserved.</p>
          <p>
            Powered By <a href="https://nekdigital.nl/" target="_blank" rel="noopener noreferrer" className="text-saffron hover:underline">Nekdigital</a>
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
