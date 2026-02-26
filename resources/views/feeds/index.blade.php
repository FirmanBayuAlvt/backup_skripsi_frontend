@extends('layouts.app')

@section('title', 'Manajemen Pakan')
@section('header-title', 'Manajemen Pakan')

@section('page-header')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pakan</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola jenis pakan dan stok ternak</p>
    </div>
    <div class="flex items-center space-x-3">
        <button class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Pakan
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
                    <i class="fas fa-seedling text-2xl text-primary-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Jenis Pakan</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="total-feed-types">-</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-warehouse text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Stok</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="total-stock">- kg</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-2xl text-yellow-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Stok Rendah</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="low-stock-count">-</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Nilai Stok</h3>
                    <p class="text-2xl font-semibold text-gray-900" id="stock-value">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feeds Table -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Jenis Pakan</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pakan
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stok
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga/kg
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="feeds-table-body">
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="loading-spinner mx-auto"></div>
                                <p class="mt-2">Memuat data pakan...</p>
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
    loadFeedsData();
});

async function loadFeedsData() {
    try {
        const response = await fetch('/web-api/feeds/data');
        const data = await response.json();

        if (data.success) {
            updateFeedsTable(data.data.feed_types);
            updateStats(data.data);
        } else {
            showErrorState();
        }
    } catch (error) {
        console.error('Error loading feeds data:', error);
        showErrorState();
    }
}

function updateFeedsTable(feedTypes) {
    const tableBody = document.getElementById('feeds-table-body');

    if (!feedTypes || feedTypes.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    Tidak ada data pakan
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = feedTypes.map(feed => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-seedling text-primary-600"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${feed.name}</div>
                        <div class="text-sm text-gray-500">${feed.unit}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    ${feed.category}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${feed.current_stock} kg</div>
                <div class="text-sm text-gray-500">Stok tersedia</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${Utils.formatCurrency(feed.price_per_kg)}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                    feed.is_stock_low ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'
                }">
                    ${feed.is_stock_low ? 'Stok Rendah' : 'Aman'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-primary-600 hover:text-primary-900 mr-3">Edit</button>
                <button class="text-green-600 hover:text-green-900">Stok</button>
            </td>
        </tr>
    `).join('');
}

function updateStats(data) {
    document.getElementById('total-feed-types').textContent = data.total_types || '0';
    document.getElementById('total-stock').textContent = data.stock_summary ? data.stock_summary.total_stock_kg + ' kg' : '0 kg';
    document.getElementById('low-stock-count').textContent = data.low_stock_count || '0';
    document.getElementById('stock-value').textContent = data.stock_summary ? Utils.formatCurrency(data.stock_summary.total_value) : 'Rp 0';
}

function showErrorState() {
    document.getElementById('feeds-table-body').innerHTML = `
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-red-500">
                <i class="fas fa-exclamation-circle text-red-400 text-2xl mb-2"></i>
                <p>Gagal memuat data pakan</p>
            </td>
        </tr>
    `;
}
</script>
@endpush
