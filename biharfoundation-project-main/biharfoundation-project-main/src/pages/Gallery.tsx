import React, { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import { Maximize2, ChevronLeft, ChevronRight } from 'lucide-react';
import Lightbox from '../components/Lightbox';
import { useLightbox } from '../hooks/useLightbox';

const Gallery = () => {
  const [currentPage, setCurrentPage] = useState(1);
  const imagesPerPage = 12;

  const allImages = [
    '/images/Homepage/480971677_122145562928579269_2176968860162883411_n.webp',
    '/images/Homepage/572361016_122184952952579269_4566659540459077237_n.webp',
    '/images/Homepage/WhatsApp-Image-2024-11-26-at-03.50.17_c2d753a6-1.webp',
    '/images/Homepage/WhatsApp-Image-2025-12-02-at-15.11.40_70340508.webp',
    '/images/Blog/Bihar & Suriname Meet-Up Celebrating Shared Heritage and Strengthening Diaspora Bonds.webp',
    '/images/Blog/WhatsApp-Image-2025-05-20-at-15.41.13_7aa0ce94.webp',
    '/images/Blog/WhatsApp-Image-2025-05-20-at-15.41.14_56463721.webp',
    '/images/Past Events/Bihar diwas 2025/480972446_122145562700579269_3570874758825703100_n-1.webp',
    '/images/Past Events/Bihar diwas 2025/481251909_122145562736579269_6368987077798951441_n.webp',
    '/images/Past Events/Bihar diwas 2025/481948308_122145562664579269_6897185471703647883_n.webp',
    '/images/Past Events/Bihar diwas 2025/484509510_122145562940579269_3871540392827145402_n.webp',
    '/images/Past Events/Bihar diwas 2025/485098934_122145563054579269_6950708779318055086_n.webp',
    '/images/Past Events/Bihar diwas 2025/485349656_122145563312579269_1230072193317731939_n-1024x683.webp',
    '/images/Past Events/Bihar diwas 2025/485360883_122145563282579269_1696506616041326447_n-1024x683.webp',
    '/images/Past Events/Bihar diwas 2025/485945697_122145562754579269_1721758887716690479_n-1024x683.webp',
    '/images/Past Events/Bihar diwas 2025/486043627_122145562844579269_3953385366516295797_n.webp',
    '/images/Past Events/Bihar diwas 2025/486293589_122145563036579269_6727683052670791168_n.webp',
    '/images/Past Events/Chhath puja 2025/565337688_122184944036579269_3889057590439821486_n.webp',
    '/images/Past Events/Chhath puja 2025/570390746_122184570824579269_5886365615461355314_n.webp',
    '/images/Past Events/Chhath puja 2025/571019582_122184943670579269_5869308127404202568_n.webp',
    '/images/Past Events/Chhath puja 2025/571024011_122184570812579269_262641769487931780_n.webp',
    '/images/Past Events/Chhath puja 2025/571034169_122184944090579269_8172596898758219142_n.webp',
    '/images/Past Events/Chhath puja 2025/571121290_122184943808579269_1302625555855427803_n.webp',
    '/images/Past Events/Chhath puja 2025/571132678_122184944174579269_6704691351347848981_n.webp',
    '/images/Past Events/Chhath puja 2025/571132754_122184573128579269_3109632417624441377_n.webp',
    '/images/Past Events/Chhath puja 2025/571138047_122184570770579269_9077757135380230953_n.webp',
    '/images/Past Events/Chhath puja 2025/571224129_122184944060579269_8479713664632188501_n.webp',
    '/images/Past Events/Chhath puja 2025/571319187_122184944072579269_7300221797969328314_n.webp',
    '/images/Past Events/Chhath puja 2025/571334207_122184943922579269_4865962191728973581_n.webp',
    '/images/Past Events/Chhath puja 2025/571449466_122184943712579269_8973673564717458534_n.webp',
    '/images/Past Events/Chhath puja 2025/571657189_122184944210579269_5790203645943145714_n.webp',
    '/images/Past Events/Chhath puja 2025/572361016_122184952952579269_4566659540459077237_n.webp',
    '/images/Past Events/Chhath puja 2025/573058541_122184944006579269_8084723986992163924_n.webp',
    '/images/Past Events/Chhath puja 2025/573103128_122184953006579269_5955534467866824343_n.webp',
    '/images/Past Events/Chhath puja 2025/573297385_122184943964579269_1606645933533496798_n.webp',
    '/images/Past Events/Chhath puja 2025/573334537_122184953030579269_2751290101935838458_n.webp',
    '/images/Past Events/Chhath puja 2025/573466220_122184943952579269_1467167763499224933_n.webp',
    '/images/Past Events/Chhath puja 2025/574078200_122184952604579269_545867743599380109_n.webp',
    '/images/Past Events/Chhath puja 2025/574116093_122184952832579269_7646087427729473071_n.webp',
    '/images/Past Events/India House Visit 2025/IMG_04321-1536x1152.webp',
    '/images/Past Events/India House Visit 2025/IMG_0472-1536x1152.webp',
    '/images/Past Events/India House Visit 2025/IMG_57411-1536x864.webp',
    '/images/Past Events/India House Visit 2025/IMG_57431-1536x864.webp',
    '/images/Past Events/India House Visit 2025/IMG_57481-1536x864.webp',
    '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.40_70340508.webp',
    '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.40_f2fd3ead.webp',
    '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.41_333dcddd.webp',
    '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.41_d5ea8f12.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_3b02ee98.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_6bf6eaf6.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_e6da52c0.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_f1d0ce92.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.44_bf5538e1.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.59.02_2a4415b1.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.59.28_30e49874.webp',
    '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.59.28_7251c36d.webp',
  ];

  const totalPages = Math.ceil(allImages.length / imagesPerPage);
  const startIndex = (currentPage - 1) * imagesPerPage;
  const currentImages = allImages.slice(startIndex, startIndex + imagesPerPage);

  const { isOpen, currentIndex, openLightbox, closeLightbox, goToNext, goToPrev } = useLightbox(allImages);

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
  }, [currentPage]);

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
    window.scrollTo({ top: 400, behavior: 'smooth' });
  };

  const handleImageClick = (localIndex: number) => {
    const globalIndex = startIndex + localIndex;
    openLightbox(globalIndex);
  };

  return (
    <div className="bg-background min-h-screen">
      {/* Hero Section with Background Image */}
      <section className="relative h-[30vh] md:h-[80vh] flex items-center justify-center overflow-hidden pt-14 md:pt-20">
        <div className="absolute inset-0">
          <img 
            src="/images/Banner image/kmdchh (1).png" 
            alt="Gallery" 
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
            The Archive
          </motion.span>
          
          <motion.h1 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-2xl md:text-6xl lg:text-7xl font-serif font-bold text-white mb-4 md:mb-8 leading-tight"
          >
            Visual <span className="italic font-light text-saffron">Memories.</span>
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
            A collection of moments that define our journey in the Netherlands. From grand festivals to intimate community gatherings.
          </motion.p>
        </div>
      </section>

      {/* Masonry Grid */}
      <section className="px-6 lg:px-12 max-w-7xl mx-auto py-16">
        <div className="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
          {currentImages.map((img, i) => (
            <motion.div 
              key={`${currentPage}-${i}`} 
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.05 }}
              className="relative group cursor-pointer overflow-hidden scroll-reveal break-inside-avoid rounded-2xl"
              onClick={() => handleImageClick(i)}
            >
              <img 
                src={img} 
                alt={`Gallery image ${startIndex + i + 1}`} 
                className="w-full h-auto transition-all duration-500 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-ink/0 group-hover:bg-ink/30 transition-all duration-500 flex items-center justify-center">
                <Maximize2 className="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-500" size={28} />
              </div>
            </motion.div>
          ))}
        </div>

        {/* Pagination */}
        <div className="flex items-center justify-center gap-2 mt-16">
          <button 
            onClick={() => handlePageChange(currentPage - 1)}
            disabled={currentPage === 1}
            className={`w-12 h-12 rounded-full flex items-center justify-center transition-all ${
              currentPage === 1 
                ? 'bg-slate-100 text-slate-300 cursor-not-allowed' 
                : 'bg-white text-ink hover:bg-saffron hover:text-white shadow-lg'
            }`}
          >
            <ChevronLeft size={20} />
          </button>
          
          {Array.from({ length: totalPages }, (_, i) => i + 1).map(page => (
            <button
              key={page}
              onClick={() => handlePageChange(page)}
              className={`w-12 h-12 rounded-full flex items-center justify-center font-bold text-sm transition-all ${
                currentPage === page
                  ? 'bg-saffron text-white shadow-lg'
                  : 'bg-white text-ink hover:bg-slate-100 shadow'
              }`}
            >
              {page}
            </button>
          ))}
          
          <button 
            onClick={() => handlePageChange(currentPage + 1)}
            disabled={currentPage === totalPages}
            className={`w-12 h-12 rounded-full flex items-center justify-center transition-all ${
              currentPage === totalPages 
                ? 'bg-slate-100 text-slate-300 cursor-not-allowed' 
                : 'bg-white text-ink hover:bg-saffron hover:text-white shadow-lg'
            }`}
          >
            <ChevronRight size={20} />
          </button>
        </div>

        {/* Image count info */}
        <p className="text-center text-slate-400 text-sm mt-6">
          Showing {startIndex + 1}-{Math.min(startIndex + imagesPerPage, allImages.length)} of {allImages.length} images
        </p>
      </section>

      {/* Lightbox */}
      <Lightbox
        images={allImages}
        currentIndex={currentIndex}
        isOpen={isOpen}
        onClose={closeLightbox}
        onNext={goToNext}
        onPrev={goToPrev}
      />

    </div>
  );
};

export default Gallery;
