<?php $__env->startSection('title', 'Prediksi & AI'); ?>
<?php $__env->startSection('header-title', 'Prediksi Pertumbuhan & Analisis AI'); ?>

<?php $__env->startSection('page-header'); ?>
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Prediksi & Analisis AI</h1>
        <p class="mt-1 text-sm text-gray-600">Prediksi pertumbuhan bobot dan analisis korelasi pakan menggunakan TensorFlow</p>
    </div>
    <div class="flex items-center space-x-3">
        <button onclick="runCorrelationAnalysis()" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <i class="fas fa-chart-line mr-2"></i>
            Analisis Korelasi
        </button>
        <button onclick="retrainModel()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <i class="fas fa-robot mr-2"></i>
            Retrain Model
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Model Status -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Status Model AI</h3>
                <p class="mt-1 text-sm text-gray-600">Informasi model prediksi pertumbuhan bobot</p>
            </div>
            <div id="model-status-badge">
                <!-- Status will be populated via JavaScript -->
            </div>
        </div>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4" id="model-metrics">
            <!-- Metrics will be populated via JavaScript -->
        </div>
    </div>

    <!-- Prediction Interface -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Prediction Form -->
        <div class="lg:col-span-1 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Prediksi Pertumbuhan</h3>
            <form id="prediction-form" class="space-y-4">
                <div>
                    <label for="prediction_livestock" class="block text-sm font-medium text-gray-700">Pilih Ternak</label>
                    <select id="prediction_livestock" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Pilih Ternak...</option>
                    </select>
                </div>
                <div>
                    <label for="prediction_days" class="block text-sm font-medium text-gray-700">Periode Prediksi (hari)</label>
                    <input type="number" id="prediction_days" value="30" min="1" max="90" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                    <button type="button" onclick="runPrediction()" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <i class="fas fa-play mr-2"></i>
                        Jalankan Prediksi
                    </button>
                </div>
            </form>
        </div>

        <!-- Prediction Results -->
        <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Hasil Prediksi</h3>
            <div id="prediction-results">
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-brain text-4xl text-gray-300 mb-3"></i>
                    <p>Pilih ternak dan jalankan prediksi untuk melihat hasil</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Correlation Analysis -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Analisis Korelasi Pakan</h3>
        <div id="correlation-results">
            <div class="text-center py-8 text-gray-500">
                <p>Klik "Analisis Korelasi" untuk melihat hubungan antara pakan dan pertumbuhan</p>
            </div>
        </div>
    </div>

    <!-- Prediction History -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Riwayat Prediksi</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ternak</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prediksi</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kepercayaan</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rekomendasi</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="prediction-history">
                        <!-- History will be populated via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadModelStatus();
    loadLivestocksForPrediction();
    loadPredictionHistory();
});

async function loadModelStatus() {
    try {
        const response = await fetch('/api/predictions/model-metrics');
        const data = await response.json();

        if (data.success) {
            updateModelStatus(data.data);
        }
    } catch (error) {
        console.error('Error loading model status:', error);
    }
}

function updateModelStatus(metrics) {
    // Update status badge
    const statusBadge = document.getElementById('model-status-badge');
    statusBadge.innerHTML = `
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
            <i class="fas fa-check-circle mr-1"></i>
            Aktif
        </span>
    `;

    // Update metrics
    const metricsContainer = document.getElementById('model-metrics');
    metricsContainer.innerHTML = `
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">${(metrics.performance_estimate?.accuracy * 100).toFixed(1)}%</p>
            <p class="text-sm text-gray-600">Akurasi</p>
        </div>
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">${metrics.feature_count}</p>
            <p class="text-sm text-gray-600">Variabel</p>
        </div>
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">${metrics.model_architecture?.split('(')[1]?.split('-')?.length || '4'}</p>
            <p class="text-sm text-gray-600">Layers</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-900">v${metrics.model_version}</p>
            <p class="text-sm text-gray-600">Versi</p>
        </div>
    `;
}

async function loadLivestocksForPrediction() {
    try {
        const response = await fetch('/api/livestocks?status=active&per_page=100');
        const data = await response.json();

        if (data.success) {
            const select = document.getElementById('prediction_livestock');
            select.innerHTML = '<option value="">Pilih Ternak...</option>' +
                data.data.livestocks.map(livestock => `
                    <option value="${livestock.id}">${livestock.ear_tag} - ${livestock.pen?.name || 'Unknown'}</option>
                `).join('');
        }
    } catch (error) {
        console.error('Error loading livestocks for prediction:', error);
    }
}

