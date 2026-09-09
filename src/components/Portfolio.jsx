import React, { useState, useMemo } from 'react';
import { useContent } from '../context/ContentContext';
import { projectCategories } from '../data/projects';
import { Search, ArrowUpRight, Sparkles, TrendingUp, Layers } from 'lucide-react';

export default function Portfolio({ onSelectProject }) {
  const { projects } = useContent();
  const [activeCategory, setActiveCategory] = useState('all');
  const [searchQuery, setSearchQuery] = useState('');

  // Filter projects by category & search term
  const filteredProjects = useMemo(() => {
    return projects.filter((project) => {
      const matchCategory = activeCategory === 'all' || project.category === activeCategory;
      const matchSearch =
        (project.title || '').toLowerCase().includes(searchQuery.toLowerCase()) ||
        (project.client || '').toLowerCase().includes(searchQuery.toLowerCase()) ||
        (project.summary || '').toLowerCase().includes(searchQuery.toLowerCase()) ||
        (project.techStack || []).some((tech) => tech.toLowerCase().includes(searchQuery.toLowerCase()));

      return matchCategory && matchSearch;
    });
  }, [projects, activeCategory, searchQuery]);

  return (
    <section className="section portfolio-section" id="portofolio">
      <div className="container">
        {/* Section Header */}
        <div className="section-header">
          <div className="section-tag">
            <Sparkles size={14} />
            <span>Portofolio & Studi Kasus</span>
          </div>
          <h2 className="section-title">
            Karya Terpilih yang Memberikan <span className="gradient">Dampak Nyata</span>
          </h2>
          <p className="section-description">
            Jelajahi bagaimana kami merancang arsitektur sistem, memecahkan masalah kompleks, dan mengakselerasi pertumbuhan bisnis klien kami melalui studi kasus mendalam.
          </p>
        </div>

        {/* Filter & Search Bar */}
        <div className="portfolio-controls">
          {/* Category Tabs */}
          <div className="category-tabs">
            {projectCategories.map((cat) => (
              <button
                key={cat.id}
                className={`category-tab-btn ${activeCategory === cat.id ? 'active' : ''}`}
                onClick={() => setActiveCategory(cat.id)}
              >
                {cat.label}
              </button>
            ))}
          </div>

          {/* Search Box */}
          <div className="search-box-wrap">
            <Search size={18} className="search-icon" />
            <input
              type="text"
              placeholder="Cari proyek, teknologi (React, AI, AWS...)"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="search-input"
            />
            {searchQuery && (
              <button className="clear-search-btn" onClick={() => setSearchQuery('')}>
                ✕
              </button>
            )}
          </div>
        </div>

        {/* Results Info */}
        <div className="portfolio-meta-bar">
          <span className="results-count">
            Menampilkan <strong>{filteredProjects.length}</strong> dari {projects.length} proyek studi kasus
          </span>
          <span className="case-study-hint">
            💡 Klik kartu proyek untuk membaca laporan arsitektur, tantangan & solusi teknis
          </span>
        </div>

        {/* Project Cards Grid */}
        {filteredProjects.length > 0 ? (
          <div className="projects-grid">
            {filteredProjects.map((project) => (
              <article
                key={project.id}
                className="project-card glass-card glass-card-interactive"
                onClick={() => onSelectProject(project)}
              >
                {/* Image Cover */}
                <div className="project-cover-wrap">
                  <img
                    src={project.coverImage}
                    alt={project.title}
                    className="project-cover-img"
                    loading="lazy"
                  />
                  <div className="project-badge-overlay">
                    <span className="badge badge-cyan">{project.heroBadge || project.categoryLabel}</span>
                    <span className="badge-year">{project.year}</span>
                  </div>
                  <div className="project-hover-curtain">
                    <span className="hover-explore-text">
                      Buka Studi Kasus Lengkap <ArrowUpRight size={16} />
                    </span>
                  </div>
                </div>

                {/* Card Content */}
                <div className="project-body">
                  <div className="project-category-row">
                    <span className="project-category-text">{project.categoryLabel}</span>
                    <span className="project-client-name">• {project.client}</span>
                  </div>

                  <h3 className="project-card-title">{project.title}</h3>

                  <p className="project-card-summary">{project.summary}</p>

                  {/* Highlight Metric */}
                  {project.keyMetrics && project.keyMetrics[0] && (
                    <div className="project-metric-highlight">
                      <TrendingUp size={15} className="metric-icon text-cyan" />
                      <span className="metric-value">{project.keyMetrics[0].value}</span>
                      <span className="metric-label">{project.keyMetrics[0].label}</span>
                    </div>
                  )}

                  {/* Tech Stack Chips */}
                  <div className="project-tech-chips">
                    {(project.techStack || []).slice(0, 4).map((tech, idx) => (
                      <span key={idx} className="badge-tech">
                        {tech}
                      </span>
                    ))}
                    {(project.techStack || []).length > 4 && (
                      <span className="badge-tech more-tech">
                        +{project.techStack.length - 4}
                      </span>
                    )}
                  </div>

                  {/* Card Footer */}
                  <div className="project-card-footer">
                    <span className="read-case-study-btn">
                      <span>Detail Case Study</span>
                      <ArrowUpRight size={16} />
                    </span>
                  </div>
                </div>
              </article>
            ))}
          </div>
        ) : (
          <div className="empty-portfolio-state glass-card">
            <Layers size={48} className="empty-icon text-cyan" />
            <h3>Tidak Ada Proyek yang Cocok</h3>
            <p>
              Tidak ditemukan proyek dengan kata kunci "<strong>{searchQuery}</strong>" pada kategori ini.
            </p>
            <button
              className="btn btn-secondary btn-sm"
              onClick={() => {
                setActiveCategory('all');
                setSearchQuery('');
              }}
            >
              Reset Filter & Pencarian
            </button>
          </div>
        )}
      </div>

      <style>{`
        .portfolio-section {
          background: rgba(8, 11, 17, 0.6);
          position: relative;
        }

        .portfolio-controls {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 20px;
          flex-wrap: wrap;
          margin-bottom: 24px;
        }

        .category-tabs {
          display: flex;
          align-items: center;
          gap: 8px;
          flex-wrap: wrap;
        }

        .category-tab-btn {
          padding: 8px 18px;
          border-radius: var(--radius-full);
          font-size: 0.88rem;
          font-weight: 600;
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid var(--border-subtle);
          color: var(--text-secondary);
          cursor: pointer;
          transition: all var(--transition-fast);
        }

        .category-tab-btn:hover {
          color: var(--text-primary);
          border-color: rgba(255, 255, 255, 0.2);
          background: rgba(255, 255, 255, 0.06);
        }

        .category-tab-btn.active {
          background: rgba(0, 240, 255, 0.12);
          border-color: var(--accent-cyan);
          color: var(--accent-cyan);
          box-shadow: 0 0 20px rgba(0, 240, 255, 0.2);
        }

        .search-box-wrap {
          position: relative;
          min-width: 300px;
        }

        .search-icon {
          position: absolute;
          left: 14px;
          top: 50%;
          transform: translateY(-50%);
          color: var(--text-muted);
          pointer-events: none;
        }

        .search-input {
          width: 100%;
          padding: 10px 38px 10px 42px;
          background: rgba(20, 28, 44, 0.6);
          border: 1px solid var(--border-subtle);
          border-radius: var(--radius-full);
          color: var(--text-primary);
          font-size: 0.88rem;
          outline: none;
          transition: all 0.2s;
        }

        .search-input:focus {
          border-color: var(--accent-cyan);
          box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
          background: rgba(20, 28, 44, 0.9);
        }

        .clear-search-btn {
          position: absolute;
          right: 12px;
          top: 50%;
          transform: translateY(-50%);
          background: transparent;
          border: none;
          color: var(--text-muted);
          cursor: pointer;
          font-size: 0.8rem;
        }

        .portfolio-meta-bar {
          display: flex;
          align-items: center;
          justify-content: space-between;
          flex-wrap: wrap;
          gap: 12px;
          font-size: 0.85rem;
          color: var(--text-muted);
          margin-bottom: 32px;
          padding-bottom: 16px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .portfolio-meta-bar strong {
          color: var(--accent-cyan);
        }

        .case-study-hint {
          color: #94A3B8;
        }

        .projects-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 30px;
        }

        .project-card {
          display: flex;
          flex-direction: column;
          overflow: hidden;
          background: rgba(14, 20, 32, 0.7);
          border: 1px solid rgba(255, 255, 255, 0.08);
          border-radius: var(--radius-lg);
          transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .project-card:hover {
          transform: translateY(-6px);
          border-color: rgba(0, 240, 255, 0.35);
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), 0 0 25px rgba(0, 240, 255, 0.15);
        }

        .project-cover-wrap {
          position: relative;
          width: 100%;
          height: 220px;
          overflow: hidden;
          background: #080B11;
        }

        .project-cover-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .project-card:hover .project-cover-img {
          transform: scale(1.08);
        }

        .project-badge-overlay {
          position: absolute;
          top: 14px;
          left: 14px;
          right: 14px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          z-index: 2;
        }

        .badge-year {
          font-size: 0.75rem;
          font-weight: 700;
          padding: 4px 10px;
          border-radius: var(--radius-full);
          background: rgba(0, 0, 0, 0.6);
          backdrop-filter: blur(8px);
          border: 1px solid rgba(255, 255, 255, 0.15);
          color: var(--text-primary);
        }

        .project-hover-curtain {
          position: absolute;
          inset: 0;
          background: rgba(8, 11, 17, 0.6);
          backdrop-filter: blur(4px);
          display: flex;
          align-items: center;
          justify-content: center;
          opacity: 0;
          transition: opacity 0.3s;
        }

        .project-card:hover .project-hover-curtain {
          opacity: 1;
        }

        .hover-explore-text {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          padding: 8px 18px;
          border-radius: var(--radius-full);
          background: rgba(0, 240, 255, 0.2);
          border: 1px solid var(--accent-cyan);
          color: var(--accent-cyan);
          font-size: 0.85rem;
          font-weight: 700;
          box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
        }

        .project-body {
          padding: 24px;
          display: flex;
          flex-direction: column;
          flex-grow: 1;
        }

        .project-category-row {
          display: flex;
          align-items: center;
          gap: 6px;
          font-size: 0.8rem;
          margin-bottom: 10px;
        }

        .project-category-text {
          color: var(--accent-cyan);
          font-weight: 700;
          text-transform: uppercase;
          letter-spacing: 0.04em;
        }

        .project-client-name {
          color: var(--text-muted);
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }

        .project-card-title {
          font-size: 1.25rem;
          font-weight: 700;
          line-height: 1.3;
          margin-bottom: 12px;
          color: var(--text-primary);
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
        }

        .project-card-summary {
          font-size: 0.9rem;
          color: var(--text-secondary);
          line-height: 1.6;
          margin-bottom: 18px;
          display: -webkit-box;
          -webkit-line-clamp: 3;
          -webkit-box-orient: vertical;
          overflow: hidden;
        }

        .project-metric-highlight {
          display: flex;
          align-items: center;
          gap: 8px;
          padding: 10px 14px;
          border-radius: var(--radius-md);
          background: rgba(0, 240, 255, 0.05);
          border: 1px solid rgba(0, 240, 255, 0.15);
          margin-bottom: 18px;
          font-size: 0.85rem;
        }

        .metric-value {
          font-weight: 800;
          font-family: var(--font-display);
          color: var(--accent-cyan);
        }

        .metric-label {
          color: var(--text-secondary);
          font-size: 0.8rem;
        }

        .project-tech-chips {
          display: flex;
          flex-wrap: wrap;
          gap: 6px;
          margin-bottom: 20px;
        }

        .more-tech {
          color: var(--accent-cyan);
        }

        .project-card-footer {
          margin-top: auto;
          padding-top: 14px;
          border-top: 1px solid rgba(255, 255, 255, 0.06);
          display: flex;
          justify-content: flex-end;
        }

        .read-case-study-btn {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          font-size: 0.85rem;
          font-weight: 700;
          color: var(--accent-cyan);
          transition: transform 0.2s;
        }

        .project-card:hover .read-case-study-btn {
          transform: translateX(4px);
        }

        .empty-portfolio-state {
          padding: 60px 24px;
          text-align: center;
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 16px;
          max-width: 500px;
          margin: 0 auto;
        }

        .empty-portfolio-state p {
          color: var(--text-secondary);
          font-size: 0.95rem;
        }

        @media (max-width: 1080px) {
          .projects-grid {
            grid-template-columns: repeat(2, 1fr);
          }
        }

        @media (max-width: 720px) {
          .projects-grid {
            grid-template-columns: 1fr;
            gap: 20px;
          }
          .portfolio-controls {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
          }
          .category-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
            justify-content: flex-start;
            padding-bottom: 6px;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
            width: 100%;
          }
          .category-tabs::-webkit-scrollbar {
            display: none;
          }
          .category-tab-btn {
            flex-shrink: 0;
            padding: 8px 14px;
            font-size: 0.82rem;
          }
          .search-box-wrap {
            width: 100%;
            min-width: unset;
          }
          .project-cover-wrap {
            height: 190px;
          }
          .project-body {
            padding: 18px;
          }
          .project-card-title {
            font-size: 1.15rem;
          }
        }
      `}</style>
    </section>
  );
}
