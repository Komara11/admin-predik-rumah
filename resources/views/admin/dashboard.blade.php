@extends('layouts.admin')

@section('title', 'Admin Dashboard - Overview')

@section('content')
<!-- Metric Summary (Bento Grid) -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-12">
    <!-- Stat 1: Total Dataset -->
    <div class="neumorphic-outset rounded-3xl p-6 bg-background flex items-center gap-4">
        <div class="w-12 h-12 neumorphic-inset rounded-2xl flex items-center justify-center text-primary">
            <span class="material-symbols-outlined">database</span>
        </div>
        <div>
            <div class="font-label-sm text-label-sm text-on-surface-variant">Total Dataset</div>
            <div class="font-headline-md text-headline-md font-bold text-on-surface">{{ number_format($totalProperties) }} <span class="font-label-sm text-label-sm text-on-surface-variant">baris</span></div>
        </div>
    </div>
    <!-- Stat 2: Akurasi Model -->
    <div class="neumorphic-outset rounded-3xl p-6 bg-background flex items-center gap-4">
        <div class="w-12 h-12 neumorphic-inset rounded-2xl flex items-center justify-center text-success-green">
            <span class="material-symbols-outlined">verified</span>
        </div>
        <div>
            <div class="font-label-sm text-label-sm text-on-surface-variant">Akurasi Model</div>
            <div class="font-headline-md text-headline-md font-bold text-success-green">
                {{ $modelInfo && isset($modelInfo['accuracy_pct']) ? $modelInfo['accuracy_pct'] . '%' : 'N/A' }}
            </div>
            @if($modelInfo && isset($modelInfo['r2_test']))
                <div class="text-[11px] text-on-surface-variant">R² = {{ $modelInfo['r2_test'] }}</div>
            @endif
        </div>
    </div>
    <!-- Stat 3: MAE -->
    <div class="neumorphic-outset rounded-3xl p-6 bg-background flex items-center gap-4">
        <div class="w-12 h-12 neumorphic-inset rounded-2xl flex items-center justify-center text-primary">
            <span class="material-symbols-outlined">payments</span>
        </div>
        <div>
            <div class="font-label-sm text-label-sm text-on-surface-variant">MAE (Error Rata-rata)</div>
            <div class="font-headline-md text-headline-md font-bold text-on-surface">
                @if($modelInfo && isset($modelInfo['mae']))
                    Rp {{ number_format($modelInfo['mae'] / 1000000, 1) }}M
                @else
                    Rp {{ number_format($avgPrice / 1000000, 0) }}M
                @endif
            </div>
            @if($modelInfo && isset($modelInfo['rmse']))
                <div class="text-[11px] text-on-surface-variant">RMSE: Rp {{ number_format($modelInfo['rmse'] / 1000000, 1) }}M</div>
            @endif
        </div>
    </div>
    <!-- Stat 4: Total Prediksi -->
    <div class="neumorphic-outset rounded-3xl p-6 bg-background flex items-center gap-4">
        <div class="w-12 h-12 neumorphic-inset rounded-2xl flex items-center justify-center text-primary">
            <span class="material-symbols-outlined">history</span>
        </div>
        <div>
            <div class="font-label-sm text-label-sm text-on-surface-variant">Total Prediksi User</div>
            <div class="font-headline-md text-headline-md font-bold text-on-surface">{{ $totalPredictions }}</div>
            @if($modelInfo && isset($modelInfo['trained_at']))
                <div class="text-[11px] text-on-surface-variant">Trained: {{ \Carbon\Carbon::parse($modelInfo['trained_at'])->format('d M Y, H:i') }}</div>
            @endif
        </div>
    </div>
</section>

<!-- Accuracy & Model Performance Section -->
@if($modelInfo && isset($modelInfo['accuracy_pct']))
<section class="neumorphic-outset rounded-3xl p-8 bg-background mb-12">
    <div class="flex items-center gap-3 mb-8">
        <span class="material-symbols-outlined text-primary">speed</span>
        <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Performa Model Machine Learning</h3>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-gutter">
        <div class="neumorphic-inset rounded-2xl p-4 text-center">
            <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">Akurasi (MAPE)</div>
            <div class="font-headline-md text-headline-md font-bold text-success-green">{{ $modelInfo['accuracy_pct'] }}%</div>
        </div>
        <div class="neumorphic-inset rounded-2xl p-4 text-center">
            <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">R² Train</div>
            <div class="font-headline-md text-headline-md font-bold text-on-surface">{{ $modelInfo['r2_train'] ?? '—' }}</div>
        </div>
        <div class="neumorphic-inset rounded-2xl p-4 text-center">
            <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">R² Test</div>
            <div class="font-headline-md text-headline-md font-bold text-primary">{{ $modelInfo['r2_test'] ?? '—' }}</div>
        </div>
        <div class="neumorphic-inset rounded-2xl p-4 text-center">
            <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">CV Mean ± Std</div>
            <div class="font-headline-md text-headline-md font-bold text-on-surface">{{ $modelInfo['cv_mean'] ?? '—' }} <span class="text-label-sm text-on-surface-variant">± {{ $modelInfo['cv_std'] ?? '—' }}</span></div>
        </div>
        <div class="neumorphic-inset rounded-2xl p-4 text-center">
            <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">MAPE</div>
            <div class="font-headline-md text-headline-md font-bold text-on-surface">{{ $modelInfo['mape'] ?? '—' }}%</div>
        </div>
        <div class="neumorphic-inset rounded-2xl p-4 text-center">
            <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">Jumlah Pohon</div>
            <div class="font-headline-md text-headline-md font-bold text-on-surface">{{ $modelInfo['n_estimators'] }}</div>
        </div>
    </div>
