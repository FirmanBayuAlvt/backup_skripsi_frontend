<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendApiService;
use Illuminate\Support\Facades\Log;

class PredictionController extends Controller
{
    protected $apiService;

    public function __construct(BackendApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        return view('predictions.index', [
            'predictions' => $this->getEmptyPredictions()
        ]);
    }

    public function show($id)
    {
        return view('predictions.show', [
            'predictionDetail' => $this->getEmptyPredictionDetail($id)
        ]);
    }

    public function correlation()
    {
        return view('predictions.correlation', [
            'correlationData' => $this->getEmptyCorrelationData()
        ]);
    }

    /**
     * API endpoint untuk mendapatkan data predictions
     */
    public function getPredictionsData()
    {
        try {
            $response = $this->apiService->get('/api/predictions');

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching predictions data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data prediksi',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackPredictionsData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan detail prediction
     */
    public function getPredictionDetail($id)
    {
        try {
            $response = $this->apiService->get("/api/predictions/{$id}");

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching prediction detail: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail prediksi',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackPredictionDetail($id)
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan data correlation
     */
    public function getCorrelationData()
    {
        try {
            $response = $this->apiService->get('/api/predictions/correlation');

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching correlation data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data korelasi',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackCorrelationData()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan prediction history
     */
    public function getPredictionHistory()
    {
        try {
            $perPage = request('per_page', 5);
            $response = $this->apiService->get("/api/predictions/history?per_page={$perPage}");

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching prediction history: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat riwayat prediksi',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackPredictionHistory()
            ], 500);
        }
    }

    /**
     * API endpoint untuk membuat prediksi baru
     */
    public function createPrediction(Request $request)
    {
        try {
            $response = $this->apiService->post('/api/predictions', $request->all());

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error creating prediction: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat prediksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Private helper methods untuk fallback data
    private function getEmptyPredictions()
    {
        return [
            'weight_gain_prediction' => 0,
            'feed_requirement_prediction' => 0,
            'completion_time_prediction' => 0
        ];
    }

    private function getEmptyPredictionDetail($id)
    {
        return [
            'id' => $id,
            'predicted_weight' => 0,
            'confidence_level' => 0,
            'recommended_feed' => 0,
            'estimated_completion' => '-'
        ];
    }

    private function getEmptyCorrelationData()
    {
        return [
            'feed_weight_correlation' => 0,
            'factors' => [
                'Jenis Pakan' => 0,
                'Kondisi Kandang' => 0,
                'Kesehatan' => 0,
                'Umur' => 0
            ]
        ];
    }

    private function getFallbackPredictionsData()
    {
        return [
            'weight_gain_prediction' => 15.2,
            'feed_requirement_prediction' => 1250,
            'completion_time_prediction' => 45,
            'model_info' => [
                'version' => 'v1.0',
                'accuracy' => 0.85,
                'last_updated' => now()->format('Y-m-d')
            ]
        ];
    }

    private function getFallbackPredictionDetail($id)
    {
        return [
            'id' => $id,
            'predicted_weight' => 68.5,
            'confidence_level' => 85.2,
            'recommended_feed' => 1350,
            'estimated_completion' => '2024-12-15',
            'input_features' => [
                'current_weight' => 45.2,
                'age_days' => 120,
                'feed_composition' => 'standard',
                'pen_category' => 'A'
            ]
        ];
    }

    private function getFallbackCorrelationData()
    {
        return [
            'feed_weight_correlation' => 0.85,
            'factors' => [
                'Jenis Pakan' => 0.78,
                'Kondisi Kandang' => 0.65,
                'Kesehatan' => 0.72,
                'Umur' => 0.68,
                'Suhu Lingkungan' => 0.55,
                'Kepadatan Kandang' => 0.62
            ],
            'analysis_period' => '6_bulan_terakhir'
        ];
    }

    private function getFallbackPredictionHistory()
    {
        return [
            'predictions' => [
                [
                    'id' => 1,
                    'livestock_ear_tag' => 'SAPI-001',
                    'predicted_gain' => 0.18,
                    'confidence' => 0.82,
                    'created_at' => now()->subDays(1)->format('d M Y H:i')
                ],
                [
                    'id' => 2,
                    'livestock_ear_tag' => 'SAPI-002',
                    'predicted_gain' => 0.15,
                    'confidence' => 0.75,
                    'created_at' => now()->subDays(2)->format('d M Y H:i')
                ]
            ]
        ];
    }
}
