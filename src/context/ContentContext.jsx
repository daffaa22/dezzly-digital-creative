import React, { createContext, useContext, useState, useEffect } from 'react';
import { projects as defaultProjects } from '../data/projects';
import { services as defaultServices } from '../data/services';
import { agencyConfig as defaultAgencyConfig } from '../data/agencyConfig';
import { testimonials as defaultTestimonials } from '../data/testimonials';
import { faqs as defaultFaqs } from '../data/faqs';

const ContentContext = createContext(null);
const STORAGE_KEY = 'dezzly_cms_data_v1';

export function ContentProvider({ children }) {
  // Initialize state from localStorage if available, or fall back to default files
  const [data, setData] = useState(() => {
    try {
      const stored = localStorage.getItem(STORAGE_KEY);
      if (stored) {
        const parsed = JSON.parse(stored);
        return {
          projects: parsed.projects || defaultProjects,
          services: parsed.services || defaultServices,
          agencyConfig: parsed.agencyConfig || defaultAgencyConfig,
          testimonials: parsed.testimonials || defaultTestimonials,
          faqs: parsed.faqs || defaultFaqs,
          inquiries: parsed.inquiries || [
            {
              id: 'inq-sample-1',
              name: 'Ardi Kusuma',
              email: 'ardi@ventures.id',
              phone: '+62 811-9876-5432',
              company: 'Kusuma Ventures Tech',
              services: ['Web App & SaaS', 'AI & Automation'],
              budget: 'Rp 100 - 250 Juta',
              message: 'Tertarik mengembangkan portal AI analytics untuk portofolio startup kami dalam 2 bulan ke depan.',
              date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }),
              status: 'Baru'
            }
          ]
        };
      }
    } catch (e) {
      console.warn('Gagal membaca data CMS dari LocalStorage:', e);
    }

    return {
      projects: defaultProjects,
      services: defaultServices,
      agencyConfig: defaultAgencyConfig,
      testimonials: defaultTestimonials,
      faqs: defaultFaqs,
      inquiries: [
        {
          id: 'inq-sample-1',
          name: 'Ardi Kusuma',
          email: 'ardi@ventures.id',
          phone: '+62 811-9876-5432',
          company: 'Kusuma Ventures Tech',
          services: ['Web App & SaaS', 'AI & Automation'],
          budget: 'Rp 100 - 250 Juta',
          message: 'Tertarik mengembangkan portal AI analytics untuk portofolio startup kami dalam 2 bulan ke depan.',
          date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }),
          status: 'Baru'
        }
      ]
    };
  });

  // Auto-sync state to localStorage whenever it changes
  useEffect(() => {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
    } catch (e) {
      console.error('Gagal menyimpan ke LocalStorage:', e);
    }
  }, [data]);

  // --- PROJECT ACTIONS ---
  const addProject = (newProject) => {
    setData((prev) => ({
      ...prev,
      projects: [newProject, ...prev.projects]
    }));
  };

  const updateProject = (id, updatedFields) => {
    setData((prev) => ({
      ...prev,
      projects: prev.projects.map((p) => (p.id === id ? { ...p, ...updatedFields } : p))
    }));
  };

  const deleteProject = (id) => {
    setData((prev) => ({
      ...prev,
      projects: prev.projects.filter((p) => p.id !== id)
    }));
  };

  // --- SERVICE ACTIONS ---
  const updateService = (id, updatedFields) => {
    setData((prev) => ({
      ...prev,
      services: prev.services.map((s) => (s.id === id ? { ...s, ...updatedFields } : s))
    }));
  };

  // --- AGENCY CONFIG ACTIONS ---
  const updateAgencyConfig = (newConfig) => {
    setData((prev) => ({
      ...prev,
      agencyConfig: { ...prev.agencyConfig, ...newConfig }
    }));
  };

  // --- TESTIMONIAL ACTIONS ---
  const addTestimonial = (testi) => {
    setData((prev) => ({
      ...prev,
      testimonials: [testi, ...prev.testimonials]
    }));
  };

  const deleteTestimonial = (id) => {
    setData((prev) => ({
      ...prev,
      testimonials: prev.testimonials.filter((t) => t.id !== id)
    }));
  };

  // --- INQUIRY / LEADS ACTIONS ---
  const addInquiry = (inquiry) => {
    const newInquiry = {
      ...inquiry,
      id: `inq-${Date.now()}`,
      date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }),
      status: 'Baru'
    };
    setData((prev) => ({
      ...prev,
      inquiries: [newInquiry, ...prev.inquiries]
    }));
  };

  const updateInquiryStatus = (id, status) => {
    setData((prev) => ({
      ...prev,
      inquiries: prev.inquiries.map((inq) => (inq.id === id ? { ...inq, status } : inq))
    }));
  };

  const deleteInquiry = (id) => {
    setData((prev) => ({
      ...prev,
      inquiries: prev.inquiries.filter((inq) => inq.id !== id)
    }));
  };

  // --- BACKUP & RESTORE ACTIONS ---
  const resetToDefaults = () => {
    const defaultData = {
      projects: defaultProjects,
      services: defaultServices,
      agencyConfig: defaultAgencyConfig,
      testimonials: defaultTestimonials,
      faqs: defaultFaqs,
      inquiries: []
    };
    setData(defaultData);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(defaultData));
  };

  const exportDataJSON = () => {
    const jsonStr = JSON.stringify(data, null, 2);
    const blob = new Blob([jsonStr], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `dezzly_cms_backup_${new Date().toISOString().slice(0, 10)}.json`;
    link.click();
    URL.revokeObjectURL(url);
  };

  return (
    <ContentContext.Provider
      value={{
        projects: data.projects,
        services: data.services,
        agencyConfig: data.agencyConfig,
        testimonials: data.testimonials,
        faqs: data.faqs,
        inquiries: data.inquiries,
        addProject,
        updateProject,
        deleteProject,
        updateService,
        updateAgencyConfig,
        addTestimonial,
        deleteTestimonial,
        addInquiry,
        updateInquiryStatus,
        deleteInquiry,
        resetToDefaults,
        exportDataJSON
      }}
    >
      {children}
    </ContentContext.Provider>
  );
}

export function useContent() {
  const context = useContext(ContentContext);
  if (!context) {
    throw new Error('useContent harus digunakan di dalam ContentProvider');
  }
  return context;
}
