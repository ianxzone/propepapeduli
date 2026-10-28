@props([
    'badgeName' => '',
    'badgeIcon' => 'workspace_premium'
])

@php
    $categories = [
        'all' => 'Semua',
        'prestasi' => '🏆 Prestasi',
        'pancasila' => '🇮🇩 Pancasila',
        'belajar' => '📚 Belajar',
        'lingkungan' => '🌿 Lingkungan',
        'kreatif' => '🎨 Kreatif',
    ];

    $icons = [
        // Prestasi & Apresiasi
        ['id' => 'workspace_premium', 'name' => 'Medali', 'cat' => 'prestasi', 'kw' => 'medali juara prestasi emas perak perunggu award penghargaan'],
        ['id' => 'emoji_events', 'name' => 'Piala', 'cat' => 'prestasi', 'kw' => 'piala trofi juara pemenang turnamen kemenangan victory'],
        ['id' => 'military_tech', 'name' => 'Lencana', 'cat' => 'prestasi', 'kw' => 'lencana bintang ksatria tanda jasa kehormatan badge'],
        ['id' => 'stars', 'name' => 'Bintang', 'cat' => 'prestasi', 'kw' => 'bintang bersinar cemerlang gemilang prestasi stars'],
        ['id' => 'crown', 'name' => 'Mahkota', 'cat' => 'prestasi', 'kw' => 'mahkota raja ratu terbaik agung mulia utama crown'],
        ['id' => 'star', 'name' => 'Favorit', 'cat' => 'prestasi', 'kw' => 'favorit bintang kesukaan unggulan rating jempolan'],
        ['id' => 'verified', 'name' => 'Juara Sah', 'cat' => 'prestasi', 'kw' => 'juara sah centang lulus tuntas verifikasi resmi'],
        ['id' => 'diamond', 'name' => 'Berlian', 'cat' => 'prestasi', 'kw' => 'berlian intan diamond permata berharga berkilau istimewa'],
        ['id' => 'thumb_up', 'name' => 'Hebat', 'cat' => 'prestasi', 'kw' => 'hebat keren jempol mantap bagus apresiasi like'],
        ['id' => 'trophy', 'name' => 'Trofi', 'cat' => 'prestasi', 'kw' => 'trofi piala kejuaraan juara 1 pemenang juara umum'],
        ['id' => 'flag', 'name' => 'Bendera', 'cat' => 'prestasi', 'kw' => 'bendera target pencapaian finis merah putih cita-cita'],
        ['id' => 'grade', 'name' => 'Peringkat', 'cat' => 'prestasi', 'kw' => 'peringkat nilai tinggi bintang lima unggul utama'],

        // Pancasila & Karakter
        ['id' => 'shield', 'name' => 'Akhlak', 'cat' => 'pancasila', 'kw' => 'akhlak budi pekerti perisai integritas iman garuda pelindung'],
        ['id' => 'diversity_3', 'name' => 'Kebinekaan', 'cat' => 'pancasila', 'kw' => 'kebinekaan bhinneka tunggal ika suku budaya nusantara beragam'],
        ['id' => 'groups', 'name' => 'Gotong Royong', 'cat' => 'pancasila', 'kw' => 'gotong royong kerja sama tim kelompok saling bantu kolaborasi'],
        ['id' => 'handshake', 'name' => 'Toleransi', 'cat' => 'pancasila', 'kw' => 'toleransi jabat tangan damai rukun persahabatan mufakat'],
        ['id' => 'favorite', 'name' => 'Peduli', 'cat' => 'pancasila', 'kw' => 'peduli kasih sayang empati cinta hati kemanusiaan santun'],
        ['id' => 'volunteer_activism', 'name' => 'Relawan', 'cat' => 'pancasila', 'kw' => 'relawan sosial bakti masyarakat sedekah memberi donor'],
        ['id' => 'balance', 'name' => 'Keadilan', 'cat' => 'pancasila', 'kw' => 'keadilan timbangan adil hukum hak kewajiban seimbang bijak'],
        ['id' => 'sentiment_satisfied', 'name' => 'Santun', 'cat' => 'pancasila', 'kw' => 'santun senyum ramah sopan etika adab baik budi'],
        ['id' => 'loyalty', 'name' => 'Integritas', 'cat' => 'pancasila', 'kw' => 'integritas setia komitmen kejujuran amanah terpercaya'],
        ['id' => 'family_restroom', 'name' => 'Keluarga', 'cat' => 'pancasila', 'kw' => 'keluarga kasih sayang rukun orang tua anak generasi'],
        ['id' => 'public', 'name' => 'Global', 'cat' => 'pancasila', 'kw' => 'global dunia bumi internasional wawasan luas persaudaraan'],
        ['id' => 'spa', 'name' => 'Kedamaian', 'cat' => 'pancasila', 'kw' => 'kedamaian tenang damai harmoni teratai batin teduh'],

        // Belajar & Riset
        ['id' => 'school', 'name' => 'Toga', 'cat' => 'belajar', 'kw' => 'toga wisuda sekolah lulus sarjana murid universitas'],
        ['id' => 'menu_book', 'name' => 'Buku', 'cat' => 'belajar', 'kw' => 'buku membaca literasi ilmu pengetahuan belajar modul bahan ajar'],
        ['id' => 'psychology', 'name' => 'Nalar Kritis', 'cat' => 'belajar', 'kw' => 'nalar kritis pikiran psikologi otak analisis berpikir cerdas'],
        ['id' => 'lightbulb', 'name' => 'Ide Solutif', 'cat' => 'belajar', 'kw' => 'ide gagasan bohlam inspirasi inovasi solusi terang penemuan'],
        ['id' => 'science', 'name' => 'Sains', 'cat' => 'belajar', 'kw' => 'sains lab kimia percobaan eksperimen tabung reaksi ilmiah'],
        ['id' => 'biotech', 'name' => 'Riset', 'cat' => 'belajar', 'kw' => 'riset penelitian biologi dna mikroskop mikro molekul data'],
        ['id' => 'search', 'name' => 'Eksplorasi', 'cat' => 'belajar', 'kw' => 'eksplorasi cari temukan kaca pembesar teliti telaah observasi'],
        ['id' => 'analytics', 'name' => 'Analisis', 'cat' => 'belajar', 'kw' => 'analisis statistik grafik diagram kurva fakta temuan metrik'],
        ['id' => 'calculate', 'name' => 'Hitung', 'cat' => 'belajar', 'kw' => 'hitung angka matematika logika kalkulator kuantitatif'],
        ['id' => 'history_edu', 'name' => 'Sejarah', 'cat' => 'belajar', 'kw' => 'sejarah piagam bulu pena prasasti peradaban tradisi budaya'],
        ['id' => 'quiz', 'name' => 'Kuis', 'cat' => 'belajar', 'kw' => 'kuis tanya jawab refleksi ujian tes uji kompetensi soal'],
        ['id' => 'edit_note', 'name' => 'Catatan', 'cat' => 'belajar', 'kw' => 'catatan rangkuman tulis pena laporan modul portofolio'],

        // Lingkungan & PEDULI
        ['id' => 'eco', 'name' => 'Lingkungan', 'cat' => 'lingkungan', 'kw' => 'lingkungan daun hijau alam ramah lingkungan ekologi kelestarian'],
        ['id' => 'forest', 'name' => 'Hutan', 'cat' => 'lingkungan', 'kw' => 'hutan pohon rimba penghijauan alam ekosistem oksigen hijau'],
        ['id' => 'water_drop', 'name' => 'Air Bersih', 'cat' => 'lingkungan', 'kw' => 'air bersih sungai pahlawan sungai kali tetesan embun sanitasi'],
        ['id' => 'recycling', 'name' => 'Daur Ulang', 'cat' => 'lingkungan', 'kw' => 'daur ulang sampah reuse recycle reduce pilah kelola kompos'],
        ['id' => 'potted_plant', 'name' => 'Tanaman', 'cat' => 'lingkungan', 'kw' => 'tanaman bibit bunga berkebun pot tunas bertani hijau'],
        ['id' => 'cleaning_services', 'name' => 'Kebersihan', 'cat' => 'lingkungan', 'kw' => 'kebersihan sapu bersih-bersih lingkungan higienis sanitasi sehat'],
        ['id' => 'nature_people', 'name' => 'Kawan Alam', 'cat' => 'lingkungan', 'kw' => 'kawan alam sahabat bumi manusia ekologi pohon hijau pelindung'],
        ['id' => 'park', 'name' => 'Taman Asri', 'cat' => 'lingkungan', 'kw' => 'taman kota pohon asri ruang terbuka hijau rindang'],
        ['id' => 'sunny', 'name' => 'Matahari', 'cat' => 'lingkungan', 'kw' => 'matahari terang cahaya surya energi tenaga surya cuaca cerah'],
        ['id' => 'cruelty_free', 'name' => 'Kasih Satwa', 'cat' => 'lingkungan', 'kw' => 'kasih satwa hewan binatang pelestarian kelinci perlindungan fauna'],
        ['id' => 'compost', 'name' => 'Kompos', 'cat' => 'lingkungan', 'kw' => 'kompos pupuk tanah organik daur ulang sampah sisa makanan'],
        ['id' => 'energy_savings_leaf', 'name' => 'Hemat Energi', 'cat' => 'lingkungan', 'kw' => 'hemat energi listrik hijau efisiensi konservasi ramah lingkungan'],

        // Kreatif & Aksi Nyata
        ['id' => 'auto_awesome', 'name' => 'Kreatif', 'cat' => 'kreatif', 'kw' => 'kreatif ajaib imajinasi bakat cemerlang luar biasa bintang'],
        ['id' => 'local_fire_department', 'name' => 'Semangat', 'cat' => 'kreatif', 'kw' => 'semangat api membara daya juang energi motivasi tinggi aktif'],
        ['id' => 'palette', 'name' => 'Seni Lukis', 'cat' => 'kreatif', 'kw' => 'seni lukis palet gambar warna estetika rupa kanvas'],
        ['id' => 'rocket_launch', 'name' => 'Inovasi', 'cat' => 'kreatif', 'kw' => 'inovasi roket peluncuran karya masa depan maju terobosan'],
        ['id' => 'extension', 'name' => 'Solutif', 'cat' => 'kreatif', 'kw' => 'solutif puzzle logika susun pemecahan masalah teka-teki strategi'],
        ['id' => 'brush', 'name' => 'Kreasi', 'cat' => 'kreatif', 'kw' => 'kreasi kuas cat melukis merancang karya desain keterampilan'],
        ['id' => 'music_note', 'name' => 'Musik', 'cat' => 'kreatif', 'kw' => 'musik nada irama lagu harmoni vokal instrumen seni suara'],
        ['id' => 'construction', 'name' => 'Rancang', 'cat' => 'kreatif', 'kw' => 'rancang bangun karya pertukangan konstruksi prakarya produk'],
        ['id' => 'camera', 'name' => 'Dokumentasi', 'cat' => 'kreatif', 'kw' => 'kamera foto gambar potret dokumentasi rekam bukti aksi'],
        ['id' => 'theater_comedy', 'name' => 'Budaya', 'cat' => 'kreatif', 'kw' => 'budaya teater topeng drama seni pertunjukan kearifan lokal'],
        ['id' => 'explore', 'name' => 'Penjelajah', 'cat' => 'kreatif', 'kw' => 'penjelajah kompas petualang arah jalan penemu jejak'],
        ['id' => 'campaign', 'name' => 'Aksi Nyata', 'cat' => 'kreatif', 'kw' => 'aksi nyata megafon seruan pengumuman kampanye pahlawan suara'],
    ];

    $selectedIcon = $badgeIcon ?: 'workspace_premium';
    $selectedName = $badgeName ?: 'Pahlawan Lingkungan';
