import React, { createContext, useCallback, useContext, useEffect, useMemo, useState } from 'react';
import { fetchSiteMeta } from '../lib/api';

export const SITE_DEFAULTS = {
  contactEmail: 'info@biharfoundationnl.org',
  phoneDisplay: '+31 6 1234 5678',
  phoneTel: '+31612345678',
  businessName: 'Stichting Bihar Foundation Netherlands Chapter',
} as const;

type SiteContextValue = {
  /** config('app.name') */
  appName: string;
  /** config('app.url') */
  appUrl: string;
  /** Raw whitelisted settings from API */
  settings: Record<string, string>;
  loading: boolean;
  error: string | null;
  refresh: () => Promise<void>;
  /** Merged shortcuts for UI */
  displayName: string;
  contactEmail: string;
  phoneDisplay: string;
  phoneTel: string;
  address: string | null;
};

const SiteContext = createContext<SiteContextValue | undefined>(undefined);

function digitsForTel(phone: string): string {
  const digits = phone.replace(/[^\d+]/g, '');
  if (digits.startsWith('+')) return digits;
  if (digits.startsWith('0')) return `+31${digits.slice(1)}`;
  return digits ? `+${digits}` : '';
}

export const SiteProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [appName, setAppName] = useState('');
  const [appUrl, setAppUrl] = useState('');
  const [settings, setSettings] = useState<Record<string, string>>({});
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const refresh = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const data = await fetchSiteMeta();
      setAppName(data.name ?? '');
      setAppUrl(data.url ?? '');
      setSettings(data.settings ?? {});
    } catch (e) {
      setError(e instanceof Error ? e.message : 'Could not load site info.');
      setSettings({});
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    void refresh();
  }, [refresh]);

  const value = useMemo<SiteContextValue>(() => {
    const email = settings.contact_email?.trim() || SITE_DEFAULTS.contactEmail;
    const phoneRaw = settings.phone?.trim();
    const phoneDisplay = phoneRaw || SITE_DEFAULTS.phoneDisplay;
    const phoneTel = phoneRaw ? digitsForTel(phoneRaw) : SITE_DEFAULTS.phoneTel;
    const address = settings.address?.trim() || null;
    const displayName =
      settings.business_name?.trim() ||
      settings.site_title?.trim() ||
      appName ||
      SITE_DEFAULTS.businessName;

    return {
      appName,
      appUrl,
      settings,
      loading,
      error,
      refresh,
      displayName,
      contactEmail: email,
      phoneDisplay,
      phoneTel,
      address,
    };
  }, [appName, appUrl, settings, loading, error, refresh]);

  return <SiteContext.Provider value={value}>{children}</SiteContext.Provider>;
};

export function useSite(): SiteContextValue {
  const ctx = useContext(SiteContext);
  if (!ctx) throw new Error('useSite must be used within SiteProvider');
  return ctx;
}
