import React, { useState, useMemo } from 'react';
import { useContent } from '../context/ContentContext';
import { 
  Calculator, 
  Check, 
  MessageSquare, 
  ArrowRight, 
  Sparkles, 
  Clock, 
  ShieldCheck, 
  Layers 
} from 'lucide-react';

const PROJECT_TYPES = [
  { id: 'saas', name: 'Web App & Cloud SaaS', basePrice: 45000000, baseWeeks: 8, icon: '💻' },
  { id: 'mobile', name: 'Mobile App (iOS & Android)', basePrice: 55000000, baseWeeks: 10, icon: '📱' },
  { id: 'hybrid', name: 'Full Web + Mobile Ecosystem', basePrice: 85000000, baseWeeks: 14, icon: '🚀' },
  { id: 'ai', name: 'Enterprise AI & Automation', basePrice: 50000000, baseWeeks: 8, icon: '🧠' },
  { id: 'design', name: 'UI/UX & Design System', basePrice: 30000000, baseWeeks: 6, icon: '🎨' }
];

const SCALES = [
  { id: 'mvp', name: 'MVP / Startup', multiplier: 1.0, desc: 'Fitur esensial untuk validasi pasar & testing user' },
  { id: 'growth', name: 'Growth / Scaling', multiplier: 1.4, desc: 'Performa tinggi, optimasi konversi, analitik mendalam' },
  { id: 'enterprise', name: 'Enterprise Grade', multiplier: 2.0, desc: 'Keamanan ketat, audit ISO, failover, multi-region SLA' }
];

const ADDONS = [
  { id: 'auth', name: 'Role-Based Access (RBAC) & SSO', price: 10000000 },
  { id: 'payment', name: 'Payment Gateway Multi-Channel', price: 12000000 },
  { id: 'ai-bot', name: 'AI Copilot / Custom RAG Chatbot', price: 20000000 },
  { id: 'multilang', name: 'Multi-Language & Multi-Currency', price: 8000000 },
  { id: 'devops', name: 'High-Availability CI/CD & AWS Cloud', price: 15000000 },
  { id: 'sla', name: 'Extended 6-Bulan Garansi & VIP Support', price: 12000000 }
];

const TIMELINES = [
  { id: 'standard', name: 'Standar Optimal', multiplier: 1.0, label: 'Alur kerja terstruktur & review berkala' },
  { id: 'rush', name: 'Prioritas Cepat (Rush)', multiplier: 1.25, label: 'Alokasi tim dedikasi 2x untuk rilis cepat' }
];

