@extends('layouts.admin')

@section('title', 'Admin Dashboard - Panduan & Dokumentasi')

@section('content')
<!-- Header Page -->
<section class="mb-10">
    <h1 class="font-headline-lg md:font-display-lg text-headline-lg md:text-display-lg font-bold text-on-surface mb-2">Panduan & Dokumentasi Sistem</h1>
    <p class="text-body-md text-on-surface-variant max-w-3xl">
        Halaman ini memberikan penjelasan mendalam tentang metrik performa model, cara melakukan pelatihan ulang (retraining), pembobotan parameter (feature importance), serta panduan operasional sistem untuk keperluan sidang Tugas Akhir.
    </p>
</section>

<!-- Tab Navigation (Neumorphic Style) -->
<div class="grid grid-cols-2 md:flex md:flex-wrap gap-3 md:gap-4 mb-8">
    <button onclick="switchTab('dashboard-tab')" id="btn-dashboard-tab" 
        class="tab-btn flex items-center justify-center md:justify-start gap-2 px-4 md:px-6 py-3 rounded-2xl font-semibold text-label-md transition-all duration-300 w-full md:w-auto neumorphic-inset text-primary">
        <span class="material-symbols-outlined text-[20px]">dashboard</span>
        <span class="truncate">Ikhtisar Dashboard</span>
    </button>
    <button onclick="switchTab('retrain-tab')" id="btn-retrain-tab" 
        class="tab-btn flex items-center justify-center md:justify-start gap-2 px-4 md:px-6 py-3 rounded-2xl font-semibold text-label-md transition-all duration-300 w-full md:w-auto neumorphic-outset text-on-surface-variant hover:text-primary hover:scale-[1.02] active:scale-95">
        <span class="material-symbols-outlined text-[20px]">settings_suggest</span>
        <span class="truncate">Pelatihan Model</span>
    </button>
    <button onclick="switchTab('theory-tab')" id="btn-theory-tab" 
        class="tab-btn flex items-center justify-center md:justify-start gap-2 px-4 md:px-6 py-3 rounded-2xl font-semibold text-label-md transition-all duration-300 w-full md:w-auto neumorphic-outset text-on-surface-variant hover:text-primary hover:scale-[1.02] active:scale-95">
        <span class="material-symbols-outlined text-[20px]">analytics</span>
        <span class="truncate">Teori & Bobot ML</span>
    </button>
    <button onclick="switchTab('user-tab')" id="btn-user-tab" 
        class="tab-btn flex items-center justify-center md:justify-start gap-2 px-4 md:px-6 py-3 rounded-2xl font-semibold text-label-md transition-all duration-300 w-full md:w-auto neumorphic-outset text-on-surface-variant hover:text-primary hover:scale-[1.02] active:scale-95">
        <span class="material-symbols-outlined text-[20px]">menu_book</span>
        <span class="truncate">Panduan Pengguna</span>
    </button>
</div>

