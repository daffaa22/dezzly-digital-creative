import React, { useState } from 'react';
import { useContent } from '../context/ContentContext';
import { 
  Layout, 
  Smartphone, 
  Palette, 
  Cpu, 
  Sparkles, 
  CheckCircle2, 
  ArrowUpRight, 
  ChevronDown, 
  ChevronUp 
} from 'lucide-react';

const iconMap = {
  Layout: Layout,
  Smartphone: Smartphone,
  Palette: Palette,
  Cpu: Cpu,
  Sparkles: Sparkles
};

export default function Services({ onSelectService }) {
  const { services } = useContent();
  const [expandedId, setExpandedId] = useState(services[0]?.id || null);

  const toggleExpand = (id) => {
    setExpandedId(expandedId === id ? null : id);
  };

  return (
    <section className="section services-section" id="layanan">
      <div className="container">
        {/* Header */}
        <div className="section-header">
          <div className="section-tag">
            <Sparkles size={14} />
            <span>Keahlian & Layanan</span>
          </div>
          <h2 className="section-title">
            Spektrum Layanan <span className="gradient">End-to-End</span> untuk Produk Digital
          </h2>
          <p className="section-description">
            Dari strategi produk awal, desain antarmuka mutakhir, rekayasa software berperforma tinggi, hingga implementasi kecerdasan buatan.
          </p>
        </div>

        {/* Services List / Accordion */}
        <div className="services-container">
          {services.map((service, index) => {
            const IconComponent = iconMap[service.icon] || Layout;
            const isExpanded = expandedId === service.id;

            return (
              <div 
                key={service.id}
                className={`service-card glass-card ${isExpanded ? 'service-card-expanded' : ''}`}
              >
                {/* Header Row */}
                <div 
                  className="service-card-header"
                  onClick={() => toggleExpand(service.id)}
                >
                  <div className="service-number-col">
                    <span className="service-idx">0{index + 1}</span>
                    <div className="service-icon-box">
                      <IconComponent size={24} className="service-icon" />
                    </div>
                  </div>

                  <div className="service-title-col">
                    <div className="service-tagline-text">{service.tagline}</div>
                    <h3 className="service-title-text">{service.title}</h3>
                  </div>

                  <div className="service-price-col">
                    <span className="service-price-tag">{service.startingFrom}</span>
                    <button className="service-toggle-btn" aria-label="Toggle detail layanan">
                      {isExpanded ? <ChevronUp size={20} /> : <ChevronDown size={20} />}
                    </button>
                  </div>
                </div>

                {/* Expanded Details */}
                {isExpanded && (
                  <div className="service-details-body animate-fade-in">
                    <p className="service-desc-paragraph">{service.description}</p>

                    <div className="service-two-cols">
                      {/* Deliverables */}
                      <div className="service-deliverables-box">
                        <h4 className="service-box-title">Deliverables & Output Kerja:</h4>
                        <div className="deliverables-grid">
                          {(service.deliverables || []).map((deliv, i) => (
                            <div key={i} className="service-deliv-item">
                              <CheckCircle2 size={16} className="text-cyan flex-shrink-0" />
                              <span>{deliv}</span>
                            </div>
                          ))}
                        </div>
                      </div>

                      {/* Tech & CTA */}
                      <div className="service-tech-box">
                        <h4 className="service-box-title">Teknologi & Tools Utama:</h4>
                        <div className="service-tech-tags">
                          {(service.technologies || []).map((tech, i) => (
                            <span key={i} className="badge-tech">
                              {tech}
                            </span>
                          ))}
                        </div>

                        <div className="service-action-wrap">
                          <a 
                            href="#kontak"
                            className="btn btn-glow btn-sm"
                            onClick={() => onSelectService(service.title)}
                          >
                            <span>Konsultasikan Kebutuhan Ini</span>
                            <ArrowUpRight size={15} />
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                )}
              </div>
            );
          })}
        </div>
      </div>

      <style>{`
        .services-section {
          background: rgba(13, 19, 31, 0.4);
          position: relative;
        }

        .services-container {
          display: flex;
          flex-direction: column;
          gap: 18px;
          max-width: 1040px;
          margin: 0 auto;
        }

        .service-card {
          border: 1px solid rgba(255, 255, 255, 0.08);
          background: rgba(14, 20, 32, 0.6);
          border-radius: var(--radius-lg);
          overflow: hidden;
          transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .service-card-expanded {
          border-color: rgba(0, 240, 255, 0.35);
          background: rgba(18, 26, 42, 0.85);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4), 0 0 25px rgba(0, 240, 255, 0.08);
        }

        .service-card-header {
          display: flex;
          align-items: center;
          padding: 26px 32px;
          gap: 24px;
          cursor: pointer;
          user-select: none;
        }

        .service-card-header:hover .service-title-text {
          color: var(--accent-cyan);
        }

        .service-number-col {
          display: flex;
          align-items: center;
          gap: 16px;
        }

        .service-idx {
          font-family: var(--font-display);
          font-size: 1.1rem;
          font-weight: 700;
          color: var(--text-muted);
          width: 28px;
        }

        .service-icon-box {
          width: 48px;
          height: 48px;
          border-radius: var(--radius-md);
          background: rgba(0, 240, 255, 0.08);
          border: 1px solid rgba(0, 240, 255, 0.2);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--accent-cyan);
          flex-shrink: 0;
        }

        .service-title-col {
          flex-grow: 1;
        }

        .service-tagline-text {
          font-size: 0.78rem;
          text-transform: uppercase;
          letter-spacing: 0.08em;
          color: var(--text-muted);
          margin-bottom: 4px;
          font-weight: 600;
        }

        .service-title-text {
          font-size: 1.35rem;
          font-weight: 700;
          color: var(--text-primary);
          transition: color 0.2s;
        }

        .service-price-col {
          display: flex;
          align-items: center;
          gap: 20px;
        }

        .service-price-tag {
          font-size: 0.85rem;
          font-weight: 600;
          color: var(--accent-cyan);
          background: rgba(0, 240, 255, 0.08);
          padding: 6px 14px;
          border-radius: var(--radius-full);
          border: 1px solid rgba(0, 240, 255, 0.18);
          white-space: nowrap;
        }

        .service-toggle-btn {
          background: rgba(255, 255, 255, 0.05);
          border: 1px solid var(--border-subtle);
          border-radius: 50%;
          width: 38px;
          height: 38px;
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--text-primary);
          cursor: pointer;
          transition: all 0.2s;
        }

        .service-toggle-btn:hover {
          background: rgba(0, 240, 255, 0.15);
          color: var(--accent-cyan);
          border-color: var(--accent-cyan);
        }

        .service-details-body {
          padding: 0 32px 32px 32px;
          border-top: 1px solid rgba(255, 255, 255, 0.05);
          margin-top: 4px;
          padding-top: 24px;
        }

        .service-desc-paragraph {
          font-size: 1.02rem;
          color: var(--text-secondary);
          line-height: 1.7;
          margin-bottom: 24px;
          max-width: 900px;
        }

        .service-two-cols {
          display: grid;
          grid-template-columns: 1.3fr 1fr;
          gap: 30px;
        }

        .service-box-title {
          font-size: 0.92rem;
          font-weight: 700;
          color: var(--text-primary);
          margin-bottom: 14px;
          text-transform: uppercase;
          letter-spacing: 0.04em;
        }

        .deliverables-grid {
          display: flex;
          flex-direction: column;
          gap: 10px;
        }

        .service-deliv-item {
          display: flex;
          align-items: center;
          gap: 10px;
          font-size: 0.9rem;
          color: var(--text-secondary);
        }

        .service-tech-tags {
          display: flex;
          flex-wrap: wrap;
          gap: 8px;
          margin-bottom: 24px;
        }

        .service-action-wrap {
          margin-top: 10px;
        }

        @media (max-width: 860px) {
          .service-card-header {
            padding: 20px;
            flex-wrap: wrap;
          }
          .service-details-body {
            padding: 0 20px 24px 20px;
          }
          .service-two-cols {
            grid-template-columns: 1fr;
          }
          .service-price-col {
            width: 100%;
            justify-content: space-between;
          }
        }
      `}</style>
    </section>
  );
}
