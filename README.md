# 📊 Survey-as-a-Service Core System (SurveyCore) - Manual Teknis & Arsitektur Terperinci

![SurveyCore Technical Header](https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=2070)

**SurveyCore** adalah platform infrastruktur survei terpusat tingkat enterprise yang dibangun untuk menangani beban operasional pemerintahan (Government-as-a-Platform). Sistem ini memberikan isolasi data instansi yang mutlak, pengolahan bahasa alami (NLP) melalui AI, serta ekosistem integrasi "Headless" untuk aplikasi pihak ketiga.

---

## 🏗️ 1. Arsitektur Komputasi & Keamanan (Architecture Deep Dive)

### A. Lapisan Perangkat Lunak (Software Layers)
1.  **Core Framework**: Laravel 12.0 (PHP 8.3+) dengan optimasi cache/Opcache.
2.  **Logic Layer**: Mengimplementasikan **Service-Repository Pattern**.
    - `Services/`: Menangani logika bisnis (misal: perhitungan skor IKM, validasi kuota).
    - `Repositories/`: Mengisolasi query ke database agar data akses layer tetap modular.
3.  **Data Isolation (True Multi-Tenancy)**:
    - Menggunakan **Eloquent Global Scopes**. Setiap model (Survey, Response, dsb.) secara otomatis memfilter data berdasarkan `tenant_id` dari user yang terautentikasi.
    - Menjamin tidak ada kebocoran data (*Data Leakage*) antar-instansi/organisasi.
4.  **UI Engine**: Filament v3 (TALL Stack). Memberikan antarmuka admin yang sepenuhnya reaktif melalui Livewire dan Alpine.js.

### B. Kerangka Keamanan (Security Framework)
- **HMAC Signature Verification**: API tingkat tinggi dilindungi oleh tanda tangan digital (HMAC-SHA256) untuk memastikan integritas pesan.
- **Nonce & Anti-Replay**: Menggunakan Redis untuk memvalidasi `nonce` setiap request API guna mencegah serangan *Replay Attack*.
- **Rate Limiting**: Throttling per-Client ID untuk mencegah banjir trafik (DDoS) pada endpoint pengiriman respons.
- **Content Security Policy (CSP)**: Implementasi header keamanan ketat untuk mencegah XSS dan Frame Injection.

---

## 🗄️ 2. Katalog Domain & Database (Domain Knowledge)

Skema database dirancang secara normalisasi tinggi untuk konsistensi data:

### i. Domain Identitas & Akses
- `tenants`: Basis data workspace instansi (Dinas/Unit).
- `users`, `roles`, `permissions`: Implementasi RBAC dengan tingkat presisi kolom.

### ii. Domain Survey Engine (Dynamic Structure)
- `surveys`: Induk survei dengan kontrol status (Draft, Active, Closed).
- `survey_sections`: Memungkinkan survei multi-halaman.
- `questions`: Mendukung tipe data: `standard`, `rating`, `multiple_choice`, `matrix`.
- `question_logic`: Menyimpan aturan lompatan (Branching) berbasis jawaban sebelumnya.

### iii. Domain Respons & Analitik
- `survey_responses`: Metadata teknis (User Agent, IP, Duration).
- `response_answers`: Penyimpanan jawaban atomik (per pertanyaan).
- `survey_statistics`: Tabel agregasi untuk pembacaan dashboard cepat (Read-Optimized).

### iv. Domain AI & Intelligence
- `ai_sentiment_analysis`: Output NLP untuk mendeteksi emosi warga.
- `ai_insights`: Generasi rekomendasi naratif berbasis data agregat.
- `ai_chat_conversations`: RIwayat dialog AI-Human untuk analisis interaktif.

---

## � 3. Bedah Operasional Modul Admin (19 Modul)

