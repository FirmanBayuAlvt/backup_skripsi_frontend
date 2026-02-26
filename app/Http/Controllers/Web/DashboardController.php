<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendApiService;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $apiService;

    public function __construct(BackendApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        return view('dashboard');
    }

    public function getOverviewData()
    {
        try {
            $response = $this->apiService->get('/api/dashboard/overview');
            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching dashboard overview: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data dashboard',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackData()
            ], 500);
        }
    }

    public function getPenAnalytics()
    {
        try {
            $response = $this->apiService->get('/api/dashboard/pen-analytics');
            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching pen analytics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat analisis kandang',
                'error' => $e->getMessage(),
                'data' => ['pens' => []]
            ], 500);
        }
    }

    public function getPredictionHistory()
    {
        try {
            $response = $this->apiService->get('/api/predictions/history');
            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching prediction history: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat riwayat prediksi',
                'error' => $e->getMessage(),
                'data' => ['predictions' => []]
            ], 500);
        }
    }

    private function getFallbackData()
    {
        return [
            'overview' => [
                'total_livestock' => 0,
                'total_pens' => 0,
                'total_feed_types' => 0,
                'recent_weight_gain_kg' => 0,
                'monthly_feed_cost' => 0,
                'average_daily_gain' => 0,
                'feed_efficiency' => 0,
                'occupancy_rate' => 0,
                'mortality_rate' => 0
            ],
            'alerts' => [
                [
                    'severity' => 'info',
                    'message' => 'Sistem dalam pemeliharaan',
                    'suggestion' => 'Data akan tersedia kembali sebentar lagi'
                ]
            ],
            'recent_activity' => [
                'recent_livestocks' => [],
                'recent_feedings' => []
            ]
        ];
    }
}
