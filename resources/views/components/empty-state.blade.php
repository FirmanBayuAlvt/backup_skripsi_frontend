<div class="text-center py-12">
    <i class="fas fa-{{ $icon ?? 'inbox' }} text-4xl text-gray-300 mb-3"></i>
    <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $title ?? 'Tidak ada data' }}</h3>
    <p class="text-gray-500 mb-4">{{ $description ?? 'Data tidak ditemukan' }}</p>
    @if(isset($action))
        {{ $action }}
    @endif
</div>
