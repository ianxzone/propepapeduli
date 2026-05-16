# Panduan Implementasi Modul PEDULI

Dokumen ini menjelaskan teknis bagaimana modul pembelajaran diimplementasikan ke dalam kode program, sangat berguna untuk diskusi pengembangan fitur di Gemini atau NotebookLM.

## 1. Struktur Database
Modul utama disimpan dalam tabel `modules` dengan kolom penting:
- `title` (string): Judul proyek/modul.
- `slug` (string): URL friendly identifier.
- `content` (json): Kolom kunci yang menyimpan konfigurasi tiap fase PEDULI.
- `is_active` (boolean): Status publikasi.

## 2. Struktur JSON `content`
Kolom `content` mengikuti format berikut:
```json
{
  "P": { "title": "Pelajari", "body": "Konten materi..." },
  "E": { "title": "Eksplorasi", "video_url": "...", "instructions": "..." },
  "D": { "title": "Diskusi", "type": "chat|map", "topic": "..." },
  "U": { "title": "Ungkapkan", "question": "..." },
  "L": { "title": "Lakukan", "task": "..." },
  "I": { "title": "Introspeksi", "checklist": [...] },
  "S": { "title": "Selesai", "summary": "..." }
}
```

## 3. Alur Logika (Controller)
`App\Http\Controllers\Student\ModuleController` menangani navigasi:
- **`showStep()`**: Menentukan view mana yang akan dimuat berdasarkan kode fase (P/E/D/U/L/I/S).
- **`nextStep()`**: Validasi apakah siswa sudah menyelesaikan tugas di fase saat ini sebelum lanjut ke fase berikutnya.
- **`module_progress`**: Tabel yang melacak `current_step` tiap siswa untuk tiap modul.

## 4. Pemetaan Tampilan (Views)
File tampilan berada di `resources/views/student/steps/`:
- `pelajari.blade.php` (P)
- `eksplorasi.blade.php` (E)
- `diskusi.blade.php` (D) -> Mendukung mode Chat dan Map (SVG).
- `ungkapkan.blade.php` (U) -> Form input jurnal/refleksi.
- `lakukan.blade.php` (L)
- `introspeksi.blade.php` (I)

## 5. Integrasi Argument Mapping (Fase D)
Fase Diskusi memiliki fitur khusus **Argument Mapping Board**:
- Menggunakan **SVG** untuk menggambar koneksi antar node argumen.
- Data disimpan dalam tabel `group_maps`.
- Frontend menggunakan Vanilla JS (`resources/js/argument-map.js`) untuk manipulasi DOM secara real-time.

## 6. Sistem Penilaian
Guru memberikan nilai pada fase **Ungkapkan (U)** atau **Selesai (S)** melalui `TeacherDashboardController`. Nilai ini akan mengupdate tabel `journals` dan menambah `points` pada user siswa.