<!-- Tab Content Wrapper -->
<div class="space-y-10">

    <!-- TAB 1: IKHTISAR DASHBOARD -->
    <div id="dashboard-tab" class="tab-content block">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
            <!-- Left Side: Bento Cards explaining Top Metrics -->
            <div class="space-y-6">
                <div class="neumorphic-outset rounded-3xl p-6 bg-background">
                    <h3 class="font-headline-md text-headline-md font-bold text-primary mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">info</span>
                        Penjelasan 4 Metrik Utama Dashboard
                    </h3>
                    <div class="space-y-4">
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">1. Total Dataset (Baris)</span>
                            <p class="text-label-md text-on-surface-variant">
                                Representasi total sampel data transaksi penjualan rumah nyata di Kabupaten Majalengka yang telah dimasukkan ke database. Seluruh baris data ini diekspor dan dipakai oleh Flask API untuk proses pembelajaran (*training*).
                            </p>
                        </div>
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-success-green block mb-1">2. Akurasi Model (MAPE)</span>
                            <p class="text-label-md text-on-surface-variant">
                                Dihitung dengan rumus $100\% - \text{MAPE}$. Nilai ini mencerminkan keakuratan model dalam memprediksi data uji (*test set*) yang belum pernah dipelajari sebelumnya. Jika akurasi bernilai 84.63%, berarti tingkat kesalahan prediksi rata-rata model adalah 15.37%.
                            </p>
                        </div>
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">3. MAE (Mean Absolute Error)</span>
                            <p class="text-label-md text-on-surface-variant">
                                Rata-rata absolut selisih antara harga prediksi dengan harga penjualan riil. Contoh: MAE sebesar Rp 38 Juta menandakan bahwa rata-rata simpangan kesalahan nominal prediksi model berada pada kisaran kurang lebih Rp 38.640.515 dari harga aslinya.
                            </p>
                        </div>
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">4. Total Prediksi Publik</span>
                            <p class="text-label-md text-on-surface-variant">
                                Jumlah akumulasi pengetesan prediksi harga yang diinputkan oleh masyarakat umum secara eksternal. Setiap kali masyarakat menekan tombol prediksi, log input dan hasilnya disimpan di database admin.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Explanation of visual graphs and logs -->
            <div class="space-y-6">
                <div class="neumorphic-outset rounded-3xl p-6 bg-background">
                    <h3 class="font-headline-md text-headline-md font-bold text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">analytics</span>
                        Penjelasan Grafik & Log
                    </h3>
                    <div class="space-y-4 text-label-md text-on-surface-variant">
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">Grafik Bobot Parameter (Feature Importance)</span>
                            <p>
                                Visualisasi ini menampilkan parameter fisik/geografis rumah mana yang paling krusial bagi keputusan penetapan harga model Random Forest. Parameter dengan persentase paling tinggi (misalnya Luas Bangunan) merupakan penentu harga terkuat secara matematis.
                            </p>
                        </div>
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">Grafik Distribusi Lokasi</span>
                            <p>
                                Menunjukkan kecamatan mana saja di Majalengka yang memiliki data paling melimpah di dalam dataset. Ini berguna untuk menilai apakah model kita bias terhadap daerah urban (seperti Kec. Majalengka atau Jatiwangi) dibandingkan daerah rural.
                            </p>
                        </div>
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">Log Prediksi Terbaru</span>
                            <p>
                                Merupakan rekaman transaksi maya dari masyarakat. Menampilkan tanggal, detail masukan parameter rumah, tingkat keyakinan (*confidence score*), serta estimasi harga yang diberikan oleh model regresi secara real-time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: RETRAIN SYSTEM -->
    <div id="retrain-tab" class="tab-content hidden">
        <div class="neumorphic-outset rounded-3xl p-8 bg-background">
            <h3 class="font-headline-md text-headline-md font-bold text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">rocket_launch</span>
                Alur & Parameter Pelatihan Ulang (Model Retraining)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-label-md text-on-surface-variant mb-8">
                <div>
                    <h4 class="font-semibold text-on-surface mb-2">Mengapa Model Perlu Dilatih Ulang?</h4>
                    <p class="mb-4">
                        Nilai pasar properti di Kabupaten Majalengka terus mengalami inflasi dan perubahan tren spasial (misal akibat pembangunan BIJB Kertajati). Agar prediksi tetap akurat dan relevan, model *Machine Learning* harus disegarkan (re-trained) dengan memasukkan baris data riil penjualan properti terbaru.
                    </p>
                    <h4 class="font-semibold text-on-surface mb-2">Langkah Pelatihan Ulang:</h4>
                    <ol class="list-decimal list-inside space-y-2">
                        <li>Buka menu <strong>Dataset</strong> pada navigasi atas.</li>
                        <li>Masukkan data properti baru secara manual melalui form, atau lakukan ekspor/impor langsung dari basis data server.</li>
                        <li>Buka menu <strong>Settings</strong> pada navigasi atas.</li>
                        <li>Atur hyperparameter model (Jumlah Pohon, Max Depth, Test Size) lalu klik <strong>Latih Ulang Model</strong>.</li>
                        <li>Sistem secara otomatis akan melatih ulang model Random Forest melalui Flask API dan mengganti file biner <code class="bg-surface-container-low px-1.5 py-0.5 rounded font-mono text-[12px]">model.joblib</code> secara instan tanpa mematikan aplikasi web (*zero-downtime hot swap*).</li>
                    </ol>
                </div>
                
                <div>
                    <h4 class="font-semibold text-on-surface mb-2">Penjelasan Hyperparameter Settings:</h4>
                    <div class="space-y-4">
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">Jumlah Pohon (Estimators)</span>
                            <p class="text-[13px]">
                                Menentukan berapa banyak pohon keputusan (*Decision Trees*) independen yang dibuat. Semakin banyak pohon (misal 100 s/d 200), prediksi cenderung semakin stabil dan akurat karena variansi ditekan, namun memakan memori komputasi lebih lama saat retraining.
                            </p>
                        </div>
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">Kedalaman Maksimum (Max Depth)</span>
                            <p class="text-[13px]">
                                Membatasi tingkat percabangan ke bawah pada pohon. Pengaturan <strong>Auto</strong> membiarkan cabang tumbuh maksimal hingga data terbagi habis. Membatasi kedalaman (misal 10-15 tingkat) sangat membantu jika model mengalami indikasi *Overfitting*.
                            </p>
                        </div>
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">Porsi Data Uji (Test Size %)</span>
                            <p class="text-[13px]">
                                Mengatur rasio data yang akan diisolasi sebagai data evaluasi (tidak ikut dipelajari model). Umumnya diatur sebesar 20%, yang berarti jika total dataset ada 150 baris, maka 120 baris dipakai untuk belajar (*Training Set*) dan 30 baris dipakai untuk ujian akurasi (*Test Set*).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: MACHINE LEARNING THEORY & METRICS -->
    <div id="theory-tab" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
            <!-- Column 1 & 2: RF Algorithm and Feature Importance -->
            <div class="lg:col-span-2 space-y-6">
                <div class="neumorphic-outset rounded-3xl p-8 bg-background">
                    <h3 class="font-headline-md text-headline-md font-bold text-primary mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined">forest</span>
                        Metodologi Regresi Random Forest
                    </h3>
                    <div class="text-label-md text-on-surface-variant space-y-4">
                        <p>
                            Sistem ini menggunakan algoritma **Random Forest Regressor**, sebuah metode *ensemble learning* (metode yang menggabungkan banyak model sederhana) berbasis pohon keputusan (*Decision Trees*).
                        </p>
                        <div class="neumorphic-inset rounded-2xl p-5 bg-background">
                            <span class="font-semibold text-on-surface block mb-2">Cara Kerja Random Forest Regressor:</span>
                            <ul class="list-disc list-inside space-y-2">
                                <li><strong>Bootstrapping:</strong> Membuat sub-sampel dataset secara acak dengan pengembalian untuk setiap pohon keputusan.</li>
                                <li><strong>Random Feature Selection:</strong> Di setiap percabangan pohon, algoritma hanya memilih sebagian fitur secara acak untuk membagi data. Hal ini mencegah dominasi fitur tertentu dan menghasilkan pohon yang beragam (*uncorrelated trees*).</li>
                                <li><strong>Averaging:</strong> Ketika prediksi dilakukan, masing-masing dari 100 pohon akan menghasilkan nilai prediksi nominal harga tersendiri. Nilai akhir prediksi yang dikembalikan ke user adalah **nilai rata-rata** dari seluruh prediksi pohon keputusan tersebut.</li>
                            </ul>
                        </div>
                        <h4 class="font-semibold text-on-surface mt-6">Interpretasi Pembobotan Parameter (Feature Importance)</h4>
                        <p>
                            *Feature Importance* dihitung secara internal menggunakan teknik *Mean Decrease in Impurity* (Gini Importance) pada pohon-pohon keputusan. Parameter dengan persentase paling dominan menandakan bahwa parameter tersebut paling sering digunakan untuk membagi data secara signifikan guna meminimalkan kesalahan prediksi harga.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Column 3: Deep Metrics Explanation -->
            <div class="space-y-6">
                <div class="neumorphic-outset rounded-3xl p-6 bg-background">
                    <h3 class="font-headline-md text-headline-md font-bold text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined">speed</span>
                        Formulasi & Evaluasi Akademik
                    </h3>
                    <div class="space-y-4 text-[13px] text-on-surface-variant">
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">R² (Koefisien Determinasi)</span>
                            <p class="mb-2">Mengukur kontribusi variabel independen terhadap variabel dependen. Rentang nilai 0 hingga 1.</p>
                            <code class="block bg-surface-container-low p-2 rounded text-[11px] font-mono text-center">R² = 1 - (SS_res / SS_tot)</code>
                            <p class="mt-2 text-[11px]">R² Test sebesar 0.8139 menandakan bahwa 81.39% variasi harga properti di Majalengka dapat dijelaskan oleh 10 fitur fisik/lokasi yang ada pada model.</p>
                        </div>
                        
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">MAPE (Mean Absolute Percentage Error)</span>
                            <p class="mb-2">Persentase rata-rata penyimpangan prediksi terhadap harga riil.</p>
                            <code class="block bg-surface-container-low p-2 rounded text-[11px] font-mono text-center">MAPE = (1/n) * Σ(|y - ŷ| / y) * 100%</code>
                            <p class="mt-2 text-[11px]">MAPE model saat ini adalah 15.37%, yang membuktikan model tergolong dalam kategori <strong>Performa Prediksi Baik</strong> (nilai di bawah 20%).</p>
                        </div>
                        
                        <div class="neumorphic-inset rounded-2xl p-4">
                            <span class="font-semibold text-on-surface block mb-1">Cross-Validation (CV) R²</span>
                            <p>
                                Evaluasi 5-Fold membagi seluruh data menjadi 5 bagian terpisah secara bergantian sebagai data latih dan uji guna menjamin bahwa performa akurasi di atas tidak didapatkan secara kebetulan/acak semata.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: USER MANUAL (PUBLIC INTERFACE) -->
    <div id="user-tab" class="tab-content hidden">
        <div class="neumorphic-outset rounded-3xl p-8 bg-background">
            <h3 class="font-headline-md text-headline-md font-bold text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">menu_book</span>
                Panduan Penggunaan Fitur di Sisi Publik (User Website)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-label-md text-on-surface-variant">
                <div class="space-y-4">
                    <h4 class="font-semibold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">calculate</span>
                        1. Simulasi Prediksi Harga Rumah
                    </h4>
                    <p>
                        Pengguna publik dapat mengakses halaman prediksi, kemudian mengisi spesifikasi fisik rumah. Setelah menekan tombol <strong>Hitung Estimasi Harga</strong>:
                    </p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li><strong>Harga Tengah:</strong> Merupakan harga wajar rata-rata pasar menurut model.</li>
                        <li><strong>Rentang Harga:</strong> Menampilkan perkiraan batas bawah (minimum) dan batas atas (maksimum) harga pasar berdasarkan interval kepercayaan model (95% Confidence Interval).</li>
                        <li><strong>Tingkat Keyakinan (Confidence):</strong> Nilai keyakinan model terhadap kelengkapan dan kecocokan data input user dengan sebaran titik data pelatihan model.</li>
                    </ul>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">calculate</span>
                        2. Kalkulator KPR (Kredit Kepemilikan Rumah)
                    </h4>
                    <p>
                        Setelah estimasi harga rumah keluar, pengguna dapat langsung menekan tombol <strong>Simulasi KPR</strong>. Sistem akan membawa harga tersebut secara otomatis ke kalkulator KPR:
                    </p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>User menginput persentase uang muka (DP), suku bunga bank per tahun, dan tenor cicilan (dalam tahun).</li>
                        <li>Sistem mengkalkulasi nominal pinjaman pokok, bunga total, total pinjaman, serta besarnya cicilan per bulan secara terperinci.</li>
                        <li>Aesthetic kalkulator dirancang responsif dan neumorphic inset agar cicilan bulanan mudah dibaca di smartphone maupun tablet.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function switchTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('block');
        });
        
        // Show target tab content
        const activeContent = document.getElementById(tabId);
        activeContent.classList.remove('hidden');
        activeContent.classList.add('block');
        
        // Reset button states (neumorphic-outset)
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('neumorphic-inset', 'text-primary');
            btn.classList.add('neumorphic-outset', 'text-on-surface-variant');
        });
        
        // Set active button state (neumorphic-inset)
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.add('neumorphic-inset', 'text-primary');
        activeBtn.classList.remove('neumorphic-outset', 'text-on-surface-variant');
    }
</script>
@endpush
