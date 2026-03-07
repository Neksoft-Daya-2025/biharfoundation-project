import React, { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { motion, AnimatePresence } from 'motion/react';
import { BookOpen, Calendar, User, ArrowRight } from 'lucide-react';
import { blogs } from '../data';
import BlogCard from '../components/BlogCard';

const Blog = () => {
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
    <div className="bg-background min-h-screen">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[80vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Blog" 
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
            The Journal
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Cultural <span className="italic font-light text-saffron">Insights.</span>
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
            Stories, updates, and insights from the Bihar Foundation Netherlands community.
          </motion.p>
        </div>
      </section>


      {/* Featured Post (if any) */}
      {blogs.length > 0 && (
        <section className="px-6 lg:px-12 max-w-7xl mx-auto mt-16 mb-32 scroll-reveal">
          <Link to={`/blog/${blogs[0].id}`} className="block group">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center bg-paper p-12 lg:p-20 transition-shadow hover:shadow-xl">
              <div className="relative overflow-hidden">
                <img 
                  src={blogs[0].image} 
                  alt={blogs[0].title} 
                  className="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-110"
                  referrerPolicy="no-referrer"
                />
                <div className="absolute top-6 left-6 bg-saffron text-white px-4 py-1 text-[10px] font-bold uppercase tracking-widest">
                  Featured
                </div>
              </div>
              <div>
                <span className="text-[10px] uppercase tracking-widest font-bold text-saffron block mb-4">{blogs[0].category}</span>
                <h2 className="text-2xl md:text-3xl font-serif font-bold text-ink mb-6 leading-tight group-hover:text-saffron transition-colors">{blogs[0].title}</h2>
                <p className="text-slate-500 mb-8 leading-relaxed">{blogs[0].excerpt}</p>
                <div className="flex items-center gap-6 text-xs text-slate-400 mb-12">
                  <span className="flex items-center gap-2"><Calendar size={14} /> {blogs[0].date}</span>
                  <span className="flex items-center gap-2"><User size={14} /> {blogs[0].author}</span>
                </div>
                <span className="flex items-center gap-4 text-xs font-bold uppercase tracking-widest text-ink group-hover:text-saffron group-hover:gap-6 transition-all">
                  Read Article <ArrowRight size={16} />
                </span>
              </div>
            </div>
          </Link>
        </section>
      )}

      {/* Blog Grid */}
      <section className="px-6 lg:px-12 max-w-7xl mx-auto">
        <AnimatePresence mode="wait">
          {blogs.length > 0 ? (
            <motion.div 
              key="all-posts"
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -20 }}
              className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12"
            >
              {blogs.map((post, i) => (
                <div key={post.id} className="scroll-reveal">
                  <BlogCard blog={post} />
                </div>
              ))}
            </motion.div>
          ) : (
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              className="py-32 text-center"
            >
              <div className="w-24 h-24 bg-paper rounded-full flex items-center justify-center mx-auto mb-8 text-slate-300">
                <BookOpen size={40} />
              </div>
              <h3 className="text-2xl font-serif font-bold text-ink mb-2">No articles found</h3>
              <p className="text-slate-400">Try adjusting your search or filters.</p>
            </motion.div>
          )}
        </AnimatePresence>
      </section>
    </div>
  );
};

export default Blog;
