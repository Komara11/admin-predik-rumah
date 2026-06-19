@extends('layouts.admin')

@section('title', 'Admin Dashboard - Model Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mb-12">
    <!-- Parameters Configuration Card -->
    <div class="neumorphic-outset rounded-3xl p-8 bg-background lg:col-span-1 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-6 text-primary">
                <span class="material-symbols-outlined">tune</span>
                <h3 class="font-headline-md text-headline-md font-bold">Parameter Model</h3>
            </div>
            <p class="text-label-sm text-on-surface-variant mb-6">
                Sesuaikan parameter algoritma Random Forest untuk pelatihan model berikutnya.
            </p>
            
            <form id="settingsForm" class="space-y-6">
                @csrf
                <!-- Estimator Slider -->
                <div class="space-y-2">
                    <div class="flex justify-between ml-1 text-label-md font-label-md">
                        <label for="n_estimators">n_estimators (Jumlah Pohon)</label>
                        <span class="text-primary font-bold" id="estimatorsVal">{{ $modelInfo['n_estimators'] ?? 100 }}</span>
                    </div>
                    <input
                        id="n_estimators"
                        name="n_estimators"
                        type="range"
                        min="10"
                        max="500"
                        value="{{ $modelInfo['n_estimators'] ?? 100 }}"
                        step="10"
                        class="w-full h-4 rounded-full neumorphic-inset bg-background appearance-none cursor-pointer accent-primary" />
                </div>

                <!-- Max Depth Slider -->
                <div class="space-y-2">
                    <div class="flex justify-between ml-1 text-label-md font-label-md">
                        <label for="max_depth">max_depth (Kedalaman Maksimal)</label>
                        <span class="text-primary font-bold" id="depthVal">Tak Terbatas</span>
                    </div>
                    <input
                        id="max_depth"
                        name="max_depth"
                        type="range"
                        min="5"
                        max="50"
                        value="50"
                        step="5"
                        class="w-full h-4 rounded-full neumorphic-inset bg-background appearance-none cursor-pointer accent-primary" />
                </div>

                <!-- Test Size Slider -->
                <div class="space-y-2">
                    <div class="flex justify-between ml-1 text-label-md font-label-md">
                        <label for="test_size">test_size (Ukuran Data Uji)</label>
                        <span class="text-primary font-bold" id="testSizeVal">20%</span>
                    </div>
                    <input
                        id="test_size"
                        name="test_size"
                        type="range"
                        min="10"
                        max="50"
                        value="20"
                        step="5"
                        class="w-full h-4 rounded-full neumorphic-inset bg-background appearance-none cursor-pointer accent-primary" />
                </div>
            </form>
        </div>

        <div class="pt-8">
            <button class="w-full py-4 bg-background neumorphic-outset text-primary font-bold text-headline-md flex items-center justify-center gap-2 transition-all hover:scale-[1.02] active:scale-95" id="retrainBtn">
                <span class="material-symbols-outlined">refresh</span>
                Latih Ulang Model
            </button>
        </div>
    </div>

    <!-- Training Outputs & Console Logs -->
    <div class="neumorphic-outset rounded-3xl p-8 bg-background lg:col-span-2 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-6 text-primary">
                <span class="material-symbols-outlined">terminal</span>
                <h3 class="font-headline-md text-headline-md font-bold">Konsol Output Pelatihan</h3>
            </div>
            
            <!-- Output Console Box -->
            <div class="w-full h-64 p-6 rounded-2xl neumorphic-inset bg-[#1e293b] text-[#38bdf8] font-mono text-xs overflow-y-auto space-y-2" id="consoleLogs">
                <div class="text-[#94a3b8]">[{{ now()->format('H:i:s') }}] Model idle. Menunggu inisialisasi dari admin...</div>
                @if($modelInfo)
                <div class="text-[#94a3b8]">[{{ now()->format('H:i:s') }}] Model aktif: n_estimators={{ $modelInfo['n_estimators'] }}, {{ $modelInfo['n_features'] }} fitur</div>
                @endif
            </div>
        </div>

        <!-- Metric comparison cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-gutter mt-8">
            <div class="neumorphic-inset rounded-2xl p-6">
                <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">R² Test (Sebelum Retrain)</div>
                <div class="font-headline-lg text-headline-lg font-bold text-on-surface" id="prevR2">—</div>
                <div class="text-[11px] text-on-surface-variant mt-1" id="prevDate">Belum ada pelatihan</div>
            </div>
            <div class="neumorphic-inset rounded-2xl p-6">
                <div class="font-label-sm text-label-sm text-on-surface-variant mb-1">R² Test (Sesudah Retrain)</div>
                <div class="font-headline-lg text-headline-lg font-bold text-primary" id="currR2">—</div>
                <div class="text-[11px] text-on-surface-variant mt-1" id="currInfo">Jalankan retrain untuk melihat</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const estSlider = document.getElementById('n_estimators');
        const depthSlider = document.getElementById('max_depth');
        const sizeSlider = document.getElementById('test_size');
        const estVal = document.getElementById('estimatorsVal');
        const depthVal = document.getElementById('depthVal');
        const sizeVal = document.getElementById('testSizeVal');
        const retrainBtn = document.getElementById('retrainBtn');
        const consoleBox = document.getElementById('consoleLogs');
        const prevR2 = document.getElementById('prevR2');
        const currR2 = document.getElementById('currR2');
        const currInfo = document.getElementById('currInfo');

        estSlider.addEventListener('input', (e) => estVal.innerText = e.target.value);
        depthSlider.addEventListener('input', (e) => {
            depthVal.innerText = e.target.value == 50 ? 'Tak Terbatas' : e.target.value;
        });
        sizeSlider.addEventListener('input', (e) => sizeVal.innerText = e.target.value + '%');

        function addLog(text, color) {
            const time = new Date().toLocaleTimeString();
            const logDiv = document.createElement('div');
            logDiv.innerHTML = `<span class="text-[#94a3b8]">[${time}]</span> <span style="color: ${color}">${text}</span>`;
            consoleBox.appendChild(logDiv);
            consoleBox.scrollTop = consoleBox.scrollHeight;
        }

        if (retrainBtn) {
            retrainBtn.addEventListener('click', async () => {
                retrainBtn.disabled = true;
                retrainBtn.style.boxShadow = 'inset 4px 4px 8px #D1D9E6, inset -4px -4px 8px #FFFFFF';
                retrainBtn.innerHTML = `
                    <span class="material-symbols-outlined animate-spin">sync</span>
                    Melatih Model...
                `;

                consoleBox.innerHTML = '';
                addLog('Menginisialisasi pipeline pelatihan Random Forest...', '#f43f5e');

                setTimeout(() => addLog('Membaca database properti...', '#eab308'), 500);
                setTimeout(() => addLog(`Parameter: n_estimators=${estSlider.value}, max_depth=${depthSlider.value == 50 ? 'None' : depthSlider.value}, test_size=${sizeSlider.value}%`, '#3b82f6'), 1000);
                setTimeout(() => addLog('Melatih pohon keputusan...', '#a855f7'), 1500);

                try {
                    const response = await fetch('{{ route("admin.settings.retrain") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            n_estimators: parseInt(estSlider.value),
                            max_depth: parseInt(depthSlider.value),
                            test_size: parseInt(sizeSlider.value)
                        })
                    });

                    const result = await response.json();

                    if (result.error) {
                        addLog('❌ Error: ' + result.error, '#f43f5e');
                    } else {
                        addLog(`✅ Model selesai dilatih!`, '#22c55e');
                        addLog(`   R² Train: ${result.r2_train}`, '#22c55e');
                        addLog(`   R² Test:  ${result.r2_test}`, '#22c55e');
                        addLog(`   MAE: Rp ${result.mae.toLocaleString('id-ID')}`, '#38bdf8');
                        addLog(`   RMSE: Rp ${result.rmse.toLocaleString('id-ID')}`, '#38bdf8');
                        addLog(`   CV Mean: ${result.cv_mean} ± ${result.cv_std}`, '#38bdf8');
                        addLog(`   Train: ${result.train_count} data, Test: ${result.test_count} data`, '#94a3b8');

                        // Update metric cards
                        prevR2.innerText = currR2.innerText !== '—' ? currR2.innerText : '—';
                        currR2.innerText = result.r2_test;
                        currInfo.innerText = `MAE: Rp ${(result.mae / 1000000).toFixed(1)}M | ${new Date().toLocaleDateString('id-ID')}`;
                        currInfo.classList.remove('text-on-surface-variant');
                        currInfo.classList.add('text-success-green');
                    }
                } catch (err) {
                    addLog('❌ Gagal terhubung ke Flask API: ' + err.message, '#f43f5e');
                    addLog('Pastikan Flask API berjalan di port 5000.', '#eab308');
                }

                retrainBtn.disabled = false;
                retrainBtn.style.boxShadow = '';
                retrainBtn.innerHTML = `
                    <span class="material-symbols-outlined">refresh</span>
                    Latih Ulang Model
                `;
            });
        }
    });
</script>
@endpush
