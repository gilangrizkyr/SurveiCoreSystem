<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PublicStatsController extends Controller
{
    /**
     * Get public platform statistics
     */
    public function index(): JsonResponse
    {
        $stats = Cache::remember('public_stats', 300, function () {
            return [
            'total_surveys' => Survey::where('type', 'public')
            ->where('status', 'active')
            ->count(),

            'total_responses' => SurveyResponse::whereHas('survey', function ($query) {
                    $query->where('type', 'public');
                }
                )->count(),

                'total_organizations' => Tenant::where('status', 'active')->count(),

                'active_surveys' => Survey::where('type', 'public')
                ->where('status', 'active')
                ->whereDate('starts_at', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('ends_at')
                        ->orWhereDate('ends_at', '>=', now());
                }
                )
                ->count(),

                'response_rate' => $this->calculateResponseRate(),

                'monthly_responses' => $this->getMonthlyResponses(),

                'popular_surveys' => $this->getPopularSurveys(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get chatbot response with real data
     */
    public function chatbot(Request $request): JsonResponse
    {
        $message = strtolower(trim($request->input('message', '')));
        $response = '';

        // Berapa survei
        if (str_contains($message, 'berapa') && (str_contains($message, 'survei') || str_contains($message, 'survey'))) {
            $count = Survey::where('type', 'public')->where('status', 'active')->count();
            $response = "Saat ini ada **{$count} survei publik aktif** di platform kami yang bisa Anda ikuti!";
        }
        // Total respons
        elseif (str_contains($message, 'respons') || str_contains($message, 'response')) {
            $count = SurveyResponse::count();
            $response = "Platform kami telah mengumpulkan **{$count} respons** dari berbagai survei!";
        }
        // Organisasi
        elseif (str_contains($message, 'organisasi') || str_contains($message, 'instansi')) {
            $count = Tenant::where('status', 'active')->count();
            $response = "Kami melayani **{$count} organisasi/instansi** yang menggunakan platform survei kami.";
        }
        // Survei populer
        elseif (str_contains($message, 'populer') || str_contains($message, 'terpopuler')) {
            $surveys = Survey::where('type', 'public')
                ->where('status', 'active')
                ->withCount('responses')
                ->orderBy('responses_count', 'desc')
                ->take(3)
                ->get(['title', 'responses_count']);

            if ($surveys->count() > 0) {
                $list = $surveys->map(fn($s) => "• {$s->title} ({$s->responses_count} respons)")->join("\n");
                $response = "**Survei paling populer:**\n{$list}";
            }
            else {
                $response = "Belum ada survei publik yang tersedia saat ini.";
            }
        }
        // Cara ikut survei
        elseif (str_contains($message, 'ikut') || str_contains($message, 'partisipasi')) {
            $response = "Untuk mengikuti survei:\n1. Klik menu **'Survei Publik'**\n2. Pilih survei yang ingin Anda ikuti\n3. Isi pertanyaan dengan jujur\n4. Kirim respons Anda\n\nSemua data Anda terjaga kerahasiaannya! 🔒";
        }
        // API
        elseif (str_contains($message, 'api')) {
            $response = "Platform kami menyediakan **RESTful API v1** lengkap dengan:\n• JWT Authentication\n• API Key Management\n• HMAC Request Signing\n• Rate Limiting\n\nKunjungi **/api/v1** untuk dokumentasi lengkap!";
        }
        // Keamanan
        elseif (str_contains($message, 'aman') || str_contains($message, 'security') || str_contains($message, 'keamanan')) {
            $response = "Keamanan data Anda adalah prioritas kami! 🔐\n\n• Enkripsi end-to-end\n• OWASP Top 10 compliant\n• Multi-factor authentication\n• IP whitelisting\n• Audit logging lengkap";
        }
        // Default
        else {
            $response = "Halo! Saya bisa membantu Anda dengan:\n• Informasi jumlah survei aktif\n• Statistik platform\n• Cara ikut survei\n• Informasi API\n• Keamanan data\n\nSilakan tanya apa saja! 😊";
        }

        return response()->json([
            'success' => true,
            'message' => $response,
        ]);
    }

    /**
     * Calculate average response rate
     */
    private function calculateResponseRate(): float
    {
        $surveys = Survey::where('type', 'public')
            ->where('status', 'active')
            ->withCount('responses')
            ->get();

        if ($surveys->count() === 0) {
            return 0;
        }

        $avgResponses = $surveys->avg('responses_count');
        return round($avgResponses, 2);
    }

    /**
     * Get monthly responses for chart
     */
    private function getMonthlyResponses(): array
    {
        return SurveyResponse::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    /**
     * Get popular public surveys
     */
    private function getPopularSurveys(): array
    {
        return Survey::where('type', 'public')
            ->where('status', 'active')
            ->withCount('responses')
            ->orderBy('responses_count', 'desc')
            ->take(5)
            ->get(['uuid', 'title', 'responses_count'])
            ->toArray();
    }
}