@endphp

<!-- Container Gamifikasi & Lencana Modul -->
<div class="p-6 rounded-[1.75rem] bg-gradient-to-br from-surface-container-low to-white border border-outline-variant/30 shadow-xs space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-outline-variant/20">
        <div>
            <h3 class="font-headline font-bold text-base text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1;">military_tech</span>
                Lencana & Gamifikasi Modul
            </h3>
            <p class="text-xs text-on-surface-variant mt-0.5">Lencana ini akan didapatkan siswa pada profil dan dasbor saat mereka berhasil menuntaskan modul ini.</p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-primary/10 text-primary border border-primary/20 w-fit">
            <span class="material-symbols-outlined text-xs">auto_awesome</span>
            {{ count($icons) }}+ Pilihan Ikon
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Kolom Kiri: Input Nama Lencana & Kartu Pratinjau Siswa -->
        <div class="lg:col-span-5 space-y-4">
            <div>
                <label for="badge_name" class="block font-bold text-xs text-on-surface mb-1.5 uppercase tracking-wider">
                    Nama Lencana <span class="text-error">*</span>
                </label>
                <input type="text" id="badge_name" name="badge_name" value="{{ $badgeName }}"
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-2.5 bg-white text-sm shadow-2xs"
                       placeholder="Contoh: Pahlawan Sungai"
                       oninput="updateBadgePreview()">
                <p class="text-[11px] text-on-surface-variant mt-1">Nama titel apresiasi yang akan dibanggakan siswa.</p>
            </div>

            <!-- Kartu Pratinjau Visual Siswa -->
            <div>
                <label class="block font-bold text-[11px] text-outline mb-1.5 uppercase tracking-wider">
                    Pratinjau Tampilan Siswa
                </label>
                <div class="relative p-4 rounded-2xl bg-white border border-outline-variant/30 shadow-sm overflow-hidden flex items-center gap-4 group">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/5 rounded-full pointer-events-none"></div>
                    
                    <div id="badge-preview-icon-wrapper" class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary/15 to-primary/5 border-2 border-primary/30 flex items-center justify-center text-primary shrink-0 shadow-inner transition-transform duration-300 group-hover:scale-105">
                        <span id="badge-preview-icon" class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">{{ $selectedIcon }}</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <span class="text-[9px] font-extrabold text-primary tracking-widest uppercase block mb-0.5">Lencana Modul</span>
                        <h4 id="badge-preview-name" class="font-headline font-bold text-sm text-on-surface truncate">
                            {{ $badgeName ?: 'Pahlawan Sungai' }}
                        </h4>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="inline-flex items-center gap-0.5 text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                <span class="material-symbols-outlined text-[12px]">verified</span>
                                Siap Diperoleh
                            </span>
                            <span class="text-[10px] text-on-surface-variant/80 font-mono" id="badge-preview-code">
                                ({{ $selectedIcon }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Galeri Ikon Interaktif (Filter Kategori & Pencarian) -->
        <div class="lg:col-span-7 space-y-3">
            <div class="flex items-center justify-between gap-2">
                <label class="block font-bold text-xs text-on-surface uppercase tracking-wider">
                    Pilih Ikon Lencana Secara Visual
                </label>
                <span id="badge-icon-counter" class="text-[11px] font-medium text-on-surface-variant">
                    Menampilkan <span id="visible-icons-count">{{ count($icons) }}</span> ikon
                </span>
            </div>

            <!-- Kolom Pencarian & Kategori -->
            <div class="space-y-2.5">
                <!-- Input Pencarian -->
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-base pointer-events-none">search</span>
                    <input type="text" id="badge-icon-search"
                           placeholder="Cari ikon... (contoh: bintang, piala, buku, alam, air, garuda, toga)"
                           class="w-full pl-9 pr-9 py-2 text-xs rounded-xl border border-outline-variant/40 bg-white focus:border-primary focus:ring-0 shadow-2xs"
                           oninput="filterBadgeIcons()">
                    <button type="button" id="badge-search-clear-btn" onclick="clearBadgeSearch()"
                            class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-surface-container-high text-on-surface-variant hover:bg-outline-variant/50 flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-[13px]">close</span>
                    </button>
                </div>

                <!-- Tab Kategori -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 no-scrollbar text-xs">
                    @foreach($categories as $catKey => $catLabel)
                        <button type="button" onclick="selectBadgeCategory('{{ $catKey }}')"
                                id="badge-cat-tab-{{ $catKey }}"
                                class="badge-cat-tab shrink-0 px-3 py-1.5 rounded-xl font-bold transition-all {{ $catKey === 'all' ? 'bg-primary text-white shadow-xs' : 'bg-white text-on-surface-variant border border-outline-variant/30 hover:border-primary/40' }}">
                            {{ $catLabel }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Input Nilai Tersembunyi untuk Dikirim ke Form Backend -->
            <input type="hidden" id="badge_icon" name="badge_icon" value="{{ $selectedIcon }}">

            <!-- Galeri Grid Ikon -->
            <div id="badge-icon-grid"
                 style="display: grid; grid-template-columns: repeat(auto-fill, minmax(70px, 1fr)); gap: 8px; max-height: 220px; overflow-y: auto; padding: 6px;"
                 class="bg-white rounded-2xl border border-outline-variant/30 p-2 shadow-inner">
                @foreach($icons as $item)
                    <button type="button"
                            onclick="selectBadgeIcon('{{ $item['id'] }}')"
                            id="badge-icon-btn-{{ $item['id'] }}"
                            data-icon-id="{{ $item['id'] }}"
                            data-icon-name="{{ $item['name'] }}"
                            data-category="{{ $item['cat'] }}"
                            data-keywords="{{ $item['kw'] }}"
                            title="{{ $item['name'] }} ({{ $item['id'] }})"
                            class="badge-icon-btn flex flex-col items-center justify-center p-2 rounded-xl border-2 transition-all gap-1 cursor-pointer group text-center {{ $selectedIcon === $item['id'] ? 'border-primary bg-primary/10 text-primary shadow-xs font-bold' : 'border-transparent bg-surface-container-low/50 hover:bg-surface-container-low hover:border-outline-variant/60 text-on-surface-variant' }}">
                        <span class="material-symbols-outlined text-2xl group-hover:scale-115 transition-transform" style="font-variation-settings: 'FILL' 1;">{{ $item['id'] }}</span>
                        <span class="text-[10px] tracking-tight leading-tight line-clamp-1 w-full">{{ $item['name'] }}</span>
                    </button>
                @endforeach
            </div>

            <!-- Pesan jika hasil pencarian kosong -->
            <div id="badge-no-results" class="hidden p-4 rounded-xl bg-surface-container-low border border-dashed border-outline-variant/40 text-center">
                <span class="material-symbols-outlined text-outline text-2xl mb-1">search_off</span>
                <p class="text-xs text-on-surface-variant font-medium">Ikon tidak ditemukan untuk kata kunci tersebut.</p>
                <button type="button" onclick="clearBadgeSearch()" class="mt-2 text-primary font-bold text-xs hover:underline inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">refresh</span> Tampilkan Semua Ikon
                </button>
            </div>

            <!-- Opsi Input Custom Material Symbol -->
            <div class="pt-2 border-t border-outline-variant/20 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[11px] text-on-surface-variant">
                <span>Ingin ikon Material Symbol lainnya di luar daftar?</span>
                <div class="flex items-center gap-1.5">
                    <input type="text" id="custom-icon-input" placeholder="contoh: sports_soccer"
                           class="px-2.5 py-1 text-xs rounded-lg border border-outline-variant/40 bg-white focus:border-primary focus:ring-0 font-mono w-36">
                    <button type="button" onclick="applyCustomBadgeIcon()"
                            class="px-3 py-1 bg-surface-container-high hover:bg-primary hover:text-white rounded-lg font-bold text-xs transition-colors border border-outline-variant/40">
                        Gunakan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentBadgeCategory = 'all';

    function updateBadgePreview() {
        const nameInput = document.getElementById('badge_name');
        const previewName = document.getElementById('badge-preview-name');
        if (nameInput && previewName) {
            previewName.textContent = nameInput.value.trim() || 'Pahlawan Sungai';
        }
    }

    function selectBadgeIcon(iconId) {
        if (!iconId) return;

        // Set value input form
        const hiddenInput = document.getElementById('badge_icon');
        if (hiddenInput) {
            hiddenInput.value = iconId;
        }

        // Update preview icon
        const previewIcon = document.getElementById('badge-preview-icon');
        const previewCode = document.getElementById('badge-preview-code');
        const iconWrapper = document.getElementById('badge-preview-icon-wrapper');

        if (previewIcon) {
            previewIcon.textContent = iconId;
        }
        if (previewCode) {
            previewCode.textContent = '(' + iconId + ')';
        }

        // Animasi bounce kecil pada preview
        if (iconWrapper) {
            iconWrapper.classList.add('scale-110');
            setTimeout(() => iconWrapper.classList.remove('scale-110'), 200);
        }

        // Update active class pada tombol galeri
        document.querySelectorAll('.badge-icon-btn').forEach(btn => {
            btn.classList.remove('border-primary', 'bg-primary/10', 'text-primary', 'shadow-xs', 'font-bold');
            btn.classList.add('border-transparent', 'bg-surface-container-low/50', 'text-on-surface-variant');
        });

        const activeBtn = document.getElementById('badge-icon-btn-' + iconId);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'bg-surface-container-low/50', 'text-on-surface-variant');
            activeBtn.classList.add('border-primary', 'bg-primary/10', 'text-primary', 'shadow-xs', 'font-bold');
            // Auto scroll tombol terpilih ke viewport jika tertutup
            activeBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function selectBadgeCategory(catKey) {
        currentBadgeCategory = catKey;

        // Update styling tab
        document.querySelectorAll('.badge-cat-tab').forEach(tab => {
            tab.classList.remove('bg-primary', 'text-white', 'shadow-xs');
            tab.classList.add('bg-white', 'text-on-surface-variant', 'border', 'border-outline-variant/30');
        });

        const activeTab = document.getElementById('badge-cat-tab-' + catKey);
        if (activeTab) {
            activeTab.classList.remove('bg-white', 'text-on-surface-variant', 'border', 'border-outline-variant/30');
            activeTab.classList.add('bg-primary', 'text-white', 'shadow-xs');
        }

        filterBadgeIcons();
    }

    function filterBadgeIcons() {
        const searchInput = document.getElementById('badge-icon-search');
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const clearBtn = document.getElementById('badge-search-clear-btn');
        const buttons = document.querySelectorAll('.badge-icon-btn');
        let visibleCount = 0;

        if (clearBtn) {
            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        buttons.forEach(btn => {
            const iconId = btn.getAttribute('data-icon-id') || '';
            const iconName = (btn.getAttribute('data-icon-name') || '').toLowerCase();
            const category = btn.getAttribute('data-category') || '';
            const keywords = (btn.getAttribute('data-keywords') || '').toLowerCase();

            const matchCat = (currentBadgeCategory === 'all' || category === currentBadgeCategory);
            const matchQuery = !query || iconId.includes(query) || iconName.includes(query) || keywords.includes(query);

            if (matchCat && matchQuery) {
                btn.style.display = 'flex';
                visibleCount++;
            } else {
                btn.style.display = 'none';
            }
        });

        // Update counter
        const counterEl = document.getElementById('visible-icons-count');
        if (counterEl) {
            counterEl.textContent = visibleCount;
        }

        // Tampilkan placeholder jika tidak ada hasil
        const noResults = document.getElementById('badge-no-results');
        const grid = document.getElementById('badge-icon-grid');
        if (noResults && grid) {
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
                grid.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                grid.classList.remove('hidden');
            }
        }
    }

    function clearBadgeSearch() {
        const searchInput = document.getElementById('badge-icon-search');
        if (searchInput) {
            searchInput.value = '';
        }
        currentBadgeCategory = 'all';
        selectBadgeCategory('all');
    }

    function applyCustomBadgeIcon() {
        const input = document.getElementById('custom-icon-input');
        if (!input) return;
        const iconCode = input.value.trim().toLowerCase().replace(/[^a-z0-9_]/g, '_');
        if (iconCode) {
            selectBadgeIcon(iconCode);
            input.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialIcon = document.getElementById('badge_icon')?.value || 'workspace_premium';
        selectBadgeIcon(initialIcon);
        updateBadgePreview();
    });
</script>
