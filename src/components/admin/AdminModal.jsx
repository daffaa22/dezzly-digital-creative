import React, { useState } from 'react';
import { useContent } from '../../context/ContentContext';
import { 
  X, 
  Layers, 
  Plus, 
  Trash2, 
  Edit3, 
  Save, 
  Download, 
  RefreshCw, 
  ShieldCheck, 
  MessageSquare, 
  TrendingUp, 
  Sliders, 
  Star, 
  Check, 
  ExternalLink,
  Briefcase,
  Users,
  KeyRound,
  FileText
} from 'lucide-react';

export default function AdminModal({ isOpen, onClose }) {
  const {
    projects,
    services,
    agencyConfig,
    testimonials,
    inquiries,
    addProject,
    updateProject,
    deleteProject,
    updateService,
    updateAgencyConfig,
    addTestimonial,
    deleteTestimonial,
    updateInquiryStatus,
    deleteInquiry,
    resetToDefaults,
    exportDataJSON
  } = useContent();

  // Authentication State
  const [pin, setPin] = useState('');
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [pinError, setPinError] = useState(false);

  // Active Tab: 'overview' | 'projects' | 'services' | 'agency' | 'testimonials' | 'inquiries' | 'backup'
  const [activeTab, setActiveTab] = useState('overview');

  // Editing Project State
  const [editingProject, setEditingProject] = useState(null);
  const [isAddingNewProject, setIsAddingNewProject] = useState(false);

  // Agency Config Form State
  const [agencyForm, setAgencyForm] = useState(agencyConfig);

  // New Testimonial State
  const [newTesti, setNewTesti] = useState({
    author: '',
    role: '',
    company: '',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
    rating: 5,
    quote: '',
    projectType: 'Web & SaaS Platform'
  });

  if (!isOpen) return null;

  // Handle PIN Login
  const handlePinSubmit = (e) => {
    e.preventDefault();
    if (pin === 'dezzly2026' || pin === 'admin') {
      setIsAuthenticated(true);
      setPinError(false);
    } else {
      setPinError(true);
    }
  };

  // Quick One-Click Login
  const handleQuickLogin = () => {
    setIsAuthenticated(true);
  };

  // Save Project (New or Edit)
  const handleSaveProject = (e) => {
    e.preventDefault();
    if (isAddingNewProject) {
      addProject(editingProject);
    } else {
      updateProject(editingProject.id, editingProject);
    }
    setEditingProject(null);
    setIsAddingNewProject(false);
  };

  // Initialize New Project Form
  const handleStartAddProject = () => {
    setIsAddingNewProject(true);
    setEditingProject({
      id: `project-${Date.now()}`,
      slug: `project-${Date.now()}`,
      title: '',
      client: '',
      category: 'saas',
      categoryLabel: 'Web & SaaS',
      industry: 'Fintech / Enterprise',
      year: new Date().getFullYear().toString(),
      timeline: '10 Minggu',
      heroBadge: 'Studi Kasus Baru',
      summary: '',
      coverImage: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
      gallery: [
        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'
      ],
      keyMetrics: [
        { value: '+250%', label: 'Pertumbuhan Metrik', description: 'Hasil implementasi awal' },
        { value: '0.6s', label: 'Waktu Muat', description: 'Optimalisasi performa sistem' }
      ],
      challenge: '',
      solution: '',
      architectureHighlights: [
        'High-speed API Architecture',
        'Modern Responsive UI'
      ],
      techStack: ['React', 'Node.js', 'PostgreSQL', 'TailwindCSS'],
      deliverables: ['Web Application', 'Figma Design System'],
      clientReview: {
        quote: 'Hasil karya yang luar biasa memuaskan dan berkelas.',
        author: 'Klien Puas',
        role: 'Founder',
        company: 'Startup Baru',
        avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80'
      },
      links: { demo: '#' }
    });
  };

  // Save Agency Config
  const handleSaveAgencyConfig = (e) => {
    e.preventDefault();
    updateAgencyConfig(agencyForm);
    alert('Pengaturan Profil Agensi Berhasil Diperbarui!');
  };

  // Add Testimonial
  const handleAddTestimonial = (e) => {
    e.preventDefault();
    if (!newTesti.author || !newTesti.quote) return;
    addTestimonial({
      ...newTesti,
      id: `testi-${Date.now()}`
    });
    setNewTesti({
      author: '',
      role: '',
      company: '',
      avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
      rating: 5,
      quote: '',
      projectType: 'Web & SaaS Platform'
    });
    alert('Testimoni baru berhasil ditambahkan!');
  };

  return (
    <div className="modal-backdrop" onClick={onClose}>
      <div 
        className="modal-content admin-modal-container"
        onClick={(e) => e.stopPropagation()}
      >
        {/* Modal Close Button */}
        <button className="modal-close-btn" onClick={onClose} aria-label="Tutup CMS">
          <X size={20} />
        </button>

        {/* --- AUTHENTICATION SCREEN --- */}
        {!isAuthenticated ? (
          <div className="admin-auth-box">
            <div className="admin-auth-icon">
              <KeyRound size={36} className="text-cyan" />
            </div>
            <h2 className="admin-auth-title">DEZZLY CMS Admin Portal</h2>
            <p className="admin-auth-desc">
              Pusat manajemen konten, portofolio proyek, layanan, dan kotak masuk leads klien Dezzly Digital Creative.
            </p>

            <form onSubmit={handlePinSubmit} className="admin-auth-form">
              <input
                type="password"
                placeholder="Masukkan PIN Admin (default: dezzly2026)"
                value={pin}
                onChange={(e) => {
                  setPin(e.target.value);
                  setPinError(false);
                }}
                className="form-input admin-pin-input"
                autoFocus
              />
              {pinError && (
                <p className="pin-error-text">PIN salah. Silakan coba lagi atau gunakan tombol akses cepat.</p>
              )}
              <div className="auth-actions-row">
                <button type="submit" className="btn btn-primary" style={{ width: '100%' }}>
                  <span>Masuk Dashboard CMS</span>
                </button>
                <button 
                  type="button" 
                  className="btn btn-secondary btn-sm" 
                  onClick={handleQuickLogin}
                  style={{ width: '100%' }}
                >
                  <span>⚡ Masuk Cepat (Akses Pemilik)</span>
                </button>
              </div>
            </form>
          </div>
        ) : (
          /* --- MAIN CMS DASHBOARD --- */
          <div className="admin-dashboard-layout">
            {/* Sidebar / Navigation Tabs */}
            <aside className="admin-sidebar">
              <div className="admin-brand">
                <div className="admin-brand-icon">
                  <Sliders size={18} />
                </div>
                <div>
                  <div className="admin-brand-name">DEZZLY CMS</div>
                  <div className="admin-brand-sub">Content Management System</div>
                </div>
              </div>

              <nav className="admin-nav-list">
                <button 
                  className={`admin-nav-item ${activeTab === 'overview' ? 'active' : ''}`}
                  onClick={() => setActiveTab('overview')}
                >
                  <TrendingUp size={16} />
                  <span>Ringkasan Overview</span>
                </button>

                <button 
                  className={`admin-nav-item ${activeTab === 'projects' ? 'active' : ''}`}
                  onClick={() => {
                    setActiveTab('projects');
                    setEditingProject(null);
                  }}
                >
                  <Briefcase size={16} />
                  <span>Kelola Proyek ({projects.length})</span>
                </button>

                <button 
                  className={`admin-nav-item ${activeTab === 'inquiries' ? 'active' : ''}`}
                  onClick={() => setActiveTab('inquiries')}
                >
                  <MessageSquare size={16} />
                  <span>Inbox Leads ({inquiries.length})</span>
                  {inquiries.filter(i => i.status === 'Baru').length > 0 && (
                    <span className="badge-new-count">
                      {inquiries.filter(i => i.status === 'Baru').length}
                    </span>
                  )}
                </button>

                <button 
                  className={`admin-nav-item ${activeTab === 'services' ? 'active' : ''}`}
                  onClick={() => setActiveTab('services')}
                >
                  <Layers size={16} />
                  <span>Kelola Layanan ({services.length})</span>
                </button>

                <button 
                  className={`admin-nav-item ${activeTab === 'agency' ? 'active' : ''}`}
                  onClick={() => setActiveTab('agency')}
                >
                  <ShieldCheck size={16} />
                  <span>Profil & Kontak Agensi</span>
                </button>

                <button 
                  className={`admin-nav-item ${activeTab === 'testimonials' ? 'active' : ''}`}
                  onClick={() => setActiveTab('testimonials')}
                >
                  <Star size={16} />
                  <span>Testimoni Klien ({testimonials.length})</span>
                </button>

                <button 
                  className={`admin-nav-item ${activeTab === 'backup' ? 'active' : ''}`}
                  onClick={() => setActiveTab('backup')}
                >
                  <Download size={16} />
                  <span>Backup & Restore</span>
                </button>
              </nav>

              <div className="admin-sidebar-footer">
                <button 
                  className="btn btn-secondary btn-sm" 
                  onClick={() => setIsAuthenticated(false)}
                  style={{ width: '100%' }}
                >
                  <span>Kunci Sesi Admin</span>
                </button>
              </div>
            </aside>

            {/* Main Content Area */}
            <main className="admin-main-panel">
              {/* TAB 1: OVERVIEW */}
              {activeTab === 'overview' && (
                <div className="tab-pane animate-fade-in">
                  <div className="tab-header">
                    <div>
                      <h3 className="tab-title">Ringkasan Sistem Konten Agensi</h3>
                      <p className="tab-desc">Selamat datang di pusat kendali website Dezzly Digital Creative.</p>
                    </div>
                    <button className="btn btn-primary btn-sm" onClick={handleStartAddProject}>
                      <Plus size={16} />
                      <span>Tambah Proyek Baru</span>
                    </button>
                  </div>

                  {/* Stat Cards */}
                  <div className="admin-stats-row">
                    <div className="admin-stat-card">
                      <div className="admin-stat-icon text-cyan">
                        <Briefcase size={24} />
                      </div>
                      <div className="admin-stat-val">{projects.length}</div>
                      <div className="admin-stat-lbl">Proyek Portofolio Aktif</div>
                    </div>

                    <div className="admin-stat-card">
                      <div className="admin-stat-icon text-emerald">
                        <MessageSquare size={24} />
                      </div>
                      <div className="admin-stat-val">{inquiries.length}</div>
                      <div className="admin-stat-lbl">Pesan Leads Masuk</div>
                    </div>

                    <div className="admin-stat-card">
                      <div className="admin-stat-icon text-violet">
                        <Layers size={24} />
                      </div>
                      <div className="admin-stat-val">{services.length}</div>
                      <div className="admin-stat-lbl">Layanan Utama Ditawarkan</div>
                    </div>

                    <div className="admin-stat-card">
                      <div className="admin-stat-icon text-amber">
                        <Star size={24} />
                      </div>
                      <div className="admin-stat-val">{testimonials.length}</div>
                      <div className="admin-stat-lbl">Ulasan Klien Terverifikasi</div>
                    </div>
                  </div>

                  {/* Agency Status Quick Control */}
                  <div className="admin-quick-box glass-card">
                    <div className="quick-box-header">
                      <h4>Status Penerimaan Proyek Klien</h4>
                      <span className="badge badge-cyan">{agencyConfig.status.text}</span>
                    </div>
                    <p className="quick-box-desc">
                      Saat ini kuota slot proyek terbuka: <strong>{agencyConfig.status.slotsRemaining} Slot</strong>. Anda dapat mengubah teks ini secara live di tab <em>Profil & Kontak Agensi</em>.
                    </p>
                    <div className="quick-actions-bar">
                      <button 
                        className="btn btn-secondary btn-sm"
                        onClick={() => {
                          setActiveTab('projects');
                          handleStartAddProject();
                        }}
                      >
                        <Plus size={14} />
                        <span>Input Proyek Baru</span>
                      </button>
                      <button 
                        className="btn btn-secondary btn-sm"
                        onClick={() => setActiveTab('inquiries')}
                      >
                        <MessageSquare size={14} />
                        <span>Buka Kotak Masuk Leads</span>
                      </button>
                      <button 
                        className="btn btn-secondary btn-sm"
                        onClick={exportDataJSON}
                      >
                        <Download size={14} />
                        <span>Download Backup JSON</span>
                      </button>
                    </div>
                  </div>
                </div>
              )}

              {/* TAB 2: PROJECTS MANAGEMENT */}
              {activeTab === 'projects' && (
                <div className="tab-pane animate-fade-in">
                  {!editingProject ? (
                    <>
                      <div className="tab-header">
                        <div>
                          <h3 className="tab-title">Daftar Proyek & Studi Kasus ({projects.length})</h3>
                          <p className="tab-desc">Semua proyek di bawah ini langsung tampil di galeri portofolio website.</p>
                        </div>
                        <button className="btn btn-primary btn-sm" onClick={handleStartAddProject}>
                          <Plus size={16} />
                          <span>Tambah Proyek Baru</span>
                        </button>
                      </div>

                      {/* Projects Table */}
                      <div className="admin-table-container">
                        <table className="admin-table">
                          <thead>
                            <tr>
                              <th>Cover</th>
                              <th>Judul & Klien</th>
                              <th>Kategori</th>
                              <th>Tahun</th>
                              <th>Metrik Utama</th>
                              <th style={{ textAlign: 'right' }}>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            {projects.map((proj) => (
                              <tr key={proj.id}>
                                <td>
                                  <img 
                                    src={proj.coverImage} 
                                    alt={proj.title} 
                                    className="admin-table-thumb" 
                                  />
                                </td>
                                <td>
                                  <div className="table-proj-title">{proj.title}</div>
                                  <div className="table-proj-client">{proj.client}</div>
                                </td>
                                <td>
                                  <span className="badge badge-cyan">{proj.categoryLabel || proj.category}</span>
                                </td>
                                <td>{proj.year}</td>
                                <td>
                                  <span className="table-metric-highlight">
                                    {proj.keyMetrics && proj.keyMetrics[0] ? proj.keyMetrics[0].value : '-'}
                                  </span>
                                </td>
                                <td style={{ textAlign: 'right' }}>
                                  <div className="table-action-btns">
                                    <button 
                                      className="btn-icon-action btn-edit"
                                      onClick={() => {
                                        setEditingProject(proj);
                                        setIsAddingNewProject(false);
                                      }}
                                      title="Edit Proyek"
                                    >
                                      <Edit3 size={15} />
                                    </button>
                                    <button 
                                      className="btn-icon-action btn-delete"
                                      onClick={() => {
                                        if (confirm(`Apakah Anda yakin ingin menghapus proyek "${proj.title}"?`)) {
                                          deleteProject(proj.id);
                                        }
                                      }}
                                      title="Hapus Proyek"
                                    >
                                      <Trash2 size={15} />
                                    </button>
                                  </div>
                                </td>
                              </tr>
                            ))}
                          </tbody>
                        </table>
                      </div>
                    </>
                  ) : (
                    /* Project Add/Edit Form */
                    <div className="project-editor-form animate-fade-in">
                      <div className="editor-form-header">
                        <h4>{isAddingNewProject ? 'Tambah Proyek Studi Kasus Baru' : `Edit: ${editingProject.title}`}</h4>
                        <button 
                          className="btn btn-secondary btn-sm"
                          onClick={() => setEditingProject(null)}
                        >
                          Batal
                        </button>
                      </div>

                      <form onSubmit={handleSaveProject} className="project-edit-grid">
                        <div className="form-group">
                          <label className="form-label">Judul Proyek *</label>
                          <input
                            type="text"
                            required
                            className="form-input"
                            value={editingProject.title}
                            onChange={(e) => setEditingProject({ ...editingProject, title: e.target.value })}
                            placeholder="Contoh: FinFlow - Next-Gen Payment Engine"
                          />
                        </div>

                        <div className="form-group">
                          <label className="form-label">Nama Klien / Perusahaan *</label>
                          <input
                            type="text"
                            required
                            className="form-input"
                            value={editingProject.client}
                            onChange={(e) => setEditingProject({ ...editingProject, client: e.target.value })}
                            placeholder="Contoh: PT FinFlow Asia"
                          />
                        </div>

                        <div className="form-group">
                          <label className="form-label">Kategori *</label>
                          <select
                            className="form-select"
                            value={editingProject.category}
                            onChange={(e) => {
                              const cat = e.target.value;
                              const labelMap = {
                                saas: 'Web & SaaS',
                                mobile: 'Mobile Apps',
                                ai: 'AI & Otomasi',
                                design: 'Branding & UI/UX'
                              };
                              setEditingProject({ 
                                ...editingProject, 
                                category: cat,
                                categoryLabel: labelMap[cat] || cat
                              });
                            }}
                          >
                            <option value="saas">Web & SaaS</option>
                            <option value="mobile">Mobile Apps</option>
                            <option value="ai">AI & Otomasi</option>
                            <option value="design">Branding & UI/UX</option>
                          </select>
                        </div>

                        <div className="form-group">
                          <label className="form-label">Industri</label>
                          <input
                            type="text"
                            className="form-input"
                            value={editingProject.industry}
                            onChange={(e) => setEditingProject({ ...editingProject, industry: e.target.value })}
                            placeholder="Contoh: Fintech / Digital Banking"
                          />
                        </div>

                        <div className="form-group">
                          <label className="form-label">Tahun Rilis</label>
                          <input
                            type="text"
                            className="form-input"
                            value={editingProject.year}
                            onChange={(e) => setEditingProject({ ...editingProject, year: e.target.value })}
                          />
                        </div>

                        <div className="form-group">
                          <label className="form-label">Durasi Pengerjaan</label>
                          <input
                            type="text"
                            className="form-input"
                            value={editingProject.timeline}
                            onChange={(e) => setEditingProject({ ...editingProject, timeline: e.target.value })}
                            placeholder="Contoh: 12 Minggu"
                          />
                        </div>

                        <div className="form-group span-full">
                          <label className="form-label">URL Gambar Cover Proyek *</label>
                          <input
                            type="text"
                            required
                            className="form-input"
                            value={editingProject.coverImage}
                            onChange={(e) => setEditingProject({ ...editingProject, coverImage: e.target.value })}
                            placeholder="https://images.unsplash.com/..."
                          />
                        </div>

                        <div className="form-group span-full">
                          <label className="form-label">Ringkasan Singkat (Summary) *</label>
                          <textarea
                            rows={3}
                            required
                            className="form-textarea"
                            value={editingProject.summary}
                            onChange={(e) => setEditingProject({ ...editingProject, summary: e.target.value })}
                            placeholder="Deskripsikan produk dan dampak utamanya dalam 2-3 kalimat..."
                          ></textarea>
                        </div>

                        <div className="form-group span-full">
                          <label className="form-label">Tantangan Klien (The Challenge)</label>
                          <textarea
                            rows={3}
                            className="form-textarea"
                            value={editingProject.challenge}
                            onChange={(e) => setEditingProject({ ...editingProject, challenge: e.target.value })}
                            placeholder="Kendala apa yang dihadapi klien sebelumnya..."
                          ></textarea>
                        </div>

                        <div className="form-group span-full">
                          <label className="form-label">Solusi & Rekayasa Arsitektur (The Solution)</label>
                          <textarea
                            rows={3}
                            className="form-textarea"
                            value={editingProject.solution}
                            onChange={(e) => setEditingProject({ ...editingProject, solution: e.target.value })}
                            placeholder="Solusi desain, teknologi, dan arsitektur yang Anda bangun..."
                          ></textarea>
                        </div>

                        <div className="form-group span-full">
                          <label className="form-label">Tech Stack (Pisahkan dengan koma)</label>
                          <input
                            type="text"
                            className="form-input"
                            value={Array.isArray(editingProject.techStack) ? editingProject.techStack.join(', ') : editingProject.techStack}
                            onChange={(e) => setEditingProject({
                              ...editingProject,
                              techStack: e.target.value.split(',').map(s => s.trim()).filter(Boolean)
                            })}
                            placeholder="React, TypeScript, Node.js, AWS, PostgreSQL"
                          />
                        </div>

                        <div className="editor-form-actions span-full">
                          <button type="button" className="btn btn-secondary" onClick={() => setEditingProject(null)}>
                            Batal
                          </button>
                          <button type="submit" className="btn btn-primary">
                            <Save size={16} />
                            <span>Simpan Perubahan Proyek</span>
                          </button>
                        </div>
                      </form>
                    </div>
                  )}
                </div>
              )}

              {/* TAB 3: INQUIRIES / LEADS INBOX */}
              {activeTab === 'inquiries' && (
                <div className="tab-pane animate-fade-in">
                  <div className="tab-header">
                    <div>
                      <h3 className="tab-title">Kotak Masuk Leads & Konsultasi ({inquiries.length})</h3>
                      <p className="tab-desc">Pesan dan rincian estimasi biaya yang dikirimkan oleh calon klien di website.</p>
                    </div>
                  </div>

                  {inquiries.length > 0 ? (
                    <div className="inquiries-list">
                      {inquiries.map((inq) => (
                        <div key={inq.id} className="inquiry-card glass-card">
                          <div className="inquiry-header-row">
                            <div className="inquiry-client-info">
                              <h4 className="inquiry-name">{inq.name}</h4>
                              <span className="inquiry-company">{inq.company || 'Perorangan / Startup'}</span>
                              <span className="inquiry-date">• {inq.date}</span>
                            </div>

                            <div className="inquiry-status-row">
                              <select
                                className="form-select status-select"
                                value={inq.status}
                                onChange={(e) => updateInquiryStatus(inq.id, e.target.value)}
                              >
                                <option value="Baru">🟢 Baru</option>
                                <option value="Dihubungi">🟡 Dihubungi</option>
                                <option value="Deal">🟣 Deal / Klien</option>
                                <option value="Arsip">⚪ Arsip</option>
                              </select>

                              <button 
                                className="btn-icon-action btn-delete"
                                onClick={() => {
                                  if (confirm(`Hapus pesan lead dari ${inq.name}?`)) {
                                    deleteInquiry(inq.id);
                                  }
                                }}
                                title="Hapus Lead"
                              >
                                <Trash2 size={15} />
                              </button>
                            </div>
                          </div>

                          <div className="inquiry-meta-grid">
                            <div className="inquiry-meta-item">
                              <span className="meta-lbl">Email:</span>
                              <a href={`mailto:${inq.email}`} className="text-cyan">{inq.email}</a>
                            </div>
                            <div className="inquiry-meta-item">
                              <span className="meta-lbl">WhatsApp:</span>
                              <a 
                                href={`https://wa.me/${(inq.phone || '').replace(/[^0-9]/g, '')}`} 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                className="text-emerald"
                              >
                                {inq.phone}
                              </a>
                            </div>
                            <div className="inquiry-meta-item">
                              <span className="meta-lbl">Estimasi Budget:</span>
                              <strong>{inq.budget || 'Tidak disebutkan'}</strong>
                            </div>
                            <div className="inquiry-meta-item">
                              <span className="meta-lbl">Layanan Dicari:</span>
                              <span>{Array.isArray(inq.services) ? inq.services.join(', ') : inq.services || '-'}</span>
                            </div>
                          </div>

                          <div className="inquiry-message-box">
                            <div className="message-label">Isi Brief Proyek:</div>
                            <p className="message-content">{inq.message}</p>
                          </div>

                          <div className="inquiry-card-actions">
                            <a 
                              href={`https://wa.me/${(inq.phone || '').replace(/[^0-9]/g, '')}?text=Halo%20${encodeURIComponent(inq.name)},%20terima%20kasih%20telah%20menghubungi%20Dezzly%20Digital%20Creative.%20Kami%20telah%20meninjau%20brief%20proyek%20Anda.`}
                              target="_blank"
                              rel="noopener noreferrer"
                              className="btn btn-primary btn-sm"
                            >
                              <MessageSquare size={14} />
                              <span>Balas Langsung via WhatsApp</span>
                            </a>
                            <a 
                              href={`mailto:${inq.email}?subject=Konsultasi%20Proyek%20Dezzly%20Digital%20Creative`}
                              className="btn btn-secondary btn-sm"
                            >
                              <span>Balas via Email</span>
                            </a>
                          </div>
                        </div>
                      ))}
                    </div>
                  ) : (
                    <div className="empty-inquiry-state glass-card">
                      <MessageSquare size={40} className="text-cyan" />
                      <h4>Belum Ada Leads Masuk</h4>
                      <p>Setiap calon klien yang mengisi formulir konsultasi atau menggunakan kalkulator biaya akan otomatis tercatat di sini.</p>
                    </div>
                  )}
                </div>
              )}

              {/* TAB 4: SERVICES MANAGEMENT */}
              {activeTab === 'services' && (
                <div className="tab-pane animate-fade-in">
                  <div className="tab-header">
                    <div>
                      <h3 className="tab-title">Kelola Layanan Agensi ({services.length})</h3>
                      <p className="tab-desc">Sesuaikan judul layanan, patokan harga awal, dan daftar deliverables.</p>
                    </div>
                  </div>

                  <div className="services-admin-grid">
                    {services.map((srv) => (
                      <div key={srv.id} className="service-admin-card glass-card">
                        <div className="service-admin-header">
                          <span className="badge badge-cyan">{srv.tagline}</span>
                          <span className="service-admin-price">{srv.startingFrom}</span>
                        </div>
                        <h4 className="service-admin-title">{srv.title}</h4>
                        <p className="service-admin-desc">{srv.description}</p>
                        
                        <div className="service-admin-delivs">
                          <strong>Deliverables Utama:</strong>
                          <ul>
                            {srv.deliverables.slice(0, 3).map((d, i) => (
                              <li key={i}>{d}</li>
                            ))}
                          </ul>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {/* TAB 5: AGENCY PROFILE & SETTINGS */}
              {activeTab === 'agency' && (
                <div className="tab-pane animate-fade-in">
                  <div className="tab-header">
                    <div>
                      <h3 className="tab-title">Profil & Konfigurasi Agensi</h3>
                      <p className="tab-desc">Ubah nama brand, kontak resmi WhatsApp, alamat, dan stats highlight di Hero.</p>
                    </div>
                  </div>

                  <form onSubmit={handleSaveAgencyConfig} className="agency-config-form glass-card">
                    <div className="form-row-two">
                      <div className="form-group">
                        <label className="form-label">Nama Agensi *</label>
                        <input
                          type="text"
                          required
                          className="form-input"
                          value={agencyForm.name}
                          onChange={(e) => setAgencyForm({ ...agencyForm, name: e.target.value })}
                        />
                      </div>

                      <div className="form-group">
                        <label className="form-label">Nama Singkat / Brand Mark</label>
                        <input
                          type="text"
                          className="form-input"
                          value={agencyForm.shortName}
                          onChange={(e) => setAgencyForm({ ...agencyForm, shortName: e.target.value })}
                        />
                      </div>
                    </div>

                    <div className="form-group">
                      <label className="form-label">Tagline Resmi</label>
                      <input
                        type="text"
                        className="form-input"
                        value={agencyForm.tagline}
                        onChange={(e) => setAgencyForm({ ...agencyForm, tagline: e.target.value })}
                      />
                    </div>

                    <div className="form-group">
                      <label className="form-label">Subheadline Hero Banner</label>
                      <textarea
                        rows={2}
                        className="form-textarea"
                        value={agencyForm.subheadline}
                        onChange={(e) => setAgencyForm({ ...agencyForm, subheadline: e.target.value })}
                      ></textarea>
                    </div>

                    <div className="form-row-two">
                      <div className="form-group">
                        <label className="form-label">Nomor WhatsApp Resmi *</label>
                        <input
                          type="text"
                          required
                          className="form-input"
                          value={agencyForm.contact?.whatsapp || ''}
                          onChange={(e) => setAgencyForm({
                            ...agencyForm,
                            contact: { ...agencyForm.contact, whatsapp: e.target.value }
                          })}
                        />
                      </div>

                      <div className="form-group">
                        <label className="form-label">Email Resmi Proyek *</label>
                        <input
                          type="email"
                          required
                          className="form-input"
                          value={agencyForm.contact?.email || ''}
                          onChange={(e) => setAgencyForm({
                            ...agencyForm,
                            contact: { ...agencyForm.contact, email: e.target.value }
                          })}
                        />
                      </div>
                    </div>

                    <div className="form-group">
                      <label className="form-label">Alamat Kantor / Studio</label>
                      <input
                        type="text"
                        className="form-input"
                        value={agencyForm.contact?.address || ''}
                        onChange={(e) => setAgencyForm({
                          ...agencyForm,
                          contact: { ...agencyForm.contact, address: e.target.value }
                        })}
                      />
                    </div>

                    <div className="form-row-two">
                      <div className="form-group">
                        <label className="form-label">Teks Status Ketersediaan</label>
                        <input
                          type="text"
                          className="form-input"
                          value={agencyForm.status?.text || ''}
                          onChange={(e) => setAgencyForm({
                            ...agencyForm,
                            status: { ...agencyForm.status, text: e.target.value }
                          })}
                        />
                      </div>

                      <div className="form-group">
                        <label className="form-label">Sisa Slot Proyek Tersedia</label>
                        <input
                          type="number"
                          className="form-input"
                          value={agencyForm.status?.slotsRemaining || 3}
                          onChange={(e) => setAgencyForm({
                            ...agencyForm,
                            status: { ...agencyForm.status, slotsRemaining: parseInt(e.target.value) || 0 }
                          })}
                        />
                      </div>
                    </div>

                    <div className="form-submit-row">
                      <button type="submit" className="btn btn-primary">
                        <Save size={16} />
                        <span>Simpan Profil Agensi</span>
                      </button>
                    </div>
                  </form>
                </div>
              )}

              {/* TAB 6: TESTIMONIALS */}
              {activeTab === 'testimonials' && (
                <div className="tab-pane animate-fade-in">
                  <div className="tab-header">
                    <div>
                      <h3 className="tab-title">Kelola Testimoni Klien ({testimonials.length})</h3>
                      <p className="tab-desc">Tambahkan ulasan baru dari klien yang puas dengan hasil kerja agensi.</p>
                    </div>
                  </div>

                  {/* Add Testi Form */}
                  <form onSubmit={handleAddTestimonial} className="add-testi-box glass-card">
                    <h4 className="box-subhead">+ Tambah Ulasan Klien Baru</h4>
                    <div className="form-row-two">
                      <div className="form-group">
                        <label className="form-label">Nama Klien / Founder *</label>
                        <input
                          type="text"
                          required
                          className="form-input"
                          placeholder="Contoh: Rian Hardiansyah"
                          value={newTesti.author}
                          onChange={(e) => setNewTesti({ ...newTesti, author: e.target.value })}
                        />
                      </div>

                      <div className="form-group">
                        <label className="form-label">Jabatan & Perusahaan *</label>
                        <input
                          type="text"
                          required
                          className="form-input"
                          placeholder="CEO, Startup Tech"
                          value={newTesti.role}
                          onChange={(e) => setNewTesti({ ...newTesti, role: e.target.value })}
                        />
                      </div>
                    </div>

                    <div className="form-group">
                      <label className="form-label">Kutipan Ulasan / Testimoni *</label>
                      <textarea
                        rows={2}
                        required
                        className="form-textarea"
                        placeholder="Tulis kepuasan klien terhadap pengerjaan proyek..."
                        value={newTesti.quote}
                        onChange={(e) => setNewTesti({ ...newTesti, quote: e.target.value })}
                      ></textarea>
                    </div>

                    <button type="submit" className="btn btn-primary btn-sm">
                      <Plus size={15} />
                      <span>Tambahkan Testimoni</span>
                    </button>
                  </form>

                  {/* Testimonials List */}
                  <div className="testi-admin-list">
                    {testimonials.map((t) => (
                      <div key={t.id} className="testi-admin-item glass-card">
                        <div className="testi-admin-top">
                          <div>
                            <strong>{t.author}</strong> - <span>{t.role} ({t.company})</span>
                          </div>
                          <button 
                            className="btn-icon-action btn-delete"
                            onClick={() => {
                              if (confirm(`Hapus ulasan dari ${t.author}?`)) {
                                deleteTestimonial(t.id);
                              }
                            }}
                          >
                            <Trash2 size={14} />
                          </button>
                        </div>
                        <p className="testi-admin-quote">"{t.quote}"</p>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {/* TAB 7: BACKUP & RESTORE */}
              {activeTab === 'backup' && (
                <div className="tab-pane animate-fade-in">
                  <div className="tab-header">
                    <div>
                      <h3 className="tab-title">Cadangan Data & Pengaturan Ulang</h3>
                      <p className="tab-desc">Ekspor data konten ke file JSON atau kembalikan ke pengaturan bawaan awal.</p>
                    </div>
                  </div>

                  <div className="backup-grid">
                    <div className="backup-card glass-card">
                      <div className="backup-icon text-cyan">
                        <Download size={32} />
                      </div>
                      <h4>Ekspor Backup JSON</h4>
                      <p>Unduh seluruh data proyek, layanan, profil agensi, dan leads saat ini ke dalam satu file JSON untuk diarsipkan atau dipindahkan ke server lain.</p>
                      <button className="btn btn-primary" onClick={exportDataJSON}>
                        <Download size={16} />
                        <span>Unduh File Backup (.json)</span>
                      </button>
                    </div>

                    <div className="backup-card glass-card">
                      <div className="backup-icon text-rose">
                        <RefreshCw size={32} />
                      </div>
                      <h4>Reset ke Pengaturan Awal</h4>
                      <p>Kembalikan semua proyek, testimoni, dan konfigurasi agensi ke data bawaan awal. Seluruh data kustom lokal akan diganti.</p>
                      <button 
                        className="btn btn-secondary" 
                        onClick={() => {
                          if (confirm('PERINGATAN: Apakah Anda yakin ingin mereset seluruh data website ke pengaturan bawaan default?')) {
                            resetToDefaults();
                            alert('Data berhasil direset ke pengaturan default!');
                          }
                        }}
                      >
                        <RefreshCw size={16} />
                        <span>Reset Data Default</span>
                      </button>
                    </div>
                  </div>
                </div>
              )}
            </main>
          </div>
        )}
      </div>

      <style>{`
        .admin-modal-container {
          max-width: 1100px;
          min-height: 640px;
          padding: 0;
          background: #090D16;
          border: 1px solid rgba(0, 240, 255, 0.3);
          box-shadow: 0 30px 90px rgba(0, 0, 0, 0.9), 0 0 50px rgba(0, 240, 255, 0.15);
          display: flex;
          flex-direction: column;
        }

        /* Authentication Screen */
        .admin-auth-box {
          padding: 60px 40px;
          max-width: 480px;
          margin: auto;
          text-align: center;
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 16px;
        }

        .admin-auth-icon {
          width: 72px;
          height: 72px;
          border-radius: 20px;
          background: rgba(0, 240, 255, 0.1);
          border: 1px solid rgba(0, 240, 255, 0.3);
          display: flex;
          align-items: center;
          justify-content: center;
          margin-bottom: 8px;
        }

        .admin-auth-title {
          font-size: 1.6rem;
          font-weight: 800;
        }

        .admin-auth-desc {
          font-size: 0.92rem;
          color: var(--text-secondary);
          line-height: 1.6;
          margin-bottom: 12px;
        }

        .admin-auth-form {
          width: 100%;
          display: flex;
          flex-direction: column;
          gap: 14px;
        }

        .admin-pin-input {
          text-align: center;
          font-size: 1.05rem;
          letter-spacing: 0.1em;
        }

        .pin-error-text {
          font-size: 0.82rem;
          color: #F43F5E;
        }

        .auth-actions-row {
          display: flex;
          flex-direction: column;
          gap: 10px;
        }

        /* Dashboard Layout */
        .admin-dashboard-layout {
          display: grid;
          grid-template-columns: 260px 1fr;
          min-height: 640px;
          flex-grow: 1;
        }

        .admin-sidebar {
          background: rgba(13, 19, 31, 0.95);
          border-right: 1px solid rgba(255, 255, 255, 0.08);
          padding: 24px 18px;
          display: flex;
          flex-direction: column;
          gap: 20px;
        }

        .admin-brand {
          display: flex;
          align-items: center;
          gap: 12px;
          padding-bottom: 16px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .admin-brand-icon {
          width: 36px;
          height: 36px;
          border-radius: 10px;
          background: linear-gradient(135deg, rgba(0, 240, 255, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
          border: 1px solid var(--accent-cyan);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--accent-cyan);
        }

        .admin-brand-name {
          font-family: var(--font-display);
          font-weight: 800;
          font-size: 1.05rem;
          color: #FFFFFF;
        }

        .admin-brand-sub {
          font-size: 0.65rem;
          color: var(--text-muted);
        }

        .admin-nav-list {
          display: flex;
          flex-direction: column;
          gap: 6px;
          flex-grow: 1;
        }

        .admin-nav-item {
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 10px 14px;
          border-radius: var(--radius-md);
          background: transparent;
          border: none;
          color: var(--text-secondary);
          font-size: 0.88rem;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s;
          text-align: left;
          position: relative;
        }

        .admin-nav-item:hover {
          background: rgba(255, 255, 255, 0.05);
          color: var(--text-primary);
        }

        .admin-nav-item.active {
          background: rgba(0, 240, 255, 0.12);
          color: var(--accent-cyan);
          border: 1px solid rgba(0, 240, 255, 0.25);
        }

        .badge-new-count {
          margin-left: auto;
          background: #10B981;
          color: #080B11;
          font-size: 0.7rem;
          font-weight: 800;
          padding: 2px 7px;
          border-radius: 999px;
        }

        .admin-sidebar-footer {
          padding-top: 16px;
          border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* Main Panel */
        .admin-main-panel {
          padding: 32px;
          overflow-y: auto;
          max-height: 85vh;
        }

        .tab-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 24px;
          padding-bottom: 16px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.06);
          gap: 16px;
          flex-wrap: wrap;
        }

        .tab-title {
          font-size: 1.35rem;
          margin-bottom: 4px;
        }

        .tab-desc {
          font-size: 0.88rem;
          color: var(--text-secondary);
        }

        /* Overview Tab */
        .admin-stats-row {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 16px;
          margin-bottom: 28px;
        }

        .admin-stat-card {
          padding: 20px;
          border-radius: var(--radius-md);
          background: rgba(18, 24, 38, 0.6);
          border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .admin-stat-icon {
          margin-bottom: 8px;
        }

        .admin-stat-val {
          font-family: var(--font-display);
          font-size: 2rem;
          font-weight: 800;
          color: #FFFFFF;
          line-height: 1.1;
        }

        .admin-stat-lbl {
          font-size: 0.8rem;
          color: var(--text-muted);
          margin-top: 4px;
        }

        .admin-quick-box {
          padding: 28px;
        }

        .quick-box-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 10px;
        }

        .quick-box-desc {
          font-size: 0.9rem;
          color: var(--text-secondary);
          margin-bottom: 20px;
        }

        .quick-actions-bar {
          display: flex;
          gap: 12px;
          flex-wrap: wrap;
        }

        /* Table */
        .admin-table-container {
          overflow-x: auto;
          background: rgba(14, 20, 32, 0.5);
          border: 1px solid rgba(255, 255, 255, 0.06);
          border-radius: var(--radius-md);
        }

        .admin-table {
          width: 100%;
          border-collapse: collapse;
          font-size: 0.88rem;
        }

        .admin-table th {
          padding: 14px 18px;
          text-align: left;
          background: rgba(20, 28, 44, 0.6);
          color: var(--text-muted);
          font-weight: 700;
          text-transform: uppercase;
          letter-spacing: 0.05em;
          font-size: 0.75rem;
          border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .admin-table td {
          padding: 14px 18px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.04);
          vertical-align: middle;
        }

        .admin-table-thumb {
          width: 48px;
          height: 36px;
          object-fit: cover;
          border-radius: 6px;
        }

        .table-proj-title {
          font-weight: 700;
          color: var(--text-primary);
        }

        .table-proj-client {
          font-size: 0.78rem;
          color: var(--text-muted);
        }

        .table-metric-highlight {
          font-weight: 800;
          color: var(--accent-cyan);
        }

        .table-action-btns {
          display: inline-flex;
          gap: 6px;
        }

        .btn-icon-action {
          width: 32px;
          height: 32px;
          border-radius: 6px;
          border: 1px solid var(--border-subtle);
          background: rgba(255, 255, 255, 0.04);
          color: var(--text-secondary);
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          transition: all 0.2s;
        }

        .btn-edit:hover {
          border-color: var(--accent-cyan);
          color: var(--accent-cyan);
          background: rgba(0, 240, 255, 0.1);
        }

        .btn-delete:hover {
          border-color: #F43F5E;
          color: #F43F5E;
          background: rgba(244, 63, 94, 0.1);
        }

        /* Project Editor Form */
        .project-editor-form {
          background: rgba(14, 20, 32, 0.7);
          border: 1px solid rgba(0, 240, 255, 0.2);
          border-radius: var(--radius-lg);
          padding: 28px;
        }

        .editor-form-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 24px;
        }

        .project-edit-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 16px;
        }

        .span-full {
          grid-column: 1 / -1;
        }

        .editor-form-actions {
          display: flex;
          justify-content: flex-end;
          gap: 12px;
          margin-top: 16px;
        }

        /* Inquiries / Leads */
        .inquiries-list {
          display: flex;
          flex-direction: column;
          gap: 16px;
        }

        .inquiry-card {
          padding: 24px;
          background: rgba(14, 20, 32, 0.7);
          border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .inquiry-header-row {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 16px;
          flex-wrap: wrap;
          gap: 12px;
        }

        .inquiry-name {
          font-size: 1.15rem;
          font-weight: 700;
          color: var(--text-primary);
        }

        .inquiry-company {
          font-size: 0.85rem;
          color: var(--accent-cyan);
          margin-left: 8px;
        }

        .inquiry-date {
          font-size: 0.78rem;
          color: var(--text-muted);
          margin-left: 6px;
        }

        .inquiry-status-row {
          display: flex;
          align-items: center;
          gap: 10px;
        }

        .status-select {
          padding: 6px 12px;
          font-size: 0.82rem;
          width: auto;
        }

        .inquiry-meta-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 14px;
          font-size: 0.84rem;
          padding: 12px 16px;
          background: rgba(255, 255, 255, 0.02);
          border-radius: var(--radius-md);
          margin-bottom: 16px;
        }

        .meta-lbl {
          color: var(--text-muted);
          display: block;
          margin-bottom: 2px;
        }

        .inquiry-message-box {
          margin-bottom: 18px;
        }

        .message-label {
          font-size: 0.8rem;
          color: var(--text-muted);
          margin-bottom: 4px;
          font-weight: 600;
        }

        .message-content {
          font-size: 0.92rem;
          color: var(--text-secondary);
          line-height: 1.6;
          white-space: pre-wrap;
          background: rgba(20, 28, 44, 0.4);
          padding: 12px 16px;
          border-radius: var(--radius-md);
          border: 1px solid var(--border-subtle);
        }

        .inquiry-card-actions {
          display: flex;
          gap: 10px;
        }

        .empty-inquiry-state {
          padding: 60px 20px;
          text-align: center;
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 12px;
        }

        /* Services Grid */
        .services-admin-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 16px;
        }

        .service-admin-card {
          padding: 20px;
        }

        .service-admin-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 10px;
        }

        .service-admin-price {
          font-size: 0.8rem;
          color: var(--accent-cyan);
          font-weight: 700;
        }

        .service-admin-title {
          font-size: 1.1rem;
          margin-bottom: 8px;
        }

        .service-admin-desc {
          font-size: 0.85rem;
          color: var(--text-secondary);
          margin-bottom: 14px;
          line-height: 1.5;
        }

        .service-admin-delivs {
          font-size: 0.8rem;
          color: var(--text-muted);
        }

        .service-admin-delivs ul {
          margin-top: 6px;
          padding-left: 18px;
        }

        /* Agency Config Form */
        .agency-config-form {
          padding: 28px;
        }

        .form-submit-row {
          margin-top: 20px;
          display: flex;
          justify-content: flex-end;
        }

        /* Testimonials Admin */
        .add-testi-box {
          padding: 24px;
          margin-bottom: 24px;
        }

        .box-subhead {
          font-size: 1rem;
          margin-bottom: 16px;
        }

        .testi-admin-list {
          display: flex;
          flex-direction: column;
          gap: 12px;
        }

        .testi-admin-item {
          padding: 16px 20px;
        }

        .testi-admin-top {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 8px;
          font-size: 0.9rem;
        }

        .testi-admin-quote {
          font-size: 0.88rem;
          color: var(--text-secondary);
          font-style: italic;
        }

        /* Backup Grid */
        .backup-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 20px;
        }

        .backup-card {
          padding: 32px;
          display: flex;
          flex-direction: column;
          align-items: flex-start;
          gap: 14px;
        }

        .backup-card h4 {
          font-size: 1.2rem;
        }

        .backup-card p {
          font-size: 0.88rem;
          color: var(--text-secondary);
          line-height: 1.6;
          margin-bottom: 8px;
        }

        @media (max-width: 900px) {
          .admin-dashboard-layout {
            grid-template-columns: 1fr;
          }
          .admin-sidebar {
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 16px;
          }
          .admin-nav-list {
            flex-direction: row;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 6px;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
          }
          .admin-nav-list::-webkit-scrollbar {
            display: none;
          }
          .admin-nav-item {
            flex-shrink: 0;
            padding: 8px 12px;
            font-size: 0.82rem;
          }
          .admin-main-panel {
            padding: 18px;
            max-height: unset;
          }
          .admin-stats-row, 
          .inquiry-meta-grid, 
          .services-admin-grid, 
          .backup-grid {
            grid-template-columns: 1fr;
          }
          .project-edit-grid {
            grid-template-columns: 1fr;
          }
        }
      `}</style>
    </div>
  );
}