| Kelompok | Nama Modul | Logika Bisnis & Detail Views |
| :--- | :--- | :--- |
| **1-UTAMA** | **Konfigurasi Instansi** | Manajemen siklus hidup Tenant. Mendukung pengaturan batas kuota respons per-instansi. |
| | **Manajemen Pengguna** | Dashboard kontrol akun. Admin Pusat dapat melakukan "Impersonate" untuk membantu konfigurasi instansi. |
| **2-DESAIN** | **Template Survei** | Library master kuesioner. Perubahan pada template master tidak akan merusak data survei yang sudah berjalan (Versioning Support). |
| | **Tema Visual** | Editor CSS dinamis. Menyediakan preview warna primer/sekunder langsung pada panel. |
| **3-OPERASIONAL**| **Daftar Survei** | View manajemen survei dengan sistem Wizard (Step-by-step). Dilengkapi tombol **"Integrasi API"** untuk melihat panduan teknis per-survei. |
| | **Hasil Jawaban** | Viewer tabel reaktif dengan filter canggih. Admin bisa melihat detil jawaban warga dalam hitungan detik. |
| **4-ANALISIS AI** | **Statistik Data** | Visualisasi tren kepuasan (NPS/IKM). Menampilkan titik *Drop-off* (di mana warga sering berhenti mengisi). |
| | **Insight AI** | Pipeline AI yang membaca anomali dan tren, memberikan ringkasan seperti: *"Tren kepuasan menurun di unit A akibat waktu tunggu."* |
| | **Analisis Sentimen** | Klasifikasi otomatis teks esai menjadi data numerik untuk kemudahan filtering masal. |
| | **Tanya AI (Chat)** | Antarmuka Natural Language Query. Memungkinkan pengambilan data tanpa butuh skill IT. |
| **5-KONEKTIVITAS**| **Aplikasi Luar** | Manajemen aplikasi Client via OAuth2. Memberikan kontrol penuh atas siapa yang boleh menarik data. |
| | **Kunci Akses** | Rotasi API Key (Secret). Mekanisme keamanan untuk akses server-ke-server. |
| | **Webhook** | Konfigurasi URL Callback. Payload dikirim dalam format JSON terstandarisasi. |
| **6-KEAMANAN** | **Log Audit** | Mencatat aktivitas CRUD di level model. Memberikan transparansi mutlak atas tindakan administrator. |
| | **Persetujuan** | Logging legalitas pengumpulan data (Consent). Penting untuk kepatuhan hukum di level internasional. |

---

## 🔌 4. Manual Integrasi API untuk Developer (Exhaustive Guide)

Sistem ini didesain agar integrasi dapat dilakukan dalam waktu kurang dari 1 jam.

### Step 1: Autentikasi OAuth2
Dapatkan Token Akses menggunakan Client Credentials:
```bash
curl -X POST /oauth/token \
  -F "grant_type=client_credentials" \
  -F "client_id=ID" \
  -F "client_secret=SECRET"
```

### Step 2: Mengambil Skema Survei (GET)
Endpoint: `GET /api/v1/surveys/{uuid}`
- **Logika**: Mengembalikan JSON yang berisi seluruh pertanyaan, opsi, dan tema visual terkait. Developer cukup melakukan *looping* pada JSON ini untuk merender tampilan di aplikasi mobile/web mereka.

### Step 3: Pengiriman Jawaban (POST)
Endpoint: `POST /api/v1/surveys/{uuid}/submit`
- **Header Keamanan (Wajib)**:
  - `X-API-Key`: API Key Anda.
  - `X-Timestamp`: Unix timestamp saat ini.
  - `X-Signature`: HMAC(sha256, payload, secret).
- **Body JSON**:
```json
{
  "respondent_id": "unique-id-warga",
  "device_info": { "os": "Android", "model": "Pixel 8" },
  "answers": [
    { "question_id": 50, "value": "Sangat Puas" },
    { "question_id": 51, "value": "Petugas ramah dan sopan" }
  ]
}
```

---

## 🧠 5. Pipeline Analitik & AI (The Intelligence Core)

Sistem AI tidak berjalan di thread utama (Main Thread) agar akses user tidak lambat:
1.  **Entry**: Jawaban masuk via API/Web.
2.  **Queue**: Laravel Jobs memasukkan data respons ke dalam antrean.
3.  **Process**: Worker mengambil data teks, mengirimkannya ke mesin NLP AI.
4.  **Enrich**: Tabel `ai_sentiment_analysis` diisi dengan skor emosi.
5.  **Audit**: `SurveyResponseObserver` secara otomatis mencatatkan event pemicu ke log integrasi.

---

## 🛠️ 6. Panduan Maintenance & Pengembangan

### Perintah Penting (Ops):
- **Reset & Seed (Demo Power)**:
  `php artisan migrate:fresh --seed` (Menciptakan 10 Instansi & ratusan data demo).
- **Update Filament Cache**:
  `php artisan filament:upgrade`.
- **Monitor Queue**:
  `php artisan queue:work` (Pastikan worker berjalan untuk pemrosesan AI & Webhook).

### Pengembangan Mendatang (Roadmap):
- Modul GIS (Geographic Information System) untuk memetakan kepuasan per-wilayah.
- Integrasi biometrik melalui API khusus verifikasi warga.

---
**SurveyCore terus berkembang sebagai standar infrastruktur survei yang andal, aman, dan cerdas.**

---
**Developed with ❤️ by the SurveyCore Engineering Team.**
