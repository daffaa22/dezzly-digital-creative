import React, { useEffect } from 'react';
import { 
  X, 
  ArrowRight, 
  CheckCircle2, 
  Calendar, 
  Clock, 
  Building2, 
  ExternalLink, 
  TrendingUp, 
  Cpu, 
  Layers,
  Quote
} from 'lucide-react';

export default function CaseStudyModal({ project, onClose, onConsultSimilar }) {
  // Close on ESC key
  useEffect(() => {
    const handleKeyDown = (e) => {
      if (e.key === 'Escape') onClose();
    };
    window.addEventListener('keydown', handleKeyDown);
    document.body.style.overflow = 'hidden';
    return () => {
      window.removeEventListener('keydown', handleKeyDown);
      document.body.style.overflow = 'unset';
    };
  }, [onClose]);

  if (!project) return null;

  return (
    <div className="modal-backdrop" onClick={onClose}>
      <div 
        className="modal-content case-study-modal" 
        onClick={(e) => e.stopPropagation()}
      >
        {/* Close Button */}
        <button className="modal-close-btn" onClick={onClose} aria-label="Tutup modal">
          <X size={20} />
        </button>

        {/* Modal Header Banner */}
        <div className="modal-hero">
          <img 
            src={project.coverImage} 
            alt={project.title} 
            className="modal-hero-img" 
          />
          <div className="modal-hero-overlay"></div>
          <div className="modal-hero-content">
            <div className="modal-hero-badges">
              <span className="badge badge-cyan">{project.categoryLabel}</span>
              <span className="badge badge-violet">{project.heroBadge}</span>
            </div>
            <h2 className="modal-hero-title">{project.title}</h2>
            <div className="modal-meta-row">
              <div className="modal-meta-item">
                <Building2 size={15} className="text-cyan" />
                <span>{project.client}</span>
              </div>
              <div className="modal-meta-item">
                <Clock size={15} className="text-amber" />
                <span>Durasi: {project.timeline}</span>
              </div>
              <div className="modal-meta-item">
                <Calendar size={15} className="text-violet" />
                <span>Rilis: {project.year}</span>
              </div>
            </div>
          </div>
        </div>

        {/* Modal Body */}
        <div className="modal-body-content">
          {/* Key Impact Metrics Grid */}
          <div className="modal-section-card">
            <h3 className="modal-sub-title">
              <TrendingUp size={18} className="text-cyan" />
              <span>Dampak Bisnis & Metrik Kinerja</span>
            </h3>
            <div className="modal-metrics-grid">
              {project.keyMetrics.map((metric, idx) => (
                <div key={idx} className="modal-metric-box">
                  <div className="modal-metric-num">{metric.value}</div>
                  <div className="modal-metric-lbl">{metric.label}</div>
                  <div className="modal-metric-desc">{metric.description}</div>
                </div>
              ))}
            </div>
          </div>

          {/* Two-Column: Challenge vs Solution */}
          <div className="challenge-solution-grid">
            <div className="deep-box challenge-box">
              <h4 className="deep-box-title text-rose">
                <span>01</span> Tantangan Klien
              </h4>
              <p className="deep-box-text">{project.challenge}</p>
            </div>

            <div className="deep-box solution-box">
              <h4 className="deep-box-title text-cyan">
                <span>02</span> Solusi & Rekayasa Desain
              </h4>
              <p className="deep-box-text">{project.solution}</p>
            </div>
          </div>

          {/* Technical Architecture Highlights */}
          {project.architectureHighlights && (
            <div className="modal-section-card">
              <h3 className="modal-sub-title">
                <Cpu size={18} className="text-cyan" />
                <span>Sorotan Arsitektur & Rekayasa Teknis</span>
              </h3>
              <div className="architecture-grid">
                {project.architectureHighlights.map((point, idx) => (
                  <div key={idx} className="architecture-item">
                    <CheckCircle2 size={18} className="check-icon text-emerald" />
                    <span>{point}</span>
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Tech Stack & Deliverables */}
          <div className="tech-deliverables-grid">
            {/* Tech Stack */}
            <div className="deep-box">
              <h4 className="deep-box-title">
                <Layers size={16} className="text-cyan" />
                <span>Teknologi yang Digunakan</span>
              </h4>
              <div className="tech-tags-wrap">
                {project.techStack.map((tech, idx) => (
                  <span key={idx} className="badge-tech modal-tech-tag">
                    {tech}
                  </span>
                ))}
              </div>
            </div>

            {/* Deliverables */}
            <div className="deep-box">
              <h4 className="deep-box-title">
                <CheckCircle2 size={16} className="text-emerald" />
                <span>Cakupan Deliverables</span>
              </h4>
              <ul className="deliverables-list">
                {project.deliverables.map((item, idx) => (
                  <li key={idx} className="deliverable-item">
                    <span>{item}</span>
                  </li>
                ))}
              </ul>
            </div>
          </div>

          {/* Client Testimonial */}
          {project.clientReview && (
            <div className="client-quote-card">
              <Quote size={28} className="quote-icon" />
              <p className="client-quote-text">"{project.clientReview.quote}"</p>
              <div className="client-quote-author">
                <img 
                  src={project.clientReview.avatar} 
                  alt={project.clientReview.author} 
                  className="client-quote-avatar"
                />
                <div>
                  <div className="client-quote-name">{project.clientReview.author}</div>
                  <div className="client-quote-role">
                    {project.clientReview.role} • <strong>{project.clientReview.company}</strong>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* Gallery Section */}
          {project.gallery && project.gallery.length > 0 && (
            <div className="modal-gallery-section">
              <h3 className="modal-sub-title">
                <span>Dokumentasi Visual & Antarmuka</span>
              </h3>
              <div className="modal-gallery-grid">
                {project.gallery.map((imgUrl, idx) => (
                  <div key={idx} className="gallery-img-wrap">
                    <img 
                      src={imgUrl} 
                      alt={`${project.title} gallery ${idx + 1}`} 
                      className="gallery-img"
                      loading="lazy"
                    />
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Modal Bottom Call to Action */}
          <div className="modal-cta-box">
            <div className="modal-cta-text">
              <h4>Tertarik Membangun Solusi Serupa?</h4>
              <p>Konsultasikan visi produk Anda bersama tim arsitek & engineer Dezzly Digital Creative.</p>
            </div>
            <button 
              className="btn btn-primary"
              onClick={() => {
                onClose();
                onConsultSimilar(project);
              }}
            >
              <span>Konsultasi Proyek Ini</span>
              <ArrowRight size={16} />
            </button>
          </div>
        </div>
      </div>

      <style>{`
        .case-study-modal {
          max-width: 950px;
          background: #0B0F19;
          border: 1px solid rgba(0, 240, 255, 0.3);
          box-shadow: 0 25px 80px rgba(0, 0, 0, 0.9), 0 0 50px rgba(0, 240, 255, 0.12);
        }

        .modal-hero {
          position: relative;
          height: 320px;
          width: 100%;
          overflow: hidden;
          border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        }

        .modal-hero-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        .modal-hero-overlay {
          position: absolute;
          inset: 0;
          background: linear-gradient(180deg, rgba(11, 15, 25, 0.4) 0%, #0B0F19 100%);
        }

        .modal-hero-content {
          position: absolute;
          bottom: 24px;
          left: 32px;
          right: 32px;
          z-index: 2;
        }

        .modal-hero-badges {
          display: flex;
          gap: 8px;
          margin-bottom: 12px;
        }

        .modal-hero-title {
          font-size: clamp(1.4rem, 2.5vw, 2rem);
          font-weight: 800;
          line-height: 1.2;
          color: #FFFFFF;
          margin-bottom: 14px;
        }

        .modal-meta-row {
          display: flex;
          align-items: center;
          gap: 20px;
          flex-wrap: wrap;
          font-size: 0.88rem;
          color: var(--text-secondary);
        }

        .modal-meta-item {
          display: flex;
          align-items: center;
          gap: 6px;
        }

        .text-rose {
          color: #F43F5E;
        }

        .text-violet {
          color: #A78BFA;
        }

        .modal-body-content {
          padding: 32px;
          display: flex;
          flex-direction: column;
          gap: 28px;
        }

        .modal-sub-title {
          display: flex;
          align-items: center;
          gap: 10px;
          font-size: 1.15rem;
          font-weight: 700;
          margin-bottom: 18px;
          color: var(--text-primary);
        }

        .modal-section-card {
          background: rgba(18, 24, 38, 0.5);
          border: 1px solid rgba(255, 255, 255, 0.06);
          border-radius: var(--radius-lg);
          padding: 24px;
        }

        .modal-metrics-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 16px;
        }

        .modal-metric-box {
          background: rgba(0, 240, 255, 0.04);
          border: 1px solid rgba(0, 240, 255, 0.15);
          border-radius: var(--radius-md);
          padding: 16px;
          text-align: center;
        }

        .modal-metric-num {
          font-family: var(--font-display);
          font-size: 2rem;
          font-weight: 800;
          color: var(--accent-cyan);
          line-height: 1.1;
          margin-bottom: 4px;
        }

        .modal-metric-lbl {
          font-weight: 700;
          font-size: 0.9rem;
          color: var(--text-primary);
          margin-bottom: 4px;
        }

        .modal-metric-desc {
          font-size: 0.78rem;
          color: var(--text-muted);
          line-height: 1.4;
        }

        .challenge-solution-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 20px;
        }

        .deep-box {
          background: rgba(18, 24, 38, 0.5);
          border: 1px solid rgba(255, 255, 255, 0.06);
          border-radius: var(--radius-lg);
          padding: 24px;
        }

        .deep-box-title {
          font-size: 1rem;
          font-weight: 700;
          margin-bottom: 12px;
          display: flex;
          align-items: center;
          gap: 8px;
        }

        .deep-box-title span {
          font-family: var(--font-display);
        }

        .deep-box-text {
          font-size: 0.92rem;
          color: var(--text-secondary);
          line-height: 1.7;
        }

        .architecture-grid {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 14px;
        }

        .architecture-item {
          display: flex;
          align-items: flex-start;
          gap: 10px;
          font-size: 0.9rem;
          color: var(--text-secondary);
          line-height: 1.5;
        }

        .check-icon {
          flex-shrink: 0;
          margin-top: 2px;
        }

        .tech-deliverables-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 20px;
        }

        .tech-tags-wrap {
          display: flex;
          flex-wrap: wrap;
          gap: 8px;
        }

        .modal-tech-tag {
          font-size: 0.82rem;
          padding: 6px 12px;
          background: rgba(255, 255, 255, 0.05);
        }

        .deliverables-list {
          list-style: none;
          display: flex;
          flex-direction: column;
          gap: 10px;
        }

        .deliverable-item {
          position: relative;
          padding-left: 18px;
          font-size: 0.88rem;
          color: var(--text-secondary);
        }

        .deliverable-item::before {
          content: '•';
          position: absolute;
          left: 0;
          color: var(--accent-cyan);
          font-size: 1.2rem;
          line-height: 1;
        }

        .client-quote-card {
          background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(0, 240, 255, 0.05) 100%);
          border: 1px solid rgba(139, 92, 246, 0.3);
          border-radius: var(--radius-lg);
          padding: 24px;
          position: relative;
        }

        .quote-icon {
          color: var(--accent-violet);
          margin-bottom: 12px;
          opacity: 0.7;
        }

        .client-quote-text {
          font-size: 1rem;
          font-style: italic;
          color: var(--text-primary);
          line-height: 1.7;
          margin-bottom: 18px;
        }

        .client-quote-author {
          display: flex;
          align-items: center;
          gap: 12px;
        }

        .client-quote-avatar {
          width: 44px;
          height: 44px;
          border-radius: 50%;
          object-fit: cover;
          border: 2px solid var(--accent-violet);
        }

        .client-quote-name {
          font-weight: 700;
          font-size: 0.95rem;
          color: var(--text-primary);
        }

        .client-quote-role {
          font-size: 0.82rem;
          color: var(--text-muted);
        }

        .modal-gallery-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 12px;
        }

        .gallery-img-wrap {
          height: 140px;
          border-radius: var(--radius-md);
          overflow: hidden;
          background: #141C2C;
          border: 1px solid var(--border-subtle);
        }

        .gallery-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.3s;
        }

        .gallery-img:hover {
          transform: scale(1.05);
        }

        .modal-cta-box {
          background: linear-gradient(135deg, rgba(0, 240, 255, 0.12) 0%, rgba(139, 92, 246, 0.12) 100%);
          border: 1px solid rgba(0, 240, 255, 0.3);
          border-radius: var(--radius-lg);
          padding: 24px 30px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 20px;
          flex-wrap: wrap;
        }

        .modal-cta-text h4 {
          font-size: 1.15rem;
          margin-bottom: 4px;
        }

        .modal-cta-text p {
          font-size: 0.88rem;
          color: var(--text-secondary);
        }

        @media (max-width: 768px) {
          .modal-hero {
            height: 240px;
          }
          .modal-hero-content {
            left: 20px;
            right: 20px;
          }
          .modal-body-content {
            padding: 20px;
          }
          .modal-metrics-grid, 
          .challenge-solution-grid, 
          .architecture-grid, 
          .tech-deliverables-grid, 
          .modal-gallery-grid {
            grid-template-columns: 1fr;
          }
          .modal-cta-box {
            flex-direction: column;
            align-items: stretch;
          }
        }

        @media (max-width: 480px) {
          .modal-hero {
            height: 200px;
          }
          .modal-hero-title {
            font-size: 1.2rem;
          }
          .modal-hero-content {
            left: 14px;
            right: 14px;
            bottom: 14px;
          }
          .modal-body-content {
            padding: 14px;
            gap: 16px;
          }
          .modal-section-card, .deep-box {
            padding: 16px;
          }
          .modal-metric-num {
            font-size: 1.6rem;
          }
        }
      `}</style>
    </div>
  );
}