</section>
@endif

<!-- Visualizations Section -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-gutter mb-12">
    <!-- Chart 1: Feature Importance -->
    <div class="neumorphic-outset rounded-3xl p-8 bg-background">
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Bobot Parameter Model</h3>
            <span class="material-symbols-outlined text-primary">analytics</span>
        </div>
        <div class="space-y-6">
            @if($modelInfo && isset($modelInfo['feature_importances']))
                @php
                    $featureLabels = [
                        'luas_bangunan' => 'Luas Bangunan (m²)',
                        'lokasi_encoded' => 'Lokasi (Kecamatan)',
                        'luas_tanah' => 'Luas Tanah (m²)',
                        'usia' => 'Usia Bangunan',
                        'tipe_properti_encoded' => 'Tipe Properti',
                        'kmr_tidur' => 'Jumlah Kamar Tidur',
                        'tahun' => 'Tahun Data',
                        'ada_garasi' => 'Ketersediaan Garasi',
                        'kmr_mandi' => 'Jumlah Kamar Mandi',
                        'kondisi_encoded' => 'Kondisi Bangunan',
                    ];
                    $colors = ['bg-primary', 'bg-secondary', 'bg-tertiary-container', 'bg-success-green', 'bg-outline-variant'];
                    $i = 0;
                @endphp
                @foreach($modelInfo['feature_importances'] as $key => $value)
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-label-md font-label-md">{{ $featureLabels[$key] ?? $key }}</span>
                        <span class="text-label-md font-label-md">{{ round($value * 100, 2) }}%</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container-low rounded-full neumorphic-inset overflow-hidden">
                        <div class="h-full {{ $colors[$i % count($colors)] }} animate-bar" style="width: {{ round($value * 100, 1) }}%"></div>
                    </div>
                </div>
                @php $i++; @endphp
                @endforeach
            @else
                <p class="text-on-surface-variant">Model belum tersedia. Jalankan Flask API terlebih dahulu.</p>
            @endif
        </div>
    </div>

    <!-- Chart 2: Location Distribution -->
    <div class="neumorphic-outset rounded-3xl p-8 bg-background">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Distribusi Lokasi</h3>
            <span class="material-symbols-outlined text-primary">map</span>
        </div>
        <div class="space-y-4">
            @foreach($locationCounts as $loc)
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-label-md font-label-md">{{ $loc->lokasi }}</span>
                    <span class="text-label-md font-label-md">{{ $loc->total }} data</span>
                </div>
                <div class="h-3 w-full bg-surface-container-low rounded-full neumorphic-inset overflow-hidden">
                    <div class="h-full bg-secondary animate-bar" style="width: {{ round(($loc->total / $totalProperties) * 100) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Recent Prediction Logs -->
<section class="neumorphic-outset rounded-3xl p-8 bg-background">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Log Prediksi Terbaru</h3>
            <p class="text-label-sm text-label-sm text-on-surface-variant">Daftar estimasi harga yang diinput oleh publik.</p>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="neumorphic-outset rounded-xl">
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant">Tanggal</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant">Lokasi</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant">Luas (T/B)</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant">Tipe</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant">Kondisi</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant">Confidence</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant">Hasil Prediksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestPredictions as $pred)
                <tr class="border-b border-surface-dark-shadow/30">
                    <td class="p-4 text-on-surface-variant text-label-sm">{{ $pred->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-4 font-semibold text-on-surface">{{ $pred->input_data['lokasi'] ?? '-' }}</td>
                    <td class="p-4">{{ $pred->input_data['luas_tanah'] ?? '-' }}m² / {{ $pred->input_data['luas_bangunan'] ?? '-' }}m²</td>
                    <td class="p-4">{{ $pred->input_data['tipe_properti'] ?? '-' }}</td>
                    <td class="p-4">{{ $pred->input_data['kondisi'] ?? '-' }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-lg text-[11px] font-bold {{ $pred->confidence >= 80 ? 'bg-success-green/10 text-success-green' : ($pred->confidence >= 60 ? 'bg-tertiary-container/30 text-tertiary-container' : 'bg-error-red/10 text-error-red') }}">
                            {{ $pred->confidence }}%
                        </span>
                    </td>
                    <td class="p-4 font-bold text-primary">Rp {{ number_format($pred->predicted_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-on-surface-variant">Belum ada log prediksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bars = document.querySelectorAll('.animate-bar');
        bars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => { bar.style.width = width; }, 300);
        });
    });
</script>
@endpush
