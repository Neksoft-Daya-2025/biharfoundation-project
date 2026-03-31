import type { Event } from '../types';

type LegacySeed = {
  id: string;
  title: string;
  date: string;
  time: string;
  location: string;
  description: string;
  longDescription: string;
  image: string;
  price: number;
  gallery?: string[];
};

const legacyRows: LegacySeed[] = [
  {
    id: 'bihar-diwas-2026',
    title: 'Bihar Diwas 2026',
    date: '2026-03-22',
    time: '4:00 PM to 6:00 PM',
    location: 'The Gandhi Centre Embassy of India, Parkstraat 99, First Floor, The Hague, Netherlands, 2514 JH',
    description: 'Join us for Bihar Diwas 2026 - Cultural Heritage Unveiled, a vibrant celebration of Bihar\'s rich traditions, history, and cultural legacy.',
    longDescription: 'Join us for Bihar Diwas 2026 - Cultural Heritage Unveiled, a vibrant celebration of Bihar\'s rich traditions, history, and cultural legacy. Organized by Stichting Bihar Foundation Netherlands in cooperation with the Indian Embassy, this event brings the community together to experience music, culture, and heritage while honoring Bihar\'s remarkable contribution to civilization.',
    image: '/images/Bihar Diwas 2026  Event  Post.png',
    price: 0,
    gallery: [
      '/images/Bihar Diwas 2026  Event  Post.png'
    ]
  },
  {
    id: 'india-house-visit-2025',
    title: 'Stichting BFNC Netherlands Chapter Team Visits India House',
    date: '2025-12-02',
    time: 'By Invitation',
    location: 'India House, The Hague, Netherlands',
    description: 'A memorable and meaningful engagement with the Hon\'ble Indian Ambassador to the Netherlands, Mr. Kumar Tuhin, marking an important step in strengthening collaboration.',
    longDescription: 'The Stichting BFNC Netherlands Chapter team recently had the honour of visiting India House, following an invitation from the Hon\'ble Indian Ambassador to the Netherlands, Mr. Kumar Tuhin. The meeting marked an important step in strengthening collaboration between the Bihar Foundation and the Indian Embassy, fostering a shared vision for community development and cultural growth.\n\nDuring the visit, the Bihar Foundation team presented its upcoming plans for 2026, highlighting various initiatives aimed at empowering the diaspora, promoting Bihar\'s heritage, and creating impactful global partnerships. Both teams engaged in insightful discussions, exploring opportunities to work together on multiple areas of mutual interest.\n\nThe visit was made even more special by the Ambassador\'s warm hospitality, thoughtful conversations, and the delightful food served at India House. The welcoming environment added a personal touch, making the interaction not only productive but also deeply memorable.\n\nThe BFNC Netherlands Chapter looks forward to building on this meaningful engagement and exploring future collaborations with the Indian Embassy for the benefit of the community.',
    image: '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.40_70340508.webp',
    price: 0,
    gallery: [
      '/images/Past Events/India House Visit 2025/IMG_0472-1536x1152.webp',
      '/images/Past Events/India House Visit 2025/IMG_04321-1536x1152.webp',
      '/images/Past Events/India House Visit 2025/IMG_57411-1536x864.webp',
      '/images/Past Events/India House Visit 2025/IMG_57431-1536x864.webp',
      '/images/Past Events/India House Visit 2025/IMG_57481-1536x864.webp',
      '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.40_70340508.webp',
      '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.40_f2fd3ead.webp',
      '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.41_333dcddd.webp',
      '/images/Past Events/India House Visit 2025/WhatsApp-Image-2025-12-02-at-15.11.41_d5ea8f12.webp'
    ]
  },
  {
    id: 'chhath-puja-2025',
    title: 'Chhath Puja 2025 Celebrated in the Netherlands',
    date: '2025-10-25',
    time: '25th - 28th October',
    location: 'Lord Shiva Hindu Temple, Amsterdam (Hoogoorddreef 79, 1101 BB Amsterdam)',
    description: 'A divine celebration of faith, devotion, and culture dedicated to Surya Dev (the Sun God) and Chhathi Maiya.',
    longDescription: 'The Bihar Foundation Netherlands (BFN) beautifully celebrated Chhath Puja 2025 on 25th to 28th October in the Netherlands, upholding the centuries-old tradition of devotion to Surya Dev (the Sun God) and Chhathi Maiya. The main rituals and gatherings took place at the Lord Shiva Hindu Temple, Amsterdam (Hoogoorddreef 79, 1101 BB Amsterdam), where devotees from across the country joined in heartfelt reverence.\n\n**Day 1 â€“ Nahay Khay (25th October 2025)**\nThe celebration began with Nahay Khay, marking the ritual purification that opens Chhath Puja. Devotees bathed early in the morning, cleaned their homes, and prepared a simple, sattvik meal made of bottle gourd, rice, and chana dal. This act symbolizes purity and dedication, setting the spiritual tone for the coming days.\n\n**Day 2 â€“ Kharna (26th October 2025)**\nThe second day, Kharna, was observed with fasting throughout the day, followed by the evening preparation of kheer, roti, and fruits. Devotees gathered at the temple to offer prayers, share the prasad, and seek blessings. The serene environment of Amsterdam was filled with bhajans, devotion, and a sense of spiritual calm.\n\n**Day 3 â€“ Sandhya Arghya (27th October 2025)**\nOn the third day, devotees offered arghya (offering) to the setting sun. The temple premises were decorated with diyas, flowers, and rangoli, radiating divine energy. Dressed in traditional attire, men and women carried bamboo baskets filled with fruits, thekua, sugarcane, and coconuts to offer to Surya Dev.\n\n**Day 4 â€“ Usha Arghya (28th October 2025)**\nThe final day marked the most sacred ritual â€” Usha Arghya, the offering to the rising sun. Devotees arrived before dawn to perform prayers, concluding the four-day festival with gratitude and faith. As the first rays of sunlight graced the sky, chants of "Chhathi Maiya ki jai" filled the air, symbolizing hope, renewal, and peace.\n\nChhath Puja is more than a religious observance â€” it\'s a bridge connecting generations and cultures. Through this celebration, the Bihar Foundation Netherlands once again proved how traditions can flourish anywhere when carried in the hearts of devoted people.',
    image: '/images/Past Events/Chhath puja 2025/573058541_122184944006579269_8084723986992163924_n-1 (1).webp',
    price: 0,
    gallery: [
      '/images/Past Events/Chhath puja 2025/565337688_122184944036579269_3889057590439821486_n.webp',
      '/images/Past Events/Chhath puja 2025/570390746_122184570824579269_5886365615461355314_n.webp',
      '/images/Past Events/Chhath puja 2025/571019582_122184943670579269_5869308127404202568_n.webp',
      '/images/Past Events/Chhath puja 2025/571020229_17891365044360846_8730980682923673626_n.webp',
      '/images/Past Events/Chhath puja 2025/571024011_122184570812579269_262641769487931780_n.webp',
      '/images/Past Events/Chhath puja 2025/571034169_122184944090579269_8172596898758219142_n.webp',
      '/images/Past Events/Chhath puja 2025/571121290_122184943808579269_1302625555855427803_n.webp',
      '/images/Past Events/Chhath puja 2025/571132678_122184944174579269_6704691351347848981_n.webp',
      '/images/Past Events/Chhath puja 2025/571132754_122184573128579269_3109632417624441377_n.webp',
      '/images/Past Events/Chhath puja 2025/571138047_122184570770579269_9077757135380230953_n.webp',
      '/images/Past Events/Chhath puja 2025/571189414_17891365071360846_3739345181173935617_n.webp',
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
      '/images/Past Events/Chhath puja 2025/574116093_122184952832579269_7646087427729473071_n.webp'
    ]
  },
  {
    id: 'bihar-diwas-2025',
    title: 'Bihar Diwas 2025: A Grand Celebration of Culture, Community, and Progress',
    date: '2025-06-29',
    time: '12:00 PM - 6:00 PM',
    location: 'Amstelveen, Netherlands',
    description: 'The Bihar Foundation Netherlands successfully organized the grand Bhojpuri Food & Cultural Fest 2025, a spectacular showcase of Bihari culture, music, dance, and cuisine.',
    longDescription: 'The Bihar Foundation Netherlands successfully organized the grand Bhojpuri Food & Cultural Fest 2025 in Amstelveen on June 29, 2025. The event was a spectacular showcase of Bihari culture, music, dance, and cuisine, bringing together the Indian diaspora, especially the younger generation, to reconnect with their roots.\n\n**Cultural Extravaganza**\nThe festival was a colorful blend of traditional performances, lively music, and mouthwatering food, creating an atmosphere reminiscent of a "Mini India" in the heart of the Netherlands. The highlights of the event included:\n- Folk Music & Dance: Artists from Bihar, Jharkhand, and Uttar Pradesh presented mesmerizing folk songs and musical performances.\n- Ramleela & Drama: A captivating theatrical performance based on the Valmiki Ramayana enthralled the audience.\n- Jhijhiya & Samachakeva Dance: Children performed the famous Jhijhiya folk dance from Mithila and the energetic Samachakeva dance, showcasing the rich cultural heritage of Bihar.\n- Hindustani Surinamese Participation: The Surinamese-Hindustani community, originally from Bihar, actively participated, presenting traditional Bhojpuri folk music, strengthening cultural bonds.\n\n**Honoring Tradition, Inspiring the Future**\nThe chief guest of the event, Shri Kumar Tuhin, India\'s Ambassador to the Netherlands, praised the efforts of the organizers and participants. He emphasized the importance of preserving Indian culture abroad and commended the community for keeping traditions alive for future generations. Certificates were distributed to children and performers, recognizing their contributions to the festival.\n\n**A Feast for the Senses**\nThe festival also featured Indian food stalls offering a variety of traditional delicacies, from Bihari litti-chokha to sweets like thekua and khaja. The aroma of spices and the vibrant display of handicrafts made the event a true cultural immersion.\n\n**A Bridge Between Generations**\nThis festival was more than just a celebrationâ€”it was a platform for the Indian diaspora in the Netherlands to reconnect with their heritage and pass it on to the next generation. The enthusiasm of both young and old participants proved that culture knows no boundaries. The Bhojpuri Food & Cultural Fest 2025 was a resounding success, leaving everyone eagerly awaiting the next edition.',
    image: '/images/Past Events/Bihar diwas 2025/480972446_122145562700579269_3570874758825703100_n-1.webp',
    price: 0,
    gallery: [
      '/images/Past Events/Bihar diwas 2025/480972446_122145562700579269_3570874758825703100_n-1.webp',
      '/images/Past Events/Bihar diwas 2025/481251909_122145562736579269_6368987077798951441_n.webp',
      '/images/Past Events/Bihar diwas 2025/481948308_122145562664579269_6897185471703647883_n.webp',
      '/images/Past Events/Bihar diwas 2025/484509510_122145562940579269_3871540392827145402_n.webp',
      '/images/Past Events/Bihar diwas 2025/485098934_122145563054579269_6950708779318055086_n.webp',
      '/images/Past Events/Bihar diwas 2025/485349656_122145563312579269_1230072193317731939_n-1024x683.webp',
      '/images/Past Events/Bihar diwas 2025/485360883_122145563282579269_1696506616041326447_n-1024x683.webp',
      '/images/Past Events/Bihar diwas 2025/485362768_122145563366579269_2343004969871747343_n-1024x683.webp',
      '/images/Past Events/Bihar diwas 2025/485775711_122145563084579269_4648867151603466078_n.webp',
      '/images/Past Events/Bihar diwas 2025/485945697_122145562754579269_1721758887716690479_n-1024x683.webp',
      '/images/Past Events/Bihar diwas 2025/486043627_122145562844579269_3953385366516295797_n.webp',
      '/images/Past Events/Bihar diwas 2025/486293589_122145563036579269_6727683052670791168_n.webp'
    ]
  },
  {
    id: 'sankranti-2025',
    title: 'Celebrating Sankranti in the Netherlands with Bihar Foundation',
    date: '2025-01-18',
    time: 'All Day',
    location: 'Netherlands',
    description: 'A grand Sankranti celebration bringing the spirit of this traditional Indian festival to the heart of Europe, fostering cultural unity and a sense of belonging.',
    longDescription: 'On January 18, 2025, the Bihar Foundation Netherlands organized a grand Sankranti celebration, bringing the spirit of this traditional Indian festival to the heart of Europe. The event offered a unique opportunity for the Indian diaspora and the local community to come together and immerse themselves in the essence of Sankranti, with a focus on fostering cultural unity and a sense of belonging.\n\n**A Traditional Culinary Experience**\nA major highlight of the Sankranti celebration was the array of traditional foods that took center stage. Guests were treated to a delightful spread of delicacies like tilkut, dahi-chura, pitha, and litti-chokha, which are synonymous with the festival. The aromas and flavors of these dishes transported attendees straight to the heart of Bihar, creating a nostalgic experience for many. The event also featured live cooking stations, where chefs demonstrated the preparation of these iconic dishes.\n\n**The Spirit of Community**\nThe celebration was an occasion to strengthen bonds within the community. Guests participated in a traditional Dahi-Chura Samaaroh, a communal meal symbolizing the simplicity and abundance of Sankranti. Sharing food in such a warm and welcoming environment highlighted the essence of togetherness that the festival embodies.\n\n**Religious and Spiritual Observances**\nKeeping the spiritual essence of Sankranti alive, the event began with a special puja to honor Surya Dev (the Sun God), marking the transition of the sun into the Makara Rashi (Capricorn). Devotees gathered to offer prayers and perform rituals, seeking blessings for prosperity and well-being in the coming year.\n\n**Workshops and Discussions**\nThe Bihar Foundation Netherlands organized workshops and discussion forums during the event to explore the cultural and historical significance of Sankranti. Experts delved into the festival\'s importance in agrarian societies, its astronomical relevance, and its role in fostering social harmony.\n\n**A Family-Friendly Affair**\nThe event catered to people of all ages, with activities designed to engage children and adults alike. Special corners were set up for children, featuring storytelling sessions about Sankranti and its significance. Families enjoyed quality time participating in traditional games, adding an element of fun and nostalgia to the celebrations.\n\nThe Sankranti celebration in the Netherlands was a vibrant reflection of cultural pride and unity. Through food, rituals, and community spirit, the Bihar Foundation Netherlands ensured that the essence of this beloved festival resonated with everyone who attended.',
    image: '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_3b02ee98.webp',
    price: 0,
    gallery: [
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_3b02ee98.webp',
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_6bf6eaf6.webp',
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_e6da52c0.webp',
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.42_f1d0ce92.webp',
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.58.44_bf5538e1.webp',
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.59.02_2a4415b1.webp',
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.59.28_30e49874.webp',
      '/images/Past Events/Sankranti 2025/WhatsApp-Image-2025-01-20-at-02.59.28_7251c36d.webp'
    ]
  },
  {
    id: 'chhath-puja-2024',
    title: 'Chhath Puja 2024',
    date: '2024-11-07',
    time: 'All Day',
    location: 'Shiva Temple Amsterdam, Netherlands',
    description: 'Bihar Foundation Netherlands chapter celebrated Chhath Pooja at Shiva Temple Amsterdam.',
    longDescription: 'Bihar Foundation Netherlands chapter celebrated Chhath Pooja in Shiva Temple Amsterdam. This marked one of the early celebrations organized by the foundation, bringing together the Bihari community in the Netherlands to observe this sacred festival dedicated to the Sun God.',
    image: '/images/Homepage/WhatsApp-Image-2024-11-26-at-03.50.17_c2d753a6-1.webp',
    price: 0,
    gallery: []
  }
];
export const legacyEvents: Event[] = legacyRows.map((e) => ({
  ...e,
  slug: e.id,
  numericId: 0,
  isLegacy: true,
}));
