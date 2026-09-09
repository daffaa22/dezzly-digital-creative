import React, { useState, useEffect } from 'react';
import { useContent } from '../context/ContentContext';
import { Sparkles, ArrowUpRight, Send, Sliders } from 'lucide-react';

export default function Footer({ onOpenCMS }) {
  const { agencyConfig } = useContent();
  const [localTime, setLocalTime] = useState('');
  const [newsletterEmail, setNewsletterEmail] = useState('');
  const [newsletterDone, setNewsletterDone] = useState(false);

  useEffect(() => {
    const updateTime = () => {
      const now = new Date();
      const timeStr = now.toLocaleTimeString('id-ID', {
        timeZone: 'Asia/Jakarta',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      setLocalTime(timeStr + ' WIB');
    };
    updateTime();
    const timer = setInterval(updateTime, 1000);
    return () => clearInterval(timer);
  }, []);

  const handleNewsletter = (e) => {
    e.preventDefault();
    if (newsletterEmail) {
      setNewsletterDone(true);
    }
  };

  return (
    <footer className="site-footer">
      <div className="container">
        {/* Top Footer Banner */}
        <div className="footer-top-row">
          <div className="footer-brand-col">
            <a href="#" className="footer-logo">
              <div className="footer-logo-icon">
                <Sparkles size={18} />
              </div>
              <div className="footer-logo-text">
                <span className="footer-name">{agencyConfig.shortName || 'DEZZLY'}</span>
                <span className="footer-sub">DIGITAL CREATIVE</span>
              </div>
            </a>
            <p className="footer-tagline-text">
              {agencyConfig.tagline}. Kami merekayasa platform digital unggul untuk memenangkan persaingan di era transformasi teknologi modern.
            </p>
            <div className="footer-timezone-box">
              <span className="pulse-dot"></span>
              <span>Jakarta, ID: <strong>{localTime || '19:00:00 WIB'}</strong></span>
            </div>
          </div>

          {/* Nav Columns */}
          <div className="footer-nav-col">
            <h4 className="footer-col-title">Navigasi</h4>
            <ul className="footer-links-list">
              {(agencyConfig.navigation || []).map((item, idx) => (
                <li key={idx}>
                  <a href={item.href} className="footer-link">{item.label}</a>
                </li>
              ))}
              <li>
                <button 
                  onClick={onOpenCMS} 
                  className="footer-link footer-cms-link"
                  style={{ background: 'transparent', border: 'none', cursor: 'pointer', padding: 0 }}
                >
                  ⚙️ CMS Admin Portal
                </button>
              </li>
            </ul>
          </div>

          <div className="footer-nav-col">
            <h4 className="footer-col-title">Sosial & Portofolio</h4>
            <ul className="footer-links-list">
              {(agencyConfig.socials || []).map((soc, idx) => (
                <li key={idx}>
                  <a 
                    href={soc.url} 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    className="footer-link footer-ext-link"
                  >
                    <span>{soc.name}</span>
                    <ArrowUpRight size={13} />
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Newsletter / Insights */}
          <div className="footer-news-col">
            <h4 className="footer-col-title">Insights & Engineering Notes</h4>
            <p className="footer-news-desc">
              Dapatkan analisis berkala seputar arsitektur cloud, tren AI, dan studi kasus UI/UX langsung ke inbox Anda dari tim {agencyConfig.name}.
            </p>

            {newsletterDone ? (
              <div className="newsletter-success-badge">
                ✓ Berhasil berlangganan insights {agencyConfig.name}!
              </div>
            ) : (
              <form onSubmit={handleNewsletter} className="newsletter-form">
                <input
                  type="email"
                  required
                  placeholder="Email kerja Anda"
                  className="newsletter-input"
                  value={newsletterEmail}
                  onChange={(e) => setNewsletterEmail(e.target.value)}
                />
                <button type="submit" className="newsletter-submit-btn" aria-label="Langganan newsletter">
                  <Send size={15} />
                </button>
              </form>
            )}
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="footer-bottom-row">
          <p className="footer-copyright">
            © {new Date().getFullYear()} {agencyConfig.name}. Hak Cipta Dilindungi Undang-Undang.
          </p>
          <div className="footer-bottom-links">
            <a href="#kebijakan" className="footer-sub-link">Kebijakan Privasi</a>
            <span>•</span>
            <a href="#syarat" className="footer-sub-link">Ketentuan Layanan</a>
            <span>•</span>
            <button 
              onClick={onOpenCMS} 
              className="footer-sub-link"
              style={{ background: 'transparent', border: 'none', cursor: 'pointer', padding: 0 }}
            >
              CMS Portal Login
            </button>
          </div>
        </div>
      </div>

      <style>{`
        .site-footer {
          background: #06080D;
          border-top: 1px solid rgba(255, 255, 255, 0.08);
          padding-top: 80px;
          padding-bottom: 40px;
          position: relative;
        }

        .footer-top-row {
          display: grid;
          grid-template-columns: 1.5fr 0.8fr 0.8fr 1.3fr;
          gap: 40px;
          margin-bottom: 60px;
        }

        .footer-logo {
          display: flex;
          align-items: center;
          gap: 12px;
          text-decoration: none;
          margin-bottom: 18px;
        }

        .footer-logo-icon {
          width: 36px;
          height: 36px;
          border-radius: 10px;
          background: linear-gradient(135deg, rgba(0, 240, 255, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
          border: 1px solid rgba(0, 240, 255, 0.3);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--accent-cyan);
        }

        .footer-name {
          font-family: var(--font-display);
          font-weight: 800;
          font-size: 1.15rem;
          color: #FFFFFF;
          letter-spacing: -0.02em;
        }

        .footer-sub {
          font-size: 0.62rem;
          font-weight: 700;
          letter-spacing: 0.15em;
          color: var(--accent-cyan);
          display: block;
        }

        .footer-tagline-text {
          font-size: 0.9rem;
          color: var(--text-secondary);
          line-height: 1.6;
          margin-bottom: 20px;
          max-width: 360px;
        }

        .footer-timezone-box {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          font-size: 0.8rem;
          color: var(--text-muted);
          padding: 6px 14px;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-full);
        }

        .footer-timezone-box strong {
          color: var(--accent-cyan);
        }

        .footer-col-title {
          font-size: 0.92rem;
          font-weight: 700;
          color: var(--text-primary);
          margin-bottom: 20px;
          text-transform: uppercase;
          letter-spacing: 0.05em;
        }

        .footer-links-list {
          list-style: none;
          display: flex;
          flex-direction: column;
          gap: 12px;
        }

        .footer-link {
          font-size: 0.9rem;
          color: var(--text-secondary);
          transition: color 0.2s;
        }

        .footer-link:hover {
          color: var(--accent-cyan);
        }

        .footer-cms-link {
          color: var(--accent-cyan) !important;
          font-weight: 600;
        }

        .footer-ext-link {
          display: inline-flex;
          align-items: center;
          gap: 4px;
        }

        .footer-news-desc {
          font-size: 0.88rem;
          color: var(--text-secondary);
          line-height: 1.6;
          margin-bottom: 16px;
        }

        .newsletter-form {
          display: flex;
          position: relative;
        }

        .newsletter-input {
          width: 100%;
          padding: 12px 48px 12px 16px;
          background: rgba(20, 28, 44, 0.8);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-full);
          color: var(--text-primary);
          font-size: 0.88rem;
          outline: none;
        }

        .newsletter-input:focus {
          border-color: var(--accent-cyan);
        }

        .newsletter-submit-btn {
          position: absolute;
          right: 4px;
          top: 4px;
          bottom: 4px;
          width: 38px;
          border-radius: 50%;
          border: none;
          background: var(--gradient-brand);
          color: #080B11;
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          transition: transform 0.2s;
        }

        .newsletter-submit-btn:hover {
          transform: scale(1.05);
        }

        .newsletter-success-badge {
          font-size: 0.82rem;
          color: #34D399;
          background: rgba(16, 185, 129, 0.1);
          border: 1px solid rgba(16, 185, 129, 0.3);
          padding: 10px 14px;
          border-radius: var(--radius-md);
        }

        .footer-bottom-row {
          padding-top: 30px;
          border-top: 1px solid rgba(255, 255, 255, 0.05);
          display: flex;
          align-items: center;
          justify-content: space-between;
          flex-wrap: wrap;
          gap: 16px;
          font-size: 0.82rem;
          color: var(--text-muted);
        }

        .footer-bottom-links {
          display: flex;
          align-items: center;
          gap: 12px;
        }

        .footer-sub-link {
          color: var(--text-muted);
          transition: color 0.2s;
        }

        .footer-sub-link:hover {
          color: var(--text-secondary);
        }

        @media (max-width: 992px) {
          .footer-top-row {
            grid-template-columns: 1fr 1fr;
            gap: 36px;
          }
        }

        @media (max-width: 600px) {
          .footer-top-row {
            grid-template-columns: 1fr;
          }
          .footer-bottom-row {
            flex-direction: column;
            align-items: flex-start;
          }
        }
      `}</style>
    </footer>
  );
}
