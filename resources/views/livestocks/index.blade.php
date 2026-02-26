@extends('layouts.app')

@section('title', 'Manajemen Ternak')
@section('header-title', 'Manajemen Ternak')

@section('page-header')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Ternak</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola data ternak dan monitoring pertumbuhan</p>
    </div>
    <div class="flex items-center space-x-3">
        <button onclick="openAddModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <i class="fas fa-plus mr-2"></i>
            Tambah Ternak
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="pen-filter" class="block text-sm font-medium text-gray-700 mb-1">Kandang</label>
                <select id="pen-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Semua Kandang</option>
                    <!-- Options will be populated via JavaScript -->
                </select>
            </div>
            <div>
                <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label for="breed-filter" class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                <select id="breed-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Semua Jenis</option>
                    <option value="domba_lokal">Domba Lokal</option>
                    <option value="domba_ekor_gemuk">Domba Ekor Gemuk</option>
                    <option value="domba_garut">Domba Garut</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="applyFilters()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-filter mr-2"></i>
                    Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Livestock Grid -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Data Ternak</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ear Tag</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kandang</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat (kg)</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertumbuhan</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="livestock-table-body">
                        <!-- Data will be populated via JavaScript -->
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="loading-spinner mx-auto"></div>
                                <p class="mt-2 text-sm text-gray-500">Memuat data ternak...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between" id="pagination-container">
                <!-- Pagination will be populated via JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Add Livestock Modal -->
<div id="add-modal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <i class="fas fa-sheep text-green-600 text-xl"></i>
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tambah Ternak Baru</h3>
                    <div class="mt-4">
                        <form id="add-livestock-form" class="space-y-4 text-left">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="ear_tag" class="block text-sm font-medium text-gray-700">Ear Tag *</label>
                                    <input type="text" name="ear_tag" id="ear_tag" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label for="pen_id" class="block text-sm font-medium text-gray-700">Kandang *</label>
                                    <select name="pen_id" id="pen_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <option value="">Pilih Kandang</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="breed_type" class="block text-sm font-medium text-gray-700">Jenis *</label>
                                    <select name="breed_type" id="breed_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <option value="domba_lokal">Domba Lokal</option>
                                        <option value="domba_ekor_gemuk">Domba Ekor Gemuk</option>
                                        <option value="domba_garut">Domba Garut</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin *</label>
                                    <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <option value="male">Jantan</option>
                                        <option value="female">Betina</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir *</label>
                                    <input type="date" name="birth_date" id="birth_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label for="initial_weight" class="block text-sm font-medium text-gray-700">Berat Awal (kg) *</label>
                                    <input type="number" step="0.1" name="initial_weight" id="initial_weight" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>

                            <div>
                                <label for="health_status" class="block text-sm font-medium text-gray-700">Status Kesehatan</label>
                                <select name="health_status" id="health_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="excellent">Sangat Baik</option>
                                    <option value="good" selected>Baik</option>
                                    <option value="fair">Cukup</option>
                                    <option value="poor">Kurang</option>
                                </select>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                                <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button type="button" onclick="submitAddForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:col-start-2 sm:text-sm">
                    Simpan
                </button>
                <button type="button" onclick="closeAddModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Record Weight Modal -->
<div id="weight-modal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="weight-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                    <i class="fas fa-weight text-blue-600 text-xl"></i>
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="weight-modal-title">Catat Berat Badan</h3>
                    <div class="mt-4">
                        <form id="record-weight-form" class="space-y-4 text-left">
                            @csrf
                            <input type="hidden" name="livestock_id" id="weight_livestock_id">
                            <div>
                                <label for="weight_kg" class="block text-sm font-medium text-gray-700">Berat Badan (kg) *</label>
                                <input type="number" step="0.1" name="weight_kg" id="weight_kg" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label for="record_date" class="block text-sm font-medium text-gray-700">Tanggal Pencatatan *</label>
                                <input type="date" name="record_date" id="record_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" value="{{ date('Y-m-d') }}">
                            </div>
                            <div>
                                <label for="weight_notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                                <textarea name="notes" id="weight_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Catatan tambahan..."></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button type="button" onclick="submitWeightForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:col-start-2 sm:text-sm">
                    Simpan
                </button>
                <button type="button" onclick="closeWeightModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let currentFilters = {};

document.addEventListener('DOMContentLoaded', function() {
    loadLivestocks();
    loadPensForFilter();
    loadPensForModal();
});

async function loadLivestocks(page = 1) {
    currentPage = page;

    try {
        const params = new URLSearchParams({
            page: page,
            ...currentFilters
        });

        const response = await fetch(`/api/livestocks?${params}`);
        const data = await response.json();

        if (data.success) {
            updateLivestockTable(data.data.livestocks);
            updatePagination(data.data.pagination);
        }
    } catch (error) {
        console.error('Error loading livestocks:', error);
        showError('Gagal memuat data ternak');
    }
}

