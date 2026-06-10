export type AttendeeField = {
  name: string;
  age: string;
};

export function emptyAttendeeFields(count: number): AttendeeField[] {
  return Array.from({ length: Math.max(0, count) }, () => ({
    name: '',
    age: '',
  }));
}

export function buildBookingAttendees(
  bookerName: string,
  bookerAge: string,
  additionalAttendees: AttendeeField[],
  quantity: number,
): { attendees: Array<{ name: string; age: number }> } | { error: string } {
  const trimmedName = bookerName.trim();
  const bookerAgeNum = Number.parseInt(bookerAge, 10);

  if (!trimmedName) {
    return { error: 'Full name is required.' };
  }

  if (
    !bookerAge.trim() ||
    !Number.isInteger(bookerAgeNum) ||
    bookerAgeNum < 1
  ) {
    return { error: 'Your age is required and must be greater than 0.' };
  }

  if (additionalAttendees.length !== Math.max(0, quantity - 1)) {
    return { error: 'Additional attendee details are incomplete.' };
  }

  const attendees: Array<{ name: string; age: number }> = [
    { name: trimmedName, age: bookerAgeNum },
  ];

  for (let index = 0; index < additionalAttendees.length; index++) {
    const attendee = additionalAttendees[index];
    const age = Number.parseInt(attendee.age, 10);

    if (!attendee.name.trim()) {
      return { error: `Additional attendee ${index + 1} name is required.` };
    }

    if (!attendee.age.trim() || !Number.isInteger(age) || age < 1) {
      return {
        error: `Additional attendee ${index + 1} age is required and must be greater than 0.`,
      };
    }

    attendees.push({ name: attendee.name.trim(), age });
  }

  if (attendees.length !== quantity) {
    return { error: `Expected ${quantity} attendee(s).` };
  }

  return { attendees };
}
