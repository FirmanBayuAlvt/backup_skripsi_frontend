<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendApiService;
use Illuminate\Support\Facades\Log;

class PenController extends Controller
{
    protected $apiService;

    public function __construct(BackendApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        return view('pens.index', [
            'pens' => [],
            'stats' => $this->getEmptyStats()
        ]);
    }

    public function show($id)
    {
        return view('pens.show', [
            'pen' => null,
            'livestockStats' => $this->getEmptyLivestockStats(),
            'feedRequirements' => $this->getEmptyFeedRequirements()
        ]);
    }

    public function analytics($id)
    {
        return view('pens.analytics', [
            'pen' => null,
            'analytics' => $this->getEmptyAnalytics(),
            'chartData' => $this->getEmptyChartData()
        ]);
    }

    /**
     * API endpoint untuk mendapatkan data pens
     */
    public function getPensData(Request $request)
    {
        try {
            $params = $request->all();
            $response = $this->apiService->get('/api/pens', $params);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching pens data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data kandang',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackPensData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan data pen detail
     */
    public function getPenDetail($id)
    {
        try {
            $response = $this->apiService->get("/api/pens/{$id}");

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching pen detail: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail kandang',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackPenDetail()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan data pen analytics
     */
    public function getPenAnalytics($id)
    {
        try {
            $response = $this->apiService->get("/api/pens/{$id}/analytics");

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching pen analytics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat analisis kandang',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackAnalytics()
            ], 500);
        }
    }

    // Private helper methods untuk fallback data
    private function getEmptyStats()
    {
        return [
            'total_pens' => 0,
            'total_capacity' => 0,
            'total_occupancy' => 0,
            'occupancy_rate' => 0,
            'available_pens' => 0,
            'by_category' => []
        ];
    }

    private function getEmptyLivestockStats()
    {
        return [
            'total' => 0,
            'average_weight' => 0,
            'average_age' => 0,
            'weight_range' => [
                'min' => 0,
                'max' => 0
            ],
            'by_type' => [],
            'by_gender' => [
                'male' => 0,
                'female' => 0
            ]
        ];
    }

    private function getEmptyFeedRequirements()
    {
        return [
            'daily_kg' => 0,
            'weekly_kg' => 0,
            'monthly_kg' => 0,
            'composition' => [
                'silase' => 0,
                'cf_jember' => 0,
                'jagung_halus' => 0
            ],
            'cost_per_day' => 0
        ];
    }

    private function getEmptyAnalytics()
    {
        return [
            'performance' => [
                'efficiency' => 0,
                'rating' => 'unknown',
                'average_daily_gain' => 0,
                'feed_conversion_ratio' => 0,
                'occupancy_rate' => 0
            ],
            'growth_trends' => [
                'weekly_gain' => 0,
                'monthly_gain' => 0,
                'trend' => 'stable',
                'consistency' => 0
            ],
            'feed_efficiency' => [
                'current' => 0,
                'target' => 0,
                'efficiency' => 0
            ],
            'health_metrics' => [
                'mortality_rate' => 0,
                'health_index' => 0,
                'vaccination_coverage' => 0,
                'disease_incidence' => 0
            ]
        ];
    }

    private function getEmptyChartData()
    {
        return [
            'weight_distribution' => [
                'labels' => [],
                'data' => []
            ],
            'growth_trend' => [
                'labels' => [],
                'data' => []
            ],
            'feed_consumption' => [
                'labels' => [],
                'data' => []
            ],
            'occupancy_history' => [
                'labels' => [],
                'data' => []
            ]
        ];
    }

    private function getFallbackPensData()
    {
        return [
            'pens' => [],
            'stats' => $this->getEmptyStats()
        ];
    }

    private function getFallbackPenDetail()
    {
        return [
            'pen' => null,
            'livestock_stats' => $this->getEmptyLivestockStats(),
            'feed_requirements' => $this->getEmptyFeedRequirements()
        ];
    }

    private function getFallbackAnalytics()
    {
        return [
            'pen' => null,
            'analytics' => $this->getEmptyAnalytics(),
            'chart_data' => $this->getEmptyChartData()
        ];
    }
}
