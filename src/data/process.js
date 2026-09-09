/**
 * Agency 5-Step Execution Methodology
 * Menjelaskan alur kerja standar dari discovery hingga deployment & scale.
 */

export const agencyProcess = [
  {
    step: "01",
    title: "Discovery & Product Strategy",
    timeline: "Minggu 1 - 2",
    description: "Kami mendalami tujuan bisnis Anda, menganalisis kompetitor, membedah masalah pengguna, dan merumuskan Product Requirement Document (PRD) yang solid.",
    activities: [
      "Stakeholder interviews & workshop",
      "Competitive analysis & user personas",
      "Scope of work definition & tech stack selection",
      "Roadmap & timeline milestone finalization"
    ]
  },
  {
    step: "02",
    title: "UI/UX Design & Rapid Prototyping",
    timeline: "Minggu 3 - 5",
    description: "Mengubah ide abstrak menjadi antarmuka interaktif yang indah, intuitif, dan telah diuji langsung kepada calon pengguna sebelum baris kode ditulis.",
    activities: [
      "Information architecture & wireframing",
      "Interactive Figma high-fidelity clickable prototype",
      "Design system components & micro-interactions",
      "Usability testing & client design sign-off"
    ]
  },
  {
    step: "03",
    title: "Agile Engineering & Sprint Delivery",
    timeline: "Minggu 6 - 11",
    description: "Pengembangan kode bersih (clean code), modular, dan berstandar industri dengan sprint 2 mingguan serta demo live rutin setiap akhir sprint.",
    activities: [
      "Frontend & Backend architecture scaffolding",
      "Bi-weekly sprint demos & progress transparency",
      "API integrations, database schema & security rules",
      "Unit testing & code review berstandar tinggi"
    ]
  },
  {
    step: "04",
    title: "Quality Assurance & Penetration Test",
    timeline: "Minggu 12 - 13",
    description: "Pengujian menyeluruh lintas perangkat, pengujian beban trafik ekstrem (load testing), serta audit keamanan celah siber sebelum rilis publik.",
    activities: [
      "Cross-browser & cross-device compatibility testing",
      "Stress testing & load endurance (10K+ virtual users)",
      "Security vulnerability assessment & OWASP audit",
      "Data privacy & compliance verification"
    ]
  },
  {
    step: "05",
    title: "Launch, Monitoring & Continuous Growth",
    timeline: "Minggu 14+",
    description: "Peluncuran produk ke server produksi tanpa downtime, pemantauan performa real-time, serta dukungan teknis berkelanjutan pasca rilis.",
    activities: [
      "Production deployment via automated CI/CD pipeline",
      "App Store & Google Play Store submission assist",
      "Live error tracking setup (Sentry, Datadog)",
      "Garansi bug-free 90 hari & opsi maintenance kontrak"
    ]
  }
];
