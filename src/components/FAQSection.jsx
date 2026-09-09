import React, { useState } from 'react';
import { faqs } from '../data/faqs';
import { Sparkles, ChevronDown, ChevronUp, HelpCircle } from 'lucide-react';

export default function FAQSection() {
  const [activeCategoryIdx, setActiveCategoryIdx] = useState(0);
  const [openQuestionIdx, setOpenQuestionIdx] = useState(0);

  const currentCategory = faqs[activeCategoryIdx];

  const toggleQuestion = (idx) => {
    setOpenQuestionIdx(openQuestionIdx === idx ? null : idx);
  };

  return (
    <section className="section faq-section" id="faq">
      <div className="container">
        {/* Header */}
        <div className="section-header">
          <div className="section-tag">
            <HelpCircle size={14} />
            <span>Pertanyaan Umum</span>
          </div>
          <h2 className="section-title">
            Segala Hal yang Perlu Anda Ketahui <span className="gradient">Sebelum Memulai</span>
          </h2>
          <p className="section-description">
            Jawaban transparan mengenai proses kerja sama, kepemilikan kode, termin pembayaran, dan pemeliharaan sistem.
          </p>
        </div>

        {/* Category Tabs */}
        <div className="faq-category-pills">
          {faqs.map((cat, idx) => (
            <button
              key={idx}
              className={`faq-cat-btn ${activeCategoryIdx === idx ? 'active' : ''}`}
              onClick={() => {
                setActiveCategoryIdx(idx);
                setOpenQuestionIdx(0);
              }}
            >
              {cat.category}
            </button>
          ))}
        </div>

        {/* Accordion Questions */}
        <div className="faq-accordion-wrap">
          {currentCategory.questions.map((item, idx) => {
            const isOpen = openQuestionIdx === idx;
            return (
              <div 
                key={idx} 
                className={`faq-item glass-card ${isOpen ? 'open' : ''}`}
              >
                <div 
                  className="faq-question-row"
                  onClick={() => toggleQuestion(idx)}
                >
                  <h3 className="faq-question-text">{item.q}</h3>
                  <button className="faq-arrow-btn" aria-label="Toggle jawaban">
                    {isOpen ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
                  </button>
                </div>

                {isOpen && (
                  <div className="faq-answer-body animate-fade-in">
                    <p className="faq-answer-text">{item.a}</p>
                  </div>
                )}
              </div>
            );
          })}
        </div>
      </div>

      <style>{`
        .faq-section {
          background: rgba(13, 19, 31, 0.4);
          position: relative;
        }

        .faq-category-pills {
          display: flex;
          justify-content: center;
          gap: 12px;
          flex-wrap: wrap;
          margin-bottom: 36px;
        }

        .faq-cat-btn {
          padding: 10px 22px;
          border-radius: var(--radius-full);
          font-size: 0.9rem;
          font-weight: 600;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          color: var(--text-secondary);
          cursor: pointer;
          transition: all 0.2s;
        }

        .faq-cat-btn:hover {
          color: var(--text-primary);
          border-color: rgba(255, 255, 255, 0.2);
        }

        .faq-cat-btn.active {
          background: rgba(0, 240, 255, 0.12);
          border-color: var(--accent-cyan);
          color: var(--accent-cyan);
          box-shadow: 0 0 15px rgba(0, 240, 255, 0.15);
        }

        .faq-accordion-wrap {
          max-width: 820px;
          margin: 0 auto;
          display: flex;
          flex-direction: column;
          gap: 14px;
        }

        .faq-item {
          border: 1px solid rgba(255, 255, 255, 0.07);
          border-radius: var(--radius-md);
          background: rgba(18, 24, 38, 0.6);
          overflow: hidden;
          transition: all 0.25s;
        }

        .faq-item.open {
          border-color: rgba(0, 240, 255, 0.3);
          background: rgba(18, 24, 38, 0.85);
        }

        .faq-question-row {
          padding: 22px 26px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          cursor: pointer;
          user-select: none;
          gap: 16px;
        }

        .faq-question-text {
          font-size: 1.05rem;
          font-weight: 600;
          color: var(--text-primary);
          line-height: 1.4;
          transition: color 0.2s;
        }

        .faq-item.open .faq-question-text {
          color: var(--accent-cyan);
        }

        .faq-arrow-btn {
          width: 32px;
          height: 32px;
          border-radius: 50%;
          background: rgba(255, 255, 255, 0.05);
          border: 1px solid var(--border-subtle);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--text-secondary);
          cursor: pointer;
          flex-shrink: 0;
        }

        .faq-answer-body {
          padding: 0 26px 24px 26px;
          border-top: 1px solid rgba(255, 255, 255, 0.04);
          padding-top: 16px;
        }

        .faq-answer-text {
          font-size: 0.95rem;
          color: var(--text-secondary);
          line-height: 1.7;
        }

        @media (max-width: 640px) {
          .faq-cat-btn {
            padding: 8px 16px;
            font-size: 0.82rem;
          }
          .faq-question-row {
            padding: 16px 18px;
          }
          .faq-question-text {
            font-size: 0.95rem;
          }
          .faq-answer-body {
            padding: 0 18px 18px 18px;
          }
          .faq-answer-text {
            font-size: 0.88rem;
          }
        }
      `}</style>
    </section>
  );
}
