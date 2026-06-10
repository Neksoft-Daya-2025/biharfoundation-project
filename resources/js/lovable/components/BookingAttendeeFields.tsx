import React from 'react';
import type { AttendeeField } from '../utils/bookingAttendees';

type BookingAttendeeFieldsProps = {
  bookerAge?: string;
  onBookerAgeChange?: (value: string) => void;
  additionalAttendees: AttendeeField[];
  onAdditionalAttendeeChange: (
    index: number,
    field: 'name' | 'age',
    value: string,
  ) => void;
  showBookerAge?: boolean;
};

const BookingAttendeeFields = ({
  bookerAge = '',
  onBookerAgeChange,
  additionalAttendees,
  onAdditionalAttendeeChange,
  showBookerAge = true,
}: BookingAttendeeFieldsProps) => {
  return (
    <>
      {showBookerAge && (
        <div>
          <label className="block text-xs font-bold text-slate-600 mb-1">
            Your age *
          </label>
          <input
            required
            type="number"
            min={1}
            className="w-full px-3 py-2 border border-slate-200 rounded-lg"
            value={bookerAge}
            onChange={(e) => onBookerAgeChange?.(e.target.value)}
          />
        </div>
      )}

      {additionalAttendees.map((attendee, index) => (
        <div
          key={index}
          className="space-y-3 border border-slate-100 rounded-lg p-4 bg-slate-50/50"
        >
          <p className="text-xs font-bold uppercase tracking-wide text-slate-500">
            Additional attendee {index + 1}
          </p>
          <div>
            <label className="block text-xs font-bold text-slate-600 mb-1">
              Name *
            </label>
            <input
              required
              className="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white"
              value={attendee.name}
              onChange={(e) =>
                onAdditionalAttendeeChange(index, 'name', e.target.value)
              }
            />
          </div>
          <div>
            <label className="block text-xs font-bold text-slate-600 mb-1">
              Age *
            </label>
            <input
              required
              type="number"
              min={1}
              className="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white"
              value={attendee.age}
              onChange={(e) =>
                onAdditionalAttendeeChange(index, 'age', e.target.value)
              }
            />
          </div>
        </div>
      ))}
    </>
  );
};

export default BookingAttendeeFields;