export default function CostEstimator({ onExportToContact }) {
  const { agencyConfig } = useContent();

  const [selectedType, setSelectedType] = useState(PROJECT_TYPES[0]);
  const [selectedScale, setSelectedScale] = useState(SCALES[0]);
  const [selectedAddons, setSelectedAddons] = useState(['auth', 'payment']);
  const [selectedTimeline, setSelectedTimeline] = useState(TIMELINES[0]);

  const toggleAddon = (addonId) => {
    if (selectedAddons.includes(addonId)) {
      setSelectedAddons(selectedAddons.filter((id) => id !== addonId));
    } else {
      setSelectedAddons([...selectedAddons, addonId]);
    }
  };

  // Calculation Logic
  const calculation = useMemo(() => {
    const base = selectedType.basePrice * selectedScale.multiplier;
    const addonsTotal = selectedAddons.reduce((sum, id) => {
      const addon = ADDONS.find((a) => a.id === id);
      return sum + (addon ? addon.price : 0);
    }, 0);

    const subtotal = (base + addonsTotal) * selectedTimeline.multiplier;
    const minEstimate = Math.round(subtotal * 0.95);
    const maxEstimate = Math.round(subtotal * 1.15);

    let weeks = Math.round(selectedType.baseWeeks * (selectedScale.id === 'enterprise' ? 1.5 : selectedScale.id === 'growth' ? 1.2 : 1.0));
    if (selectedTimeline.id === 'rush') {
      weeks = Math.max(4, Math.round(weeks * 0.7));
    }

    return {
      min: minEstimate,
      max: maxEstimate,
      weeks: weeks,
      addonsCount: selectedAddons.length
    };
  }, [selectedType, selectedScale, selectedAddons, selectedTimeline]);

  const formatIDR = (num) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      maximumFractionDigits: 0
    }).format(num);
  };

  const handleSendWhatsApp = () => {
    const waNumber = (agencyConfig.contact?.whatsapp || '').replace(/[^0-9]/g, '');
    const text = `Halo ${agencyConfig.name || 'Dezzly Digital Creative'},%0A%0ASaya ingin konsultasi proyek dengan rincian estimasi scope berikut:%0A- Tipe Proyek: ${selectedType.name}%0A- Skala: ${selectedScale.name}%0A- Fitur Tambahan: ${selectedAddons.length} fitur%0A- Estimasi Waktu: ${calculation.weeks} Minggu%0A- Estimasi Budget: ${formatIDR(calculation.min)} - ${formatIDR(calculation.max)}%0A%0AMohon info jadwal meeting/diskusi lebih lanjut. Terima kasih!`;
    window.open(`https://wa.me/${waNumber}?text=${text}`, '_blank');
  };

  const handleApplyToContact = () => {
    if (onExportToContact) {
      onExportToContact({
        projectType: selectedType.name,
        scale: selectedScale.name,
        estimatedBudget: `${formatIDR(calculation.min)} - ${formatIDR(calculation.max)}`,
        estimatedWeeks: calculation.weeks,
        addons: selectedAddons.map(id => ADDONS.find(a => a.id === id)?.name).filter(Boolean)
      });
    }
  };

  return (
    <section className="section estimator-section" id="estimasi-biaya">
      <div className="container">
        {/* Header */}
        <div className="section-header">
          <div className="section-tag">
            <Calculator size={14} />
            <span>Transparansi & Perencanaan</span>
          </div>
          <h2 className="section-title">
            Kalkulator Interaktif <span className="gradient">Estimasi Lingkup & Budget</span>
          </h2>
          <p className="section-description">
            Hitung perkiraan biaya dan jadwal pengerjaan produk digital Anda secara transparan dalam hitungan detik.
          </p>
        </div>

        {/* Calculator Grid */}
        <div className="estimator-grid">
          {/* Controls Column */}
          <div className="estimator-controls glass-card">
            {/* 1. Project Type */}
            <div className="estimator-step">
              <label className="estimator-step-label">
                <span className="step-badge">1</span>
                Pilih Tipe Produk / Layanan
              </label>
              <div className="type-options-grid">
                {PROJECT_TYPES.map((type) => (
                  <button
                    key={type.id}
                    className={`type-option-btn ${selectedType.id === type.id ? 'active' : ''}`}
                    onClick={() => setSelectedType(type)}
                  >
                    <span className="type-icon">{type.icon}</span>
                    <span className="type-name">{type.name}</span>
                  </button>
                ))}
              </div>
            </div>

            {/* 2. Scale */}
            <div className="estimator-step">
              <label className="estimator-step-label">
                <span className="step-badge">2</span>
                Pilih Skala Proyek
              </label>
              <div className="scale-options-grid">
                {SCALES.map((scale) => (
                  <button
                    key={scale.id}
                    className={`scale-option-btn ${selectedScale.id === scale.id ? 'active' : ''}`}
                    onClick={() => setSelectedScale(scale)}
                  >
                    <div className="scale-head">
                      <span className="scale-title">{scale.name}</span>
                      {selectedScale.id === scale.id && <Check size={16} className="text-cyan" />}
                    </div>
                    <p className="scale-desc">{scale.desc}</p>
                  </button>
                ))}
              </div>
            </div>

            {/* 3. Addon Modules */}
            <div className="estimator-step">
              <label className="estimator-step-label">
                <span className="step-badge">3</span>
                Pilih Modul & Fitur Tambahan (Opsional)
              </label>
              <div className="addons-grid">
                {ADDONS.map((addon) => {
                  const isChecked = selectedAddons.includes(addon.id);
                  return (
                    <button
                      key={addon.id}
                      className={`addon-btn ${isChecked ? 'active' : ''}`}
                      onClick={() => toggleAddon(addon.id)}
                    >
                      <div className="addon-checkbox">
                        {isChecked && <Check size={14} className="checkbox-check" />}
                      </div>
                      <div className="addon-info">
                        <span className="addon-name">{addon.name}</span>
                        <span className="addon-price">+{formatIDR(addon.price)}</span>
                      </div>
                    </button>
                  );
                })}
              </div>
            </div>

            {/* 4. Timeline */}
            <div className="estimator-step">
              <label className="estimator-step-label">
                <span className="step-badge">4</span>
                Target Jadwal Peluncuran
              </label>
              <div className="timeline-options-grid">
                {TIMELINES.map((time) => (
                  <button
                    key={time.id}
                    className={`timeline-option-btn ${selectedTimeline.id === time.id ? 'active' : ''}`}
                    onClick={() => setSelectedTimeline(time)}
                  >
                    <span className="timeline-title">{time.name}</span>
                    <span className="timeline-sub">{time.label}</span>
                  </button>
                ))}
              </div>
            </div>
          </div>

          {/* Result Sticky Card */}
          <div className="estimator-summary-col">
            <div className="summary-card glass-card">
              <div className="summary-badge">
                <Sparkles size={14} className="text-cyan" />
                <span>Hasil Kalkulasi Estimasi</span>
              </div>

              <div className="summary-price-box">
                <div className="summary-price-label">Perkiraan Rentang Investasi:</div>
                <div className="summary-price-value">
                  {formatIDR(calculation.min)} - {formatIDR(calculation.max)}
                </div>
                <div className="summary-price-sub">
                  *Belum termasuk PPN. Angka final disesuaikan setelah Product Discovery Document (PRD).
                </div>
              </div>

              <div className="summary-specs-list">
                <div className="spec-row">
                  <span className="spec-icon-label">
                    <Clock size={16} className="text-amber" />
                    <span>Estimasi Durasi Pengerjaan:</span>
                  </span>
                  <strong>{calculation.weeks} Minggu Sprint</strong>
                </div>

                <div className="spec-row">
                  <span className="spec-icon-label">
                    <Layers size={16} className="text-violet" />
                    <span>Layanan & Skala:</span>
                  </span>
                  <strong>{selectedType.name} ({selectedScale.name})</strong>
                </div>

                <div className="spec-row">
                  <span className="spec-icon-label">
                    <ShieldCheck size={16} className="text-emerald" />
                    <span>Garansi & Perlindungan:</span>
                  </span>
                  <strong>90 Hari Bug-Free Warranty</strong>
                </div>
              </div>

              <div className="summary-actions">
                <button 
                  className="btn btn-primary btn-summary"
                  onClick={handleApplyToContact}
                >
                  <span>Bawa Estimasi ke Form Kontak</span>
                  <ArrowRight size={16} />
                </button>

                <button 
                  className="btn btn-secondary btn-summary"
                  onClick={handleSendWhatsApp}
                >
                  <MessageSquare size={16} className="text-emerald" />
                  <span>Kirim Rincian via WhatsApp</span>
                </button>
              </div>

              <div className="summary-guarantee-note">
                🔒 Tanpa komitmen terikat. Konsultasi discovery perdana 45 menit 100% gratis.
              </div>
            </div>
          </div>
        </div>
      </div>

      <style>{`
        .estimator-section {
          background: rgba(8, 11, 17, 0.7);
        }

        .estimator-grid {
          display: grid;
          grid-template-columns: 1.4fr 1fr;
          gap: 32px;
          align-items: start;
        }

        .estimator-controls {
          padding: 32px;
          display: flex;
          flex-direction: column;
          gap: 30px;
        }

        .estimator-step-label {
          display: flex;
          align-items: center;
          gap: 12px;
          font-size: 1.05rem;
          font-weight: 700;
          color: var(--text-primary);
          margin-bottom: 16px;
        }

        .step-badge {
          width: 28px;
          height: 28px;
          border-radius: 50%;
          background: rgba(0, 240, 255, 0.15);
          border: 1px solid var(--accent-cyan);
          color: var(--accent-cyan);
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 0.85rem;
          font-weight: 800;
        }

        .type-options-grid {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 12px;
        }

        .type-option-btn {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 14px 18px;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-md);
          color: var(--text-secondary);
          cursor: pointer;
          transition: all var(--transition-fast);
          text-align: left;
        }

        .type-option-btn:hover {
          background: rgba(255, 255, 255, 0.06);
          border-color: rgba(255, 255, 255, 0.2);
          color: var(--text-primary);
        }

        .type-option-btn.active {
          background: rgba(0, 240, 255, 0.12);
          border-color: var(--accent-cyan);
          color: var(--accent-cyan);
          box-shadow: 0 0 15px rgba(0, 240, 255, 0.15);
        }

        .type-icon {
          font-size: 1.25rem;
        }

        .type-name {
          font-weight: 600;
          font-size: 0.9rem;
        }

        .scale-options-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 12px;
        }

        .scale-option-btn {
          padding: 14px 16px;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-md);
          cursor: pointer;
          transition: all var(--transition-fast);
          text-align: left;
          color: var(--text-secondary);
          display: flex;
          flex-direction: column;
          gap: 6px;
        }

        .scale-option-btn:hover {
          background: rgba(255, 255, 255, 0.06);
          color: var(--text-primary);
        }

        .scale-option-btn.active {
          background: rgba(139, 92, 246, 0.12);
          border-color: var(--accent-violet);
          color: var(--text-primary);
          box-shadow: 0 0 15px rgba(139, 92, 246, 0.15);
        }

        .scale-head {
          display: flex;
          align-items: center;
          justify-content: space-between;
        }

        .scale-title {
          font-weight: 700;
          font-size: 0.92rem;
        }

        .scale-desc {
          font-size: 0.78rem;
          color: var(--text-muted);
          line-height: 1.4;
        }

        .addons-grid {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 10px;
        }

        .addon-btn {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 12px 14px;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-md);
          cursor: pointer;
          transition: all var(--transition-fast);
          text-align: left;
        }

        .addon-btn:hover {
          border-color: rgba(255, 255, 255, 0.2);
        }

        .addon-btn.active {
          background: rgba(0, 240, 255, 0.08);
          border-color: rgba(0, 240, 255, 0.4);
        }

        .addon-checkbox {
          width: 18px;
          height: 18px;
          border-radius: 4px;
          border: 1px solid var(--border-subtle);
          background: rgba(20, 28, 44, 0.8);
          display: flex;
          align-items: center;
          justify-content: center;
          flex-shrink: 0;
        }

        .addon-btn.active .addon-checkbox {
          background: var(--accent-cyan);
          border-color: var(--accent-cyan);
          color: #080B11;
        }

        .addon-info {
          display: flex;
          flex-direction: column;
        }

        .addon-name {
          font-size: 0.82rem;
          font-weight: 600;
          color: var(--text-primary);
        }

        .addon-price {
          font-size: 0.74rem;
          color: var(--accent-cyan);
          font-weight: 600;
        }

        .timeline-options-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 12px;
        }

        .timeline-option-btn {
          padding: 14px 16px;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-md);
          cursor: pointer;
          transition: all 0.2s;
          text-align: left;
          display: flex;
          flex-direction: column;
          gap: 4px;
        }

        .timeline-option-btn:hover {
          background: rgba(255, 255, 255, 0.06);
        }

        .timeline-option-btn.active {
          background: rgba(0, 240, 255, 0.1);
          border-color: var(--accent-cyan);
        }

        .timeline-title {
          font-size: 0.9rem;
          font-weight: 700;
          color: var(--text-primary);
        }

        .timeline-sub {
          font-size: 0.78rem;
          color: var(--text-muted);
        }

        /* Summary Sticky Column */
        .estimator-summary-col {
          position: sticky;
          top: calc(var(--header-height) + 20px);
        }

        .summary-card {
          padding: 32px;
          background: linear-gradient(165deg, rgba(18, 26, 42, 0.9) 0%, rgba(10, 14, 24, 0.95) 100%);
          border: 1px solid rgba(0, 240, 255, 0.25);
          box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(0, 240, 255, 0.1);
        }

        .summary-badge {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          font-size: 0.8rem;
          font-weight: 700;
          text-transform: uppercase;
          letter-spacing: 0.05em;
          color: var(--accent-cyan);
          margin-bottom: 20px;
        }

        .summary-price-box {
          background: rgba(0, 240, 255, 0.04);
          border: 1px solid rgba(0, 240, 255, 0.15);
          border-radius: var(--radius-md);
          padding: 20px;
          margin-bottom: 24px;
        }

        .summary-price-label {
          font-size: 0.85rem;
          color: var(--text-secondary);
          margin-bottom: 6px;
        }

        .summary-price-value {
          font-family: var(--font-display);
          font-size: clamp(1.4rem, 2vw, 1.8rem);
          font-weight: 800;
          color: var(--accent-cyan);
          line-height: 1.2;
          margin-bottom: 8px;
        }

        .summary-price-sub {
          font-size: 0.74rem;
          color: var(--text-muted);
          line-height: 1.4;
        }

        .summary-specs-list {
          display: flex;
          flex-direction: column;
          gap: 14px;
          margin-bottom: 28px;
          padding-bottom: 20px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .spec-row {
          display: flex;
          align-items: center;
          justify-content: space-between;
          font-size: 0.88rem;
          gap: 12px;
        }

        .spec-icon-label {
          display: flex;
          align-items: center;
          gap: 8px;
          color: var(--text-secondary);
        }

        .spec-row strong {
          color: var(--text-primary);
          text-align: right;
        }

        .summary-actions {
          display: flex;
          flex-direction: column;
          gap: 12px;
          margin-bottom: 20px;
        }

        .btn-summary {
          width: 100%;
        }

        .summary-guarantee-note {
          font-size: 0.76rem;
          color: var(--text-muted);
          text-align: center;
          line-height: 1.5;
        }

        @media (max-width: 980px) {
          .estimator-grid {
            grid-template-columns: 1fr;
          }
          .estimator-summary-col {
            position: relative;
            top: 0;
          }
          .type-options-grid, .scale-options-grid, .addons-grid {
            grid-template-columns: 1fr;
          }
        }
      `}</style>
    </section>
  );
}
