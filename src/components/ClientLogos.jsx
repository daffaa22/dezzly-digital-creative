import React from 'react';
import { clientLogos } from '../data/testimonials';

export default function ClientLogos() {
  // Duplicate array to achieve seamless infinite scroll
  const marqueeItems = [...clientLogos, ...clientLogos, ...clientLogos];

  return (
    <div className="client-logos-section">
      <div className="container">
        <p className="client-logos-title">
          DIPERCAYA OLEH STARTUP INOVATIF & ENTERPRISE TERKEMUKA DI ASIA PASIFIK
        </p>
      </div>

      <div className="marquee-wrapper">
        <div className="marquee-track">
          {marqueeItems.map((logo, index) => (
            <div key={index} className="client-logo-item">
              <span className="client-logo-dot">✦</span>
              <span className="client-logo-name">{logo.name}</span>
              <span className="client-logo-badge">{logo.category}</span>
            </div>
          ))}
        </div>
      </div>

      <style>{`
        .client-logos-section {
          padding: 40px 0 50px 0;
          border-top: 1px solid rgba(255, 255, 255, 0.05);
          border-bottom: 1px solid rgba(255, 255, 255, 0.05);
          background: rgba(13, 19, 31, 0.3);
          overflow: hidden;
        }

        .client-logos-title {
          text-align: center;
          font-size: 0.75rem;
          font-weight: 700;
          letter-spacing: 0.15em;
          color: var(--text-muted);
          margin-bottom: 24px;
          text-transform: uppercase;
        }

        .marquee-wrapper {
          position: relative;
          width: 100%;
          overflow: hidden;
          mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
          -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }

        .marquee-track {
          display: flex;
          width: fit-content;
          gap: 40px;
          animation: marqueeScroll 28s linear infinite;
        }

        .marquee-track:hover {
          animation-play-state: paused;
        }

        .client-logo-item {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 10px 22px;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid rgba(255, 255, 255, 0.07);
          border-radius: var(--radius-full);
          white-space: nowrap;
          transition: all 0.2s;
        }

        .client-logo-item:hover {
          border-color: rgba(0, 240, 255, 0.3);
          background: rgba(0, 240, 255, 0.06);
          transform: translateY(-2px);
        }

        .client-logo-dot {
          color: var(--accent-cyan);
          font-size: 0.8rem;
        }

        .client-logo-name {
          font-family: var(--font-display);
          font-weight: 700;
          font-size: 1rem;
          color: var(--text-primary);
        }

        .client-logo-badge {
          font-size: 0.72rem;
          color: var(--text-muted);
          padding: 2px 8px;
          background: rgba(255, 255, 255, 0.05);
          border-radius: 4px;
        }
      `}</style>
    </div>
  );
}
