<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class BackendApiService
{
    protected $baseUrl;
    protected $timeout;
    protected $retryTimes;
    protected $retrySleep;
    protected $endpoints;

    public function __construct()
    {
        $this->baseUrl = config('services.backend.base_url', 'http://localhost:8000');
        $this->timeout = config('services.backend.timeout', 30);

        // Ambil konfigurasi retry dengan benar
        $retryConfig = config('services.backend.retry', []);
        $this->retryTimes = $retryConfig['times'] ?? 3;
        $this->retrySleep = $retryConfig['sleep'] ?? 100;

        $this->endpoints = config('services.backend.endpoints', []);
    }

    public function get($endpoint, $params = [])
    {
        try {
            $response = Http::timeout($this->timeout)
                ->retry($this->retryTimes, $this->retrySleep)
                ->get($this->baseUrl . $endpoint, $params);

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error('Backend API Error - GET ' . $endpoint . ': ' . $e->getMessage());
            return $this->errorResponse('Gagal terhubung ke server backend', $e->getMessage());
        }
    }

    public function post($endpoint, $data = [])
    {
        try {
            $response = Http::timeout($this->timeout)
                ->retry($this->retryTimes, $this->retrySleep)
                ->post($this->baseUrl . $endpoint, $data);

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error('Backend API Error - POST ' . $endpoint . ': ' . $e->getMessage());
            return $this->errorResponse('Gagal terhubung ke server backend', $e->getMessage());
        }
    }

    protected function handleResponse($response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        $statusCode = $response->status();
        $errorMessage = $this->getErrorMessage($statusCode);

        return [
            'success' => false,
            'message' => $errorMessage,
            'error' => $response->body(),
            'status_code' => $statusCode
        ];
    }

    protected function getErrorMessage($statusCode)
    {
        return match($statusCode) {
            401 => 'Tidak terautentikasi. Silakan login kembali.',
            403 => 'Anda tidak memiliki akses ke resource ini.',
            404 => 'Data tidak ditemukan.',
            422 => 'Data yang dikirim tidak valid.',
            500 => 'Terjadi kesalahan server internal.',
            503 => 'Service tidak tersedia. Silakan coba lagi nanti.',
            default => 'Terjadi kesalahan. Silakan coba lagi.',
        };
    }

    protected function errorResponse($message, $error = null)
    {
        return [
            'success' => false,
            'message' => $message,
            'error' => $error,
            'data' => null
        ];
    }

    /**
     * Method helper khusus untuk livestock
     */
    public function getLivestocks($params = [])
    {
        return $this->get($this->endpoints['livestocks'] ?? '/api/livestocks', $params);
    }

    public function getLivestockDetail($id)
    {
        return $this->get(($this->endpoints['livestocks'] ?? '/api/livestocks') . '/' . $id);
    }

    public function createLivestock($data)
    {
        return $this->post($this->endpoints['livestocks'] ?? '/api/livestocks', $data);
    }

    public function recordWeight($livestockId, $data)
    {
        $endpoint = ($this->endpoints['livestocks'] ?? '/api/livestocks') . '/' . $livestockId . '/record-weight';
        return $this->post($endpoint, $data);
    }

    /**
     * Method helper khusus untuk pens
     */
    public function getPens($params = [])
    {
        return $this->get($this->endpoints['pens'] ?? '/api/pens', $params);
    }

    public function getPenDetail($id)
    {
        return $this->get(($this->endpoints['pens'] ?? '/api/pens') . '/' . $id);
    }

    public function getPenAnalytics($id)
    {
        return $this->get(($this->endpoints['pens'] ?? '/api/pens') . '/' . $id . '/analytics');
    }

    /**
     * Method helper khusus untuk feeds
     */
    public function getFeeds($params = [])
    {
        return $this->get($this->endpoints['feeds'] ?? '/api/feeds', $params);
    }

    public function getFeedStock()
    {
        return $this->get(($this->endpoints['feeds'] ?? '/api/feeds') . '/stock');
    }

    public function getFeedRequirements()
    {
        return $this->get(($this->endpoints['feeds'] ?? '/api/feeds') . '/requirements');
    }

    public function recordFeeding($data)
    {
        return $this->post(($this->endpoints['feeds'] ?? '/api/feeds') . '/record-feeding', $data);
    }

    public function updateFeedStock($data)
    {
        return $this->post(($this->endpoints['feeds'] ?? '/api/feeds') . '/update-stock', $data);
    }

    /**
     * Method helper khusus untuk predictions
     */
    public function getPredictions($params = [])
    {
        return $this->get($this->endpoints['predictions'] ?? '/api/predictions', $params);
    }

    public function getPredictionDetail($id)
    {
        return $this->get(($this->endpoints['predictions'] ?? '/api/predictions') . '/' . $id);
    }

    public function getPredictionHistory($params = [])
    {
        return $this->get(($this->endpoints['predictions'] ?? '/api/predictions') . '/history', $params);
    }

    public function createPrediction($data)
    {
        return $this->post($this->endpoints['predictions'] ?? '/api/predictions', $data);
    }

    public function getCorrelationData()
    {
        return $this->get(($this->endpoints['predictions'] ?? '/api/predictions') . '/correlation');
    }

    /**
     * Method helper untuk dashboard
     */
    public function getDashboardOverview()
    {
        return $this->get('/api/dashboard/overview');
    }

    public function getDashboardPenAnalytics()
    {
        return $this->get('/api/dashboard/pen-analytics');
    }

    /**
     * Method helper untuk reports
     */
    public function getReports($type = 'summary')
    {
        return $this->get('/api/reports/' . $type);
    }

    public function getReportSummary()
    {
        return $this->get('/api/reports/summary');
    }

    public function getReportPerformance()
    {
        return $this->get('/api/reports/performance');
    }

    public function getReportFinancial()
    {
        return $this->get('/api/reports/financial');
    }

    public function getReportGrowth()
    {
        return $this->get('/api/reports/growth');
    }

    /**
     * Test koneksi ke backend
     */
    public function healthCheck()
    {
        return $this->get('/api/health');
    }

    /**
     * Get service configuration for debugging
     */
    public function getConfig()
    {
        return [
            'base_url' => $this->baseUrl,
            'timeout' => $this->timeout,
            'retry_times' => $this->retryTimes,
            'retry_sleep' => $this->retrySleep,
            'endpoints' => $this->endpoints
        ];
    }
}
