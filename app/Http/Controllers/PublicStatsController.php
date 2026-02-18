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
            'total_surveys' => Survey::where('status', 'active')->count(),
            'total_responses' => SurveyResponse::count(),
            'total_organizations' => Tenant::where('status', 'active')->count(),
            'active_surveys' => Survey::where('status', 'active')
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
                'active_tenants' => Survey::where('status', 'active')
                ->whereNotNull('source_app_name')
                ->distinct()
                ->take(10)
                ->pluck('source_app_name')
                ->map(fn($name) => ['name' => $name])
                ->toArray(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get chatbot response with real data and AI intelligence
     */
    public function chatbot(Request $request, \App\Services\AiChatService $aiService): JsonResponse
    {
        $message = $request->input('message', '');

        // 1. Ambil data real-time untuk konteks AI
        $statsContext = [
            'total_surveys' => Survey::where('status', 'active')->count(),
            'total_responses' => SurveyResponse::count(),
            'total_organizations' => Tenant::where('status', 'active')->count(),
            'popular_surveys' => Survey::where('type', 'public')
            ->where('status', 'active')
            ->withCount('responses')
            ->orderBy('responses_count', 'desc')
            ->take(3)
            ->pluck('title')
            ->toArray()
        ];

        // 2. Bungkus pesan dengan konteks data agar AI tahu statistik terbaru
        $contextualMessage = "DATA PLATFORM SAAT INI:\n";
        $contextualMessage .= "- Total Survei Aktif: {$statsContext['total_surveys']}\n";
        $contextualMessage .= "- Total Jawaban Masuk: {$statsContext['total_responses']}\n";
        $contextualMessage .= "- Total Instansi: {$statsContext['total_organizations']}\n";
        $contextualMessage .= "- Survei Populer: " . implode(', ', $statsContext['popular_surveys']) . "\n\n";
        $contextualMessage .= "PERTANYAAN USER: " . $message;

        // 3. Dapatkan jawaban dari AI Service (Gemini atau Fallback Smart Simulator)
        $aiResponse = $aiService->getResponse($contextualMessage);

        return response()->json([
            'success' => true,
            'message' => $aiResponse,
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