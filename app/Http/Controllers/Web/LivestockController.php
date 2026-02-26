<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BackendApiService;
use Illuminate\Support\Facades\Log;

class LivestockController extends Controller
{
    protected $apiService;

    public function __construct(BackendApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        return view('livestocks.index');
    }

    public function show($id)
    {
        return view('livestocks.show', ['livestockId' => $id]);
    }

    public function growth($id)
    {
        return view('livestocks.growth', ['livestockId' => $id]);
    }

    /**
     * API endpoint untuk mendapatkan data livestock
     */
    public function getLivestocksData(Request $request)
    {
        try {
            $params = $request->all();
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->getLivestocks($params);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching livestock data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data ternak',
                'error' => $e->getMessage(),
                'data' => [
                    'livestocks' => [],
                    'pagination' => $this->getEmptyPagination()
                ]
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan detail livestock
     */
    public function getLivestockDetail($id)
    {
        try {
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->getLivestockDetail($id);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching livestock detail: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail ternak',
                'error' => $e->getMessage(),
                'data' => $this->getFallbackLivestockDetail()
            ], 500);
        }
    }

    /**
     * API endpoint untuk menambah livestock
     */
    public function storeLivestock(Request $request)
    {
        try {
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->createLivestock($request->all());

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error creating livestock: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan ternak',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint untuk mencatat berat
     */
    public function recordWeight($id, Request $request)
    {
        try {
            // Gunakan method helper dari BackendApiService
            $response = $this->apiService->recordWeight($id, $request->all());

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error recording weight: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mencatat berat badan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Helper methods
    private function getEmptyPagination()
    {
        return [
            'current_page' => 1,
            'per_page' => 15,
            'total' => 0,
            'last_page' => 1
        ];
    }

    private function getFallbackLivestockDetail()
    {
        return [
            'id' => 0,
            'ear_tag' => 'N/A',
            'breed_type' => 'N/A',
            'current_weight' => 0,
            'initial_weight' => 0,
            'gender' => 'unknown',
            'health_status' => 'unknown',
            'status' => false,
            'pen' => null,
            'weight_records' => [],
            'performance' => [
                'average_daily_gain' => 0,
                'feed_efficiency' => 0
            ]
        ];
    }
}
