<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Survey;
use App\Models\SurveySection;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\SurveyResponse;
use App\Models\ResponseAnswer;
use App\Models\ApiClient;
use App\Models\Integration;
use App\Models\AuditLog;
use App\Models\SurveyStatistic;
use App\Models\SurveyTemplate;
use App\Models\SurveyTheme;
use App\Models\AiInsight;
use App\Models\AiSentimentAnalysis;
use App\Models\AiChatConversation;
use App\Models\ApiKey;
use App\Models\Webhook;
use App\Models\ApiUsageLog;
use App\Models\WebhookLog;
use App\Models\ConsentRecord;
use App\Models\DataRetentionPolicy;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create 10 Realistic Tenants (Indonesian Institutions)
        $tenantsData = [
            ['name' => 'Dinas Pendidikan Jawa Barat', 'slug' => 'disdik-jabar'],
            ['name' => 'Dinas Kesehatan Kota Bandung', 'slug' => 'dinkes-bandung'],
            ['name' => 'Diskominfo Prov. Jawa Barat', 'slug' => 'diskominfo-jabar'],
            ['name' => 'RSUD Al-Ihsan Bandung', 'slug' => 'rsud-alihsan'],
            ['name' => 'Bappeda Jawa Barat', 'slug' => 'bappeda-jabar'],
            ['name' => 'Dinas Sosial Kota Cimahi', 'slug' => 'dinsos-cimahi'],
            ['name' => 'DPMPTSP Kab. Bandung', 'slug' => 'dpmptsp-kabbdg'],
            ['name' => 'Dinas Pariwisata Jabar', 'slug' => 'dispar-jabar'],
            ['name' => 'Universitas Indonesia', 'slug' => 'ui-depok'],
            ['name' => 'Kantor Gubernur Jabar', 'slug' => 'humas-jabar'],
        ];

        $tenantModels = [];
        foreach ($tenantsData as $data) {
            $tenantModels[] = Tenant::updateOrCreate(
            ['slug' => $data['slug']],
            [
                'uuid' => (string)Str::uuid(),
                'name' => $data['name'],
                'status' => 'active',
            ]
            );
        }

        // 2. Realistic Survey Contexts & Apps
        $surveyContexts = [
            [
                'title' => 'Evaluasi Pembelajaran Jarak Jauh 2024',
                'app_name' => 'Portal Belajar Jabar',
                'app_url' => 'https://belajar.jabarprov.go.id',
                'context' => 'Embed di dashboard siswa dan guru untuk evaluasi kurikulum setiap semester.',
            ],
            [
                'title' => 'Indeks Kepuasan Masyarakat (IKM) Pelayanan Perizinan',
                'app_name' => 'Aplikasi SiPinter',
                'app_url' => 'https://sipinter.bandung.go.id',
                'context' => 'Muncul otomatis setelah perizinan disetujui. Data ditarik via API untuk laporan IKM bulanan ke Walikota.',
            ],
            [
                'title' => 'Survei Kesiapan Vaksinasi Booster Tahap 3',
                'app_name' => 'Sistem Informasi Kesehatan (SIK)',
                'app_url' => 'https://sik.bandung.go.id',
                'context' => 'Kuesioner pra-pendaftaran vaksinasi. Digunakan untuk screening awal kesehatan masyarakat.',
            ],
            [
                'title' => 'Opini Publik Terhadap Pembangunan Flyover',
                'app_name' => 'Website Resmi Jabar',
                'app_url' => 'https://jabarprov.go.id/polling',
                'context' => 'Poling terbuka di homepage website pemprov untuk menjaring aspirasi warga terkait infrastruktur.',
            ],
            [
                'title' => 'Evaluasi Kinerja ASN Pemerintah Daerah',
                'app_name' => 'SIM-ASN Jabar',
                'app_url' => 'https://sim.bkd.jabarprov.go.id',
                'context' => 'Survei internal (Private). Dibagikan melalui broadcast WhatsApp internal BKD.',
            ],
            [
                'title' => 'Survei Kebutuhan Pelatihan UMKM Digital',
                'app_name' => 'Marketplace Lokal Cimahi',
                'app_url' => 'https://umkm.cimahi.go.id',
                'context' => 'Muncul di dashboard seller. Digunakan untuk menentukan silabus pelatihan digital dinas.',
            ],
            [
                'title' => 'Penilaian Fasilitas Ruang Publik Kota',
                'app_name' => 'Aplikasi Sapa Warga',
                'app_url' => 'https://sapawarga.jabarprov.go.id',
                'context' => 'Integrasi via Webhook. Laporan otomatis masuk ke tim teknis perbaikan fasilitas umum.',
            ],
            [
                'title' => 'Survei Penggunaan Transportasi Umum',
                'app_name' => 'Aplikasi TMB Mobile',
                'app_url' => 'https://tmb.bandung.go.id',
                'context' => 'Polling di aplikasi mobile setelah penumpang selesai melakukan perjalanan.',
            ],
            [
                'title' => 'Feedback Pasca Rawat Jalan Pasien RSUD',
                'app_name' => 'Sistem Antrean RSUD',
                'app_url' => 'https://antrean.alihsan.id',
                'context' => 'SMS/Email broadcast otomatis setelah status pasien dinyatakan selesai rawat.',
            ],
            [
                'title' => 'Polling Efektivitas Penyaluran Bansos',
                'app_name' => 'Sistem Logistik SosJabar',
                'app_url' => 'https://bansos.jabarprov.go.id',
                'context' => 'Verifikasi penerima manfaat. Data digunakan untuk audit internal penyaluran bantuan.',
            ],
        ];

        $superAdmin = User::where('email', 'superadmin@survei.test')->first();
        if (!$superAdmin) {
            $superAdmin = User::create([
                'uuid' => (string)Str::uuid(),
                'name' => 'Super Administrator',
                'email' => 'superadmin@survei.test',
                'password' => Hash::make('Password123!'),
            ]);
        }

        // Add 5 more dummy users
        $dummyUsers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@jabarprov.go.id'],
            ['name' => 'Siti Aminah', 'email' => 'siti@bandung.go.id'],
            ['name' => 'Asep Surasep', 'email' => 'asep@cimahi.go.id'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@pelayanan.test'],
            ['name' => 'Randi Pangalila', 'email' => 'randi@analisis.test'],
        ];

        foreach ($dummyUsers as $uData) {
            User::updateOrCreate(
            ['email' => $uData['email']],
            [
                'uuid' => (string)Str::uuid(),
                'name' => $uData['name'],
                'password' => Hash::make('Password123!'),
            ]
            );
        }

        foreach ($tenantModels as $index => $tenant) {
            if (!isset($surveyContexts[$index]))
                continue;

            $ctx = $surveyContexts[$index];
            $survey = Survey::create([
                'uuid' => (string)Str::uuid(),
                'tenant_id' => $tenant->id,
                'creator_id' => $superAdmin->id,
                'title' => $ctx['title'],
                'source_app_name' => $ctx['app_name'],
                'source_app_url' => $ctx['app_url'],
                'usage_context' => $ctx['context'],
                'description' => "Survei ini bertujuan untuk mendapatkan data akurat mengenai " . strtolower($ctx['title']) . " guna meningkatkan kualitas layanan publik.",
                'welcome_message' => "Selamat datang di Survei Layanan Publik. Mohon luangkan waktu Anda sebentar.",
                'thank_you_message' => "Terima kasih atas partisipasi Anda. Pendapat Anda sangat berarti bagi kami.",
                'status' => 'active',
                'type' => 'public',
                'starts_at' => now()->subDays(10),
                'ends_at' => now()->addDays(20),
            ]);

            // Create 2 sections
            $sectionsData = [
                ['title' => 'Identitas & Demografi', 'order' => 1],
                ['title' => 'Feedback Utama', 'order' => 2],
            ];

            foreach ($sectionsData as $sItem) {
                $section = SurveySection::create([
                    'survey_id' => $survey->id,
                    'title' => $sItem['title'],
                    'order' => $sItem['order'],
                ]);

                if ($sItem['order'] == 1) {
                    $q1 = Question::create([
                        'section_id' => $section->id,
                        'type' => 'multiple_choice',
                        'title' => 'Kelompok Usia Anda',
                        'is_required' => true,
                        'order' => 1,
                    ]);
                    $ageOptions = ['< 20 tahun', '21 - 35 tahun', '36 - 50 tahun', '> 50 tahun'];
                    foreach ($ageOptions as $oIdx => $label) {
                        QuestionOption::create(['question_id' => $q1->id, 'label' => $label, 'value' => $label, 'order' => $oIdx]);
                    }

                    $q2 = Question::create([
                        'section_id' => $section->id,
                        'type' => 'short_text',
                        'title' => 'Pekerjaan Saat Ini',
                        'is_required' => false,
                        'order' => 2,
                    ]);
                }
                else {
                    $q3 = Question::create([
                        'section_id' => $section->id,
                        'type' => 'rating',
                        'title' => 'Seberapa puas Anda dengan layanan kami?',
                        'is_required' => true,
                        'order' => 1,
                    ]);

                    $q4 = Question::create([
                        'section_id' => $section->id,
                        'type' => 'long_text',
                        'title' => 'Kritik dan Saran untuk perbaikan ke depan',
                        'is_required' => false,
                        'order' => 2,
                    ]);
                }
            }

            $survey->load('sections.questions.options');

            // 3. Responses
            for ($r = 0; $r < 5; $r++) {
                $response = SurveyResponse::create([
                    'uuid' => (string)Str::uuid(),
                    'survey_id' => $survey->id,
                    'status' => 'completed',
                    'started_at' => now()->subDays(rand(1, 9))->subMinutes(rand(10, 60)),
                    'submitted_at' => now()->subDays(rand(1, 9)),
                    'completion_time_seconds' => rand(120, 600),
                    'ip_address' => '192.168.1.' . rand(1, 254),
                    'device_type' => collect(['desktop', 'mobile', 'tablet'])->random(),
                    'user_agent' => 'Mozilla/5.0 (Realistic Dummy Data)',
                ]);

                foreach ($survey->sections as $sec) {
                    foreach ($sec->questions as $ques) {
                        $answer = [
                            'response_id' => $response->id,
                            'question_id' => $ques->id,
                        ];

                        if ($ques->type == 'multiple_choice') {
                            $opt = @$ques->options->random();
                            if ($opt) {
                                $answer['option_id'] = $opt->id;
                                $answer['answer_text'] = $opt->label;
                            }
                        }
                        elseif ($ques->type == 'short_text') {
                            $answer['answer_text'] = collect(['PNS', 'Karyawan Swasta', 'Wiraswasta', 'Mahasiswa', 'Buruh'])->random();
                        }
                        elseif ($ques->type == 'rating') {
                            $answer['answer_numeric'] = rand(3, 5);
                        }
                        else {
                            $answer['answer_text'] = "Layanan sangat " . collect(['bagus', 'cepat', 'membantu', 'baik'])->random() . ", mohon dipertahankan.";
                        }
                        $respAnswer = ResponseAnswer::create($answer);

                        // 4. AI Sentiment Analysis (Per Answer)
                        if ($ques->type == 'long_text') {
                            AiSentimentAnalysis::create([
                                'response_id' => $response->id,
                                'question_id' => $ques->id,
                                'answer_id' => $respAnswer->id,
                                'text_content' => $respAnswer->answer_text,
                                'sentiment' => collect(['positive', 'neutral', 'negative'])->random(),
                                'confidence_score' => rand(70, 99) / 100,
                                'emotion' => collect(['joy', 'neutral', 'surprise'])->random(),
                            ]);
                        }
                    }
                }

                // 5. Consent Records
                ConsentRecord::create([
                    'survey_id' => $survey->id,
                    'response_id' => $response->id,
                    'consent_type' => 'data_processing',
                    'given' => true,
                    'ip_address' => $response->ip_address,
                    'user_agent' => $response->user_agent,
                ]);
            }

            SurveyStatistic::create([
                'survey_id' => $survey->id,
                'total_views' => 100 + rand(10, 50),
                'total_started' => 70 + rand(5, 20),
                'total_completed' => 5,
                'completion_rate' => 21.4,
                'avg_completion_time' => 350.5,
                'last_calculated_at' => now(),
            ]);

            AuditLog::create([
                'tenant_id' => $tenant->id,
                'user_id' => $superAdmin->id,
                'action' => 'create',
                'model_type' => Survey::class ,
                'model_id' => $survey->id,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'new_values' => json_encode(['title' => $survey->title]),
            ]);

            // 6. API & Integrations
            $apiClient = ApiClient::create([
                'uuid' => (string)Str::uuid(),
                'tenant_id' => $tenant->id,
                'name' => 'Aplikasi Internal - ' . $tenant->name,
                'client_id' => (string)Str::random(16),
                'client_secret' => Hash::make('secret123'),
                'status' => 'active',
            ]);

            $apiKey = ApiKey::create([
                'client_id' => $apiClient->id,
                'key' => 'sk_' . Str::random(32),
                'secret' => Str::random(32),
                'name' => 'Key Produksi',
                'last_used_at' => now(),
            ]);

            $integrationTypes = ['slack', 'zapier', 'sheets', 'email', 'sms'];
            Integration::create([
                'tenant_id' => $tenant->id,
                'type' => $integrationTypes[rand(0, 4)],
                'settings' => json_encode(['webhook_url' => 'https://hooks.external.com/' . Str::random(8)]),
                'is_active' => true,
            ]);

            // 7. Webhooks
            $webhook = Webhook::create([
                'tenant_id' => $tenant->id,
                'survey_id' => $survey->id,
                'url' => 'https://api.external-system.test/callback',
                'events' => json_encode(['survey.completed']),
                'secret' => Str::random(16),
                'is_active' => true,
            ]);

            WebhookLog::create([
                'webhook_id' => $webhook->id,
                'event' => 'survey.completed',
                'payload' => json_encode(['survey_id' => $survey->id]),
                'status_code' => 200,
                'delivered_at' => now(),
            ]);

            // 8. AI Insights
            AiInsight::create([
                'survey_id' => $survey->id,
                'insight_type' => 'summary',
                'title' => 'Ringkasan Kepuasan Layanan',
                'description' => "Mayoritas responden merasa puas dengan kecepatan layanan, namun mencatat perlunya perbaikan pada fasilitas fisik.",
                'confidence_score' => 0.92,
            ]);

            // 9. AI Chat Conversations
            AiChatConversation::create([
                'tenant_id' => $tenant->id,
                'user_id' => $superAdmin->id,
                'session_id' => Str::random(10),
                'message' => 'Apa keluhan utama dari masyarakat bulan ini?',
                'response' => 'Keluhan utama adalah mengenai waktu tunggu di pagi hari antara jam 08:00 - 10:00.',
                'intent' => 'complaint_analysis',
            ]);

            // 10. Compliance
            DataRetentionPolicy::create([
                'tenant_id' => $tenant->id,
                'data_type' => 'survey_responses',
                'retention_days' => 730,
                'auto_delete' => false,
            ]);

            // 11. API Usage Log
            ApiUsageLog::create([
                'client_id' => $apiClient->id,
                'api_key_id' => $apiKey->id,
                'endpoint' => '/api/v1/surveys/' . $survey->uuid,
                'method' => 'GET',
                'status_code' => 200,
                'response_time' => rand(50, 200),
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Internal-App/1.0',
            ]);
        }

        // 12. Global Templates & Themes
        SurveyTemplate::create([
            'tenant_id' => $tenantModels[0]->id,
            'name' => 'Template Standar IKM',
            'category' => 'Layanan Publik',
            'description' => 'Template sesuai Permenpan-RB nomor 14 tahun 2017.',
            'structure' => json_encode(['sections' => [['title' => 'Pertanyaan IKM']]]),
            'is_public' => true,
        ]);

        SurveyTheme::create([
            'tenant_id' => $tenantModels[0]->id,
            'name' => 'Tema Modern Biru',
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'font_family' => 'Inter, sans-serif',
        ]);
    }
}