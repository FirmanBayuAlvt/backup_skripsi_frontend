<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendApiService;
use Illuminate\Support\Facades\Log;

class FeedController extends Controller
{
    protected $apiService;

    public function __construct(BackendApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        return view('feeds.index', [
            'feeds' => [],
            'stockSummary' => $this->getEmptyStockSummary(),
            'recentActivity' => []
        ]);
    }

    public function stock()
    {
        return view('feeds.stock', [
            'feeds' => [],
            'lowStockAlerts' => [],
            'stockValue' => 0,
            'consumptionRate' => $this->getEmptyConsumptionRate()
        ]);
    }

    public function requirements()
    {
        return view('feeds.requirements', [
            'requirements' => $this->getEmptyRequirements(),
            'currentStock' => [],
            'stockCoverage' => []
        ]);
    }

    /**
     * API endpoint untuk mendapatkan data feeds
     */
    public function getFeedsData()
    {
        try {
            $response = $this->apiService->get('/api/feeds');

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching feeds data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data pakan',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackFeedsData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan data stock levels
     */
    public function getStockLevels()
    {
        try {
            $response = $this->apiService->get('/api/feeds/stock');

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching stock levels: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data stok',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackStockData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan data feed requirements
     */
    public function getFeedRequirements()
    {
        try {
            $response = $this->apiService->get('/api/feeds/requirements');

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching feed requirements: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data kebutuhan pakan',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackRequirementsData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mencatat pemberian pakan
     */
    public function recordFeeding(Request $request)
    {
        try {
            $response = $this->apiService->post('/api/feeds/record-feeding', $request->all());

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error recording feeding: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mencatat pemberian pakan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint untuk update stok pakan
     */
    public function updateStock(Request $request)
    {
        try {
            $response = $this->apiService->post('/api/feeds/update-stock', $request->all());

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error updating stock: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui stok',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Private helper methods untuk fallback data
    private function getEmptyStockSummary()
    {
        return [
            'total_feeds' => 0,
            'total_stock_kg' => 0,
            'low_stock_count' => 0,
            'out_of_stock_count' => 0,
            'total_value' => 0,
            'value_by_type' => []
        ];
    }

    private function getEmptyConsumptionRate()
    {
        return [
            'daily_consumption' => 0,
            'weekly_consumption' => 0,
            'stock_days_remaining' => 0,
            'trend' => 'stable'
        ];
    }

    private function getEmptyRequirements()
    {
        return [
            'daily' => [
                'total_kg' => 0,
                'silase' => 0,
                'cf_jember' => 0,
                'jagung_halus' => 0,
                'cost' => 0
            ],
            'weekly' => [
                'total_kg' => 0,
                'silase' => 0,
                'cf_jember' => 0,
                'jagung_halus' => 0,
                'cost' => 0
            ],
            'monthly' => [
                'total_kg' => 0,
                'silase' => 0,
                'cf_jember' => 0,
                'jagung_halus' => 0,
                'cost' => 0
            ]
        ];
    }

    private function getFallbackFeedsData()
    {
        return [
            'feed_types' => [],
            'total_types' => 0,
            'low_stock_count' => 0,
            'stock_summary' => $this->getEmptyStockSummary()
        ];
    }

    private function getFallbackStockData()
    {
        return [
            'feed_types' => [],
            'low_stock_alerts' => [],
            'stock_summary' => [
                'total_value' => 0,
                'total_stock_kg' => 0,
                'low_stock_count' => 0,
                'out_of_stock_count' => 0,
                'average_price_per_kg' => 0
            ],
            'consumption_rate' => $this->getEmptyConsumptionRate()
        ];
    }

    private function getFallbackRequirementsData()
    {
        return [
            'requirements' => $this->getEmptyRequirements(),
            'current_stock' => [],
            'stock_coverage' => [],
            'total_livestock_weight' => 0,
            'feed_types_available' => 0
        ];
    }
}
