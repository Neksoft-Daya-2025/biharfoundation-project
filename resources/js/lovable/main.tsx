import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import App from './App.tsx';
import './index.css';

const rootEl = document.getElementById('root');
if (!rootEl) {
  throw new Error('Lovable theme: missing #root element');
}

const basename = rootEl.dataset.routerBasename || '/';

createRoot(rootEl).render(
  <StrictMode>
    <App basename={basename} />
  </StrictMode>,
);
