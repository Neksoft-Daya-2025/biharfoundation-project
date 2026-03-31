import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { motion, AnimatePresence } from 'motion/react';
import { Calendar, User, ArrowLeft, ArrowRight, Facebook, Twitter, Linkedin, Clock, ChevronLeft, ChevronRight } from 'lucide-react';
import { blogs } from '../data';
import ReactMarkdown from 'react-markdown';
import Lightbox from '../components/Lightbox';
import { useLightbox } from '../hooks/useLightbox';

const BlogDetail = () => {
  const { id } = useParams();
  const post = blogs.find(b => b.id === id);
  const [currentSlide, setCurrentSlide] = useState(0);
  
  const galleryImages = post?.gallery || [];
  const { isOpen, currentIndex, openLightbox, closeLightbox, goToNext, goToPrev } = useLightbox(galleryImages);

  const nextSlide = () => {
    if (post?.gallery) {
      setCurrentSlide((prev) => (prev + 1) % post.gallery!.length);
    }
  };

  const prevSlide = () => {
    if (post?.gallery) {
      setCurrentSlide((prev) => (prev - 1 + post.gallery!.length) % post.gallery!.length);
    }
  };

  useEffect(() => {
    window.scrollTo(0, 0);
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
    return () => observer.disconnect();
  }, [id]);

  if (!post) {
    return (
      <div className="pt-40 pb-24 text-center">
        <h1 className="text-3xl font-serif font-bold mb-4">Article not found</h1>
        <Link to="/blog" className="text-saffron hover:underline">Back to News</Link>
      </div>
    );
  }

  const formattedDate = new Date(post.date).toLocaleDateString('en-US', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });

  const readTime = Math.ceil(post.content.split(' ').length / 200);

  return (
    <div className="bg-background min-h-screen">
      {/* Hero Section - Full Width with Overlay */}
      <section className="relative min-h-[85vh] flex items-end overflow-hidden pt-20">
        {/* Background Image */}
        <div className="absolute inset-0">
          <img 
            src={post.image} 
            alt={post.title} 
            className="w-full h-full object-cover"
            referrerPolicy="no-referrer"
          />
          <div className="absolute inset-0 bg-gradient-to-t from-ink via-ink/70 to-transparent" />
        </div>

        {/* Hero Content */}
        <div className="relative z-10 w-full pb-16 pt-32">
          <div className="max-w-7xl mx-auto px-6 lg:px-12">
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
            >
              <Link to="/blog" className="inline-flex items-center gap-3 text-white/70 hover:text-white transition-colors mb-8 text-sm">
                <ArrowLeft size={16} /> Back to News & Articles
              </Link>
              
              <div className="flex items-center gap-4 mb-6">
                <span className="px-4 py-1.5 bg-saffron text-white text-xs font-bold uppercase tracking-wider rounded-full">
                  {post.category}
                </span>
                <div className="flex items-center gap-2 text-white/70 text-sm">
                  <Clock size={14} />
                  <span>{readTime} min read</span>
                </div>
              </div>

              <h1 className="text-3xl md:text-5xl lg:text-6xl font-serif font-bold text-white mb-8 leading-tight max-w-4xl">
                {post.title}
              </h1>

              <div className="flex flex-wrap items-center gap-6 text-white/80">
                <div className="flex items-center gap-3">
                  <div className="w-12 h-12 bg-saffron rounded-full flex items-center justify-center text-white font-bold">
                    {post.author.charAt(0)}
                  </div>
                  <div>
                    <p className="text-white font-semibold">{post.author}</p>
                    <p className="text-white/60 text-sm">Contributor</p>
                  </div>
                </div>
                <div className="w-px h-8 bg-white/20 hidden sm:block" />
                <div className="flex items-center gap-2">
                  <Calendar size={16} />
                  <span>{formattedDate}</span>
                </div>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Article Content */}
      <article className="relative">
        {/* Content Section with Side Elements */}
        <div className="max-w-7xl mx-auto px-6 lg:px-12 py-20">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {/* Sticky Sidebar - Share & Info */}
            <aside className="lg:col-span-2 order-2 lg:order-1">
              <div className="lg:sticky lg:top-32">
                <div className="flex lg:flex-col gap-4 items-center lg:items-start">
                  <span className="text-xs uppercase tracking-widest font-bold text-slate-400 mb-2 hidden lg:block">Share</span>
                  <div className="flex lg:flex-col gap-3">
                    <button className="w-10 h-10 bg-paper rounded-full flex items-center justify-center text-ink hover:bg-saffron hover:text-white transition-all shadow-sm">
                      <Facebook size={16} />
                    </button>
                    <button className="w-10 h-10 bg-paper rounded-full flex items-center justify-center text-ink hover:bg-saffron hover:text-white transition-all shadow-sm">
                      <Twitter size={16} />
                    </button>
                    <button className="w-10 h-10 bg-paper rounded-full flex items-center justify-center text-ink hover:bg-saffron hover:text-white transition-all shadow-sm">
                      <Linkedin size={16} />
                    </button>
                  </div>
                </div>
              </div>
            </aside>

            {/* Main Content */}
            <div className="lg:col-span-8 order-1 lg:order-2">
              {/* Excerpt/Lead */}
              <motion.p 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.3 }}
                className="text-xl md:text-2xl text-ink/80 font-light leading-relaxed mb-12 border-l-4 border-saffron pl-6"
              >
                {post.excerpt}
              </motion.p>

              {/* Article Body */}
              <motion.div 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.4 }}
                className="blog-content"
              >
                <ReactMarkdown
                  components={{
                    h2: ({children}) => (
                      <h2 className="text-2xl md:text-3xl font-serif font-bold text-ink mt-14 mb-6 pb-4 border-b-2 border-saffron/30 relative">
                        <span className="absolute -left-6 top-0 w-1 h-full bg-saffron rounded-full hidden md:block"></span>
                        {children}
                      </h2>
                    ),
                    h3: ({children}) => (
                      <h3 className="text-xl md:text-2xl font-serif font-semibold text-saffron mt-10 mb-4 flex items-center gap-3">
                        <span className="w-8 h-0.5 bg-saffron"></span>
                        {children}
                      </h3>
                    ),
                    h4: ({children}) => (
                      <h4 className="text-lg font-bold text-ink mt-6 mb-3 uppercase tracking-wide">
                        {children}
                      </h4>
                    ),
                    p: ({children}) => (
                      <p className="text-ink/80 leading-relaxed mb-6 text-base md:text-lg">
                        {children}
                      </p>
                    ),
                    ul: ({children}) => (
                      <ul className="my-6 space-y-3 pl-6">
                        {children}
                      </ul>
                    ),
                    ol: ({children}) => (
                      <ol className="my-6 space-y-3 pl-6 list-decimal">
                        {children}
                      </ol>
                    ),
                    li: ({children}) => (
                      <li className="text-ink/80 leading-relaxed relative pl-4 before:content-[''] before:absolute before:left-0 before:top-2.5 before:w-2 before:h-2 before:bg-saffron before:rounded-full">
                        {children}
                      </li>
                    ),
                    blockquote: ({children}) => (
                      <blockquote className="my-8 pl-6 py-4 border-l-4 border-saffron bg-gradient-to-r from-paper to-transparent italic text-ink/70 text-lg rounded-r-lg">
                        {children}
                      </blockquote>
                    ),
                    strong: ({children}) => (
                      <strong className="font-bold text-ink">{children}</strong>
                    ),
                    a: ({children, href}) => (
                      <a href={href} className="text-saffron font-medium hover:underline underline-offset-4">
                        {children}
                      </a>
                    ),
                  }}
                >
                  {post.content}
                </ReactMarkdown>
              </motion.div>

              {/* Photo Gallery Carousel */}
              {post.gallery && post.gallery.length > 0 && (
                <motion.div 
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: 0.5 }}
                  className="mt-16"
                >
                  <h3 className="text-2xl font-serif font-bold text-ink mb-6 flex items-center gap-3">
                    <span className="w-8 h-0.5 bg-saffron"></span>
                    Photo Gallery
                    <span className="text-sm text-slate-400 font-normal ml-auto">Click to enlarge</span>
                  </h3>
                  
                  {/* Carousel Container */}
                  <div className="relative rounded-2xl overflow-hidden shadow-xl bg-ink">
                    {/* Main Image */}
                    <div 
                      className="relative aspect-[16/9] overflow-hidden cursor-pointer"
                      onClick={() => openLightbox(currentSlide)}
                    >
                      <AnimatePresence mode="wait">
                        <motion.img
                          key={currentSlide}
                          src={post.gallery[currentSlide]}
                          alt={`${post.title} - Image ${currentSlide + 1}`}
                          className="w-full h-full object-cover"
                          initial={{ opacity: 0, x: 100 }}
                          animate={{ opacity: 1, x: 0 }}
                          exit={{ opacity: 0, x: -100 }}
                          transition={{ duration: 0.4 }}
                        />
                      </AnimatePresence>
                      
                      {/* Navigation Arrows */}
                      <button 
                        onClick={(e) => { e.stopPropagation(); prevSlide(); }}
                        className="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-ink hover:bg-saffron hover:text-white transition-all shadow-lg"
                      >
                        <ChevronLeft size={24} />
                      </button>
                      <button 
                        onClick={(e) => { e.stopPropagation(); nextSlide(); }}
                        className="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-ink hover:bg-saffron hover:text-white transition-all shadow-lg"
                      >
                        <ChevronRight size={24} />
                      </button>

                      {/* Slide Counter */}
                      <div className="absolute bottom-4 right-4 px-4 py-2 bg-black/50 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                        {currentSlide + 1} / {post.gallery.length}
                      </div>
                    </div>

                    {/* Thumbnail Strip */}
                    <div className="flex gap-2 p-4 bg-ink/95 overflow-x-auto">
                      {post.gallery.map((img, index) => (
                        <button
                          key={index}
                          onClick={() => setCurrentSlide(index)}
                          className={`flex-shrink-0 w-20 h-14 rounded-lg overflow-hidden border-2 transition-all ${
                            currentSlide === index 
                              ? 'border-saffron opacity-100' 
                              : 'border-transparent opacity-60 hover:opacity-100'
                          }`}
                        >
                          <img 
                            src={img} 
                            alt={`Thumbnail ${index + 1}`}
                            className="w-full h-full object-cover"
                          />
                        </button>
                      ))}
                    </div>
                  </div>
                </motion.div>
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

              {/* Tags */}
              <div className="mt-16 pt-8 border-t border-slate-100">
                <div className="flex flex-wrap gap-3">
                  {['Culture', 'Bihar', 'Netherlands', 'Community', 'Diaspora'].map(tag => (
                    <span key={tag} className="px-4 py-2 bg-paper text-sm font-medium text-ink/70 rounded-full hover:bg-saffron hover:text-white transition-colors cursor-pointer">
                      #{tag}
                    </span>
                  ))}
                </div>
              </div>

            </div>

            {/* Right Sidebar - Other Articles */}
            <aside className="lg:col-span-2 order-3 hidden lg:block">
              <div className="lg:sticky lg:top-32">
                <span className="text-xs uppercase tracking-widest font-bold text-saffron mb-6 block">More Articles</span>
                <div className="space-y-4">
                  {blogs.filter(b => b.id !== id).slice(0, 3).map(article => (
                    <Link 
                      key={article.id} 
                      to={`/blog/${article.id}`}
                      className="block group"
                    >
                      <div className="aspect-video rounded-lg overflow-hidden mb-2">
                        <img 
                          src={article.image} 
                          alt={article.title}
                          className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                          referrerPolicy="no-referrer"
                        />
                      </div>
                      <h4 className="text-sm font-medium text-ink/80 group-hover:text-saffron transition-colors leading-tight line-clamp-2">
                        {article.title}
                      </h4>
                      <p className="text-xs text-slate-400 mt-1">
                        {new Date(article.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                      </p>
                    </Link>
                  ))}
                </div>
                <Link 
                  to="/blog" 
                  className="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-ink hover:text-saffron transition-colors mt-6"
                >
                  View All <ArrowRight size={12} />
                </Link>
              </div>
            </aside>
          </div>
        </div>
      </article>


      {/* Newsletter CTA */}
      <section className="py-20 bg-gradient-to-r from-saffron to-amber-500">
        <div className="max-w-4xl mx-auto px-6 text-center">
          <h3 className="text-2xl md:text-3xl font-serif font-bold text-white mb-4">Stay Updated with Our Latest News</h3>
          <p className="text-white/80 mb-8">Subscribe to receive updates on events, community news, and cultural insights.</p>
          <form className="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
            <input
              type="email"
              placeholder="Enter your email address"
              className="flex-1 px-6 py-4 rounded-full bg-white/20 backdrop-blur-sm text-white placeholder:text-white/60 border border-white/30 focus:outline-none focus:border-white"
            />
            <button type="submit" className="px-8 py-4 bg-ink text-white font-bold uppercase tracking-wider text-sm rounded-full hover:bg-ink/90 transition-colors">
              Subscribe
            </button>
          </form>
        </div>
      </section>
    </div>
  );
};

export default BlogDetail;
