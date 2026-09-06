<x-mail::message>
@if($daysRemaining === 0)
# 🚨 Batas Pengembalian Hari Ini!
@elseif($daysRemaining === 1)
# ⚠️ Besok Batas Akhir Pengembalian!
@elseif($daysRemaining === 2)
# ⏰ 2 Hari Lagi Menuju Batas Pengembalian
@else
# 📚 Pengingat Pengembalian Buku
@endif

Halo **{{ $userName }}**,

@if($daysRemaining === 0)
Hari ini adalah **batas akhir** pengembalian buku Anda. Segera kembalikan buku berikut **sebelum perpustakaan tutup** untuk menghindari denda keterlambatan.
@elseif($daysRemaining === 1)
Buku yang Anda pinjam harus dikembalikan **besok**. Mohon segera kembalikan agar tidak dikenakan denda keterlambatan.
@elseif($daysRemaining === 2)
Ini adalah pengingat bahwa buku yang Anda pinjam harus dikembalikan dalam **2 hari lagi**. Mohon siapkan pengembalian buku berikut.
@else
Ini adalah pengingat bahwa buku yang Anda pinjam harus dikembalikan dalam **{{ $daysRemaining }} hari lagi**. Mohon siapkan pengembalian buku berikut.
@endif

<x-mail::panel>
**Detail Peminjaman:**

| Keterangan | Detail |
|:---|:---|
| **Judul Buku** | {{ $bookTitle }} |
| **Tanggal Pinjam** | {{ $borrowDate }} |
| **Batas Pengembalian** | {{ $dueDate }} |
@if($daysRemaining === 0)
| **Status** | ⛔ **HARI TERAKHIR** |
@elseif($daysRemaining === 1)
| **Status** | 🟠 **Besok Jatuh Tempo** |
@else
| **Sisa Waktu** | {{ $daysRemaining }} hari lagi |
@endif
</x-mail::panel>

<x-mail::button :url="config('app.url')" color="{{ $urgencyLevel === 'critical' ? 'error' : ($urgencyLevel === 'warning' ? 'error' : 'primary') }}">
Kunjungi Portal Perpustakaan
</x-mail::button>

> **Catatan:** Jika Anda sudah mengembalikan buku ini, mohon abaikan email ini. Keterlambatan pengembalian akan dikenakan denda sesuai peraturan perpustakaan yang berlaku.

Terima kasih atas kerjasamanya! 🙏

Salam,<br>
**{{ config('app.name') }}**
</x-mail::message>
