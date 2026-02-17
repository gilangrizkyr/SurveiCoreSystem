# 📊 Survey-as-a-Service Core System (SurveyCore)
### *The Enterprise-Grade Infrastructure for Intelligent Data Collection & Analysis*

![SurveyCore Enterprise Header](https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=2070)

---

## 🏛️ 1. Visi & Filosofi Sistem
**SurveyCore** dikembangkan bukan sekadar sebagai aplikasi survei, melainkan sebagai **Infrastruktur Dasar (Core Infrastructure)** untuk tata kelola data di tingkat korporasi atau pemerintahan (Government-as-a-Platform). Sistem ini memungkinkan sentralisasi data survei dari berbagai titik entri (Web, Mobile, WhatsApp) ke dalam satu *Intelligence Hub* yang diamankan dengan standar protokol keamanan perbankan.

---

## 🏗️ 2. Arsitektur Teknis & Pola Desain (Software Engineering)

SurveyCore dibangun di atas prinsip **Clean Architecture** untuk memastikan skalabilitas jangka panjang dan kemudahan integrasi.

### A. Pola Desain (Logic Flow)
- **Service-Repository Pattern**: Memisahkan logika bisnis kompleks dari akses database. Hal ini menjamin kode tetap modular dan mudah dilakukan *unit testing*.
- **DTO (Data Transfer Objects)**: Memastikan aliran data antar lapisan sistem tetap terstruktur dan tervalidasi dengan ketat.
- **Global Multi-Tenant Scoping**: Setiap query database secara otomatis diproteksi oleh *Global Scopes* yang menyaring data berdasarkan identitas Instansi (`tenant_id`), memastikan **Isolasi Data Mutlak**.

### B. Arsitektur API (Headless Implementation)
Sistem ini bersifat **Headless Ready**, memungkinkan pengembang untuk menggunakan SurveyCore murni sebagai mesin API untuk:
- Merender kuesioner secara dinamis di aplikasi pihak ketiga.
- Mengumpulkan respons melalui jalur terenkripsi.
- Mengambil statistik agregat secara real-time.

---

## 🛡️ 3. Kerangka Keamanan Tingkat Tinggi (Security Framework)

SurveyCore menerapkan pertahanan berlapis (**Defense-in-Depth**) untuk melindungi integritas data layanan publik:

- **HMAC-SHA256 Signature**: Validasi integritas data pada setiap transaksi API. Menjamin data tidak dimanipulasi selama proses transmisi.
- **Redis Anti-Replay Mechanism**: Menggunakan *Memcached/Redis Nonce* untuk memblokir serangan pengulangan data (*Replay Attacks*).
- **Audit Traceability**: Setiap perubahan data sensitif dicatat oleh **Model Observers** ke dalam tabel log audit yang mencakup: *Who, When, Where (IP), and Change Delta*.
- **Security Headers & CSP**: Implementasi kebijakan keamanan browser yang ketat (XSS Protection, HSTS, Content-Security-Policy).
- **Compliance Ready (PDP/GDPR)**: Fitur built-in untuk manajemen persetujuan responden (*Consent Management*) dan kebijakan retensi data otomatis.

---

## 🧠 4. Artificial Intelligence & Analytics Suite (Gemini AI Integration)

Sistem tidak hanya mengumpulkan data, tetapi juga "memahami" data tersebut secara otomatis menggunakan **Google Gemini AI SDK**.

### A. Pipeline Pemrosesan Asinkron
Setiap respons yang masuk akan diproses secara non-blocking melalui **Laravel Queue (Redis)** untuk menjaga latensi:
1.  **Event Trigger**: `SurveyResponseObserver` mendeteksi data baru.
2.  **Job Queuing**: Dispatch `AnalyzeSentimentJob` ke background worker.
3.  **Engine Inference**: Mengirimkan konten teks ke model **Gemini 1.5 Flash/Pro** melalui REST API.
4.  **Data Extraction**: Menyimpan hasil analisis (sentiment score 0.0-1.0, emotion tags, confidence level) ke tabel `ai_sentiment_analysis`.