function updateLivestockTable(livestocks) {
    const tbody = document.getElementById('livestock-table-body');

    if (!livestocks || livestocks.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-sheep text-4xl text-gray-300 mb-2"></i>
                    <p>Tidak ada data ternak</p>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = livestocks.map(livestock => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-sheep text-primary-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">${livestock.ear_tag}</div>
                        <div class="text-sm text-gray-500">${livestock.breed_type}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${livestock.pen?.name || '-'}</div>
                <div class="text-sm text-gray-500">${livestock.pen?.category || ''}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">${livestock.current_weight} kg</div>
                <div class="text-sm text-gray-500">Awal: ${livestock.initial_weight} kg</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${livestock.performance?.average_daily_gain ? livestock.performance.average_daily_gain.toFixed(3) + ' kg/hari' : '-'}</div>
                <div class="text-sm text-gray-500">Total: +${(livestock.current_weight - livestock.initial_weight).toFixed(1)} kg</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                    livestock.status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                }">
                    ${livestock.status ? 'Aktif' : 'Tidak Aktif'}
                </span>
                <div class="text-xs text-gray-500 mt-1">${livestock.health_status}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end space-x-2">
                    <button onclick="openWeightModal(${livestock.id}, '${livestock.ear_tag}')" class="text-blue-600 hover:text-blue-900" title="Catat Berat">
                        <i class="fas fa-weight"></i>
                    </button>
                    <button onclick="viewLivestock(${livestock.id})" class="text-primary-600 hover:text-primary-900" title="Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="predictGrowth(${livestock.id})" class="text-green-600 hover:text-green-900" title="Prediksi">
                        <i class="fas fa-brain"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function updatePagination(pagination) {
    const container = document.getElementById('pagination-container');

    if (!pagination || pagination.total <= pagination.per_page) {
        container.innerHTML = '';
        return;
    }

    const totalPages = Math.ceil(pagination.total / pagination.per_page);

    container.innerHTML = `
        <div class="flex-1 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">${((currentPage - 1) * pagination.per_page) + 1}</span>
                    sampai <span class="font-medium">${Math.min(currentPage * pagination.per_page, pagination.total)}</span>
                    dari <span class="font-medium">${pagination.total}</span> hasil
                </p>
            </div>
            <div class="flex space-x-2">
                <button
                    onclick="loadLivestocks(${currentPage - 1})"
                    ${currentPage === 1 ? 'disabled' : ''}
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                >
                    Sebelumnya
                </button>
                <button
                    onclick="loadLivestocks(${currentPage + 1})"
                    ${currentPage === totalPages ? 'disabled' : ''}
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}"
                >
                    Selanjutnya
                </button>
            </div>
        </div>
    `;
}

async function loadPensForFilter() {
    try {
        const response = await fetch('/api/pens');
        const data = await response.json();

        if (data.success) {
            const select = document.getElementById('pen-filter');
            select.innerHTML = '<option value="">Semua Kandang</option>' +
                data.data.pens.map(pen => `
                    <option value="${pen.id}">${pen.name} (${pen.category})</option>
                `).join('');
        }
    } catch (error) {
        console.error('Error loading pens for filter:', error);
    }
}

async function loadPensForModal() {
    try {
        const response = await fetch('/api/pens');
        const data = await response.json();

        if (data.success) {
            const select = document.getElementById('pen_id');
            select.innerHTML = '<option value="">Pilih Kandang</option>' +
                data.data.pens.map(pen => `
                    <option value="${pen.id}">${pen.name} - ${pen.category}</option>
                `).join('');
        }
    } catch (error) {
        console.error('Error loading pens for modal:', error);
    }
}

function applyFilters() {
    currentFilters = {
        pen_id: document.getElementById('pen-filter').value,
        status: document.getElementById('status-filter').value,
        breed_type: document.getElementById('breed-filter').value
    };

    // Remove empty filters
    Object.keys(currentFilters).forEach(key => {
        if (!currentFilters[key]) {
            delete currentFilters[key];
        }
    });

    loadLivestocks(1);
}

function openAddModal() {
    document.getElementById('add-modal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('add-modal').classList.add('hidden');
    document.getElementById('add-livestock-form').reset();
}

async function submitAddForm() {
    const form = document.getElementById('add-livestock-form');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="button"]');

    Utils.showLoading(submitBtn);

    try {
        const response = await fetch('/api/livestocks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            closeAddModal();
            loadLivestocks();
            showSuccess('Ternak berhasil ditambahkan');
        } else {
            showError(data.message || 'Gagal menambahkan ternak');
        }
    } catch (error) {
        console.error('Error adding livestock:', error);
        showError('Gagal menambahkan ternak');
    } finally {
        Utils.hideLoading(submitBtn, 'Simpan');
    }
}

function openWeightModal(livestockId, earTag) {
    document.getElementById('weight_livestock_id').value = livestockId;
    document.getElementById('weight-modal-title').textContent = `Catat Berat - ${earTag}`;
    document.getElementById('weight-modal').classList.remove('hidden');
}

function closeWeightModal() {
    document.getElementById('weight-modal').classList.add('hidden');
    document.getElementById('record-weight-form').reset();
}

async function submitWeightForm() {
    const form = document.getElementById('record-weight-form');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="button"]');

    Utils.showLoading(submitBtn);

    try {
        const livestockId = document.getElementById('weight_livestock_id').value;
        const response = await fetch(`/api/livestocks/${livestockId}/record-weight`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            closeWeightModal();
            loadLivestocks();
            showSuccess('Berat badan berhasil dicatat');
        } else {
            showError(data.message || 'Gagal mencatat berat badan');
        }
    } catch (error) {
        console.error('Error recording weight:', error);
        showError('Gagal mencatat berat badan');
    } finally {
        Utils.hideLoading(submitBtn, 'Simpan');
    }
}

function viewLivestock(id) {
    window.location.href = `/livestocks/${id}`;
}

function predictGrowth(id) {
    window.location.href = `/predictions?livestock_id=${id}`;
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
@endpush
