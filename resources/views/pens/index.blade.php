@extends('layouts.app')

@section('title', 'Manajemen Kandang')
@section('header-title', 'Manajemen Kandang')

@section('page-header')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Kandang</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola kandang dan monitoring performa ternak</p>
    </div>
    <div class="flex items-center space-x-3">
        <button class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Kandang
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-warehouse text-2xl text-primary-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Kandang</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="total-pens">-</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-sheep text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Kapasitas</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="total-capacity">-</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-line text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Tingkat Okupansi</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="occupancy-rate">-</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Kandang Tersedia</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="available-pens">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pens Table -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Kandang</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Kandang
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kapasitas
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Okupansi
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="pens-table-body">
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="loading-spinner mx-auto"></div>
                                <p class="mt-2">Memuat data kandang...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadPensData();
});

async function loadPensData() {
    try {
        const response = await fetch('/web-api/pens/data');
        const data = await response.json();

        if (data.success) {
            updatePensTable(data.data.pens);
            updateStats(data.data.stats);
        } else {
            showErrorState();
        }
    } catch (error) {
        console.error('Error loading pens data:', error);
        showErrorState();
    }
}

function updatePensTable(pens) {
    const tableBody = document.getElementById('pens-table-body');

    if (!pens || pens.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    Tidak ada data kandang
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = pens.map(pen => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-warehouse text-primary-600"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${pen.name}</div>
                        <div class="text-sm text-gray-500">${pen.code || '-'}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    ${pen.category}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${pen.capacity} ekor</div>
                <div class="text-sm text-gray-500">Kapasitas maksimal</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${pen.current_occupancy} / ${pen.capacity}</div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-primary-600 h-2 rounded-full" style="width: ${(pen.current_occupancy / pen.capacity) * 100}%"></div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                    pen.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                }">
                    ${pen.status === 'active' ? 'Aktif' : 'Non-Aktif'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <a href="/pens/${pen.id}" class="text-primary-600 hover:text-primary-900 mr-3">Detail</a>
                <a href="/pens/${pen.id}/analytics" class="text-green-600 hover:text-green-900">Analisis</a>
            </td>
        </tr>
    `).join('');
}

function updateStats(stats) {
    document.getElementById('total-pens').textContent = stats.total_pens || '0';
    document.getElementById('total-capacity').textContent = stats.total_capacity || '0';
    document.getElementById('occupancy-rate').textContent = stats.occupancy_rate ? stats.occupancy_rate.toFixed(1) + '%' : '0%';
    document.getElementById('available-pens').textContent = stats.available_pens || '0';
}

function showErrorState() {
    document.getElementById('pens-table-body').innerHTML = `
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-red-500">
                <i class="fas fa-exclamation-circle text-red-400 text-2xl mb-2"></i>
                <p>Gagal memuat data kandang</p>
            </td>
        </tr>
    `;
}
</script>
@endpush
