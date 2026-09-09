import React, { useState, useEffect } from 'react';
import { useContent } from '../context/ContentContext';
import { Menu, X, ArrowRight, Sparkles, Sliders } from 'lucide-react';

export default function Navbar({ onOpenCMS }) {
  const { agencyConfig } = useContent();
  const [scrolled, setScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 40);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <header className={`navbar-wrapper ${scrolled ? 'navbar-scrolled' : ''}`}>
      <div className="container navbar-inner">
        {/* Brand Logo */}
        <a href="#" className="brand-logo">
          <div className="brand-logo-icon">
            <Sparkles size={20} className="brand-icon-svg" />
          </div>
          <div className="brand-logo-text">
            <span className="brand-name">{agencyConfig.shortName || 'DEZZLY'}</span>
            <span className="brand-sub">DIGITAL CREATIVE</span>
          </div>
        </a>

        {/* Desktop Navigation Links */}
        <nav className="desktop-nav">
          {agencyConfig.navigation.map((item, index) => (
            <a key={index} href={item.href} className="nav-link">
              {item.label}
            </a>
          ))}
        </nav>

        {/* Right CTA Area */}
        <div className="navbar-actions">
          {/* Admin CMS Button */}
          <button 
            className="btn btn-secondary btn-sm cms-trigger-btn"
            onClick={onOpenCMS}
            title="Buka CMS Admin Portal"
          >
            <Sliders size={14} className="text-cyan" />
            <span>CMS Admin</span>
          </button>

          <div className="status-pill-nav">
            <span className="pulse-dot"></span>
            <span className="status-nav-text">Tersedia {agencyConfig.status?.slotsRemaining || 3} Slot</span>
          </div>

          <a href="#kontak" className="btn btn-primary btn-sm">
            <span>Mulai Proyek</span>
            <ArrowRight size={15} />
          </a>

          <button 
            className="mobile-toggle-btn"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            aria-label="Toggle navigation menu"
          >
            {mobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>
      </div>

      {/* Mobile Menu Drawer */}
      {mobileMenuOpen && (
        <div className="mobile-drawer animate-fade-in">
          <div className="mobile-drawer-inner container">
            <div className="mobile-status-pill">
              <span className="pulse-dot"></span>
              <span>{agencyConfig.status?.text || 'Menerima Proyek Baru 2026'}</span>
            </div>
            <nav className="mobile-nav-links">
              {agencyConfig.navigation.map((item, index) => (
                <a 
                  key={index} 
                  href={item.href} 
                  className="mobile-nav-link"
                  onClick={() => setMobileMenuOpen(false)}
                >
                  {item.label}
                </a>
              ))}
            </nav>
            <div className="mobile-drawer-cta">
              <button 
                className="btn btn-secondary"
                style={{ width: '100%', marginBottom: '10px' }}
                onClick={() => {
                  setMobileMenuOpen(false);
                  onOpenCMS();
                }}
              >
                <Sliders size={15} />
                <span>Buka CMS Admin Portal</span>
              </button>
              <a 
                href="#kontak" 
                className="btn btn-primary"
                style={{ width: '100%' }}
                onClick={() => setMobileMenuOpen(false)}
              >
                <span>Konsultasi Proyek Sekarang</span>
                <ArrowRight size={16} />
              </a>
            </div>
          </div>
        </div>
      )}

      <style>{`
        .navbar-wrapper {
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          z-index: 990;
          transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
          background: transparent;
        }

        .navbar-scrolled {
          background: rgba(8, 11, 17, 0.85);
          backdrop-filter: blur(20px);
          -webkit-backdrop-filter: blur(20px);
          border-bottom: 1px solid rgba(255, 255, 255, 0.08);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .navbar-inner {
          display: flex;
          align-items: center;
          justify-content: space-between;
          height: var(--header-height);
        }

        .brand-logo {
          display: flex;
          align-items: center;
          gap: 12px;
          text-decoration: none;
        }

        .brand-logo-icon {
          width: 40px;
          height: 40px;
          border-radius: 12px;
          background: linear-gradient(135deg, rgba(0, 240, 255, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
          border: 1px solid rgba(0, 240, 255, 0.4);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--accent-cyan);
          box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
        }

        .brand-logo-text {
          display: flex;
          flex-direction: column;
        }

        .brand-name {
          font-family: var(--font-display);
          font-weight: 800;
          font-size: 1.25rem;
          letter-spacing: -0.02em;
          color: #FFFFFF;
          line-height: 1.1;
        }

        .brand-sub {
          font-size: 0.65rem;
          font-weight: 700;
          letter-spacing: 0.15em;
          color: var(--accent-cyan);
        }

        .desktop-nav {
          display: flex;
          align-items: center;
          gap: 28px;
        }

        .nav-link {
          font-size: 0.92rem;
          font-weight: 500;
          color: var(--text-secondary);
          transition: color 0.2s;
          position: relative;
        }

        .nav-link:hover {
          color: var(--accent-cyan);
        }

        .navbar-actions {
          display: flex;
          align-items: center;
          gap: 12px;
        }

        .cms-trigger-btn {
          border-color: rgba(0, 240, 255, 0.35);
          background: rgba(0, 240, 255, 0.08);
          color: var(--accent-cyan);
          font-weight: 700;
        }

        .cms-trigger-btn:hover {
          background: rgba(0, 240, 255, 0.18);
          box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
        }

        .status-pill-nav {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          padding: 6px 14px;
          border-radius: 999px;
          background: rgba(16, 185, 129, 0.1);
          border: 1px solid rgba(16, 185, 129, 0.25);
          font-size: 0.78rem;
          color: #34D399;
          font-weight: 600;
        }

        .mobile-toggle-btn {
          display: none;
          background: transparent;
          border: none;
          color: var(--text-primary);
          cursor: pointer;
          padding: 6px;
        }

        .mobile-drawer {
          background: rgba(13, 19, 31, 0.98);
          backdrop-filter: blur(24px);
          border-bottom: 1px solid var(--border-subtle);
          padding: 24px 0 32px 0;
        }

        .mobile-drawer-inner {
          display: flex;
          flex-direction: column;
          gap: 20px;
        }

        .mobile-status-pill {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          padding: 8px 16px;
          border-radius: 999px;
          background: rgba(16, 185, 129, 0.12);
          border: 1px solid rgba(16, 185, 129, 0.3);
          color: #34D399;
          font-size: 0.82rem;
          font-weight: 600;
          width: fit-content;
        }

        .mobile-nav-links {
          display: flex;
          flex-direction: column;
          gap: 16px;
        }

        .mobile-nav-link {
          font-size: 1.15rem;
          font-weight: 600;
          color: var(--text-primary);
          padding: 8px 0;
          border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        @media (max-width: 1024px) {
          .desktop-nav, .status-pill-nav {
            display: none;
          }
          .mobile-toggle-btn {
            display: flex;
          }
        }

        @media (max-width: 768px) {
          .cms-trigger-btn {
            display: none;
          }
        }

        @media (max-width: 480px) {
          .navbar-actions .btn-primary {
            padding: 7px 12px;
            font-size: 0.8rem;
          }
          .brand-logo-icon {
            width: 34px;
            height: 34px;
          }
          .brand-name {
            font-size: 1.1rem;
          }
        }
      `}</style>
    </header>
  );
}
