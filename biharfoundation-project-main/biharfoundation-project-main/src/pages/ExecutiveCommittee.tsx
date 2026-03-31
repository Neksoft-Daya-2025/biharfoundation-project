import React, { useEffect } from 'react';
import { motion } from 'motion/react';
import { Mail, Linkedin } from 'lucide-react';

const ExecutiveCommittee = () => {
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

  const boardMembers = [
    {
      id: 'chairman',
      name: 'Daya Shankar Kumar',
      role: 'Chairman',
      image: '/images/Member/Untitled-design-8-1.webp',
    },
    {
      id: 'vice-chairman',
      name: 'Darshan Raj Ashutosh',
      role: 'Vice Chairman',
      image: '/images/Member/Untitled-design-7-1.webp',
    },
    {
      id: 'secretary',
      name: 'Jayant Shandilya',
      role: 'Secretary',
      image: '/images/Member/Untitled-design-1-1.webp',
    },
    {
      id: 'treasurer',
      name: 'Ms. Sunita Rai',
      role: 'Treasurer',
      image: '/images/Member/Untitled-design-2-1.webp',
    },
  ];

  const executiveMembers = [
    { id: 'em-1', name: 'Shri Dharmendra Kr', role: 'Executive Member' },
    { id: 'em-2', name: 'Shri Shivam Jha', role: 'Executive Member' },
    { id: 'em-3', name: 'Shri Mukul Kumar', role: 'Executive Member' },
    { id: 'em-4', name: 'Shri Rajiv Giri', role: 'Executive Member' },
    { id: 'em-5', name: 'Shri Rohit Sinha', role: 'Executive Member' },
    { id: 'em-6', name: 'Shri Arvind Rai', role: 'Executive Member' },
    { id: 'em-7', name: 'Shri Akhilesh Kumar', role: 'Executive Member' },
    { id: 'em-8', name: 'Shri Rohit Raj Shrivastav', role: 'Executive Member' },
    { id: 'em-9', name: 'Shri Kumar Rituraj', role: 'Executive Member' },
    { id: 'em-10', name: 'Ms. Priya', role: 'Executive Member' },
    { id: 'em-11', name: 'Ms. Sweta Verma', role: 'Executive Member' },
    { id: 'em-12', name: 'Ms. Ruchi Saumya', role: 'Executive Member' },
    { id: 'em-13', name: 'Ms. Kavita Jha', role: 'Executive Member' },
    { id: 'em-14', name: 'Ms. Sonam Raj Verma', role: 'Executive Member' },
  ];

  return (
    <div className="bg-background">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[80vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Executive Committee" 
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
            The Stewards
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Executive <span className="italic font-light text-saffron">Committee.</span>
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
            Meet the dedicated leaders who guide Bihar Foundation Netherlands with passion, vision, and commitment to our community.
          </motion.p>
        </div>
      </section>

      {/* Board Members Section */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="text-center mb-16 scroll-reveal">
            <span className="section-subtitle">Leadership</span>
            <h2 className="section-title">Board <span className="italic font-light text-saffron">Members</span></h2>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {boardMembers.map((member, i) => (
              <motion.div 
                key={member.id} 
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="group scroll-reveal"
              >
                <div className="relative mb-6 overflow-hidden rounded-2xl aspect-[3/4] shadow-xl">
                  <img 
                    src={member.image} 
                    alt={member.name} 
                    className="w-full h-full object-cover transition-all duration-700 group-hover:scale-105"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-ink/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                  
                  <div className="absolute bottom-4 left-4 right-4 flex gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
                    <button className="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-saffron transition-colors">
                      <Mail size={18} />
                    </button>
                    <button className="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-saffron transition-colors">
                      <Linkedin size={18} />
                    </button>
                  </div>
                </div>
                <div className="text-center">
                  <h3 className="text-xl font-serif font-bold text-ink mb-2">{member.name}</h3>
                  <p className="text-saffron font-bold uppercase tracking-widest text-xs">{member.role}</p>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Executive Members Section */}
      <section className="py-24 bg-paper">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="text-center mb-16 scroll-reveal">
            <span className="section-subtitle">Team</span>
            <h2 className="section-title">Executive <span className="italic font-light text-saffron">Members</span></h2>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            {executiveMembers.map((member, i) => (
              <motion.div 
                key={member.id} 
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.05 }}
                className="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all text-center scroll-reveal group"
              >
                <h3 className="text-sm font-bold text-ink mb-1">{member.name}</h3>
                <p className="text-slate-500 italic text-xs">{member.role}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Join Us CTA */}
      <section className="py-24 bg-paper">
        <div className="max-w-4xl mx-auto px-6 text-center scroll-reveal">
          <h2 className="text-3xl md:text-5xl font-serif font-bold text-ink mb-6">
            Want to <span className="italic font-light text-saffron">Contribute?</span>
          </h2>
          <p className="text-slate-500 mb-8 text-lg">
            We're always looking for passionate individuals who want to make a difference in our community. Join our volunteer team or become a member.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/membership" className="inline-flex items-center justify-center gap-2 px-8 py-4 bg-saffron text-white font-bold uppercase tracking-widest text-xs rounded-full hover:bg-ink transition-all">Become a Member</a>
            <a href="/contact" className="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-ink text-ink font-bold uppercase tracking-widest text-xs rounded-full hover:bg-ink hover:text-white transition-all">Get in Touch</a>
          </div>
        </div>
      </section>
    </div>
  );
};

export default ExecutiveCommittee;
