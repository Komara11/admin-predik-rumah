@extends('layouts.admin')

@section('title', 'Admin Dashboard - Dataset Management')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mb-12">
    <!-- Upload Form Card -->
    <div class="neumorphic-outset rounded-3xl p-8 bg-background lg:col-span-1 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-6 text-primary">
                <span class="material-symbols-outlined">upload_file</span>
                <h3 class="font-headline-md text-headline-md font-bold">Upload Dataset</h3>
            </div>
            <p class="text-label-sm text-on-surface-variant mb-6">
                Unggah file Excel (.xlsx) berisi data properti Majalengka terbaru untuk menambah data training.
            </p>
            
            <form id="uploadForm" action="{{ route('admin.dataset.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="neumorphic-inset rounded-2xl p-6 border-2 border-dashed border-outline-variant flex flex-col items-center justify-center text-center cursor-pointer hover:bg-surface-container-low transition-colors min-h-[180px]" id="dropZone">
                    <span class="material-symbols-outlined text-4xl text-primary mb-2">cloud_upload</span>
                    <span class="font-label-md text-label-md text-on-surface" id="fileLabel">Pilih File Excel (.xlsx)</span>
                    <span class="text-[11px] text-on-surface-variant mt-1">Maksimal 10MB</span>
                    <input type="file" name="dataset_file" class="hidden" id="fileInput" accept=".csv,.xlsx,.xls" required />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-background neumorphic-outset text-primary font-bold text-headline-md flex items-center justify-center gap-2 transition-all hover:scale-[1.02]" id="uploadBtn">
                        <span class="material-symbols-outlined">publish</span>
                        Proses &amp; Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="neumorphic-outset rounded-3xl p-8 bg-background lg:col-span-2">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl neumorphic-inset bg-background border-l-4 border-success-green">
            <div class="flex items-center gap-2 text-success-green">
                <span class="material-symbols-outlined">check_circle</span>
                <span class="font-bold text-label-md">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Database Properti</h3>
                <p class="text-label-sm text-on-surface-variant">Total {{ $totalCount }} data properti.</p>
            </div>
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.dataset') }}" class="relative flex items-center w-full sm:w-64">
                <span class="material-symbols-outlined absolute left-4 text-on-surface-variant text-body-md">search</span>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari kecamatan..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl neumorphic-inset bg-background border-none focus:ring-1 focus:ring-primary outline-none text-body-md" />
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="neumorphic-outset rounded-xl">
                        <th class="p-4 font-label-md text-label-md text-on-surface-variant">ID</th>
                        <th class="p-4 font-label-md text-label-md text-on-surface-variant">Kecamatan</th>
                        <th class="p-4 font-label-md text-label-md text-on-surface-variant">Luas (T/B)</th>
                        <th class="p-4 font-label-md text-label-md text-on-surface-variant">Kamar</th>
                        <th class="p-4 font-label-md text-label-md text-on-surface-variant">Tipe</th>
                        <th class="p-4 font-label-md text-label-md text-on-surface-variant">Harga</th>
                        <th class="p-4 font-label-md text-label-md text-on-surface-variant text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $prop)
                    <tr class="border-b border-surface-dark-shadow/30">
                        <td class="p-4 font-semibold text-on-surface-variant">#{{ $prop->id }}</td>
                        <td class="p-4 font-semibold text-on-surface">{{ $prop->lokasi }}</td>
                        <td class="p-4">{{ $prop->luas_tanah }}m² / {{ $prop->luas_bangunan }}m²</td>
                        <td class="p-4">{{ $prop->kmr_tidur }}T / {{ $prop->kmr_mandi }}M</td>
                        <td class="p-4">{{ $prop->tipe_properti }}</td>
                        <td class="p-4 font-bold">Rp {{ number_format($prop->harga, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <form action="{{ route('admin.dataset.destroy', $prop) }}" method="POST" onsubmit="return confirm('Hapus data properti #{{ $prop->id }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 neumorphic-outset rounded-lg text-error-red hover:text-error transition-all">
                                        <span class="material-symbols-outlined text-body-md">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-between items-center mt-8 pt-4">
            <span class="text-label-sm text-on-surface-variant">
                Menampilkan {{ $properties->firstItem() ?? 0 }}-{{ $properties->lastItem() ?? 0 }} dari {{ $totalCount }} baris
            </span>
            <div class="flex gap-2">
                @if($properties->previousPageUrl())
                    <a href="{{ $properties->previousPageUrl() }}" class="px-4 py-2 neumorphic-outset rounded-lg text-primary text-label-sm hover:text-on-primary-fixed-variant transition-all">Sebelumnya</a>
                @else
                    <button class="px-4 py-2 neumorphic-inset rounded-lg text-on-surface-variant text-label-sm cursor-not-allowed" disabled>Sebelumnya</button>
                @endif
                @if($properties->nextPageUrl())
                    <a href="{{ $properties->nextPageUrl() }}" class="px-4 py-2 neumorphic-outset rounded-lg text-primary text-label-sm hover:text-on-primary-fixed-variant transition-all">Selanjutnya</a>
                @else
                    <button class="px-4 py-2 neumorphic-inset rounded-lg text-on-surface-variant text-label-sm cursor-not-allowed" disabled>Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileLabel = document.getElementById('fileLabel');

        if (dropZone && fileInput) {
            dropZone.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', (e) => {
                if(e.target.files.length > 0) {
                    fileLabel.innerText = e.target.files[0].name;
                    dropZone.classList.add('border-primary');
                }
            });
        }
    });
</script>
@endpush
