@extends('layouts.admin')

@section('title', 'Tambah User - ProPePa')
@section('header_title', 'Tambah User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-primary font-bold inline-flex items-center gap-2 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block font-bold text-sm text-on-surface mb-2">Nama Lengkap <span class="text-error">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                    @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Email <span class="text-error">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                    @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Password <span class="text-error">*</span></label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                    @error('password') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Role <span class="text-error">*</span></label>
                    <select name="role" required onchange="toggleTeacherFields(this.value)"
                            class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Siswa</option>
                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Guru</option>
                        <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="class_field">
                    <label class="block font-bold text-sm text-on-surface mb-2">Pilih Kelas</label>
                    <select name="class_id" class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                        <option value="">- Tanpa Kelas -</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }} ({{ $class->school->name }})</option>
                        @endforeach
                    </select>
                    @error('class_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-outline-variant/30">
                <button type="submit" class="bg-primary text-white font-bold px-10 py-4 rounded-2xl shadow-soft hover:bg-primary/90 transition-all w-full">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleTeacherFields(role) {
        const classField = document.getElementById('class_field');
        if (role === 'admin' || role === 'dosen') {
            classField.style.opacity = '0.5';
            classField.style.pointerEvents = 'none';
        } else {
            classField.style.opacity = '1';
            classField.style.pointerEvents = 'auto';
        }
    }
</script>
@endsection
