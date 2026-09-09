import React, { useState } from 'react';
import { agencyProcess } from '../data/process';
import { Sparkles, CheckCircle2, Clock, Calendar } from 'lucide-react';

export default function ProcessTimeline() {
  const [activeStep, setActiveStep] = useState(0);

  return (
    <section className="section process-section" id="alur-kerja">
      <div className="container">
        {/* Header */}
        <div className="section-header">
          <div className="section-tag">
            <Sparkles size={14} />
            <span>Metodologi Eksekusi</span>
          </div>
          <h2 className="section-title">
            Bagaimana Kami <span className="gradient">Merealisasikan Visi</span> Anda
          </h2>
          <p className="section-description">
            Alur kerja disiplin berbasis sprint mingguan yang menjamin kualitas arsitektur software, kepatuhan timeline, dan transparansi penuh.
          </p>
        </div>

        {/* Step Selector Pills */}
        <div className="process-nav-row">
          {agencyProcess.map((item, idx) => (
            <button
              key={idx}
              className={`process-pill-btn ${activeStep === idx ? 'active' : ''}`}
              onClick={() => setActiveStep(idx)}
            >
              <span className="process-pill-step">{item.step}</span>
              <span className="process-pill-title">{item.title.split('&')[0]}</span>
            </button>
          ))}
        </div>

        {/* Active Step Feature Showcase */}
        <div className="process-stage-card glass-card">
          <div className="process-stage-inner">
            <div className="process-stage-left">
              <div className="stage-top-meta">
                <span className="stage-big-step">{agencyProcess[activeStep].step}</span>
                <div className="stage-timeline-badge">
                  <Clock size={14} className="text-cyan" />
                  <span>{agencyProcess[activeStep].timeline}</span>
                </div>
              </div>

              <h3 className="stage-title">{agencyProcess[activeStep].title}</h3>
              <p className="stage-desc">{agencyProcess[activeStep].description}</p>
            </div>

            <div className="process-stage-right">
              <h4 className="stage-activities-head">Aktivitas & Deliverables Kunci:</h4>
              <div className="stage-activities-list">
                {agencyProcess[activeStep].activities.map((act, i) => (
                  <div key={i} className="stage-activity-item">
                    <CheckCircle2 size={18} className="text-cyan flex-shrink-0" />
                    <span>{act}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* Step Progression Grid (All 5 visible on desktop) */}
        <div className="process-roadmap-grid">
          {agencyProcess.map((item, idx) => (
            <div 
              key={idx} 
              className={`roadmap-col ${activeStep === idx ? 'current' : ''}`}
              onClick={() => setActiveStep(idx)}
            >
              <div className="roadmap-indicator">
                <span className="roadmap-num">{item.step}</span>
                <span className="roadmap-line"></span>
              </div>
              <h5 className="roadmap-title">{item.title}</h5>
              <span className="roadmap-time">{item.timeline}</span>
            </div>
          ))}
        </div>
      </div>

      <style>{`
        .process-section {
          background: rgba(13, 19, 31, 0.5);
          position: relative;
        }

        .process-nav-row {
          display: flex;
          justify-content: center;
          gap: 12px;
          flex-wrap: wrap;
          margin-bottom: 32px;
        }

        .process-pill-btn {
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 10px 20px;
          border-radius: var(--radius-full);
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          color: var(--text-secondary);
          cursor: pointer;
          transition: all 0.2s;
        }

        .process-pill-btn:hover {
          color: var(--text-primary);
          border-color: rgba(255, 255, 255, 0.2);
        }

        .process-pill-btn.active {
          background: rgba(0, 240, 255, 0.12);
          border-color: var(--accent-cyan);
          color: var(--accent-cyan);
          box-shadow: 0 0 20px rgba(0, 240, 255, 0.15);
        }

        .process-pill-step {
          font-family: var(--font-display);
          font-weight: 800;
          font-size: 0.85rem;
        }

        .process-pill-title {
          font-weight: 600;
          font-size: 0.88rem;
        }

        .process-stage-card {
          padding: 40px;
          background: linear-gradient(135deg, rgba(18, 26, 42, 0.85) 0%, rgba(13, 19, 31, 0.95) 100%);
          border: 1px solid rgba(0, 240, 255, 0.25);
          margin-bottom: 48px;
        }

        .process-stage-inner {
          display: grid;
          grid-template-columns: 1.2fr 1fr;
          gap: 48px;
          align-items: center;
        }

        .stage-top-meta {
          display: flex;
          align-items: center;
          gap: 16px;
          margin-bottom: 16px;
        }

        .stage-big-step {
          font-family: var(--font-display);
          font-size: 3rem;
          font-weight: 800;
          color: rgba(0, 240, 255, 0.3);
          line-height: 1;
        }

        .stage-timeline-badge {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          padding: 6px 14px;
          background: rgba(0, 240, 255, 0.08);
          border: 1px solid rgba(0, 240, 255, 0.2);
          border-radius: var(--radius-full);
          font-size: 0.82rem;
          color: var(--accent-cyan);
          font-weight: 600;
        }

        .stage-title {
          font-size: 1.8rem;
          font-weight: 800;
          margin-bottom: 16px;
          color: var(--text-primary);
        }

        .stage-desc {
          font-size: 1.05rem;
          color: var(--text-secondary);
          line-height: 1.7;
        }

        .stage-activities-head {
          font-size: 0.95rem;
          font-weight: 700;
          text-transform: uppercase;
          letter-spacing: 0.05em;
          color: var(--text-primary);
          margin-bottom: 16px;
        }

        .stage-activities-list {
          display: flex;
          flex-direction: column;
          gap: 14px;
        }

        .stage-activity-item {
          display: flex;
          align-items: center;
          gap: 12px;
          font-size: 0.95rem;
          color: var(--text-secondary);
        }

        /* Roadmap Grid */
        .process-roadmap-grid {
          display: grid;
          grid-template-columns: repeat(5, 1fr);
          gap: 16px;
        }

        .roadmap-col {
          padding: 20px;
          background: rgba(255, 255, 255, 0.02);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-md);
          cursor: pointer;
          transition: all 0.2s;
        }

        .roadmap-col:hover {
          background: rgba(255, 255, 255, 0.05);
          border-color: rgba(255, 255, 255, 0.2);
        }

        .roadmap-col.current {
          background: rgba(0, 240, 255, 0.08);
          border-color: var(--accent-cyan);
        }

        .roadmap-indicator {
          display: flex;
          align-items: center;
          gap: 8px;
          margin-bottom: 10px;
        }

        .roadmap-num {
          font-family: var(--font-display);
          font-weight: 800;
          font-size: 1.2rem;
          color: var(--accent-cyan);
        }

        .roadmap-title {
          font-size: 0.88rem;
          font-weight: 700;
          color: var(--text-primary);
          margin-bottom: 6px;
          line-height: 1.3;
        }

        .roadmap-time {
          font-size: 0.76rem;
          color: var(--text-muted);
        }

        @media (max-width: 900px) {
          .process-stage-inner {
            grid-template-columns: 1fr;
            gap: 28px;
          }
          .process-stage-card {
            padding: 24px;
          }
          .process-roadmap-grid {
            grid-template-columns: 1fr;
          }
        }
      `}</style>
    </section>
  );
}
