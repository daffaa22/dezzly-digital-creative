import React, { useState, useEffect } from 'react';
import { useContent } from '../context/ContentContext';
import { 
  Sparkles, 
  Send, 
  MessageSquare, 
  Mail, 
  MapPin, 
  Clock, 
  CheckCircle2, 
  Check, 
  Phone 
} from 'lucide-react';

const SERVICE_OPTIONS = [
  "Web App & SaaS",
  "Mobile App (iOS/Android)",
  "UI/UX Product Design",
  "AI & Automation",
  "Cloud & DevOps Scaling",
  "Brand Identity"
];

const BUDGET_OPTIONS = [
  "< Rp 50 Juta",
  "Rp 50 - 100 Juta",
  "Rp 100 - 250 Juta",
  "> Rp 250 Juta"
];

export default function ContactSection({ prefillData }) {
  const { agencyConfig, addInquiry } = useContent();

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    company: '',
    services: ['Web App & SaaS'],
    budget: 'Rp 50 - 100 Juta',
    message: ''
  });

  const [submitted, setSubmitted] = useState(false);
  const [loading, setLoading] = useState(false);

  // Sync prefill from CostEstimator or CaseStudy
  useEffect(() => {
    if (prefillData) {
      setFormData((prev) => ({
        ...prev,
        services: prefillData.projectType ? [prefillData.projectType] : prev.services,
        message: prefillData.estimatedBudget
          ? `[Hasil Kalkulator Estimasi]\nTipe: ${prefillData.projectType}\nSkala: ${prefillData.scale}\nEstimasi Biaya: ${prefillData.estimatedBudget}\nEstimasi Waktu: ${prefillData.estimatedWeeks} Minggu\nFitur: ${prefillData.addons?.join(', ')}\n\nKebutuhan Tambahan:`
          : prefillData.similarProject
          ? `Halo, saya tertarik berkonsultasi mengenai solusi yang serupa dengan studi kasus: "${prefillData.similarProject}".\n\nDetail kebutuhan kami:`
          : prev.message
      }));

      // Smooth scroll to contact section
      const contactEl = document.getElementById('kontak');
      if (contactEl) {
        contactEl.scrollIntoView({ behavior: 'smooth' });
      }
    }
  }, [prefillData]);

  const toggleService = (srv) => {
    if (formData.services.includes(srv)) {
      if (formData.services.length > 1) {
        setFormData({
          ...formData,
          services: formData.services.filter((s) => s !== srv)
        });
      }
    } else {
      setFormData({
        ...formData,
        services: [...formData.services, srv]
      });
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    setLoading(true);

    // Save lead into CMS Inquiries
    addInquiry({
      name: formData.name,
      email: formData.email,
      phone: formData.phone,
      company: formData.company,
      services: formData.services,
      budget: formData.budget,
      message: formData.message
    });

    setTimeout(() => {
      setLoading(false);
      setSubmitted(true);
    }, 600);
  };

  return (
    <section className="section contact-section" id="kontak">
      <div className="container">
        {/* Header */}
        <div className="section-header">
          <div className="section-tag">
            <Sparkles size={14} />
            <span>Mulai Kerja Sama</span>
          </div>
          <h2 className="section-title">
            Siap Mewujudkan <span className="gradient">Produk Digital Luar Biasa?</span>
          </h2>
          <p className="section-description">
            Jadwalkan sesi konsultasi perdana dengan lead engineer & product strategist kami di {agencyConfig.name}. Kami akan membedah ide Anda dan memberikan masukan arsitektur teknis secara gratis.
          </p>
        </div>

        {/* Form & Info Grid */}
        <div className="contact-grid">
          {/* Left Form */}
          <div className="contact-form-col glass-card">
            {submitted ? (
              <div className="submission-success-box animate-fade-in">
                <div className="success-icon-wrap">
                  <CheckCircle2 size={48} className="text-emerald" />
                </div>
                <h3>Brief Proyek Berhasil Dikirim!</h3>
                <p>
                  Terima kasih <strong>{formData.name}</strong>. Tim product strategist {agencyConfig.name} telah menerima rincian kebutuhan Anda dan akan menghubungi Anda via WhatsApp/Email dalam kurun waktu kurang dari 2 jam kerja.
                </p>
                <div className="success-actions">
                  <button 
                    className="btn btn-secondary btn-sm"
                    onClick={() => setSubmitted(false)}
                  >
                    Kirim Brief Baru
                  </button>
                  <a 
                    href={agencyConfig.contact?.whatsappLink || `https://wa.me/${agencyConfig.contact?.whatsapp || ''}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-primary btn-sm"
                  >
                    <MessageSquare size={16} />
                    <span>Chat Cepat ke WhatsApp</span>
                  </a>
                </div>
              </div>
            ) : (
              <form onSubmit={handleSubmit} className="contact-form">
                {/* Service Pills */}
                <div className="form-group">
                  <label className="form-label">Layanan yang Anda Butuhkan:</label>
                  <div className="service-select-pills">
                    {SERVICE_OPTIONS.map((srv, idx) => {
                      const isChecked = formData.services.includes(srv);
                      return (
                        <button
                          type="button"
                          key={idx}
                          className={`service-pill-btn ${isChecked ? 'active' : ''}`}
                          onClick={() => toggleService(srv)}
                        >
                          {isChecked && <Check size={14} className="pill-check" />}
                          <span>{srv}</span>
                        </button>
                      );
                    })}
                  </div>
                </div>

                {/* Name & Email Row */}
                <div className="form-row-two">
                  <div className="form-group">
                    <label className="form-label">Nama Lengkap *</label>
                    <input
                      type="text"
                      required
                      placeholder="Contoh: Budi Pratama"
                      className="form-input"
                      value={formData.name}
                      onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">Email Perusahaan / Kerja *</label>
                    <input
                      type="email"
                      required
                      placeholder="budi@perusahaan.com"
                      className="form-input"
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    />
                  </div>
                </div>

                {/* Phone & Company Row */}
                <div className="form-row-two">
                  <div className="form-group">
                    <label className="form-label">No. WhatsApp / Telepon *</label>
                    <input
                      type="tel"
                      required
                      placeholder="+62 812-xxxx-xxxx"
                      className="form-input"
                      value={formData.phone}
                      onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">Nama Perusahaan / Startup</label>
                    <input
                      type="text"
                      placeholder="PT Digital Inovasi"
                      className="form-input"
                      value={formData.company}
                      onChange={(e) => setFormData({ ...formData, company: e.target.value })}
                    />
                  </div>
                </div>

                {/* Budget Selection */}
                <div className="form-group">
                  <label className="form-label">Alokasi Anggaran Investasi:</label>
                  <div className="budget-pills-row">
                    {BUDGET_OPTIONS.map((bg, idx) => (
                      <button
                        type="button"
                        key={idx}
                        className={`budget-pill-btn ${formData.budget === bg ? 'active' : ''}`}
                        onClick={() => setFormData({ ...formData, budget: bg })}
                      >
                        {bg}
                      </button>
                    ))}
                  </div>
                </div>

                {/* Project Details Message */}
                <div className="form-group">
                  <label className="form-label">Ceritakan Singkat Rencana Proyek Anda:</label>
                  <textarea
                    rows={4}
                    required
                    placeholder="Contoh: Kami ingin membangun platform SaaS untuk logistik dengan estimasi rilis dalam 3 bulan..."
                    className="form-textarea"
                    value={formData.message}
                    onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                  ></textarea>
                </div>

                {/* Submit Button */}
                <button 
                  type="submit" 
                  className="btn btn-primary btn-lg" 
                  disabled={loading}
                  style={{ width: '100%' }}
                >
                  {loading ? (
                    <span>Menyimpan & Mengirim Brief...</span>
                  ) : (
                    <>
                      <span>Kirim Brief & Mulai Konsultasi</span>
                      <Send size={18} />
                    </>
                  )}
                </button>
              </form>
            )}
          </div>

          {/* Right Direct Contact Info */}
          <div className="contact-info-col">
            <div className="direct-contact-card glass-card">
              <h3 className="direct-card-title">Kontak Langsung Agensi</h3>
              <p className="direct-card-desc">
                Butuh respons kilat atau ingin langsung berdiskusi dengan managing partner kami? Hubungi kami langsung melalui:
              </p>

              <div className="direct-links-list">
                <a 
                  href={agencyConfig.contact?.whatsappLink || `https://wa.me/${agencyConfig.contact?.whatsapp || ''}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="direct-link-item whatsapp-link"
                >
                  <div className="direct-icon-wrap wa-icon-wrap">
                    <MessageSquare size={20} />
                  </div>
                  <div>
                    <div className="direct-link-label">WhatsApp Resmi (Chat Cepat)</div>
                    <div className="direct-link-val">{agencyConfig.contact?.phone}</div>
                  </div>
                </a>

                <a 
                  href={`mailto:${agencyConfig.contact?.email}`}
                  className="direct-link-item"
                >
                  <div className="direct-icon-wrap">
                    <Mail size={20} className="text-cyan" />
                  </div>
                  <div>
                    <div className="direct-link-label">Email Resmi Proyek</div>
                    <div className="direct-link-val">{agencyConfig.contact?.email}</div>
                  </div>
                </a>

                <div className="direct-link-item non-clickable">
                  <div className="direct-icon-wrap">
                    <MapPin size={20} className="text-violet" />
                  </div>
                  <div>
                    <div className="direct-link-label">Studio & Kantor Operasional</div>
                    <div className="direct-link-val">{agencyConfig.contact?.address}</div>
                  </div>
                </div>

                <div className="direct-link-item non-clickable">
                  <div className="direct-icon-wrap">
                    <Clock size={20} className="text-amber" />
                  </div>
                  <div>
                    <div className="direct-link-label">Jam Operasional & Respons</div>
                    <div className="direct-link-val">{agencyConfig.contact?.workingHours}</div>
                  </div>
                </div>
              </div>

              {/* Fast Response Guarantee Box */}
              <div className="fast-response-box">
                <div className="fast-response-dot pulse-dot"></div>
                <div>
                  <strong>SLA Respons Cepat:</strong> Rata-rata balasan dalam waktu &lt; 2 jam kerja. NDA (Non-Disclosure Agreement) siap ditandatangani sebelum sesi diskusi.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <style>{`
        .contact-section {
          background: rgba(8, 11, 17, 0.8);
          position: relative;
        }

        .contact-grid {
          display: grid;
          grid-template-columns: 1.35fr 1fr;
          gap: 36px;
          align-items: start;
        }

        .contact-form-col {
          padding: 36px;
          background: rgba(14, 20, 32, 0.85);
          border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .service-select-pills {
          display: flex;
          flex-wrap: wrap;
          gap: 8px;
        }

        .service-pill-btn {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          padding: 8px 16px;
          border-radius: var(--radius-full);
          font-size: 0.85rem;
          background: rgba(255, 255, 255, 0.04);
          border: 1px solid var(--border-subtle);
          color: var(--text-secondary);
          cursor: pointer;
          transition: all var(--transition-fast);
        }

        .service-pill-btn:hover {
          color: var(--text-primary);
          border-color: rgba(255, 255, 255, 0.2);
        }

        .service-pill-btn.active {
          background: rgba(0, 240, 255, 0.12);
          border-color: var(--accent-cyan);
          color: var(--accent-cyan);
        }

        .pill-check {
          color: var(--accent-cyan);
        }

        .form-row-two {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 16px;
        }

        .budget-pills-row {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 8px;
        }

        .budget-pill-btn {
          padding: 10px 8px;
          border-radius: var(--radius-md);
          font-size: 0.82rem;
          font-weight: 600;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          color: var(--text-secondary);
          cursor: pointer;
          transition: all 0.2s;
          text-align: center;
        }

        .budget-pill-btn:hover {
          color: var(--text-primary);
          border-color: rgba(255, 255, 255, 0.2);
        }

        .budget-pill-btn.active {
          background: rgba(139, 92, 246, 0.12);
          border-color: var(--accent-violet);
          color: var(--text-primary);
        }

        .submission-success-box {
          text-align: center;
          padding: 40px 20px;
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 16px;
        }

        .submission-success-box h3 {
          font-size: 1.5rem;
          color: var(--text-primary);
        }

        .submission-success-box p {
          color: var(--text-secondary);
          max-width: 480px;
          line-height: 1.7;
          font-size: 0.95rem;
        }

        .success-actions {
          display: flex;
          gap: 12px;
          margin-top: 16px;
          flex-wrap: wrap;
          justify-content: center;
        }

        /* Direct Contact Card */
        .direct-contact-card {
          padding: 36px;
          background: linear-gradient(145deg, rgba(18, 26, 42, 0.9) 0%, rgba(13, 19, 31, 0.95) 100%);
          border: 1px solid rgba(0, 240, 255, 0.2);
        }

        .direct-card-title {
          font-size: 1.35rem;
          margin-bottom: 10px;
        }

        .direct-card-desc {
          font-size: 0.92rem;
          color: var(--text-secondary);
          line-height: 1.6;
          margin-bottom: 24px;
        }

        .direct-links-list {
          display: flex;
          flex-direction: column;
          gap: 16px;
          margin-bottom: 28px;
        }

        .direct-link-item {
          display: flex;
          align-items: center;
          gap: 14px;
          padding: 14px 18px;
          border-radius: var(--radius-md);
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid rgba(255, 255, 255, 0.06);
          transition: all 0.2s;
        }

        .direct-link-item:not(.non-clickable):hover {
          background: rgba(0, 240, 255, 0.08);
          border-color: rgba(0, 240, 255, 0.3);
          transform: translateY(-2px);
        }

        .whatsapp-link:hover {
          background: rgba(16, 185, 129, 0.1) !important;
          border-color: rgba(16, 185, 129, 0.4) !important;
        }

        .direct-icon-wrap {
          width: 40px;
          height: 40px;
          border-radius: 10px;
          background: rgba(255, 255, 255, 0.05);
          display: flex;
          align-items: center;
          justify-content: center;
          flex-shrink: 0;
        }

        .wa-icon-wrap {
          background: rgba(16, 185, 129, 0.15);
          color: #34D399;
        }

        .direct-link-label {
          font-size: 0.75rem;
          text-transform: uppercase;
          letter-spacing: 0.05em;
          color: var(--text-muted);
          margin-bottom: 2px;
        }

        .direct-link-val {
          font-size: 0.92rem;
          font-weight: 600;
          color: var(--text-primary);
        }

        .fast-response-box {
          display: flex;
          align-items: flex-start;
          gap: 12px;
          padding: 16px;
          background: rgba(0, 240, 255, 0.05);
          border: 1px solid rgba(0, 240, 255, 0.18);
          border-radius: var(--radius-md);
          font-size: 0.82rem;
          color: var(--text-secondary);
          line-height: 1.5;
        }

        .fast-response-dot {
          margin-top: 4px;
          flex-shrink: 0;
        }

        @media (max-width: 960px) {
          .contact-grid {
            grid-template-columns: 1fr;
          }
          .form-row-two {
            grid-template-columns: 1fr;
          }
          .budget-pills-row {
            grid-template-columns: repeat(2, 1fr);
          }
        }

        @media (max-width: 640px) {
          .contact-form-col, .direct-contact-card {
            padding: 22px 16px;
          }
          .service-pill-btn {
            padding: 6px 12px;
            font-size: 0.8rem;
          }
        }

        @media (max-width: 420px) {
          .budget-pills-row {
            grid-template-columns: 1fr;
          }
        }
      `}</style>
    </section>
  );
}
