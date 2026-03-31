import React, { useEffect } from 'react';
import { motion } from 'motion/react';
import { Link } from 'react-router-dom';
import { Target, Eye, Award, Users, ShieldCheck, Briefcase, Heart, Globe } from 'lucide-react';

const About = () => {
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

  const coreValues = [
    { 
      icon: Award, 
      title: 'Cultural Preservation', 
      desc: 'The Indian community of Bihar in the Netherlands takes great pride in their heritage and actively works to preserve it.' 
    },
    { 
      icon: Briefcase, 
      title: 'Professional Success', 
      desc: 'The Indian community of Bihar in the Netherlands is highly skilled and contributes to the economy and society.' 
    },
    { 
      icon: Globe, 
      title: 'Social Integration', 
      desc: 'The Indian community of Bihar in the Netherlands seeks to integrate with Dutch society while maintaining their unique cultural identity.' 
    },
  ];

  return (
    <div className="bg-background">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[80vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        {/* Background Image */}
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Bihar and Netherlands" 
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-ink/90 via-ink/70 to-ink/50"></div>
        </div>
        
        {/* Content */}
        <div className="relative z-10 max-w-7xl mx-auto px-4 lg:px-12 py-4 md:py-16 text-center">
          <motion.span 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="hidden md:inline-block text-saffron font-bold uppercase tracking-[0.3em] text-sm mb-6"
          >
            Uniting for a brighter tomorrow
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Our Community, <span className="italic font-light text-saffron">Our Strength.</span>
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
            className="text-sm md:text-lg text-white/80 max-w-4xl mx-auto leading-relaxed"
          >
            "Bringing the vibrant colors and rich culture of Indian state of Bihar to the heart of the Netherlands – the incredible journey of our Bihari community."
          </motion.p>
        </div>
      </section>

      {/* About Content */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div className="scroll-reveal">
              <span className="text-sm uppercase tracking-[0.3em] text-saffron font-bold mb-4 block text-left">Who We Are</span>
              <h2 className="text-4xl md:text-5xl font-serif font-bold text-ink mb-8">
                Stichting Bihar Foundation <span className="italic font-light text-saffron">Netherlands Chapter</span>
              </h2>
              <div className="space-y-6 text-slate-600 leading-relaxed">
                <p>
                  The Stichting Bihar Foundation Netherlands Chapter is a vibrant community of Indians living in the Netherlands who celebrate their rich cultural heritage while fostering social connections and offering support to its members.
                </p>
                <p>
                  We strive to promote the cultural legacy of Bihar and India through festivals, events, and activities that bring our community together. Our members come from all walks of life and professions, and we take pride in the diversity of our community.
                </p>
                <p>
                  We believe in inclusivity, respect, and support for one another, making our Bihar Chapter a welcoming home away from home for Indians in the Netherlands.
                </p>
              </div>
            </div>
            <div className="scroll-reveal">
              <div className="bg-paper p-8 md:p-12 rounded-3xl">
                <h3 className="text-2xl font-serif font-bold text-ink mb-6">What We Offer</h3>
                <div className="space-y-6">
                  <p className="text-slate-600 leading-relaxed">
                    Through The Stichting Bihar Foundation Netherlands Chapter, members have the opportunity to participate in various social, cultural, and community service activities.
                  </p>
                  <p className="text-slate-600 leading-relaxed">
                    The community also provides a platform for members to network, seek advice, and find support in their personal and professional lives.
                  </p>
                  <p className="text-slate-600 leading-relaxed">
                    The Stichting Bihar Foundation Netherlands Chapter is committed to promoting the rich cultural heritage of Bihar and fostering a sense of community among Bihari Indians in the Netherlands. The community is constantly looking for ways to grow and improve, and welcomes new members who are interested in contributing to its mission.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Core Values */}
      <section className="py-24 bg-paper">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="text-center mb-16 scroll-reveal">
            <span className="section-subtitle">Being Together</span>
            <h2 className="section-title">Helping Each Other Can Make <span className="italic font-light text-saffron">World Better</span></h2>
            <p className="text-slate-500 max-w-2xl mx-auto mt-6">
              "By extending a hand to those in need, we not only help others, but we also create a more compassionate and supportive world for all."
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {coreValues.map((value, i) => (
              <motion.div
                key={i}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="bg-white p-10 rounded-2xl shadow-lg hover:shadow-xl transition-all scroll-reveal text-center"
              >
                <div className="w-16 h-16 bg-saffron/10 text-saffron rounded-full flex items-center justify-center mb-6 mx-auto">
                  <value.icon size={32} />
                </div>
                <h3 className="text-xl font-serif font-bold text-ink mb-4">{value.title}</h3>
                <p className="text-slate-500 leading-relaxed">{value.desc}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Mission & Vision */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="text-center mb-16 scroll-reveal">
            <span className="section-subtitle">Our Purpose</span>
            <h2 className="section-title">Mission & <span className="italic font-light text-saffron">Vision</span></h2>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
            <motion.div 
              initial={{ opacity: 0, x: -30 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              className="bg-paper p-12 md:p-16 rounded-3xl shadow-xl scroll-reveal"
            >
              <div className="w-20 h-20 bg-saffron/10 text-saffron rounded-full flex items-center justify-center mb-8">
                <Target size={40} />
              </div>
              <h2 className="text-3xl md:text-4xl font-serif font-bold text-ink mb-6">Mission Statement</h2>
              <p className="text-slate-600 leading-relaxed text-lg">
                The Stichting Bihar Foundation Netherlands Chapter is committed to promoting and preserving the rich cultural heritage of Bihar and providing a platform for Bihari Indians living in the Netherlands to connect, share their experiences, and support each other.
              </p>
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, x: 30 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              className="bg-gradient-to-br from-slate-700 to-slate-800 p-12 md:p-16 rounded-3xl shadow-xl text-white scroll-reveal relative overflow-hidden"
            >
              <div className="absolute top-0 right-0 w-40 h-40 bg-saffron/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
              <div className="absolute bottom-0 left-0 w-32 h-32 bg-saffron/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
              <div className="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-saffron to-saffron/50"></div>
              <div className="relative">
                <div className="w-20 h-20 bg-saffron text-white rounded-2xl flex items-center justify-center mb-8 shadow-lg">
                  <Eye size={40} />
                </div>
                <h2 className="text-3xl md:text-4xl font-serif font-bold mb-6">Vision Statement</h2>
                <p className="text-slate-300 leading-relaxed text-lg">
                  The Stichting Bihar Foundation Netherlands Chapter envisions a vibrant and inclusive community of Bihari Indians in the Netherlands, where members feel a strong sense of belonging and are empowered to succeed personally and professionally. We strive to create a welcoming and supportive environment that fosters strong connections, celebrates diversity, and promotes the rich cultural heritage of Bihar. Our goal is to enhance the well-being and success of all members, and to contribute to the larger society in which we live.
                </p>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Collaboration CTA */}
      <section className="py-24 bg-saffron">
        <div className="max-w-4xl mx-auto px-6 text-center scroll-reveal">
          <h2 className="text-3xl md:text-5xl font-serif font-bold text-white mb-6">
            "Collaboration builds a brighter future <span className="italic font-light">for all of us."</span>
          </h2>
          <p className="text-white/80 mb-10 text-lg max-w-2xl mx-auto">
            Join our growing community and be part of something meaningful. Together, we celebrate our heritage and build lasting connections.
          </p>
          <Link to="/membership" className="inline-flex items-center gap-2 bg-white text-ink px-8 py-4 rounded-full font-bold uppercase tracking-wider text-sm hover:bg-ink hover:text-white transition-all">
            <Heart size={18} />
            Register Now
          </Link>
        </div>
      </section>

      {/* Organization Info */}
      <section className="py-16 bg-ink text-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
            <div>
              <h4 className="font-serif font-bold text-xl mb-4">About the Organization</h4>
              <p className="text-slate-400 leading-relaxed">
                Stichting Bihar Foundation Netherlands Chapter is a community organization in the Netherlands that brings together people from the Indian state of Bihar.
              </p>
            </div>
            <div>
              <h4 className="font-serif font-bold text-xl mb-4">Bank Details</h4>
              <p className="text-slate-400">
                <span className="text-white font-medium">Account Number:</span><br />
                NL54 BUNQ 2153 6914 51
              </p>
            </div>
            <div>
              <h4 className="font-serif font-bold text-xl mb-4">Registration</h4>
              <p className="text-slate-400">
                <span className="text-white font-medium">KVK Number:</span><br />
                97340294
              </p>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default About;
