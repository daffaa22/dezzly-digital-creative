/**
 * Services & Agency Capabilities Database
 * Setiap layanan dapat diperluas dengan checklist deliverables dan tools terkait.
 */

export const services = [
  {
    id: "web-saas",
    title: "Web Apps & Cloud SaaS Engineering",
    tagline: "High-Performance Full-Stack Systems",
    icon: "Layout",
    description: "Kami merekayasa aplikasi web modern, dashboard analitik, dan platform SaaS skala besar yang aman, cepat, dan siap menangani jutaan pengguna bersamaan.",
    deliverables: [
      "Arsitektur Frontend Modern (React, Next.js, Vue)",
      "RESTful API & GraphQL Backend Berkecepatan Tinggi",
      "Database Terdistribusi (PostgreSQL, Redis, MongoDB)",
      "CI/CD Automated Deployment & Cloud Scaling (AWS, GCP)",
      "Audit Keamanan, Optimasi SEO Teknis & Web Vitals 95+"
    ],
    technologies: ["React", "Next.js", "TypeScript", "Node.js", "Python", "PostgreSQL", "Docker", "AWS"],
    startingFrom: "Mulai dari Rp 45.000.000"
  },
  {
    id: "mobile-apps",
    title: "Mobile Application Development",
    tagline: "Native & Cross-Platform iOS / Android",
    icon: "Smartphone",
    description: "Pembuatan aplikasi mobile kelas dunia dengan performa 60 FPS, antarmuka haptik responsif, dan integrasi fitur perangkat mendalam (kamera, biometrik, Bluetooth).",
    deliverables: [
      "Aplikasi Multiplatform (React Native & Flutter)",
      "Native Module Integration (iOS Swift & Android Kotlin)",
      "Offline-First Data Sync & Push Notification System",
      "Integrasi Payment Gateway Lokal & Internasional",
      "Penerbitan Resmi ke Apple App Store & Google Play Store"
    ],
    technologies: ["React Native", "Flutter", "Swift", "Kotlin", "Firebase", "WebRTC"],
    startingFrom: "Mulai dari Rp 55.000.000"
  },
  {
    id: "uiux-product-design",
    title: "Product Design & Design Systems",
    tagline: "User-Centric High-Fidelity Interfaces",
    icon: "Palette",
    description: "Dari riset pengguna, wireframing, hingga desain sistem Figma interaktif dengan token desain lengkap yang siap dikembangkan oleh tim developer.",
    deliverables: [
      "User Research & Journey Mapping Komprehensif",
      "Interactive High-Fidelity Prototype (Figma)",
      "Scalable Design System (komponen, token warna, tipografi)",
      "Usability Testing & Conversion Rate Optimization (CRO)",
      "Design Hand-off Dokumentasi Lengkap untuk Developer"
    ],
    technologies: ["Figma", "Design Tokens", "Framer", "Protopie", "UsabilityHub"],
    startingFrom: "Mulai dari Rp 30.000.000"
  },
  {
    id: "ai-automation",
    title: "AI Integration & Workflow Automation",
    tagline: "LLM, Computer Vision & Smart Agents",
    icon: "Cpu",
    description: "Akselerasi operasional bisnis Anda dengan kecerdasan buatan terapan: asisten AI kustom, RAG (Retrieval-Augmented Generation), dan otomasi alur kerja tanpa hambatan.",
    deliverables: [
      "Custom AI Assistants & Chatbots Berbasis Data Internal",
      "RAG Architecture & Vektor Database (Pinecone, Chroma)",
      "Automated Document Processing (OCR & Smart Summarizer)",
      "Integrasi API OpenAI, Anthropic Claude, atau Open-Source LLM",
      "Automasi Workflow Bisnis via Webhooks & Event-Driven Engine"
    ],
    technologies: ["OpenAI API", "LangChain", "FastAPI", "Python", "Pinecone", "Hugging Face"],
    startingFrom: "Mulai dari Rp 50.000.000"
  },
  {
    id: "branding-digital-strategy",
    title: "Brand Identity & Digital Positioning",
    tagline: "Visual Identity that Stands Out",
    icon: "Sparkles",
    description: "Merumuskan identitas merek yang unik, modern, dan berkarakter kuat untuk meningkatkan kepercayaan konsumen dan positioning di mata investor.",
    deliverables: [
      "Brand Core Strategy (Purpose, Vision, Tone of Voice)",
      "Logo System, Typography Guidelines & Color Palette",
      "Marketing Collaterals & Social Media Kit",
      "3D Visual Assets & Micro-animations",
      "Brand Guidelines Book (PDF & Digital Styleguide)"
    ],
    technologies: ["Illustrator", "Blender 3D", "Photoshop", "After Effects"],
    startingFrom: "Mulai dari Rp 25.000.000"
  }
];
