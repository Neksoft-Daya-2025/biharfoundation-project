import React, { useEffect, useRef, useState } from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, Heart, ChevronRight, Globe, Users, Award, ChevronLeft } from 'lucide-react';
import { motion, useScroll, useTransform, AnimatePresence } from 'motion/react';
import { events, blogs } from '../data';
import { getUpcomingEvents, getPastEvents } from '../utils/eventUtils';
import EventCard from '../components/EventCard';
import BlogCard from '../components/BlogCard';

const heroImages = [
  '/images/Banner image/bihar houndation bannner image 1.png',
  '/images/Banner image/bihar houndation bannner image 2.png',
  '/images/Banner image/bihar houndation bannner image 3.png',
  '/images/Banner image/bihar houndation bannner image 4.png',
  '/images/Banner image/bihar houndation bannner image 5.png',
  '/images/Banner image/bihar houndation bannner image 6.png',
  '/images/Banner image/bihar houndation bannner image 7.png',
  '/images/Banner image/bihar houndation bannner image 8.png',
];

const Home = () => {
  const upcomingEvents = getUpcomingEvents(events).slice(0, 3);
  const pastEvents = getPastEvents(events).slice(0, 4);
  const latestBlogs = blogs.slice(0, 3);
  const heroRef = useRef(null);
  const [currentSlide, setCurrentSlide] = useState(0);
  const { scrollYProgress } = useScroll({
    target: heroRef,
    offset: ["start start", "end start"]
  });

  const y = useTransform(scrollYProgress, [0, 1], [0, 200]);
  const opacity = useTransform(scrollYProgress, [0, 0.5], [1, 0]);

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % heroImages.length);
    }, 5000);
    return () => clearInterval(interval);
  }, []);

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev + 1) % heroImages.length);
  };

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev - 1 + heroImages.length) % heroImages.length);
  };

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

  return (
    <div className="overflow-hidden bg-background">
      {/* Hero Section with Image Slider */}
      <section ref={heroRef} className="relative h-screen flex items-end justify-center overflow-hidden bg-black">
        <motion.div style={{ y, opacity }} className="absolute inset-0 z-0">
          <AnimatePresence mode="wait">
            <motion.img
              key={currentSlide}
              src={heroImages[currentSlide]}
              alt={`Hero Background ${currentSlide + 1}`}
              className="w-full h-full object-cover"
              initial={{ opacity: 0, scale: 1.1 }}
              animate={{ opacity: 1, scale: 1 }}
              exit={{ opacity: 0 }}
              transition={{ duration: 1 }}
            />
          </AnimatePresence>
          <div className="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>
        </motion.div>

        {/* Slider Controls */}
        <button
          onClick={prevSlide}
          className="absolute left-4 md:left-8 xl:left-24 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/40 transition-all"
          aria-label="Previous slide"
        >
          <ChevronLeft size={24} />
        </button>
        <button
          onClick={nextSlide}
          className="absolute right-4 md:right-8 xl:right-24 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/40 transition-all"
          aria-label="Next slide"
        >
          <ChevronRight size={24} />
        </button>

        {/* Slide Indicators */}
        <div className="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2">
          {heroImages.map((_, index) => (
            <button
              key={index}
              onClick={() => setCurrentSlide(index)}
              className={`w-2 h-2 rounded-full transition-all ${
                index === currentSlide ? 'bg-saffron w-8' : 'bg-white/50 hover:bg-white/80'
              }`}
              aria-label={`Go to slide ${index + 1}`}
            />
          ))}
        </div>

        <div className="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 text-center mb-2">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 1, ease: "easeOut" }}
          >
            <span className="section-subtitle text-saffron">Stichting Bihar Foundation</span>
            <h1 className="text-[43px] md:text-[62px] lg:text-[86px] font-serif font-bold leading-[0.9] mb-2 tracking-tighter text-white">
              Bihar Foundation <br />
              <span className="text-saffron italic font-light">Netherlands</span>
            </h1>
            <p className="text-sm md:text-xl text-white/80 mx-auto mb-12 font-medium">
              Preserving Bihar's heritage in the heart of the Netherlands.
            </p>
          </motion.div>
        </div>

        {/* Vertical Rail Text */}
        <div className="absolute left-12 top-1/2 -translate-y-1/2 hidden xl:block">
          <div className="vertical-text text-white/60">ESTABLISHED 2015 — AMSTELVEEN</div>
        </div>
        <div className="absolute right-12 top-1/2 -translate-y-1/2 hidden xl:block">
          <div className="vertical-text text-white/60">CULTURE • COMMUNITY • PROGRESS</div>
        </div>
      </section>

      {/* About Us Section */}
      <section className="py-24 bg-gradient-to-b from-sky-100/50 to-amber-50/30">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {/* Image Collage - Grid Layout */}
            <div className="relative scroll-reveal">
              <div className="grid grid-cols-2 gap-4">
                {/* Left column */}
                <div className="space-y-4">
                  {/* Top-left: Horizontal image */}
                  <div className="rounded-2xl overflow-hidden shadow-lg">
                    <img
                      src="/images/Homepage/WhatsApp-Image-2025-12-02-at-15.11.40_70340508.webp"
                      alt="Community Event"
                      className="w-full h-44 object-cover hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                  {/* Bottom-left: Square image */}
                  <div className="rounded-2xl overflow-hidden shadow-lg">
                    <img
                      src="/images/Homepage/WhatsApp-Image-2024-11-26-at-03.50.17_c2d753a6-1.webp"
                      alt="Cultural Celebration"
                      className="w-full h-52 object-cover hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                </div>
                {/* Right column: Vertical image */}
                <div className="flex items-center">
                  <div className="rounded-2xl overflow-hidden shadow-lg w-full">
                    <img
                      src="/images/Homepage/572361016_122184952952579269_4566659540459077237_n.webp"
                      alt="Foundation Members"
                      className="w-full h-72 object-cover hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                </div>
              </div>
            </div>

            {/* Content Side */}
            <div className="scroll-reveal">
              <span className="text-xs uppercase tracking-[0.3em] font-bold text-slate-400 mb-4 block">About Us</span>
              <h2 className="text-4xl md:text-5xl font-serif font-bold text-ink mb-6 leading-[1.1]">
                Bihar Foundation<br />
                <span className="text-saffron italic font-light">Netherlands</span>
              </h2>
              <p className="text-ink mb-8 leading-relaxed">
                The Stichting Bihar Foundation Netherlands Chapter has been established in alignment with the mission and vision of Bihar Foundation, Govt of Bihar. We aim to celebrate and promote Bihari culture and traditions to the Bihari community living in The Netherlands. This also plays an important role to enrich our next generations with glorious history and inherit culture of Bihar.
              </p>
              <Link to="/about" className="inline-flex items-center gap-2 px-6 py-3 border-2 border-ink text-ink font-bold uppercase tracking-widest text-xs hover:bg-ink hover:text-white transition-all rounded-full">
                More About Us
              </Link>
            </div>
          </div>
        </div>

        {/* Tagline & Services */}
        <div className="max-w-7xl mx-auto px-6 lg:px-12 mt-24">
          <div className="text-center mb-16 scroll-reveal">
            <h3 className="text-3xl md:text-4xl font-serif text-ink">
              Open hearts. Open hands. <span className="italic font-light">Open to all.</span>
            </h3>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-4 gap-8 scroll-reveal">
            {[
              { icon: Users, label: "Youth & Families" },
              { icon: Heart, label: "Community Support" },
              { icon: Globe, label: "Cultural Events" },
              { icon: Award, label: "Professional Network" }
            ].map((item, i) => (
              <div key={i} className="flex flex-col items-center text-center group">
                <div className="w-20 h-20 bg-saffron/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-saffron/20 transition-colors">
                  <item.icon size={32} className="text-saffron" />
                </div>
                <span className="text-sm font-medium text-ink">{item.label}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Priorities Section - Redesigned for Balance & Elegance */}
      <section className="pt-16 pb-32 bg-white relative overflow-hidden">
        {/* Subtle Background Element */}
        <div className="absolute top-0 right-0 w-1/2 h-full bg-paper/30 -skew-x-12 translate-x-1/4 z-0 hidden lg:block" />

        <div className="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-20 lg:gap-32 items-center">

            {/* Content Side */}
            <div className="scroll-reveal">
              <div className="max-w-xl">
                <div className="flex items-center gap-4 mb-8">
                  <span className="w-12 h-px bg-saffron" />
                  <span className="text-xs uppercase tracking-[0.4em] font-bold text-saffron">Our Priorities</span>
                </div>

                <h2 className="text-4xl md:text-5xl font-serif font-bold text-ink mb-10 leading-[1.1]">
                  Community at a <span className="text-saffron italic font-light">Glance</span>
                </h2>

                <p className="text-ink mb-8 leading-relaxed">
                  Over past years, we have done some events like celebration of auspicious Chhath puja, Holi and bihari version of BBQ: Litti chokha party. The Stichting Bihar Foundation Netherlands Chapter is determined to do below activities in association with Bihar Foundation, Govt of Bihar:
                </p>

                <ul className="space-y-4 text-ink leading-relaxed">
                  <li className="flex gap-3">
                    <span className="text-saffron font-bold">1.</span>
                    <span>Being a Bridge between Govt of Bihar and Non Resident Biharis in The Netherlands</span>
                  </li>
                  <li className="flex gap-3">
                    <span className="text-saffron font-bold">2.</span>
                    <span>Provide information about policies of Bihar Govt to Individual in their interested area, be it Industrial policies, Law and order policies, Agricultural policies etc.</span>
                  </li>
                  <li className="flex gap-3">
                    <span className="text-saffron font-bold">3.</span>
                    <span>Connect Non Resident Biharis to respective govt agencies in Bihar for any kind of queries/concern/grievances.</span>
                  </li>
                  <li className="flex gap-3">
                    <span className="text-saffron font-bold">4.</span>
                    <span>Promote Bihar as Investment destination among Non Resident Biharis and in Netherlands</span>
                  </li>
                  <li className="flex gap-3">
                    <span className="text-saffron font-bold">5.</span>
                    <span>Promote Bihar Tourism among Hindustani Surinamese and in The Netherlands</span>
                  </li>
                  <li className="flex gap-3">
                    <span className="text-saffron font-bold">6.</span>
                    <span>Connect Hindustani Surinamese respective Govt agencies for their any kind of queries</span>
                  </li>
                </ul>
              </div>
            </div>

            {/* Image Side */}
            <div className="scroll-reveal">
              <div className="relative">
                {/* Main Image - Rectangular with rounded corners */}
                <div className="relative z-10 rounded-2xl overflow-hidden aspect-[4/5] shadow-2xl group">
                  <img
                    src="/images/Homepage/480971677_122145562928579269_2176968860162883411_n.webp"
                    alt="Cultural Art"
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000"
                  />
                  <div className="absolute inset-0 bg-ink/5 group-hover:bg-transparent transition-colors duration-700" />
                </div>

                {/* Decorative Elements */}
                <div className="absolute -top-12 -right-12 w-64 h-64 border-r-2 border-t-2 border-saffron/20 z-0 hidden md:block" />
                <div className="absolute -bottom-12 -left-12 w-64 h-64 border-l-2 border-b-2 border-ink/5 z-0 hidden md:block" />

                {/* Stat Card - Floating and Modern */}
                <div className="absolute -bottom-10 -right-6 md:right-12 bg-white p-10 shadow-[0_30px_60px_rgba(0,0,0,0.12)] z-20 scroll-reveal delay-500">
                  <div className="flex items-center gap-4 mb-3">
                    <div className="w-10 h-0.5 bg-saffron" />
                    <span className="text-[10px] uppercase tracking-[0.3em] font-bold text-slate-400">Our Impact</span>
                  </div>
                  <p className="text-6xl font-serif font-bold text-ink leading-none">10+</p>
                  <p className="text-xs uppercase tracking-widest font-bold text-slate-500 mt-3">Years of Excellence</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      {/* Events Section */}
      <section className="py-32 bg-paper">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="flex flex-col md:flex-row justify-between items-end mb-20 scroll-reveal">
            <div className="max-w-2xl">
              <span className="section-subtitle text-left">The Calendar</span>
              <h2 className="text-4xl md:text-6xl font-serif font-bold text-ink">Upcoming <span className="italic font-light text-saffron">Events</span></h2>
            </div>
            <Link to="/events" className="group flex items-center gap-3 text-ink font-bold uppercase tracking-widest text-xs mt-8 md:mt-0">
              Explore All <div className="w-10 h-10 rounded-full border border-ink flex items-center justify-center group-hover:bg-ink group-hover:text-white transition-all"><ChevronRight size={16} /></div>
            </Link>
          </div>
          <div className="space-y-12 scroll-reveal">
            {upcomingEvents.slice(0, 1).map(event => (
              <EventCard key={event.id} event={event} />
            ))}
          </div>
        </div>
      </section>

      {/* Past Events Section */}
      {pastEvents.length > 0 && (
        <section className="py-32 bg-gradient-to-b from-amber-50/30 to-white">
          <div className="max-w-7xl mx-auto px-6 lg:px-12">
            <div className="text-center mb-16 scroll-reveal">
              <span className="section-subtitle">Our Highlights</span>
              <h2 className="text-4xl md:text-6xl font-serif font-bold text-ink">
                Past <span className="italic font-light text-saffron">Events</span>
              </h2>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 scroll-reveal">
              {pastEvents.map(event => {
                const eventDate = new Date(event.date);
                const formattedDate = eventDate.toLocaleDateString('en-US', {
                  day: 'numeric',
                  month: 'long',
                  year: 'numeric'
                });
                const galleryCount = event.gallery?.length || 0;

                return (
                  <Link
                    key={event.id}
                    to={`/events/${event.id}`}
                    className="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all flex flex-col sm:flex-row"
                  >
                    {/* Image */}
                    <div className="relative sm:w-2/5 h-48 sm:h-auto overflow-hidden">
                      <img
                        src={event.image}
                        alt={event.title}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        referrerPolicy="no-referrer"
                      />
                    </div>

                    {/* Content */}
                    <div className="sm:w-3/5 p-6 flex flex-col justify-between">
                      <div>
                        <h3 className="text-xl font-serif font-bold text-ink mb-2 group-hover:text-saffron transition-colors">
                          {event.title}
                        </h3>
                        <p className="text-ink/60 text-sm leading-relaxed line-clamp-2 mb-4">
                          {event.description}
                        </p>
                      </div>

                      {/* Stats Row */}
                      <div className="flex items-center justify-between pt-4 border-t border-slate-100">
                        <div>
                          <p className="text-xs text-ink/50 uppercase tracking-wider font-medium">Date</p>
                          <p className="text-sm font-bold text-ink">{formattedDate}</p>
                        </div>
                        {galleryCount > 0 && (
                          <div className="text-right">
                            <p className="text-xs text-ink/50 uppercase tracking-wider font-medium">Photos</p>
                            <p className="text-sm font-bold text-saffron">{galleryCount}+</p>
                          </div>
                        )}
                      </div>
                    </div>
                  </Link>
                );
              })}
            </div>

            {/* View All Link */}
            <div className="text-center mt-12 scroll-reveal">
              <Link
                to="/events"
                className="inline-flex items-center gap-2 px-8 py-4 border-2 border-ink text-ink font-bold uppercase tracking-widest text-xs hover:bg-ink hover:text-white transition-all rounded-full"
              >
                View All Past Events <ArrowRight size={16} />
              </Link>
            </div>
          </div>
        </section>
      )}

      {/* Membership CTA */}
      <section className="py-32 bg-ink text-white relative overflow-hidden">
        <div className="absolute inset-0 opacity-30">
          <img src="/images/Banner image/ChatGPT Image Mar 6, 2026, 10_31_09 AM.png" alt="Bihar Netherlands" className="w-full h-full object-cover" />
        </div>
        <div className="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 text-center scroll-reveal">
          <h2 className="text-4xl md:text-7xl font-serif font-bold mb-8">Join the <span className="text-saffron italic font-light">Inner Circle</span></h2>
          <p className="text-slate-400 max-w-2xl mx-auto mb-12 text-lg leading-relaxed">
            Membership is more than just access—it's a commitment to our shared future and a celebration of our common roots.
          </p>
          <Link to="/membership" className="inline-flex items-center gap-2 bg-saffron text-white font-bold uppercase tracking-widest text-sm px-8 py-4 rounded-full hover:bg-white hover:text-ink transition-all">
            Become a Member <ArrowRight size={16} />
          </Link>
        </div>
      </section>

      {/* Blog Section */}
      <section className="py-32 bg-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="text-center mb-20 scroll-reveal">
            <span className="section-subtitle">Stay Updated</span>
            <h2 className="section-title">News & <span className="italic font-light text-saffron">Articles</span></h2>
            <p className="text-ink/60 mt-6 max-w-2xl mx-auto text-lg">Bringing you the latest from your community, because staying informed brings us closer together.</p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-12 scroll-reveal">
            {latestBlogs.map(blog => (
              <BlogCard key={blog.id} blog={blog} />
            ))}
          </div>
        </div>
      </section>

      {/* Our Sponsors Section */}
      <section className="py-20 bg-paper">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="text-center mb-12 scroll-reveal">
            <span className="section-subtitle">Our Partners</span>
            <h2 className="text-4xl md:text-5xl font-serif font-bold text-ink">
              Our <span className="italic font-light text-saffron">Sponsors</span>
            </h2>
          </div>

          {/* Infinite Scroll Carousel */}
          <div className="relative overflow-hidden scroll-reveal">
            <div className="flex animate-scroll-left">
              {/* First set of logos */}
              {[
                '/images/Our Sponsors/2.webp',
                '/images/Our Sponsors/3.webp',
                '/images/Our Sponsors/4.webp',
                '/images/Our Sponsors/5.webp',
                '/images/Our Sponsors/6.webp',
              ].map((logo, index) => (
                <div
                  key={`first-${index}`}
                  className="flex-shrink-0 mx-8 md:mx-12 flex items-center justify-center"
                >
                  <img
                    src={logo}
                    alt={`Sponsor ${index + 1}`}
                    className="h-20 md:h-28 w-auto object-contain transition-all duration-300"
                    style={{ borderRadius: '7px' }}
                  />
                </div>
              ))}
              {/* Duplicate set for seamless loop */}
              {[
                '/images/Our Sponsors/2.webp',
                '/images/Our Sponsors/3.webp',
                '/images/Our Sponsors/4.webp',
                '/images/Our Sponsors/5.webp',
                '/images/Our Sponsors/6.webp',
              ].map((logo, index) => (
                <div
                  key={`second-${index}`}
                  className="flex-shrink-0 mx-8 md:mx-12 flex items-center justify-center"
                >
                  <img
                    src={logo}
                    alt={`Sponsor ${index + 1}`}
                    className="h-20 md:h-28 w-auto object-contain transition-all duration-300"
                    style={{ borderRadius: '7px' }}
                  />
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

    </div>
  );
};

export default Home;
