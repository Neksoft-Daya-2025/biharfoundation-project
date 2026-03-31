import React, { useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, useLocation } from 'react-router-dom';
import { CartProvider } from './context/CartContext';
import { EventsProvider } from './context/EventsContext';
import { SiteProvider } from './context/SiteContext';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import FloatingActionButton from './components/FloatingActionButton';

// Pages
import Home from './pages/Home';
import About from './pages/About';
import ExecutiveCommittee from './pages/ExecutiveCommittee';
import Events from './pages/Events';
import EventDetail from './pages/EventDetail';
import Cart from './pages/Cart';
import Membership from './pages/Membership';
import Donations from './pages/Donations';
import Blog from './pages/Blog';
import BlogDetail from './pages/BlogDetail';
import Gallery from './pages/Gallery';
import Contact from './pages/Contact';

const ScrollToTop = () => {
  const { pathname } = useLocation();
  useEffect(() => {
    window.scrollTo(0, 0);
  }, [pathname]);
  return null;
};

type AppProps = {
  basename?: string;
};

export default function App({ basename = '/' }: AppProps) {
  return (
    <SiteProvider>
      <EventsProvider>
        <CartProvider>
          <Router basename={basename}>
            <ScrollToTop />
            <div className="flex flex-col min-h-screen">
              <Navbar />
              <main className="flex-grow">
                <Routes>
                  <Route path="/" element={<Home />} />
                  <Route path="/about" element={<About />} />
                  <Route path="/about/executive-committee" element={<ExecutiveCommittee />} />
                  <Route path="/events" element={<Events />} />
                  <Route path="/events/:slug" element={<EventDetail />} />
                  <Route path="/cart" element={<Cart />} />
                  <Route path="/membership" element={<Membership />} />
                  <Route path="/donations" element={<Donations />} />
                  <Route path="/blog" element={<Blog />} />
                  <Route path="/blog/:id" element={<BlogDetail />} />
                  <Route path="/gallery" element={<Gallery />} />
                  <Route path="/contact" element={<Contact />} />
                </Routes>
              </main>
              <Footer />
              <FloatingActionButton />
            </div>
          </Router>
        </CartProvider>
      </EventsProvider>
    </SiteProvider>
  );
}
