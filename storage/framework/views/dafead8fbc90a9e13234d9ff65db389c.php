<?php $__env->startSection('title', 'Laporan - TernakPark'); ?>

<?php $__env->startSection('content'); ?>
<div class="reports-header">
    <h1>Laporan & Analytics</h1>
    <p>Tinjau performa dan analisis data peternakan Anda</p>
</div>

<div class="alert alert-info">
    <strong>Info:</strong> Sistem laporan sedang dalam pengembangan. Data demo ditampilkan sementara.
</div>

<div class="reports-grid">
    <!-- Summary Cards -->
    <div class="cards-grid">
        <div class="card">
            <h3>Ringkasan Keseluruhan</h3>
            <div class="stats">
                <div class="stat-item">
                    <span class="label">Total Ternak</span>
                    <span class="value"><?php echo e($totalLivestocks ?? 0); ?></span>
                </div>
                <div class="stat-item">
                    <span class="label">Total Kandang</span>
                    <span class="value"><?php echo e($totalPens ?? 0); ?></span>
                </div>
                <div class="stat-item">
                    <span class="label">Jenis Pakan</span>
                    <span class="value"><?php echo e($totalFeedTypes ?? 0); ?></span>
                </div>
            </div>
            <a href="<?php echo e(route('reports.performance')); ?>" class="btn">Lihat Detail</a>
        </div>

        <div class="card">
            <h3>Data Terbaru</h3>
            <div class="stats">
                <div class="stat-item">
                    <span class="label">Ternak Ditambahkan</span>
                    <span class="value"><?php echo e($recentData['livestocks_added'] ?? 0); ?></span>
                </div>
                <div class="stat-item">
                    <span class="label">Konsumsi Pakan (kg)</span>
                    <span class="value"><?php echo e($recentData['feed_consumption'] ?? 0); ?></span>
                </div>
                <div class="stat-item">
                    <span class="label">Pertambahan Berat (kg)</span>
                    <span class="value"><?php echo e($recentData['weight_gain'] ?? 0); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Types -->
    <div class="report-types">
        <div class="card">
            <h3>Jenis Laporan</h3>
            <div class="report-links">
                <a href="<?php echo e(route('reports.performance')); ?>" class="report-link">
                    <div class="report-icon">📊</div>
                    <div class="report-info">
                        <h4>Laporan Performa</h4>
                        <p>Analisis performa ternak dan efisiensi</p>
                    </div>
                </a>

                

                <a href="<?php echo e(route('reports.growth')); ?>" class="report-link">
                    <div class="report-icon">📈</div>
                    <div class="report-info">
                        <h4>Laporan Pertumbuhan</h4>
                        <p>Tracking perkembangan berat badan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="card">
            <h3>Statistik Cepat</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">85%</div>
                    <div class="stat-label">Tingkat Okupansi</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">2.1</div>
                    <div class="stat-label">Rasio Konversi Pakan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">92%</div>
                    <div class="stat-label">Indeks Kesehatan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">15.2kg</div>
                    <div class="stat-label">Rata-rata Pertambahan Berat</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.reports-header {
    text-align: center;
    margin-bottom: 2rem;
}

.reports-header h1 {
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.reports-header p {
    color: #64748b;
    font-size: 1.1rem;
}

.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-item .label {
    color: #64748b;
}

.stat-item .value {
    font-weight: bold;
    color: #1e293b;
    font-size: 1.1rem;
}

.report-links {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.report-link {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.report-link:hover {
    border-color: #1a56db;
    background-color: #f8fafc;
    transform: translateY(-2px);
}

.report-icon {
    font-size: 2rem;
    margin-right: 1rem;
}

.report-info h4 {
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.report-info p {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.stat-card {
    text-align: center;
    padding: 1.5rem 1rem;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #1a56db;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #64748b;
    font-size: 0.9rem;
}

.quick-stats {
    margin-top: 2rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\game\Aplikasi_Skripsi\frontend-laravel\resources\views/reports/index.blade.php ENDPATH**/ ?>