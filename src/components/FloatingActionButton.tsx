import React, { useState } from 'react';
import { Phone, Mail, X } from 'lucide-react';
import { motion, AnimatePresence } from 'motion/react';

const FloatingActionButton = () => {
  const [isOpen, setIsOpen] = useState(false);

  const contactOptions = [
    {
      icon: Phone,
      label: 'Call Us',
      href: 'tel:+31612345678',
      color: 'bg-green-500 hover:bg-green-600'
    },
    {
      icon: Mail,
      label: 'Email Us',
      href: 'mailto:info@biharfoundationnl.org',
      color: 'bg-blue-500 hover:bg-blue-600'
    }
  ];

  return (
    <div 
      className="fixed bottom-8 right-6 z-50 flex flex-col items-end gap-3"
      onMouseEnter={() => setIsOpen(true)}
      onMouseLeave={() => setIsOpen(false)}
    >
      <AnimatePresence>
        {isOpen && (
          <>
            {contactOptions.map((option, index) => (
              <motion.a
                key={option.label}
                href={option.href}
                initial={{ opacity: 0, y: 20, scale: 0.8 }}
                animate={{ opacity: 1, y: 0, scale: 1 }}
                exit={{ opacity: 0, y: 20, scale: 0.8 }}
                transition={{ delay: index * 0.1 }}
                className={`flex items-center gap-3 ${option.color} text-white px-4 py-3 rounded-full shadow-lg transition-all group`}
              >
                <span className="text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                  {option.label}
                </span>
                <option.icon size={18} />
              </motion.a>
            ))}
          </>
        )}
      </AnimatePresence>

      <motion.button
        onClick={() => setIsOpen(!isOpen)}
        className="w-16 h-16 bg-saffron rounded-full shadow-xl flex items-center justify-center transition-all hover:shadow-2xl overflow-hidden p-1"
      >
        <AnimatePresence mode="wait">
          {isOpen ? (
            <motion.div
              key="close"
              initial={{ opacity: 0, rotate: -90 }}
              animate={{ opacity: 1, rotate: 0 }}
              exit={{ opacity: 0, rotate: 90 }}
              transition={{ duration: 0.2 }}
              className="w-full h-full flex items-center justify-center"
            >
              <X size={28} className="text-white" strokeWidth={2.5} />
            </motion.div>
          ) : (
            <motion.img
              key="logo"
              src="/images/Untitled-1-1.webp"
              alt="Contact"
              className="w-full h-full object-contain rounded-full"
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              exit={{ opacity: 0, scale: 0.8 }}
              transition={{ duration: 0.2 }}
            />
          )}
        </AnimatePresence>
      </motion.button>
    </div>
  );
};

export default FloatingActionButton;
