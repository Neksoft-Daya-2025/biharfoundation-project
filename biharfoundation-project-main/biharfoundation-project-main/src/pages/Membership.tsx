import React, { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import { Check, ArrowRight, Users, UserCheck, GraduationCap, Mail, CreditCard } from 'lucide-react';

const Membership = () => {
  const [selectedPlan, setSelectedPlan] = useState('family');
  const [isRepeatMember, setIsRepeatMember] = useState<string>('no');
  const [formData, setFormData] = useState({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    whyJoin: '',
    message: ''
  });

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

  const membershipPlans = [
    {
      id: 'family',
      name: 'Family',
      price: 52.20,
      icon: Users,
      description: 'Two adults + up to 2 children',
      features: [
        'Full membership for 2 adults',
        'Up to 2 children included',
        'Priority event access',
        'Voting rights in AGM',
        'Community newsletter'
      ]
    },
    {
      id: 'individual',
      name: 'Individual',
      price: 31.69,
      icon: UserCheck,
      description: 'One adult',
      features: [
        'Full membership for 1 adult',
        'Priority event access',
        'Voting rights in AGM',
        'Community newsletter',
        'Networking opportunities'
      ],
      recommended: true
    },
    {
      id: 'student',
      name: 'Student/Youth',
      price: 21.44,
      icon: GraduationCap,
      description: 'Students (with valid ID)',
      features: [
        'Full membership for students',
        'Valid student ID required',
        'Priority event access',
        'Community newsletter',
        'Youth programs access'
      ]
    }
  ];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const plan = membershipPlans.find(p => p.id === selectedPlan);
    alert(`Thank you for your application for ${plan?.name} membership (€${plan?.price})! We will contact you soon at ${formData.email}.`);
  };

  return (
    <div className="bg-background">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[60vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Membership" 
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
            Stichting Bihar Foundation Netherlands Chapter
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Become a <span className="italic font-light text-saffron">Member.</span>
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
            The Bihar Foundation welcomes committed individuals and families of Bihari origin who share our vision to connect, empower, and celebrate Bihar.
          </motion.p>
        </div>
      </section>

      {/* Main Content - Plans on Left, Form on Right */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {/* Left Side - Membership Plans */}
            <div className="scroll-reveal">
              <span className="text-sm uppercase tracking-[0.3em] text-saffron font-bold mb-4 block">Choose Your Plan</span>
              <h2 className="text-3xl md:text-4xl font-serif font-bold text-ink mb-8">
                Membership <span className="italic font-light text-saffron">Categories</span>
              </h2>
              
              <div className="space-y-4">
                {membershipPlans.map((plan, index) => (
                  <motion.div 
                    key={plan.id}
                    initial={{ opacity: 0, x: -20 }}
                    whileInView={{ opacity: 1, x: 0 }}
                    viewport={{ once: true }}
                    transition={{ delay: index * 0.1 }}
                    className={`relative p-6 bg-paper rounded-2xl transition-all duration-300 cursor-pointer ${
                      selectedPlan === plan.id 
                        ? 'ring-2 ring-saffron shadow-lg' 
                        : 'hover:shadow-md'
                    }`}
                    onClick={() => setSelectedPlan(plan.id)}
                  >
                    <div className="flex items-start gap-4">
                      <div className={`w-12 h-12 rounded-xl flex items-center justify-center shrink-0 ${
                        selectedPlan === plan.id ? 'bg-saffron text-white' : 'bg-saffron/10 text-saffron'
                      }`}>
                        <plan.icon size={24} />
                      </div>
                      
                      <div className="flex-1">
                        <div className="flex items-center justify-between mb-1">
                          <h3 className="text-xl font-serif font-bold text-ink">{plan.name}</h3>
                          <span className="text-2xl font-bold text-ink">€{plan.price.toFixed(2)}<span className="text-sm text-slate-400 font-normal">/year</span></span>
                        </div>
                        <p className="text-slate-500 text-sm mb-3">{plan.description}</p>
                        
                        {selectedPlan === plan.id && (
                          <motion.ul 
                            initial={{ opacity: 0, height: 0 }}
                            animate={{ opacity: 1, height: 'auto' }}
                            className="space-y-2 mt-4 pt-4 border-t border-slate-200"
                          >
                            {plan.features.map((feature, i) => (
                              <li key={i} className="flex gap-2 text-sm text-slate-600">
                                <Check className="text-saffron shrink-0" size={16} />
                                {feature}
                              </li>
                            ))}
                          </motion.ul>
                        )}
                      </div>
                      
                      {plan.recommended && (
                        <span className="absolute -top-2 -right-2 bg-saffron text-white px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider">
                          Popular
                        </span>
                      )}
                    </div>
                  </motion.div>
                ))}
              </div>

              {/* Payment Info */}
              <div className="mt-8 p-6 bg-saffron/10 rounded-2xl">
                <div className="flex items-center gap-3 mb-3">
                  <CreditCard className="text-saffron" size={24} />
                  <span className="font-bold text-ink">Payment Details</span>
                </div>
                <p className="text-slate-600 text-sm">
                  <span className="font-medium">Bank Account Number:</span><br />
                  <span className="text-ink font-bold text-lg">NL54 BUNQ 2153 6914 51</span>
                </p>
              </div>

              {/* Terms & Policies */}
              <div className="mt-8">
                <h3 className="text-2xl font-serif font-bold text-ink mb-4">Terms & Policies</h3>
                <div className="space-y-3">
                  <p className="text-slate-600 flex gap-2">
                    <span className="text-saffron font-bold">*</span>
                    Membership starts upon receipt of payment and lasts for 12 months.
                  </p>
                  <p className="text-slate-600 flex gap-2">
                    <span className="text-saffron font-bold">*</span>
                    Event seats limited to members; terms vary by event.
                  </p>
                  <p className="text-slate-600 flex gap-2">
                    <span className="text-saffron font-bold">*</span>
                    Privacy assured—your data used only for foundation purposes; not shared externally.
                  </p>
                </div>
              </div>
            </div>

            {/* Right Side - Application Form */}
            <div className="scroll-reveal">
              <div className="bg-paper p-8 md:p-10 rounded-3xl shadow-xl sticky top-24">
                <h2 className="text-2xl font-serif font-bold text-ink mb-2">Membership Application</h2>
                <p className="text-slate-500 text-sm mb-8">Fill out the form below to apply for membership.</p>

                <form onSubmit={handleSubmit} className="space-y-5">
                  {/* Name Fields */}
                  <div className="grid grid-cols-2 gap-4">
                    <div className="space-y-1">
                      <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">First Name *</label>
                      <input 
                        type="text" 
                        required
                        className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm"
                        placeholder="John"
                        value={formData.firstName}
                        onChange={(e) => setFormData({...formData, firstName: e.target.value})}
                      />
                    </div>
                    <div className="space-y-1">
                      <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Last Name *</label>
                      <input 
                        type="text" 
                        required
                        className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm"
                        placeholder="Doe"
                        value={formData.lastName}
                        onChange={(e) => setFormData({...formData, lastName: e.target.value})}
                      />
                    </div>
                  </div>

                  {/* Email */}
                  <div className="space-y-1">
                    <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Email *</label>
                    <input 
                      type="email" 
                      required
                      className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm"
                      placeholder="john@example.com"
                      value={formData.email}
                      onChange={(e) => setFormData({...formData, email: e.target.value})}
                    />
                  </div>

                  {/* Phone */}
                  <div className="space-y-1">
                    <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Phone *</label>
                    <input 
                      type="tel" 
                      required
                      className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm"
                      placeholder="+31 6 12345678"
                      value={formData.phone}
                      onChange={(e) => setFormData({...formData, phone: e.target.value})}
                    />
                  </div>

                  {/* Repeat Member */}
                  <div className="space-y-2">
                    <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Repeat Foundation member?</label>
                    <div className="flex gap-4">
                      <label className="flex items-center gap-2 cursor-pointer">
                        <input 
                          type="radio" 
                          name="repeatMember" 
                          value="yes"
                          checked={isRepeatMember === 'yes'}
                          onChange={() => setIsRepeatMember('yes')}
                          className="w-4 h-4 text-saffron focus:ring-saffron"
                        />
                        <span className="text-ink text-sm">Yes</span>
                      </label>
                      <label className="flex items-center gap-2 cursor-pointer">
                        <input 
                          type="radio" 
                          name="repeatMember" 
                          value="no"
                          checked={isRepeatMember === 'no'}
                          onChange={() => setIsRepeatMember('no')}
                          className="w-4 h-4 text-saffron focus:ring-saffron"
                        />
                        <span className="text-ink text-sm">No</span>
                      </label>
                    </div>
                  </div>

                  {/* Membership Type */}
                  <div className="space-y-1">
                    <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Membership Type *</label>
                    <select 
                      className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm"
                      value={selectedPlan}
                      onChange={(e) => setSelectedPlan(e.target.value)}
                    >
                      {membershipPlans.map(plan => (
                        <option key={plan.id} value={plan.id}>
                          {plan.name} - €{plan.price.toFixed(2)}/year
                        </option>
                      ))}
                    </select>
                  </div>

                  {/* Why Join */}
                  <div className="space-y-1">
                    <label className="text-[10px] uppercase tracking-widest font-bold text-slate-400">Why join Bihar Foundation?</label>
                    <textarea 
                      className="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-saffron outline-none transition-all text-sm h-20 resize-none"
                      placeholder="Tell us why you'd like to join..."
                      value={formData.whyJoin}
                      onChange={(e) => setFormData({...formData, whyJoin: e.target.value})}
                    ></textarea>
                  </div>

                  <button type="submit" className="btn-primary w-full py-4">
                    Submit Application <ArrowRight size={18} />
                  </button>

                  <p className="text-xs text-center text-slate-400">
                    For support: <a href="mailto:info@biharfoundationnl.org" className="text-saffron hover:underline">info@biharfoundationnl.org</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* How to Apply */}
      <section className="py-20 bg-paper">
        <div className="max-w-7xl mx-auto px-6 lg:px-12">
          <div className="text-center mb-12 scroll-reveal">
            <span className="text-sm uppercase tracking-[0.3em] text-saffron font-bold mb-4 block">Step by Step</span>
            <h2 className="text-3xl md:text-4xl font-serif font-bold text-ink">
              How to <span className="italic font-light text-saffron">Apply</span>
            </h2>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 scroll-reveal">
            {[
              { step: 1, title: 'Choose Plan', desc: 'Select your membership category based on your needs.' },
              { step: 2, title: 'Fill Form', desc: 'Provide your personal and contact information in the application form.' },
              { step: 3, title: 'Confirm Status', desc: 'Let us know if you\'re a returning Foundation member.' },
              { step: 4, title: 'Share Your Story', desc: 'Tell us why you\'d like to join Bihar Foundation.' },
              { step: 5, title: 'Make Payment', desc: 'Pay via Bank: NL54 BUNQ 2153 6914 51' },
              { step: 6, title: 'Submit', desc: 'Complete your submission and we\'ll contact you soon.' },
            ].map((item) => (
              <motion.div
                key={item.step}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: item.step * 0.1 }}
                className="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all"
              >
                <span className="w-10 h-10 bg-saffron text-white rounded-full flex items-center justify-center text-sm font-bold mb-4">
                  {item.step}
                </span>
                <h3 className="font-bold text-ink mb-2">{item.title}</h3>
                <p className="text-slate-500 text-sm">{item.desc}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Contact Support */}
      <section className="py-10 bg-gradient-to-r from-saffron to-orange-500 text-white">
        <div className="max-w-4xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8">
          <div className="flex items-center gap-3">
            <Mail className="text-white" size={22} />
            <span className="font-serif font-bold text-lg">Need Help?</span>
          </div>
          <span className="hidden sm:block text-white/50">|</span>
          <a 
            href="mailto:info@biharfoundationnl.org" 
            className="inline-flex items-center gap-2 bg-white text-saffron px-6 py-2.5 rounded-full font-bold text-sm hover:bg-ink hover:text-white transition-all"
          >
            info@biharfoundationnl.org <ArrowRight size={16} />
          </a>
        </div>
      </section>
    </div>
  );
};

export default Membership;
