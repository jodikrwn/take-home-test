@component('mail::message')
# Notifikasi Servis Selesai

Yth. Manajer Operasional,

Servis pemeliharaan berikut telah **selesai** dilaksanakan:

| Informasi | Detail |
|:----------|:-------|
| **Kapal** | {{ $completedLog->ship->nama }} ({{ $completedLog->ship->kode_kapal }}) |
| **Jenis Servis** | {{ $completedLog->jenis_servis }} |
| **Tanggal Selesai** | {{ $completedLog->tanggal_servis->format('d F Y') }} |
| **Biaya** | Rp {{ number_format((float) $completedLog->biaya, 0, ',', '.') }} |

---

## Jadwal Servis Berikutnya

Servis rutin berikutnya telah dijadwalkan secara **otomatis**:

| Informasi | Detail |
|:----------|:-------|
| **Kapal** | {{ $completedLog->ship->nama }} |
| **Jenis Servis** | {{ $nextScheduled->jenis_servis }} |
| **Tanggal Jadwal** | {{ $nextScheduled->tanggal_servis->format('d F Y') }} |
| **Status** | Planned |

Harap persiapkan tim dan anggaran sebelum tanggal tersebut.

Salam hormat,<br>
**Sistem Manajemen Pemeliharaan Kapal**
@endcomponent
