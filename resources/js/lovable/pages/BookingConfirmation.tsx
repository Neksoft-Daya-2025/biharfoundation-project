import React from 'react';
import { Link, useParams } from 'react-router-dom';
import { CheckCircle } from 'lucide-react';

const BookingConfirmation = () => {
  const { reference } = useParams<{ reference: string }>();

  return (
    <div className="bg-background min-h-screen pt-32 pb-24 px-6">
      <div className="max-w-xl mx-auto bg-white rounded-3xl shadow-xl p-10 text-center">
        <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <CheckCircle className="text-green-600" size={32} />
        </div>
        <h1 className="text-3xl font-serif font-bold text-ink mb-3">Booking confirmed</h1>
        <p className="text-slate-600 mb-8">
          Thank you for your booking. Please save your reference number.
        </p>
        <div className="bg-paper rounded-2xl p-6 mb-8">
          <p className="text-xs uppercase tracking-widest font-bold text-slate-400 mb-2">
            Booking reference
          </p>
          <p className="text-2xl font-mono font-bold text-saffron break-all">{reference}</p>
        </div>
        <Link
          to="/events"
          className="inline-flex items-center justify-center px-8 py-4 bg-saffron text-white font-bold uppercase tracking-widest text-sm rounded-full hover:bg-ink transition-all"
        >
          Back to events
        </Link>
      </div>
    </div>
  );
};

export default BookingConfirmation;