async function runPrediction() {
    const livestockId = document.getElementById('prediction_livestock').value;
    const predictionDays = document.getElementById('prediction_days').value;

    if (!livestockId) {
        showError('Pilih ternak terlebih dahulu');
        return;
    }

    const resultsContainer = document.getElementById('prediction-results');
    resultsContainer.innerHTML = `
        <div class="text-center py-8">
            <div class="loading-spinner mx-auto"></div>
            <p class="mt-2 text-sm text-gray-500">Menjalankan prediksi...</p>
        </div>
    `;

    try {
        const response = await fetch('/api/predictions/predict-weight-growth', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                livestock_id: livestockId,
                prediction_days: predictionDays,
                include_recommendations: true
            })
        });

        const data = await response.json();

        if (data.success) {
            displayPredictionResults(data.data);
            loadPredictionHistory(); // Reload history
        } else {
            showError(data.error || 'Prediksi gagal');
            resultsContainer.innerHTML = `
                <div class="text-center py-8 text-red-500">
                    <i class="fas fa-exclamation-triangle text-3xl mb-3"></i>
                    <p>${data.error || 'Terjadi kesalahan saat prediksi'}</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error running prediction:', error);
        showError('Gagal menjalankan prediksi');
        resultsContainer.innerHTML = `
            <div class="text-center py-8 text-red-500">
                <i class="fas fa-exclamation-triangle text-3xl mb-3"></i>
                <p>Gagal terhubung ke server prediksi</p>
            </div>
        `;
    }
}

function displayPredictionResults(data) {
    const resultsContainer = document.getElementById('prediction-results');

    resultsContainer.innerHTML = `
        <div class="space-y-6">
            <!-- Prediction Summary -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-semibold">Hasil Prediksi</h4>
                        <p class="text-primary-100">Periode ${document.getElementById('prediction_days').value} hari</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold">${data.predicted_gain.toFixed(3)} kg</p>
                        <p class="text-primary-100">Kenaikan bobot prediksi</p>
                    </div>
                </div>
            </div>

            <!-- Confidence & Interval -->
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">${(data.confidence * 100).toFixed(1)}%</p>
                    <p class="text-sm text-gray-600">Tingkat Kepercayaan</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">${data.interval.lower.toFixed(3)} kg</p>
                    <p class="text-sm text-gray-600">Batas Bawah</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">${data.interval.upper.toFixed(3)} kg</p>
                    <p class="text-sm text-gray-600">Batas Atas</p>
                </div>
            </div>

            <!-- Recommendations -->
            <div>
                <h5 class="text-lg font-medium text-gray-900 mb-3">Rekomendasi</h5>
                <div class="space-y-2">
                    ${data.recommendations ? data.recommendations.map(rec => `
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-lightbulb text-blue-500 mt-0.5"></i>
                            <p class="text-sm text-gray-700">${rec}</p>
                        </div>
                    `).join('') : '<p class="text-gray-500">Tidak ada rekomendasi spesifik</p>'}
                </div>
            </div>

            <!-- Processing Info -->
            <div class="text-center text-sm text-gray-500">
                <p>Waktu pemrosesan: ${data.processing_time.toFixed(2)} detik</p>
                <p>ID Permintaan: ${data.request_id}</p>
            </div>
        </div>
    `;
}

async function runCorrelationAnalysis() {
    const resultsContainer = document.getElementById('correlation-results');
    resultsContainer.innerHTML = `
        <div class="text-center py-8">
            <div class="loading-spinner mx-auto"></div>
            <p class="mt-2 text-sm text-gray-500">Menganalisis korelasi pakan...</p>
        </div>
    `;

    try {
        const response = await fetch('/api/predictions/analyze-feed-correlation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                analysis_type: 'overall',
                time_period: '90days'
            })
        });

        const data = await response.json();

        if (data.success) {
            displayCorrelationResults(data.data);
        } else {
            showError(data.error || 'Analisis korelasi gagal');
        }
    } catch (error) {
        console.error('Error running correlation analysis:', error);
        showError('Gagal menjalankan analisis korelasi');
    }
}

function displayCorrelationResults(data) {
    const resultsContainer = document.getElementById('correlation-results');

    const correlations = data.data?.correlations || {};
    const significantVars = data.data?.significant_variables || [];

    resultsContainer.innerHTML = `
        <div class="space-y-6">
            <!-- Summary -->
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-green-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="text-lg font-medium text-green-800">Hasil Analisis Korelasi</h4>
                        <p class="text-green-700">${data.data?.analysis_summary || 'Analisis selesai'}</p>
                    </div>
                </div>
            </div>

            <!-- Correlation Matrix -->
            <div>
                <h5 class="text-lg font-medium text-gray-900 mb-3">Matriks Korelasi</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    ${Object.entries(correlations).map(([variable, correlation]) => `
                        <div class="flex items-center justify-between p-3 bg-white border rounded-lg">
                            <span class="text-sm font-medium text-gray-700">${variable.replace(/_/g, ' ')}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                                Math.abs(correlation) >= 0.7 ? 'bg-red-100 text-red-800' :
                                Math.abs(correlation) >= 0.5 ? 'bg-yellow-100 text-yellow-800' :
                                Math.abs(correlation) >= 0.3 ? 'bg-green-100 text-green-800' :
                                'bg-gray-100 text-gray-800'
                            }">
                                ${typeof correlation === 'number' ? correlation.toFixed(3) : correlation}
                            </span>
                        </div>
                    `).join('')}
                </div>
            </div>

            <!-- Significant Variables -->
            ${significantVars.length > 0 ? `
                <div>
                    <h5 class="text-lg font-medium text-gray-900 mb-3">Variabel Signifikan</h5>
                    <div class="space-y-2">
                        ${significantVars.map(variable => `
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                                <i class="fas fa-star text-blue-500"></i>
                                <p class="text-sm font-medium text-gray-700">${variable.replace(/_/g, ' ')}</p>
                                <span class="text-xs text-blue-600">Korelasi: ${correlations[variable]?.toFixed(3) || 'N/A'}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            ` : ''}
        </div>
    `;
}

async function retrainModel() {
    if (!confirm('Retrain model AI? Proses ini mungkin memakan waktu beberapa menit.')) {
        return;
    }

    try {
        const response = await fetch('/api/predictions/retrain-model', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                force_retrain: true,
                training_data_months: 12
            })
        });

        const data = await response.json();

        if (data.success) {
            showSuccess('Model berhasil di-retrain');
            loadModelStatus(); // Reload model status
        } else {
            showError(data.error || 'Retrain model gagal');
        }
    } catch (error) {
        console.error('Error retraining model:', error);
        showError('Gagal retrain model');
    }
}

