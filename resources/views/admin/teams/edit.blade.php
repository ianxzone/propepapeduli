@extends('layouts.admin')

@section('title', 'Edit Anggota Tim - ProPePa')
@section('header_title', 'Edit Anggota Tim')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.teams.index') }}" class="text-primary font-bold inline-flex items-center gap-2 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Nama Lengkap <span class="text-error">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $team->name) }}" required
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                           placeholder="Contoh: Faridillah Fahmi N, M.Pd">
                    @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Foto Anggota (URL)</label>
                    <div class="flex gap-4 items-start">
                        <div class="w-16 h-16 rounded-2xl bg-surface-container overflow-hidden shrink-0 border border-outline-variant/30">
                            <img id="image_preview" src="{{ $team->image ?: 'https://ui-avatars.com/api/?name='.urlencode($team->name).'&size=200&background=F9DEDC&color=410002' }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="image" id="team_image" value="{{ old('image', $team->image) }}"
                                       class="flex-1 rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                                       placeholder="https://..." onchange="document.getElementById('image_preview').src = this.value">
                                <button type="button" onclick="openMediaPicker('team_image', 'image')"
                                        class="bg-surface-container-high text-on-surface px-4 rounded-xl font-bold text-sm hover:bg-surface-container-highest transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">image</span>
                                    Media
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-sm text-on-surface mb-2">NIP (Opsional)</label>
                        <input type="text" name="nip" value="{{ old('nip', $team->nip) }}"
                               class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                               placeholder="Nomor Induk Pegawai">
                    </div>
                    <div>
                        <label class="block font-bold text-sm text-on-surface mb-2">NIDN (Opsional)</label>
                        <input type="text" name="nidn" value="{{ old('nidn', $team->nidn) }}"
                               class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                               placeholder="Nomor Induk Dosen Nasional">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-sm text-on-surface mb-2">Jabatan Fungsional Akademik</label>
                        <select name="academic_rank" class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                            <option value="">Pilih Jabatan</option>
                            @foreach(['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar', 'Tenaga Pengajar'] as $rank)
                                <option value="{{ $rank }}" {{ old('academic_rank', $team->academic_rank) == $rank ? 'selected' : '' }}>{{ $rank }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-sm text-on-surface mb-2">Jabatan Struktural / Posisi <span class="text-error">*</span></label>
                        <input type="text" name="position" value="{{ old('position', $team->position) }}" required
                               class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                               placeholder="Contoh: Dekan Fakultas / Peneliti">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Riwayat Pendidikan (Pisahkan dengan baris baru)</label>
                    <textarea name="education" rows="3"
                              class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                              placeholder="Contoh: S1 - Pendidikan IPS UPI&#10;S2 - Teknologi Pendidikan ITB">{{ old('education', is_array($team->education) ? implode("\n", $team->education) : '') }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Bidang Keahlian / Kompetensi Utama</label>
                    <input type="text" name="expertise" value="{{ old('expertise', $team->expertise) }}"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                           placeholder="Contoh: Media Pembelajaran, Evaluasi Pendidikan">
                </div>

                <div class="bg-surface-container-low p-6 rounded-3xl border border-outline-variant/30 space-y-4">
                    <h4 class="font-headline font-bold text-sm text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">link</span>
                        Tautan Profil Akademik & Publikasi
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-[10px] text-outline uppercase tracking-widest mb-1">Google Scholar</label>
                            <input type="text" name="google_scholar" value="{{ old('google_scholar', $team->google_scholar) }}"
                                   class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-2 bg-white text-xs"
                                   placeholder="URL Profil Google Scholar">
                        </div>
                        <div>
                            <label class="block font-bold text-[10px] text-outline uppercase tracking-widest mb-1">SINTA Link</label>
                            <input type="text" name="sinta_link" value="{{ old('sinta_link', $team->sinta_link) }}"
                                   class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-2 bg-white text-xs"
                                   placeholder="URL Profil SINTA">
                        </div>
                        <div>
                            <label class="block font-bold text-[10px] text-outline uppercase tracking-widest mb-1">Scopus Link</label>
                            <input type="text" name="scopus_link" value="{{ old('scopus_link', $team->scopus_link) }}"
                                   class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-2 bg-white text-xs"
                                   placeholder="URL Profil Scopus">
                        </div>
                        <div>
                            <label class="block font-bold text-[10px] text-outline uppercase tracking-widest mb-1">ORCID ID</label>
                            <input type="text" name="orcid_link" value="{{ old('orcid_link', $team->orcid_link) }}"
                                   class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-2 bg-white text-xs"
                                   placeholder="URL Profil ORCID">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-[10px] text-outline uppercase tracking-widest mb-1">Link Jurnal Lainnya (Satu per baris)</label>
                        <textarea name="journal_links" rows="2"
                                  class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-2 bg-white text-xs"
                                  placeholder="https://...&#10;https://...">{{ old('journal_links', is_array($team->journal_links) ? implode("\n", $team->journal_links) : '') }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Biografi Singkat / Pengantar</label>
                    <textarea name="description" rows="2"
                              class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                              placeholder="Kutipan singkat atau pengantar profil...">{{ old('description', $team->description) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Profil Lengkap (Bio)</label>
                    <textarea name="bio" rows="4"
                              class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                              placeholder="Biografi mendalam, latar belakang, dsb...">{{ old('bio', $team->bio) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-sm text-on-surface mb-2">Urutan Tampil</label>
                        <input type="number" name="order" value="{{ old('order', $team->order) }}"
                               class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                        @error('order') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex flex-col justify-center">
                        <label class="flex items-center gap-3 cursor-pointer mt-6">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $team->is_active) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-sm font-bold text-on-surface">Tampilkan di Landing Page</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-outline-variant/30">
                <button type="submit" class="bg-primary text-white font-bold px-10 py-4 rounded-2xl shadow-soft hover:bg-primary/90 transition-all w-full flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Perbarui Anggota Tim
                </button>
            </div>
        </form>
    </div>
</div>

@include('admin.media.picker-modal')

@endsection
