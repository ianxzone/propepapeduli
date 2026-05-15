@extends('layouts.admin')

@section('title', 'Setup Wizard - ProPePa')
@section('header_title', 'Konfigurasi Awal Sistem')

@section('content')
<div class="max-w-4xl mx-auto py-10" id="setupWizard">
    <!-- Progress Stepper -->
    <div class="flex items-center justify-between mb-12 relative">
        <div class="absolute top-1/2 left-0 w-full h-1 bg-outline-variant/20 -translate-y-1/2 z-0"></div>
        <div id="progressLine" class="absolute top-1/2 left-0 w-0 h-1 bg-primary -translate-y-1/2 z-0 transition-all duration-500"></div>
        
        <div class="step-item relative z-10 flex flex-col items-center gap-3 active">
            <div class="w-12 h-12 rounded-full bg-white border-2 border-primary flex items-center justify-center text-primary font-bold transition-all duration-500">1</div>
            <span class="text-xs font-bold text-on-surface uppercase tracking-widest">Sekolah</span>
        </div>
        <div class="step-item relative z-10 flex flex-col items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-white border-2 border-outline-variant flex items-center justify-center text-outline font-bold transition-all duration-500">2</div>
            <span class="text-xs font-bold text-on-surface uppercase tracking-widest text-outline">Platform</span>
        </div>
        <div class="step-item relative z-10 flex flex-col items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-white border-2 border-outline-variant flex items-center justify-center text-outline font-bold transition-all duration-500">3</div>
            <span class="text-xs font-bold text-on-surface uppercase tracking-widest text-outline">Keamanan</span>
        </div>
        <div class="step-item relative z-10 flex flex-col items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-white border-2 border-outline-variant flex items-center justify-center text-outline font-bold transition-all duration-500">4</div>
            <span class="text-xs font-bold text-on-surface uppercase tracking-widest text-outline">Selesai</span>
        </div>
    </div>

    <!-- Wizard Cards -->
    <div class="bg-white rounded-[3rem] border border-outline-variant/30 shadow-2xl p-10 md:p-16 relative overflow-hidden">
        <form id="wizardForm">
            @csrf
            <!-- Step 1: Profil Sekolah -->
            <div class="wizard-step space-y-8 block" data-step="1">
                <div class="space-y-2">
                    <h2 class="font-headline text-3xl font-bold text-on-surface">Profil Sekolah</h2>
                    <p class="text-on-surface-variant">Lengkapi informasi dasar sekolah Anda.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-2">Nama Sekolah</label>
                        <input type="text" name="school_name" value="{{ $settings['school_name'] ?? '' }}" class="w-full bg-surface-container-low border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary transition-all" placeholder="SD Negeri 1 Contoh">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-2">NPSN</label>
                        <input type="text" name="npsn" value="{{ $settings['npsn'] ?? '' }}" class="w-full bg-surface-container-low border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary transition-all" placeholder="12345678">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-2">Alamat Sekolah</label>
                        <textarea name="school_address" rows="3" class="w-full bg-surface-container-low border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary transition-all" placeholder="Jl. Pendidikan No. 123...">{{ $settings['school_address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Step 2: Platform Settings -->
            <div class="wizard-step space-y-8 hidden" data-step="2">
                <div class="space-y-2">
                    <h2 class="font-headline text-3xl font-bold text-on-surface">Pengaturan Platform</h2>
                    <p class="text-on-surface-variant">Personalisasi tampilan platform Anda.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-2">Nama Platform</label>
                        <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'ProPePa PEDULI' }}" class="w-full bg-surface-container-low border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-2">Logo Platform</label>
                        <input type="file" name="app_logo" class="w-full bg-surface-container-low border-none rounded-2xl px-6 py-3.5 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary/90">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-2">Tahun Ajaran</label>
                        <select name="academic_year" class="w-full bg-surface-container-low border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary transition-all">
                            <option value="2024/2025" {{ ($settings['academic_year'] ?? '') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                            <option value="2025/2026" {{ ($settings['academic_year'] ?? '') == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Step 3: Security Settings -->
            <div class="wizard-step space-y-8 hidden" data-step="3">
                <div class="space-y-2">
                    <h2 class="font-headline text-3xl font-bold text-on-surface">Keamanan Sistem</h2>
                    <p class="text-on-surface-variant">Pastikan sistem Anda terlindungi dengan baik.</p>
                </div>
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-6 bg-surface-container-low rounded-3xl">
                        <div>
                            <h4 class="font-bold text-on-surface">Proteksi Rate Limiting</h4>
                            <p class="text-xs text-on-surface-variant">Batasi percobaan login untuk mencegah brute-force.</p>
                        </div>
                        <input type="hidden" name="security_rate_limit" value="0">
                        <input type="checkbox" name="security_rate_limit" value="1" {{ ($settings['security_rate_limit'] ?? '1') == '1' ? 'checked' : '' }} class="w-12 h-6 bg-outline-variant rounded-full appearance-none checked:bg-primary relative cursor-pointer transition-colors before:content-[''] before:absolute before:w-4 before:h-4 before:bg-white before:rounded-full before:top-1 before:left-1 before:transition-all checked:before:left-7">
                    </div>
                    <div class="flex items-center justify-between p-6 bg-surface-container-low rounded-3xl">
                        <div>
                            <h4 class="font-bold text-on-surface">Security Headers (CSP)</h4>
                            <p class="text-xs text-on-surface-variant">Aktifkan Content Security Policy untuk proteksi browser.</p>
                        </div>
                        <input type="hidden" name="security_csp" value="0">
                        <input type="checkbox" name="security_csp" value="1" {{ ($settings['security_csp'] ?? '1') == '1' ? 'checked' : '' }} class="w-12 h-6 bg-outline-variant rounded-full appearance-none checked:bg-primary relative cursor-pointer transition-colors before:content-[''] before:absolute before:w-4 before:h-4 before:bg-white before:rounded-full before:top-1 before:left-1 before:transition-all checked:before:left-7">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-on-surface-variant ml-2">Maksimum Percobaan Login</label>
                        <input type="number" name="security_max_attempts" value="{{ $settings['security_max_attempts'] ?? '5' }}" class="w-full bg-surface-container-low border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary transition-all">
                    </div>
                </div>
            </div>

            <!-- Step 4: Finished -->
            <div class="wizard-step space-y-8 hidden text-center" data-step="4">
                <div class="w-24 h-24 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                    <span class="material-symbols-outlined text-5xl">task_alt</span>
                </div>
                <div class="space-y-4">
                    <h2 class="font-headline text-3xl font-bold text-on-surface">Konfigurasi Selesai!</h2>
                    <p class="text-on-surface-variant max-w-sm mx-auto">Sistem Anda sekarang sudah siap digunakan dengan pengaturan terbaru.</p>
                </div>
                <div class="pt-6">
                    <a href="{{ route('admin.dashboard') }}" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold shadow-xl hover:bg-primary/90 transition-all inline-block">
                        Ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-12 flex justify-between items-center" id="wizardNav">
                <button type="button" id="prevBtn" class="px-8 py-4 rounded-2xl font-bold text-on-surface-variant hover:bg-surface-container-low transition-all opacity-0 pointer-events-none">
                    Sebelumnya
                </button>
                <button type="button" id="nextBtn" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold shadow-xl hover:bg-primary/90 transition-all flex items-center gap-2">
                    Lanjut
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 4;
    const form = document.getElementById('wizardForm');
    const steps = document.querySelectorAll('.wizard-step');
    const stepItems = document.querySelectorAll('.step-item');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const progressLine = document.getElementById('progressLine');
    const wizardNav = document.getElementById('wizardNav');

    function updateUI() {
        // Update Progress Line
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressLine.style.width = progress + '%';

        // Update Stepper Icons
        stepItems.forEach((item, index) => {
            const circle = item.querySelector('div');
            const text = item.querySelector('span');
            if (index + 1 < currentStep) {
                circle.innerHTML = '<span class="material-symbols-outlined text-sm">check</span>';
                circle.classList.add('bg-primary', 'text-white');
                circle.classList.remove('text-primary', 'border-primary', 'border-outline-variant');
                text.classList.remove('text-outline');
            } else if (index + 1 === currentStep) {
                circle.innerHTML = index + 1;
                circle.classList.add('border-primary', 'text-primary');
                circle.classList.remove('bg-primary', 'text-white', 'border-outline-variant', 'text-outline');
                text.classList.remove('text-outline');
            } else {
                circle.innerHTML = index + 1;
                circle.classList.add('border-outline-variant', 'text-outline');
                circle.classList.remove('bg-primary', 'text-white', 'border-primary', 'text-primary');
                text.classList.add('text-outline');
            }
        });

        // Toggle Steps Visibility
        steps.forEach(step => {
            step.classList.add('hidden');
            if (parseInt(step.dataset.step) === currentStep) {
                step.classList.remove('hidden');
            }
        });

        // Toggle Buttons
        if (currentStep === 1) {
            prevBtn.classList.add('opacity-0', 'pointer-events-none');
        } else {
            prevBtn.classList.remove('opacity-0', 'pointer-events-none');
        }

        if (currentStep === totalSteps) {
            wizardNav.classList.add('hidden');
        } else {
            wizardNav.classList.remove('hidden');
        }

        if (currentStep === totalSteps - 1) {
            nextBtn.innerHTML = 'Simpan & Selesai <span class="material-symbols-outlined text-sm">check_circle</span>';
        } else {
            nextBtn.innerHTML = 'Lanjut <span class="material-symbols-outlined text-sm">arrow_forward</span>';
        }
    }

    nextBtn.addEventListener('click', async function() {
        if (currentStep < totalSteps) {
            if (currentStep === totalSteps - 1) {
                // Save logic
                nextBtn.disabled = true;
                nextBtn.innerHTML = 'Menyimpan...';
                
                const formData = new FormData(form);
                try {
                    const response = await fetch('{{ route("admin.setup.save") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        currentStep++;
                        updateUI();
                    }
                } catch (error) {
                    alert('Gagal menyimpan konfigurasi.');
                } finally {
                    nextBtn.disabled = false;
                }
            } else {
                currentStep++;
                updateUI();
            }
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateUI();
        }
    });

    updateUI();
});
</script>
@endsection