async function loadPredictionHistory() {
    try {
        const response = await fetch('/api/predictions/history?per_page=10');
        const data = await response.json();

        if (data.success) {
            updatePredictionHistory(data.data.predictions);
        }
    } catch (error) {
        console.error('Error loading prediction history:', error);
    }
}

function updatePredictionHistory(predictions) {
    const tbody = document.getElementById('prediction-history');

    if (!predictions || predictions.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-brain text-3xl text-gray-300 mb-2"></i>
                    <p>Belum ada riwayat prediksi</p>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = predictions.map(pred => {
        const result = pred.prediction_result;
        if (!result) return '';

        return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${pred.livestock?.ear_tag || 'Unknown'}</div>
                    <div class="text-sm text-gray-500">${pred.livestock?.pen?.name || ''}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${result.predicted_weight_gain} kg/hari</div>
                    <div class="text-sm text-gray-500">${result.prediction_interval_lower} - ${result.prediction_interval_upper} kg</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                        result.confidence_level > 0.8 ? 'bg-green-100 text-green-800' :
                        result.confidence_level > 0.6 ? 'bg-yellow-100 text-yellow-800' :
                        'bg-red-100 text-red-800'
                    }">
                        ${(result.confidence_level * 100).toFixed(0)}%
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 max-w-xs truncate">
                        ${result.recommendations ? result.recommendations[0] : 'Tidak ada'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${new Date(pred.created_at).toLocaleDateString('id-ID')}
                </td>
            </tr>
        `;
    }).join('');
}

function showSuccess(message) {
    // Implementation for showing success message
    alert('Success: ' + message); // Replace with toast notification
}

function showError(message) {
    // Implementation for showing error message
    alert('Error: ' + message); // Replace with toast notification
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\game\Aplikasi_Skripsi\frontend-laravel\resources\views/predictions/index.blade.php ENDPATH**/ ?>