### B. Strategi Prompt Engineering
Kami menggunakan *Structured System Prompts* untuk memastikan output AI konsisten:
- **Role**: "Expert Data Analyst for Government Public Services".
- **Instruction**: "Analyze the following feedback for sentiment polarities and specific citizen complaints. Return strictly valid JSON."
- **Output Schema**: JSON format yang mencakup `score`, `label`, `priority_level`, dan `recommended_action`.

### C. Fitur Cerdas Utama
1.  **Sentiment Engine**: Pipeline NLP yang memberikan skor kebahagiaan (Emotions Scoring) pada setiap feedback.
2.  **Insight Extractor**: AI Generative yang merangkum ribuan baris jawaban menjadi poin rekomendasi strategis bagi pimpinan (Executive Summary).
3.  **BI Chat Interface (Natural Language Query)**: Memungkinkan eksplorasi data menggunakan bahasa alami melalui fitur Tanya AI di dashboard.
4.  **Smart Anomaly Detection**: Mendeteksi pola jawaban yang tidak wajar atau input "sampah" menggunakan Large Language Model (LLM) reasoning.

---

## � 5. Katalog Modul & Fungsionalitas (Functional Directory)

Sistem dibagi menjadi 6 kelompok strategis yang mencakup 19 modul operasional:

### I. Identitas & Akses (1-UTAMA)
- **Instansi**: Manajemen workspace dan kuota data untuk masing-masing Dinas/Unit.
- **Pengguna**: Sistem RBAC (*Role-Based Access Control*) profesional untuk segregasi tugas admin.

### II. Standardisasi (2-DESAIN & TEMPLATE)
- **Template Master**: Standardisasi kuesioner lintas instansi (Versioning Support).
- **Tema Visual**: Kontrol branding penuh untuk pengalaman pengguna yang *Seamless*.

### III. Operasional (3-OPERASIONAL SURVEI)
- **Daftar Survei**: Manajemen *life-cycle* survei (Draft, Active, Paused, Closed).
- **Struktur Modular**: Mendukung survei multi-halaman dengan logika lompatan (*Branching*).

### IV. Kecerdasan (4-ANALISIS & AI)
- **Analitik Kualitatif**: Transformasi jawaban teks menjadi data kategori berbasis AI.
- **Funnel Analysis**: Melacak titik di mana responden berhenti mengisi survei (*Conversion Tracking*).

### V. Integrasi (5-KONEKTIVITAS)
- **Client Management**: Implementasi OAuth2 untuk pendaftaran aplikasi pihak ketiga.
- **Webhook Engine**: Mekanisme *Push Notification* data ke sistem luar secara real-time.

### VI. Tata Kelola (6-KEAMANAN & LOG)
- **Data Retention**: Menjamin ketersediaan ruang penyimpanan melalui otomasi pembersihan data lama.
- **Consent Tracking**: Rekam jejak legalitas data sesuai UU Perlindungan Data Pribadi.

---

## 🔌 6. Integrasi Ekosistem (Developer Experience)

SurveyCore didesain untuk kemudahan integrasi sistem-ke-sistem:

1.  **Dapatkan Kredensial**: Melalui menu Konektivitas untuk mendapatkan `ID` & `Secret`.
2.  **Konsumsi API**:
    - **GET Schema**: Mengambil struktur survei dalam JSON terstandarisasi.
    - **POST Submit**: Pengiriman jawaban dengan proteksi Signature Digital (HMAC).
3.  **Otomasi Output**: Mendukung ekspor data reaktif ke format CSV, Excel, dan PDF secara instan.

---

## 🛠️ 7. Teknologi Serta Maintenance

### Stack Teknologi:
- **Backend**: Laravel 12.0 (PHP 8.3+)
- **Admin Panel**: Filament v3 (TALL Stack)
- **Security Logic**: HMAC-SHA256 & OAuth2
- **Database**: MySQL 8.0 Optimized JSON Columns
- **Worker**: Redis Queue for AI & Webhooks

### Pemeliharaan Berkala:
- **Scalability**: Mendukung optimasi caching via Redis untuk trafik tinggi.
- **Integrity**: Jalankan `php artisan db:seed --class=DummyDataSeeder` untuk simulasi beban data masif.

---
**SurveyCore terus berevolusi untuk memberikan standar keamanan dan intelijen data terbaik bagi organisasi Anda.**

---
**Developed with ❤️ by the SurveyCore Engineering Team.**

---
# SurveiCoreSystem
