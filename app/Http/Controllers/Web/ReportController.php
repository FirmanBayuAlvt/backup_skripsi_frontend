<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendApiService;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    protected $apiService;

    public function __construct(BackendApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        try {
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->getReportSummary();

            if (isset($response['success']) && $response['success']) {
                $data = $response['data'] ?? $this->getFallbackData();
            } else {
                $data = $this->getFallbackData();
            }

            return view('reports.index', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching report summary: ' . $e->getMessage());
            $fallbackData = $this->getFallbackData();
            return view('reports.index', $fallbackData);
        }
    }

    public function performance()
    {
        try {
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->getReportPerformance();

            if (isset($response['success']) && $response['success']) {
                $data = $response['data'] ?? $this->getFallbackPerformanceData();
            } else {
                $data = $this->getFallbackPerformanceData();
            }

            return view('reports.performance', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching performance report: ' . $e->getMessage());
            $fallbackData = $this->getFallbackPerformanceData();
            return view('reports.performance', $fallbackData);
        }
    }

    public function financial()
    {
        try {
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->getReportFinancial();

            if (isset($response['success']) && $response['success']) {
                $data = $response['data'] ?? $this->getFallbackFinancialData();
            } else {
                $data = $this->getFallbackFinancialData();
            }

            return view('reports.financial', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching financial report: ' . $e->getMessage());
            $fallbackData = $this->getFallbackFinancialData();
            return view('reports.financial', $fallbackData);
        }
    }

    public function growth()
    {
        try {
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->getReportGrowth();

            if (isset($response['success']) && $response['success']) {
                $data = $response['data'] ?? $this->getFallbackGrowthData();
            } else {
                $data = $this->getFallbackGrowthData();
            }

            return view('reports.growth', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching growth report: ' . $e->getMessage());
            $fallbackData = $this->getFallbackGrowthData();
            return view('reports.growth', $fallbackData);
        }
    }

    /**
     * API endpoint untuk mendapatkan data reports
     */
    public function getReportsData(Request $request)
    {
        try {
            $type = $request->get('type', 'summary');
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->getReports($type);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching reports data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data laporan',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackData()
            ], 500);
        }
    }

    /**
     * Fallback data ketika API tidak tersedia
     */
    private function getFallbackData()
    {
        return [
            'totalLivestocks' => 0,
            'totalPens' => 0,
            'totalFeedTypes' => 0,
            'recentData' => [
                'livestocks_added' => 0,
                'feed_consumption' => 0,
                'weight_gain' => 0
            ],
            'alerts' => [
                [
                    'type' => 'info',
                    'message' => 'Sistem sedang dalam pemeliharaan',
                    'description' => 'Data laporan akan tersedia kembali sebentar lagi'
                ]
            ],
            'charts' => [
                'livestockDistribution' => [
                    'labels' => ['Domba Lokal', 'Domba Ekor Gemuk', 'Domba Garut'],
                    'data' => [0, 0, 0]
                ],
                'weightGainTrend' => [
                    'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                    'data' => [0, 0, 0, 0]
                ]
            ]
        ];
    }
// Tambahkan method ini ke ReportController.php

    /**
     * API endpoint untuk mendapatkan summary report
     */
    public function getSummaryReport()
    {
        try {
            $response = $this->apiService->get('/api/reports/summary');
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching summary report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat laporan ringkasan',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan performance report
     */
    public function getPerformanceReport()
    {
        try {
            $response = $this->apiService->get('/api/reports/performance');
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching performance report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat laporan performa',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackPerformanceData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan financial report
     */
    public function getFinancialReport()
    {
        try {
            $response = $this->apiService->get('/api/reports/financial');
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching financial report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat laporan keuangan',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackFinancialData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan growth report
     */
    public function getGrowthReport()
    {
        try {
            $response = $this->apiService->get('/api/reports/growth');
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching growth report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat laporan pertumbuhan',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackGrowthData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk export report
     */
    public function exportReport(Request $request)
    {
        try {
            $response = $this->apiService->post('/api/reports/export', $request->all());
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error exporting report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    private function getFallbackPerformanceData()
    {
        return [
            'performanceData' => [
                'average_weight_gain' => 15.2,
                'feed_conversion_ratio' => 2.1,
                'mortality_rate' => 2.5,
                'growth_rate' => 1.8,
                'occupancy_rate' => 85.5,
                'health_index' => 92.3,
                'vaccination_coverage' => 88.7
            ],
            'monthlyData' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'weight_gain' => [12, 14, 15, 16, 15.5, 16.2],
                'feed_consumption' => [1200, 1250, 1300, 1350, 1320, 1380],
                'efficiency' => [1.8, 1.9, 2.0, 2.1, 2.0, 2.1]
            ],
            'alerts' => [
                [
                    'type' => 'info',
                    'message' => 'Data performa sedang dimuat',
                    'description' => 'Harap tunggu sebentar'
                ]
            ],
            'charts' => [
                'performanceTrend' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    'weightGain' => [12, 14, 15, 16, 15.5, 16.2],
                    'feedEfficiency' => [1.8, 1.9, 2.0, 2.1, 2.0, 2.1]
                ],
                'penPerformance' => [
                    'labels' => ['Kandang A', 'Kandang B', 'Kandang C', 'Kandang D'],
                    'data' => [85, 92, 78, 88]
                ]
            ]
        ];
    }

    private function getFallbackFinancialData()
    {
        return [
            'financialData' => [
                'total_revenue' => 125000000,
                'total_cost' => 89000000,
                'net_profit' => 36000000,
                'roi' => 28.8,
                'break_even_point' => 8,
                'feed_cost_per_kg' => 8500,
                'operational_efficiency' => 78.5
            ],
            'monthlyFinancial' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'revenue' => [20000000, 21000000, 22000000, 23000000, 22500000, 23500000],
                'cost' => [14500000, 14800000, 15200000, 15500000, 15300000, 15700000],
                'profit' => [5500000, 6200000, 6800000, 7500000, 7200000, 7800000]
            ],
            'costBreakdown' => [
                'feed' => 65,
                'operational' => 20,
                'veterinary' => 10,
                'other' => 5
            ],
            'alerts' => [
                [
                    'type' => 'info',
                    'message' => 'Data keuangan sedang dimuat',
                    'description' => 'Harap tunggu sebentar'
                ]
            ],
            'charts' => [
                'revenueCost' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    'revenue' => [20000000, 21000000, 22000000, 23000000, 22500000, 23500000],
                    'cost' => [14500000, 14800000, 15200000, 15500000, 15300000, 15700000]
                ],
                'costDistribution' => [
                    'labels' => ['Pakan', 'Operasional', 'Kesehatan', 'Lainnya'],
                    'data' => [65, 20, 10, 5]
                ]
            ]
        ];
    }

    private function getFallbackGrowthData()
    {
        return [
            'growthData' => [
                'average_daily_gain' => 0.85,
                'total_weight_gain' => 1250.5,
                'growth_efficiency' => 78.5,
                'target_achievement' => 92.3,
                'average_age' => 145,
                'weight_variation' => 12.3
            ],
            'weeklyGrowth' => [
                'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5', 'Minggu 6'],
                'weights' => [45.2, 48.5, 52.1, 56.3, 59.8, 63.5],
                'targets' => [44.0, 47.5, 51.0, 55.0, 58.5, 62.0],
                'gains' => [0, 3.3, 3.6, 4.2, 3.5, 3.7]
            ],
            'breedPerformance' => [
                'domba_lokal' => [
                    'avg_gain' => 0.82,
                    'efficiency' => 76.8
                ],
                'domba_ekor_gemuk' => [
                    'avg_gain' => 0.88,
                    'efficiency' => 80.2
                ],
                'domba_garut' => [
                    'avg_gain' => 0.85,
                    'efficiency' => 78.5
                ]
            ],
            'alerts' => [
                [
                    'type' => 'info',
                    'message' => 'Data pertumbuhan sedang dimuat',
                    'description' => 'Harap tunggu sebentar'
                ]
            ],
            'charts' => [
                'growthComparison' => [
                    'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5', 'Minggu 6'],
                    'actual' => [45.2, 48.5, 52.1, 56.3, 59.8, 63.5],
                    'target' => [44.0, 47.5, 51.0, 55.0, 58.5, 62.0]
                ],
                'breedPerformance' => [
                    'labels' => ['Domba Lokal', 'Domba Ekor Gemuk', 'Domba Garut'],
                    'efficiency' => [76.8, 80.2, 78.5],
                    'gain' => [0.82, 0.88, 0.85]
                ]
            ]
        ];
    }
}
