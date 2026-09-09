import React from 'react';
import { useContent } from '../context/ContentContext';
import { Sparkles, Star, Quote, ShieldCheck } from 'lucide-react';

export default function Testimonials() {
  const { testimonials } = useContent();

  return (
    <section className="section testimonials-section" id="testimoni">
      <div className="container">
        {/* Header */}
        <div className="section-header">
          <div className="section-tag">
            <Sparkles size={14} />
            <span>Bukti & Kepercayaan</span>
          </div>
          <h2 className="section-title">
            Dipercaya Oleh Para <span className="gradient">Founders & Pemimpin Teknologi</span>
          </h2>
          <p className="section-description">
            Dengar langsung pengalaman para eksekutif dan direktur teknologi yang mempercayakan produk digital mereka kepada kami.
          </p>
        </div>

        {/* Testimonials Grid */}
        <div className="testimonials-grid">
          {testimonials.map((testi) => (
            <div key={testi.id} className="testimonial-card glass-card">
              <div className="testi-header">
                <div className="testi-stars">
                  {[...Array(testi.rating || 5)].map((_, i) => (
                    <Star key={i} size={15} className="star-filled" fill="#F59E0B" color="#F59E0B" />
                  ))}
                </div>
                <span className="testi-project-badge">{testi.projectType}</span>
              </div>

              <p className="testi-quote">"{testi.quote}"</p>

              <div className="testi-author-row">
                <img 
                  src={testi.avatar} 
                  alt={testi.author} 
                  className="testi-avatar"
                  loading="lazy"
                />
                <div className="testi-author-info">
                  <h4 className="testi-author-name">{testi.author}</h4>
                  <p className="testi-author-role">
                    {testi.role} • <strong>{testi.company}</strong>
                  </p>
                </div>
                <div className="testi-verified" title="Klien Terverifikasi">
                  <ShieldCheck size={18} className="text-emerald" />
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      <style>{`
        .testimonials-section {
          background: rgba(8, 11, 17, 0.5);
          position: relative;
        }

        .testimonials-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 24px;
        }

        .testimonial-card {
          padding: 28px;
          display: flex;
          flex-direction: column;
          background: rgba(14, 20, 32, 0.7);
          border: 1px solid rgba(255, 255, 255, 0.07);
          border-radius: var(--radius-lg);
          transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .testimonial-card:hover {
          transform: translateY(-4px);
          border-color: rgba(139, 92, 246, 0.35);
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5), 0 0 25px rgba(139, 92, 246, 0.1);
        }

        .testi-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 18px;
        }

        .testi-stars {
          display: flex;
          gap: 3px;
        }

        .testi-project-badge {
          font-size: 0.74rem;
          color: var(--accent-cyan);
          background: rgba(0, 240, 255, 0.08);
          padding: 4px 10px;
          border-radius: var(--radius-full);
          border: 1px solid rgba(0, 240, 255, 0.15);
          font-weight: 600;
        }

        .testi-quote {
          font-size: 0.95rem;
          color: var(--text-primary);
          line-height: 1.7;
          margin-bottom: 24px;
          flex-grow: 1;
        }

        .testi-author-row {
          display: flex;
          align-items: center;
          gap: 12px;
          padding-top: 16px;
          border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .testi-avatar {
          width: 44px;
          height: 44px;
          border-radius: 50%;
          object-fit: cover;
          border: 2px solid rgba(0, 240, 255, 0.3);
        }

        .testi-author-info {
          flex-grow: 1;
        }

        .testi-author-name {
          font-size: 0.95rem;
          font-weight: 700;
          color: var(--text-primary);
        }

        .testi-author-role {
          font-size: 0.78rem;
          color: var(--text-muted);
        }

        .testi-author-role strong {
          color: var(--text-secondary);
        }

        @media (max-width: 1024px) {
          .testimonials-grid {
            grid-template-columns: repeat(2, 1fr);
          }
        }

        @media (max-width: 640px) {
          .testimonials-grid {
            grid-template-columns: 1fr;
          }
        }
      `}</style>
    </section>
  );
}
