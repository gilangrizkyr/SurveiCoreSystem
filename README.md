# 📊 Survey-as-a-Service Core System (SurveyCore)

![SurveyCore Technical Banner](https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=2070)

**SurveyCore** adalah platform infrastruktur survei kelas komputasi awan (SaaS) yang dirancang untuk kebutuhan integrasi tingkat tinggi, skalabilitas data masif, dan analisis cerdas berbasis AI. Dokumen ini merincikan aspek teknis, logika bisnis, dan struktur sistem secara mendalam.

---

## 🏛️ Arsitektur Sistem (Technical Design)

### 1. Pola Arsitektur
Sistem ini mengadopsi pola **Service-Repository** dan **DTO (Data Transfer Objects)** untuk memastikan kode yang bersih (*Clean Code*), testable, dan mudah dirawat. Logika validasi dipindahkan ke FormRequests atau DTO untuk memastikan integritas data dari API hingga Database.

### 2. Multi-Tenant Isolation
Platform ini dibangun dengan arsitektur **Shared Database, Shared Schema**. 
- **Logika**: Setiap baris data dalam tabel operasional (Survei, Respons, API, Log) memiliki kunci `tenant_id`.
- **Filtering**: Menggunakan *Global Scoping* pada Model Laravel untuk memastikan pengguna dari Instansi A tidak akan pernah bisa melihat data Instansi B.
- **Isolasi UI**: Admin Panel menyesuaikan konten halaman berdasarkan asosiasi tenant pengguna yang sedang login.

### 3. API-First Design
SurveyCore bukan sekadar aplikasi web, melainkan sebuah **API Provider**. 
- **OAuth2 Implementation**: Menggunakan **Laravel Passport** untuk autentikasi sistem-ke-sistem yang aman.
- **Hiding Internal Logic**: Objek internal ditransformasikan melalui *API Resources* untuk mengamankan kebocoran data sensitif.

---

## 💻 Tech Stack & Library Utama

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Framework Utama** | Laravel 12 | Memanfaatkan fitur terbaru PHP 8.3+ (Readonly properties, Typed classes). |
| **Admin Interface** | Filament v3 | Framework TALL (Tailwind, Alpine, Laravel, Livewire) untuk UI yang reaktif. |
| **Autentikasi API** | Laravel Passport | Implementasi OAuth2 Client/Secret untuk sistem pihak ketiga. |
| **AI Processing** | OpenAI/Gemini Integration | Digunakan untuk Sentiment Analysis dan NLP Insight Extraction. |
| **Data Visualization** | Chart.js & ApexCharts | Untuk Dashboard dan Statistik Operasional. |
| **Keamanan** | Laravel Sanctum & CSP | Proteksi berlapis terhadap XSS, CSRF, dan injeksi data. |
| **Versi DB** | MySQL 8.0 / PostgreSQL | Mendukung optimasi JSON Column untuk struktur survei dinamis. |

---

## 🗄️ Struktur Database & Logika Data

### Skema Database Utama (40+ Tabel)
1.  **Core Tables**: `tenants`, `users`, `roles`, `permissions` (Manajemen hak akses & multi-tenant).
2.  **Survey Engine**: `surveys`, `survey_sections`, `questions`, `question_options`, `question_logic` (Penyimpanan dinamis struktur kuesioner).
3.  **Response Engine**: `survey_responses`, `response_answers`, `response_analytics` (Penyimpanan meta-data input responden).
4.  **AI Module**: `ai_insights`, `ai_sentiment_analysis`, `ai_chat_conversations`, `ai_anomaly_detection`.
5.  **Connectivity Module**: `api_clients`, `api_keys`, `webhooks`, `webhook_logs`.
6.  **Compliance & Log**: `audit_logs`, `api_usage_logs`, `consent_records`, `data_retention_policies`.

---

## 🚀 Fitur & Modul Detail (Functional Breakdown)

### 1. Kelompok UTAMA (Identity & Access)
- **Konfigurasi Instansi (`TenantResource`)**: Mengelola "Ruang Kerja" (Workspace) setiap organisasi.
- **Manajemen Pengguna (`UserResource`)**: Pengaturan Role Admin (Super Admin vs Tenant Admin).

### 2. Kelompok DESAIN & TEMPLATE
- **Template Survei (`SurveyTemplateResource`)**: Definisi skema JSON standar untuk pertanyaan yang sering digunakan.
- **Tema Visual (`SurveyThemeResource`)**: Manajemen CSS dinamis melalui panel web untuk menyesuaikan font dan warna.

### 3. Kelompok OPERASIONAL (Survey Execution)
- **Daftar Survei (`SurveyResource`)**: Menggunakan **Wizard Interface** untuk alur pembuatan survei. Mendukung penjadwalan otomatis (`starts_at` & `ends_at`).
- **Hasil Jawaban (`SurveyResponseResource`)**: Menampilkan data mentah per responden beserta meta-data teknis (IP, Browser, Device).

### 4. Kelompok ANALISIS & AI (Intelligence Layer)
- **Statistik Data**: Aggregasi data otomatis menggunakan query SQL kompleks untuk menghitung *Completion Rate* dan *Drop-off Point*.
- **Insight AI**: Pipeline cerdas yang mengambil subset data terbaru dan mengirimkannya ke LLM (Large Language Model) guna mengekstrak poin penting tanpa intervensi manusia.
- **Analisis Sentimen**: Evaluasi real-time pada jawaban kualitatif (teks) untuk mengukur kepuasan emosional warga.
- **Tanya AI (Chat)**: Fitur RAG (Retrieval-Augmented Generation) sederhana di mana user bisa bertanya langsung pada data surveinya.

### 5. Kelompok KONEKTIVITAS (API & Automation)
- **Layanan Integrasi**: Manajemen kredensial pihak ketiga.
- **Aplikasi Luar (Client)**: Implementasi OAuth2 Client Manager.
- **Kunci Akses (Keys)**: Penyediaan API Keys yang dapat dicabut/diaktifkan kapan saja.
- **Webhook**: Sistem pengiriman payload JSON asinkron menggunakan Laravel Queue/Job.

### 6. Kelompok KEAMANAN & LOG (Governance)
- **Log Audit**: Tracker perubahan model Eloquent.
- **Consent & Retention**: Implementasi perlindungan data pribadi dengan menghapus data PII sesuai kebijakan waktu yang ditentukan.

---

## 🛠️ Alur Kerja Teknis (Workflows)

1.  **Survey Creation**: Admin menyusun Section -> Question -> Logic. Data disimpan dalam struktur relasional yang dioptimasi untuk pembacaan cepat.
2.  **Submission**: Responden mengisi data -> Validasi Server Side -> Penyimpanan asinkron untuk meta-data -> AI Sentiment Trigger (Queue).
3.  **Integration**: Data berubah -> Webhook terpicu -> Pengiriman data ke aplikasi eksternal Dinas (misal: Sapa Warga atau SiPinter).

---

## � Instalasi & Pengembangan

### Langkah Setup:
1.  **Clone & Composer Install**.
2.  **Environment Config**: Sesuaikan kredensial DB dan Passport keys.
3.  **Migration & Seeding**:
    ```bash
    php artisan migrate:fresh --seed
    ```
4.  **Passport Install**:
    ```bash
    php artisan passport:install
    ```

---
**Dokumentasi ini mencakup keseluruhan sistem SurveyCore. Untuk panduan teknis spesifik API, silakan merujuk ke file `API_DOCUMENTATION.md`.**
# SurveiCoreSystem
# SurveiCoreSystem
