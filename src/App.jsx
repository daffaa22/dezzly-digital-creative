import React, { useState } from 'react';
import { ContentProvider } from './context/ContentContext';
import Navbar from './components/Navbar';
import Hero from './components/Hero';
import ClientLogos from './components/ClientLogos';
import Services from './components/Services';
import Portfolio from './components/Portfolio';
import CaseStudyModal from './components/CaseStudyModal';
import CostEstimator from './components/CostEstimator';
import ProcessTimeline from './components/ProcessTimeline';
import Testimonials from './components/Testimonials';
import FAQSection from './components/FAQSection';
import ContactSection from './components/ContactSection';
import Footer from './components/Footer';
import AdminModal from './components/admin/AdminModal';
import { Sliders } from 'lucide-react';

function AppContent() {
  const [selectedProject, setSelectedProject] = useState(null);
  const [contactPrefill, setContactPrefill] = useState(null);
  const [isCMSOpen, setIsCMSOpen] = useState(false);

  const handleOpenProject = (project) => {
    setSelectedProject(project);
  };

  const handleCloseProject = () => {
    setSelectedProject(null);
  };

  const handleConsultSimilar = (project) => {
    setContactPrefill({
      similarProject: project.title,
      projectType: project.categoryLabel
    });
  };

  const handleExportEstimate = (estimateData) => {
    setContactPrefill(estimateData);
  };

  const handleSelectService = (serviceTitle) => {
    setContactPrefill({
      projectType: serviceTitle
    });
  };

  return (
    <div className="app-layout">
      {/* Navigation */}
      <Navbar onOpenCMS={() => setIsCMSOpen(true)} />

      <main>
        {/* Hero Section */}
        <Hero />

        {/* Client Partners Marquee */}
        <ClientLogos />

        {/* Services & Capabilities */}
        <Services onSelectService={handleSelectService} />

        {/* Detailed Portfolio & Case Studies */}
        <Portfolio onSelectProject={handleOpenProject} />

        {/* Interactive Scope & Cost Estimator */}
        <CostEstimator onExportToContact={handleExportEstimate} />

        {/* 5-Step Methodology */}
        <ProcessTimeline />

        {/* Testimonials & Social Proof */}
        <Testimonials />

        {/* FAQ Section */}
        <FAQSection />

        {/* Contact & Consultation Form */}
        <ContactSection prefillData={contactPrefill} />
      </main>

      {/* Footer */}
      <Footer onOpenCMS={() => setIsCMSOpen(true)} />

      {/* Deep-Dive Case Study Modal */}
      {selectedProject && (
        <CaseStudyModal
          project={selectedProject}
          onClose={handleCloseProject}
          onConsultSimilar={handleConsultSimilar}
        />
      )}

      {/* In-App CMS Admin Modal */}
      <AdminModal
        isOpen={isCMSOpen}
        onClose={() => setIsCMSOpen(false)}
      />

      {/* Floating Quick CMS Access Button */}
      <button 
        className="floating-cms-btn"
        onClick={() => setIsCMSOpen(true)}
        title="Buka CMS Admin Panel"
        aria-label="Buka CMS Admin"
      >
        <Sliders size={18} />
        <span>CMS Admin</span>
      </button>

      <style>{`
        .floating-cms-btn {
          position: fixed;
          bottom: 24px;
          right: 24px;
          z-index: 800;
          display: inline-flex;
          align-items: center;
          gap: 8px;
          padding: 10px 18px;
          border-radius: var(--radius-full);
          background: rgba(13, 19, 31, 0.9);
          border: 1px solid rgba(0, 240, 255, 0.4);
          color: var(--accent-cyan);
          font-weight: 700;
          font-size: 0.85rem;
          cursor: pointer;
          backdrop-filter: blur(12px);
          -webkit-backdrop-filter: blur(12px);
          box-shadow: 0 8px 24px rgba(0, 0, 0, 0.6), 0 0 20px rgba(0, 240, 255, 0.2);
          transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .floating-cms-btn:hover {
          background: rgba(0, 240, 255, 0.15);
          border-color: var(--accent-cyan);
          transform: translateY(-3px) scale(1.02);
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7), 0 0 25px rgba(0, 240, 255, 0.35);
        }

        @media (max-width: 640px) {
          .floating-cms-btn {
            bottom: 16px;
            right: 16px;
            padding: 8px 14px;
            font-size: 0.8rem;
          }
        }
      `}</style>
    </div>
  );
}

export default function App() {
  return (
    <ContentProvider>
      <AppContent />
    </ContentProvider>
  );
}
