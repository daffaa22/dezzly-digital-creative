import React from 'react';
import { useContent } from '../context/ContentContext';
import { ArrowUpRight, Calculator, CheckCircle, ShieldCheck, Zap } from 'lucide-react';

export default function Hero() {
  const { agencyConfig } = useContent();

  return (
    <section className="hero-section" id="beranda">
      <div className="container hero-container">
        {/* Availability Badge */}
        <div className="hero-badge animate-fade-in">
          <span className="pulse-dot"></span>
          <span className="hero-badge-text">{agencyConfig.status?.text || 'Menerima Proyek Baru 2026'}</span>
          <span className="hero-badge-divider">/</span>
          <span className="hero-badge-highlight">Tersedia {agencyConfig.status?.slotsRemaining || 3} Slot Klien</span>
        </div>

        {/* Main Headline */}
        <h1 className="hero-title animate-fade-in">
          Membangun Produk Digital <br />
          <span className="gradient">Kelas Dunia</span> yang Mengakselerasi <br className="break-mobile" />
          Pertumbuhan Bisnis
        </h1>

        {/* Subtitle */}
        <p className="hero-subtitle animate-fade-in">
          {agencyConfig.subheadline}
        </p>

        {/* CTAs */}
        <div className="hero-cta-group animate-fade-in">
          <a href="#portofolio" className="btn btn-primary btn-lg">
            <span>Jelajahi Studi Kasus</span>
            <ArrowUpRight size={18} />
          </a>
          <a href="#estimasi-biaya" className="btn btn-secondary btn-lg">
            <Calculator size={18} className="text-cyan" />
            <span>Kalkulator Estimasi Biaya</span>
          </a>
        </div>

        {/* Trust Badges */}
        <div className="hero-trust-row animate-fade-in">
          <div className="trust-item">
            <ShieldCheck size={16} className="text-cyan" />
            <span>Standard ISO-27001 Security</span>
          </div>
          <div className="trust-item">
            <Zap size={16} className="text-amber" />
            <span>Sub-Second Page Performance</span>
          </div>
          <div className="trust-item">
            <CheckCircle size={16} className="text-emerald" />
            <span>90 Hari Garansi Bebas Bug</span>
          </div>
        </div>

        {/* Stats Grid */}
        <div className="hero-stats-grid">
          {agencyConfig.stats && agencyConfig.stats.map((stat, idx) => (
            <div key={idx} className="hero-stat-card glass-card">
              <div className="stat-number-wrap">
                <span className="stat-number">{stat.value}</span>
              </div>
              <div className="stat-label">{stat.label}</div>
              <div className="stat-sub">{stat.sub}</div>
            </div>
          ))}
        </div>
      </div>

      <style>{`
        .hero-section {
          padding-top: calc(var(--header-height) + 60px);
          padding-bottom: 80px;
          position: relative;
          text-align: center;
        }

        .hero-container {
          display: flex;
          flex-direction: column;
          align-items: center;
        }

        .hero-badge {
          display: inline-flex;
          align-items: center;
          gap: 10px;
          padding: 8px 20px;
          border-radius: var(--radius-full);
          background: rgba(13, 19, 31, 0.85);
          border: 1px solid rgba(0, 240, 255, 0.25);
          box-shadow: 0 0 25px rgba(0, 240, 255, 0.12);
          font-size: 0.88rem;
          font-weight: 600;
          color: var(--text-primary);
          margin-bottom: 28px;
        }

        .hero-badge-divider {
          color: var(--text-muted);
        }

        .hero-badge-highlight {
          color: var(--accent-cyan);
        }

        .hero-title {
          font-size: clamp(2.4rem, 5.5vw, 4.4rem);
          font-weight: 800;
          line-height: 1.12;
          letter-spacing: -0.03em;
          max-width: 1000px;
          margin-bottom: 24px;
        }

        .hero-title .gradient {
          background: linear-gradient(135deg, #00F0FF 0%, #A78BFA 45%, #F43F5E 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
          font-size: clamp(1.05rem, 1.8vw, 1.25rem);
          color: var(--text-secondary);
          max-width: 780px;
          line-height: 1.7;
          margin-bottom: 36px;
        }

        .hero-cta-group {
          display: flex;
          align-items: center;
          gap: 16px;
          flex-wrap: wrap;
          justify-content: center;
          margin-bottom: 36px;
        }

        .text-cyan {
          color: var(--accent-cyan);
        }

        .text-amber {
          color: var(--accent-amber);
        }

        .text-emerald {
          color: var(--accent-emerald);
        }

        .hero-trust-row {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 28px;
          flex-wrap: wrap;
          margin-bottom: 64px;
        }

        .trust-item {
          display: flex;
          align-items: center;
          gap: 8px;
          font-size: 0.85rem;
          color: var(--text-secondary);
          font-weight: 500;
        }

        .hero-stats-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 20px;
          width: 100%;
          max-width: 1120px;
        }

        .hero-stat-card {
          padding: 24px 20px;
          text-align: left;
          background: rgba(18, 24, 38, 0.5);
          border: 1px solid rgba(255, 255, 255, 0.07);
          transition: all 0.3s;
        }

        .hero-stat-card:hover {
          border-color: rgba(0, 240, 255, 0.3);
          transform: translateY(-4px);
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 240, 255, 0.1);
        }

        .stat-number {
          font-family: var(--font-display);
          font-size: 2.3rem;
          font-weight: 800;
          letter-spacing: -0.03em;
          background: linear-gradient(135deg, #FFFFFF 0%, var(--accent-cyan) 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          line-height: 1.1;
          display: block;
          margin-bottom: 6px;
        }

        .stat-label {
          font-size: 0.95rem;
          font-weight: 700;
          color: var(--text-primary);
          margin-bottom: 4px;
        }

        .stat-sub {
          font-size: 0.8rem;
          color: var(--text-muted);
        }

        @media (max-width: 992px) {
          .hero-stats-grid {
            grid-template-columns: repeat(2, 1fr);
          }
        }

        @media (max-width: 580px) {
          .hero-cta-group {
            width: 100%;
          }
          .hero-cta-group .btn {
            width: 100%;
          }
          .hero-stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
          }
          .hero-stat-card {
            padding: 16px 12px;
          }
          .stat-number {
            font-size: 1.8rem;
          }
          .stat-label {
            font-size: 0.85rem;
          }
          .stat-sub {
            font-size: 0.72rem;
          }
        }

        @media (max-width: 420px) {
          .hero-badge {
            flex-direction: column;
            gap: 4px;
            padding: 10px 16px;
            font-size: 0.8rem;
          }
          .hero-badge-divider {
            display: none;
          }
          .hero-title {
            font-size: 1.9rem;
          }
          .hero-trust-row {
            gap: 12px;
            flex-direction: column;
          }
          .hero-stats-grid {
            grid-template-columns: 1fr;
          }
        }
      `}</style>
    </section>
  );
}
