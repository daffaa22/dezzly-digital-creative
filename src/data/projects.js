/**
 * Data Portofolio & Studi Kasus Mendetail (Data-Driven Case Studies)
 * Anda dapat menambah proyek baru sebanyak mungkin dengan mengikuti format objek di bawah ini.
 */

export const projectCategories = [
  { id: "all", label: "Semua Proyek" },
  { id: "saas", label: "Web & SaaS" },
  { id: "mobile", label: "Mobile Apps" },
  { id: "ai", label: "AI & Otomasi" },
  { id: "design", label: "Branding & UI/UX" }
];

export const projects = [
  {
    id: "paypulse-fintech",
    slug: "paypulse-fintech-superapp",
    title: "PayPulse - Enterprise Fintech & Cross-Border Payment",
    client: "PayPulse Financial Technologies Pte Ltd",
    category: "saas",
    categoryLabel: "Web & SaaS",
    industry: "Fintech / Digital Banking",
    year: "2025",
    timeline: "14 Minggu",
    heroBadge: "Studi Kasus Unggulan",
    summary: "Platform perbankan digital B2B dan cross-border settlement dengan enkripsi end-to-end berkecepatan tinggi, memproses transaksi harian senilai $8.5M+.",
    coverImage: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80",
    gallery: [
      "https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80"
    ],
    keyMetrics: [
      { value: "+340%", label: "Kenaikan Transaksi", description: "Peningkatan volume transaksi dalam 6 bulan pertama" },
      { value: "0.45s", label: "Settlement Latency", description: "Waktu eksekusi transfer multi-mata uang real-time" },
      { value: "99.99%", label: "System Reliability", description: "Zero-downtime SLA selama jam perdagangan puncak" }
    ],
    challenge: "Klien menghadapi masalah infrastruktur lama yang lambat, waktu rekonsiliasi antar bank memakan waktu hingga 48 jam, dan angka drop-off alur verifikasi KYC mencapai 42% karena antarmuka yang membingungkan.",
    solution: "Kami merancang ulang seluruh pengalaman pengguna (UX) dengan alur instant KYC 3 langkah, membangun dashboard mikro-frontends berbasis React & WebSockets untuk real-time rate monitoring, serta mengintegrasikan arsitektur API terdistribusi dengan failover otomatis.",
    architectureHighlights: [
      "Distributed Microservices dengan Event-Driven Kafka",
      "Sub-second WebSocket Streaming untuk update valas live",
      "Automated e-KYC AI verification via biometric scanning",
      "Compliance standar ISO-27001 dan PCI-DSS Level 1"
    ],
    techStack: ["React 19", "TypeScript", "Node.js", "PostgreSQL", "Apache Kafka", "Redis", "TailwindCSS", "Docker", "AWS"],
    deliverables: [
      "Full Product Discovery & System Architecture Document",
      "High-Fidelity Figma Design System (320+ komponen modular)",
      "Web Dashboard App & REST API Engine",
      "Automated Unit & Penetration Testing Suite"
    ],
    clientReview: {
      quote: "Dezzly Digital Creative tidak hanya membangun perangkat lunak; mereka merombak fundamental produk kami. Konversi aktivasi merchant kami melonjak 3 kali lipat dalam waktu kuartal pertama peluncuran.",
      author: "David Wicaksono",
      role: "Chief Technology Officer",
      company: "PayPulse Asia",
      avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80"
    },
    links: {
      demo: "https://example.com/paypulse-demo",
      figma: "https://figma.com/@nexora-paypulse"
    }
  },
  {
    id: "zenith-health-mobile",
    slug: "zenith-telehealth-patient-app",
    title: "Zenith Health - AI Telemedicine & Clinical Diagnostics App",
    client: "Zenith Health Global",
    category: "mobile",
    categoryLabel: "Mobile Apps",
    industry: "Healthcare / Telemedicine",
    year: "2025",
    timeline: "12 Minggu",
    heroBadge: "4.9 App Store Rating",
    summary: "Aplikasi mobile iOS & Android yang menghubungkan 250,000+ pasien dengan dokter spesialis, dilengkapi rekam medis digital terenkripsi dan triase berbasis AI.",
    coverImage: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80",
    gallery: [
      "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80"
    ],
    keyMetrics: [
      { value: "4.9/5", label: "App Store Rating", description: "Berdasarkan lebih dari 18.000 ulasan pasien" },
      { value: "1.2M+", label: "Konsultasi Selesai", description: "Total telekonsultasi aman yang telah diproses" },
      { value: "-65%", label: "Waktu Tunggu Pasien", description: "Pengurangan waktu tunggu dokter berkat alur otomatis" }
    ],
    challenge: "Pasien di daerah rural kesulitan mengakses dokter spesialis. Aplikasi lama sering crash saat panggilan video HD, dan dokter merasa lelah mencatat riwayat pasien secara manual.",
    solution: "Mengembangkan aplikasi React Native dengan WebRTC adaptif yang tetap stabil di jaringan 3G/4G, dilengkapi asisten AI yang merangkum transkrip konsultasi menjadi rekam medis elektronik (EMR) otomatis.",
    architectureHighlights: [
      "Low-bandwidth Adaptive WebRTC Video Consultations",
      "HIPAA-compliant End-to-End Encrypted Patient Records",
      "Speech-to-Text Medical Scribe untuk rangkuman otomatis",
      "Offline-first sync database menggunakan WatermelonDB"
    ],
    techStack: ["React Native", "Expo", "WebRTC", "FastAPI (Python)", "OpenAI GPT-4o", "MongoDB", "WebSockets"],
    deliverables: [
      "Aplikasi iOS (App Store) & Android (Google Play)",
      "Doctor Portal Web Application",
      "Integrasi Asuransi Medis & Pembayaran Digital",
      "Audit Keamanan Data Medis & Sertifikasi HIPAA"
    ],
    clientReview: {
      quote: "Pengalaman video dan AI summary yang dirancang NEXORA berhasil mengubah cara kerja ribuan dokter kami. Sangat intuitif, cepat, dan zero-lag.",
      author: "dr. Sarah Anindita",
      role: "VP of Medical Operations",
      company: "Zenith Telehealth Network",
      avatar: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80"
    },
    links: {
      demo: "https://example.com/zenith-health",
      figma: "https://figma.com/@nexora-zenith"
    }
  },
  {
    id: "omnisight-ai",
    slug: "omnisight-predictive-supply-chain",
    title: "OmniSight AI - Supply Chain Intelligence Platform",
    client: "OmniLogistics Worldwide",
    category: "ai",
    categoryLabel: "AI & Otomasi",
    industry: "Logistics & Enterprise AI",
    year: "2024",
    timeline: "16 Minggu",
    heroBadge: "Enterprise AI",
    summary: "Platform pemantauan rantai pasok global bertenaga Computer Vision dan Machine Learning untuk memprediksi keterlambatan pengiriman dan anomali kargo.",
    coverImage: "https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80",
    gallery: [
      "https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80"
    ],
    keyMetrics: [
      { value: "94.8%", label: "Akurasi Prediksi", description: "Tingkat akurasi prediksi waktu tiba kapal & truk kontainer" },
      { value: "$3.2M", label: "Biaya Dihemat", description: "Pengurangan biaya penalti demurrage per tahun" },
      { value: "450K+", label: "Kontainer Dimonitor", description: "Volume kargo real-time di 28 pelabuhan internasional" }
    ],
    challenge: "Keterlambatan pelabuhan dan cuaca ekstrem sering tidak terdeteksi lebih awal, mengakibatkan penumpukan kontainer dan denda jutaan dolar setiap kuartal.",
    solution: "Membangun sistem ingest data sensor IoT satelit dan citra CCTV dermaga, diolah oleh model prediktif PyTorch, divisualisasikan melalui antarmuka peta 3D interaktif berbasis WebGL.",
    architectureHighlights: [
      "Real-time Stream Processing via Apache Flink",
      "Interactive 3D Geospatial Map menggunakan Mapbox GL & Three.js",
      "Model Prediksi Waktu Kedatangan (ETA) berbasis Transformer",
      "Alerting Otomatis ke Telegram & WhatsApp Operational Team"
    ],
    techStack: ["Next.js", "Python / PyTorch", "Apache Flink", "Three.js", "Mapbox GL", "Kubernetes", "GCP"],
    deliverables: [
      "Platform Web Enterprise Command Center",
      "Pipeline Data Ingestion & Machine Learning Model Deployment",
      "Dokumentasi API Terintegrasi SAP & Oracle SCM",
      "Training & Onboarding untuk 200+ Operator Logistik"
    ],
    clientReview: {
      quote: "Dashboard 3D dan model kecerdasan buatan dari NEXORA memberikan visibilitas real-time yang sebelumnya mustahil kami dapatkan.",
      author: "Robert Chen",
      role: "Head of Global Supply Operations",
      company: "OmniLogistics",
      avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80"
    },
    links: {
      demo: "https://example.com/omnisight-ai",
      figma: "https://figma.com/@nexora-omnisight"
    }
  },
  {
    id: "lumos-brand-identity",
    slug: "lumos-luxury-lifestyle-rebrand",
    title: "LUMOS - Global E-Commerce & Rebranding Experience",
    client: "Lumos Atelier & Co",
    category: "design",
    categoryLabel: "Branding & UI/UX",
    industry: "Luxury Retail & Fashion",
    year: "2025",
    timeline: "8 Minggu",
    heroBadge: "Design Excellence",
    summary: "Rebranding menyeluruh, desain visual identitas premium, dan toko e-commerce headless berperforma tinggi dengan konversi checkout meningkat 85%.",
    coverImage: "https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80",
    gallery: [
      "https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=800&q=80"
    ],
    keyMetrics: [
      { value: "+85%", label: "Checkout Conversion", description: "Peningkatan rasio pengunjung menjadi pembeli aktif" },
      { value: "0.8s", label: "Page Load Speed", description: "Kecepatan muat halaman di 12 negara target" },
      { value: "3.4x", label: "Average Order Value", description: "Kenaikan nilai rata-rata keranjang belanja" }
    ],
    challenge: "Brand lama terasa ketinggalan zaman dan lambat dibuka di perangkat smartphone, sehingga kehilangan pangsa pasar pembeli muda di Asia Tenggara dan Eropa.",
    solution: "Merumuskan identitas visual baru yang minimalis dan elegan, tipografi tipografi bespoke, dipadukan arsitektur e-commerce headless Shopify yang sangat cepat dengan transisi halaman sehalus aplikasi native.",
    architectureHighlights: [
      "Headless Shopify Storefront dengan Next.js App Router",
      "Edge Caching Global melalui Vercel Edge Network",
      "Custom 3D Product Interactive Viewer",
      "Dynamic Multi-Currency & Multi-Language Localization"
    ],
    techStack: ["Shopify Storefront API", "React", "Next.js", "TailwindCSS", "Framer Motion", "Three.js"],
    deliverables: [
      "Complete Brand Identity Guidelines (Logo, Typography, Palette, Packaging)",
      "E-Commerce Web Storefront Berkecepatan Tinggi",
      "Marketing Kit & 3D Interactive Product Models",
      "Automated Email Marketing Design Templates"
    ],
    clientReview: {
      quote: "Estetika yang dihadirkan NEXORA melampaui ekspektasi dewan direksi kami. Website terasa sangat mewah, berkelas, dan transaksi naik secara eksponensial.",
      author: "Helena Sasmita",
      role: "Creative Director & Founder",
      company: "Lumos Atelier",
      avatar: "https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80"
    },
    links: {
      demo: "https://example.com/lumos-atelier",
      figma: "https://figma.com/@nexora-lumos"
    }
  },
  {
    id: "strata-cloud-devops",
    slug: "strata-cloud-infrastructure-management",
    title: "Strata - Multi-Cloud Orchestration & Observability Suite",
    client: "Strata Cloud Infrastructure Inc",
    category: "saas",
    categoryLabel: "Web & SaaS",
    industry: "DevOps & Cloud SaaS",
    year: "2024",
    timeline: "14 Minggu",
    heroBadge: "DevOps Innovation",
    summary: "Dashboard orkestrasi multi-cloud AWS, Azure, dan GCP untuk tim engineering skala besar, menghemat 35% biaya komputasi bulanan secara otomatis.",
    coverImage: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80",
    gallery: [
      "https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=800&q=80"
    ],
    keyMetrics: [
      { value: "-35%", label: "Cloud Cost Saved", description: "Pengurangan pengeluaran server yang tidak terpakai" },
      { value: "10x", label: "Deployment Speed", description: "Akselerasi siklus rilis fitur tim developer" },
      { value: "15,000+", label: "Nodes Managed", description: "Jumlah cluster server yang dikelola dalam 1 antarmuka" }
    ],
    challenge: "Tim DevOps harus membuka 4 konsol cloud terpisah setiap hari, menyulitkan pelacakan tagihan boros dan memperlambat troubleshooting ketika terjadi insiden server down.",
    solution: "Membangun antarmuka terpadu (single pane of glass) dengan visualisasi topologi cluster live, metrik utilisasi CPU/Memory instan, dan rekomendasi otomatis pemangkasan resource idle.",
    architectureHighlights: [
      "Unified OpenTelemetry Ingestion Engine",
      "Terraform & Kubernetes Native Integration",
      "Role-Based Access Control (RBAC) dengan SSO Okta",
      "High-density Data Grids dengan virtualisasi render 60 FPS"
    ],
    techStack: ["React", "TypeScript", "Go (Golang)", "Prometheus", "Grafana", "Kubernetes", "TailwindCSS"],
    deliverables: [
      "Multi-Cloud Management Web Portal",
      "Agent Collector Daemon (Open Source)",
      "Role & Permission Security Matrix",
      "Enterprise On-Premises & SaaS Deployment Helm Charts"
    ],
    clientReview: {
      quote: "Strata menjadi senjata utama tim teknis kami dalam mengendalikan anggaran infrastruktur cloud. Visualisasinya sangat jernih dan responsif.",
      author: "Alex Morgan",
      role: "VP of Cloud Engineering",
      company: "Strata Cloud Corp",
      avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80"
    },
    links: {
      demo: "https://example.com/strata-cloud",
      figma: "https://figma.com/@nexora-strata"
    }
  },
  {
    id: "kura-neo-bank",
    slug: "kura-digital-banking-for-gen-z",
    title: "Kura - Neobank & Smart Budgeting for Gen-Z",
    client: "Kura Financial Asia",
    category: "mobile",
    categoryLabel: "Mobile Apps",
    industry: "Fintech / Consumer Banking",
    year: "2025",
    timeline: "10 Minggu",
    heroBadge: "Fintech of the Year",
    summary: "Aplikasi perbankan neobank generasi baru dengan gamifikasi tabungan, kartu debit virtual dinamis, dan fitur investasi reksadana mikro otomatis.",
    coverImage: "https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80",
    gallery: [
      "https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=800&q=80"
    ],
    keyMetrics: [
      { value: "500K+", label: "Akun Terdaftar", description: "Pertumbuhan pengguna dalam 4 bulan pertama rilis" },
      { value: "4.8", label: "Google Play Store", description: "Rating pengguna dengan rasio uninstall di bawah 3%" },
      { value: "82%", label: "Aktivitas Bulanan", description: "Monthly Active Users (MAU) konsisten bertransaksi" }
    ],
    challenge: "Generasi muda menganggap perbankan konvensional kaku, membosankan, dan sulit dipahami, sementara mereka membutuhkan alat menabung yang fleksibel dan interaktif.",
    solution: "Merancang pengalaman perbankan bertema gamifikasi ('Smart Vaults' & 'Round-up Investing'), dengan antarmuka haptik yang memuaskan dan grafik pengeluaran kategori yang interaktif.",
    architectureHighlights: [
      "Real-time Card Freeze & Virtual CVV generation",
      "Gamified Auto-Savings Round-Up Engine",
      "Secure Biometric Passkey & Face ID authentication",
      "Micro-interactions 60 FPS menggunakan Reanimated 3"
    ],
    techStack: ["Flutter", "Dart", "Node.js", "Redis", "PostgreSQL", "Firebase Cloud Messaging", "Figma"],
    deliverables: [
      "iOS & Android Mobile App Packages",
      "Gamified Design System & Animated Micro-assets",
      "Anti-Fraud Analytics Integration",
      "Brand Launch Strategy & Interactive Marketing Webpage"
    ],
    clientReview: {
      quote: "Kerja sama dengan NEXORA adalah investasi terbaik kami. Desain aplikasi yang mereka buat viral di media sosial dan menghemat budget akuisisi user hingga 50%.",
      author: "Reza Pratama",
      role: "Co-Founder & Chief Product Officer",
      company: "Kura Neobank",
      avatar: "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80"
    },
    links: {
      demo: "https://example.com/kura-bank",
      figma: "https://figma.com/@nexora-kura"
    }
  }
];
