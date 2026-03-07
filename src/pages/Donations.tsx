import React, { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import { Heart, Globe, BookOpen, Users, ArrowRight } from 'lucide-react';

const Donations = () => {
  const [amount, setAmount] = useState<number | string>(50);
  const [customAmount, setCustomAmount] = useState('');

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

  const handleDonate = (e: React.FormEvent) => {
    e.preventDefault();
    alert(`Thank you for your donation of €${customAmount || amount}!`);
  };

  const causes = [
    { icon: BookOpen, title: "Education", desc: "Supporting schools and scholarships for underprivileged children in Bihar." },
    { icon: Heart, title: "Healthcare", desc: "Funding medical camps and emergency relief in rural areas." },
    { icon: Globe, title: "Culture", desc: "Preserving and promoting Bihari arts, language, and traditions in the Netherlands." },
    { icon: Users, title: "Community", desc: "Building a support network for new immigrants and students." }
  ];

  return (
    <div className="bg-background">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[80vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Donations" 
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
            Make a Difference
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Fuel the <span className="italic font-light text-saffron">Mission.</span>
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
            Your contribution directly supports our cultural initiatives and social welfare projects in both Bihar and the Netherlands.
          </motion.p>
        </div>
      </section>

      {/* Main Content - Causes on Left, Form on Right */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {/* Left Side - Impact Causes */}
            <div className="scroll-reveal">
              <span className="text-sm uppercase tracking-[0.3em] text-saffron font-bold mb-4 block">Your Support Matters</span>
              <h2 className="text-3xl md:text-4xl font-serif font-bold text-ink mb-8">
                Where Your <span className="italic font-light text-saffron">Donation</span> Goes
              </h2>
              
              <div className="space-y-4">
                {causes.map((cause, i) => (
                  <motion.div 
                    key={i}
                    initial={{ opacity: 0, x: -20 }}
                    whileInView={{ opacity: 1, x: 0 }}
                    viewport={{ once: true }}
                    transition={{ delay: i * 0.1 }}
                    className="flex items-start gap-4 p-5 bg-paper rounded-2xl hover:shadow-md transition-all"
                  >
                    <div className="w-12 h-12 bg-saffron/10 text-saffron rounded-xl flex items-center justify-center shrink-0">
                      <cause.icon size={24} />
                    </div>
                    <div>
                      <h3 className="text-lg font-serif font-bold text-ink mb-1">{cause.title}</h3>
                      <p className="text-sm text-slate-500">{cause.desc}</p>
                    </div>
                  </motion.div>
                ))}
              </div>

              {/* Bank Info */}
              <div className="mt-8 p-6 bg-saffron/10 rounded-2xl">
                <span className="font-bold text-ink block mb-2">Direct Bank Transfer</span>
                <p className="text-slate-600 text-sm">
                  <span className="font-medium">Bank Account Number:</span><br />
                  <span className="text-ink font-bold text-lg">NL54 BUNQ 2153 6914 51</span>
                </p>
              </div>
            </div>

            {/* Right Side - Donation Form */}
            <div className="scroll-reveal">
              <div className="bg-paper p-8 md:p-10 rounded-3xl shadow-xl sticky top-24">
                <h2 className="text-2xl font-serif font-bold text-ink mb-2">Make a Donation</h2>
                <p className="text-slate-500 text-sm mb-8">Choose an amount and complete your donation.</p>

                <form onSubmit={handleDonate} className="space-y-6">
                  {/* Amount Selection */}
                  <div>
                    <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400 block mb-3">Select Amount</label>
                    <div className="grid grid-cols-4 gap-3">
                      {[25, 50, 100, 250].map((val) => (
                        <button
                          key={val}
                          type="button"
                          onClick={() => { setAmount(val); setCustomAmount(''); }}
                          className={`py-4 text-sm font-bold transition-all border rounded-xl ${amount === val && !customAmount ? 'bg-saffron text-white border-saffron shadow-lg' : 'bg-white text-ink border-slate-200 hover:border-saffron'}`}
                        >
                          €{val}
                        </button>
                      ))}
                    </div>
                  </div>

                  <div className="flex items-center gap-3">
                    <div className="h-px bg-slate-200 flex-1"></div>
                    <span className="text-xs text-slate-400 font-medium">or enter custom amount</span>
                    <div className="h-px bg-slate-200 flex-1"></div>
                  </div>

                  <div className="relative">
                    <span className="absolute left-4 top-1/2 -translate-y-1/2 text-lg font-bold text-slate-300">€</span>
                    <input 
                      type="number" 
                      placeholder="Custom amount"
                      className={`w-full pl-10 pr-4 py-3 bg-white border rounded-xl focus:border-saffron outline-none transition-all text-lg font-bold ${customAmount ? 'border-saffron' : 'border-slate-200'}`}
                      value={customAmount}
                      onChange={(e) => { setCustomAmount(e.target.value); setAmount(''); }}
                    />
                  </div>

                  {/* Personal Info */}
                  <div className="grid grid-cols-2 gap-4">
                    <div className="space-y-1">
                      <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Full Name *</label>
                      <input 
                        type="text" 
                        required
                        className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm"
                        placeholder="John Doe"
                      />
                    </div>
                    <div className="space-y-1">
                      <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Email *</label>
                      <input 
                        type="email" 
                        required
                        className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm"
                        placeholder="john@example.com"
                      />
                    </div>
                  </div>

                  <button type="submit" className="btn-primary w-full py-4">
                    Complete Donation <ArrowRight size={18} />
                  </button>

                  <p className="text-xs text-center text-slate-400">
                    Secure payment. Your donation is tax-deductible.
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
  );
};

export default Donations;
