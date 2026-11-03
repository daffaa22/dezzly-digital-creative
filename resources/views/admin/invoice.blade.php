<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota Sewa Kamera #{{ $order->order_code }} - DEZZLY CREATIVE</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                margin: 0 !important;
                padding: 20px !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100 min-h-screen py-8 px-4 font-sans">

    {{-- Top Action Bar (hidden on print) --}}
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-700 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors shadow-sm">
            &larr; Kembali ke Dashboard Admin
        </a>

        <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white text-sm font-extrabold shadow-md transition-all hover:scale-[1.02] active:scale-[0.98]">
            <svg class="w-4 h-4 fill-none stroke-current stroke-2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak Nota / Simpan PDF
        </button>
    </div>

    {{-- Printable Invoice Sheet --}}
    <div class="max-w-4xl mx-auto bg-white text-slate-900 print-card p-8 sm:p-12 rounded-2xl shadow-xl border-2 border-slate-200 space-y-8">

        {{-- Header & Kop Surat --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b-2 border-slate-200 pb-6 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#0284C7] flex items-center justify-center font-extrabold text-white text-3xl">
                    D
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">DEZZLY CREATIVE</h1>
                    <p class="text-xs font-bold text-[#0284C7] uppercase tracking-widest">Studio Dokumentasi & Persewaan Kamera Sony</p>
                    <p class="text-xs text-slate-500 mt-0.5">Operasional: Jabodetabek & Luar Kota | WA: 0821-4603-1398</p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="inline-block px-3.5 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider {{ $order->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                    Status: {{ strtoupper($order->status) }}
                </span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-2">NOTA SEWA KAMERA</h2>
                <p class="text-xs font-mono font-bold text-slate-600">No. Order: #{{ $order->order_code }}</p>
                <p class="text-xs text-slate-500">Tgl Dibuat: {{ $order->created_at->format('d/m/Y H:i') }} WIB</p>
            </div>
        </div>

        {{-- Order & Customer Details --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-xl border border-slate-200 text-sm">
            <div class="space-y-1.5">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Data Penyewa:</span>
                <p class="font-extrabold text-base text-slate-900">{{ $order->customer_name }}</p>
                <p class="text-slate-700"><strong>WhatsApp:</strong> {{ $order->customer_whatsapp }}</p>
                @if($order->customer_email)
                <p class="text-slate-700"><strong>Email:</strong> {{ $order->customer_email }}</p>
                @endif
                @if($order->notes)
                <p class="text-slate-600 text-xs italic"><strong>Catatan:</strong> {{ $order->notes }}</p>
                @endif
            </div>

            <div class="space-y-1.5 sm:border-l sm:border-slate-200 sm:pl-6">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Jadwal & Durasi Sewa:</span>
                <p class="text-slate-900"><strong>Mulai Sewa:</strong> {{ \Carbon\Carbon::parse($order->start_date)->isoFormat('dddd, D MMMM Y') }}</p>
                <p class="text-slate-900"><strong>Durasi Waktu:</strong> {{ $order->duration_days }} Hari (x 24 Jam)</p>
                <p class="text-slate-900"><strong>Batas Kembali:</strong> {{ \Carbon\Carbon::parse($order->start_date)->addDays($order->duration_days)->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
        </div>

        {{-- Table Rincian Gear & Biaya --}}
        <div>
            <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block mb-3">Rincian Unit Kamera & Perlengkapan:</span>
            <div class="overflow-x-auto border-2 border-slate-200 rounded-xl">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-100 text-slate-800 font-extrabold text-xs uppercase border-b-2 border-slate-200">
                        <tr>
                            <th class="p-4">Item & Spesifikasi</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4 text-right">Tarif / 24 Jam</th>
                            <th class="p-4 text-center">Durasi</th>
                            <th class="p-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-800">
                        {{-- Kamera --}}
                        <tr>
                            <td class="p-4">
                                <strong class="block text-slate-900">{{ $order->camera->name }}</strong>
                                <span class="text-xs text-slate-500">Sensor {{ $order->camera->sensor_type }} | Kelengkapan: Baterai, Charger, Tas, Strap</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded bg-slate-100 border text-xs font-bold">{{ $order->camera->sensor_type }}</span>
                            </td>
                            <td class="p-4 text-right font-medium">{{ $order->camera->formatted_price }}</td>
                            <td class="p-4 text-center font-bold">{{ $order->duration_days }} Hari</td>
                            <td class="p-4 text-right font-bold text-slate-900">
                                Rp {{ number_format($order->camera->daily_price * $order->duration_days, 0, ',', '.') }}
                            </td>
                        </tr>

                        {{-- Lensa (jika ada) --}}
                        @if($order->lens)
                        <tr>
                            <td class="p-4">
                                <strong class="block text-slate-900">{{ $order->lens->name }}</strong>
                                <span class="text-xs text-slate-500">Mount: {{ $order->lens->mount_type }} | Kelengkapan: Lens Cap Depan/Belakang, Lens Hood</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded bg-slate-100 border text-xs font-bold">Lensa</span>
                            </td>
                            <td class="p-4 text-right font-medium">{{ $order->lens->formatted_price }}</td>
                            <td class="p-4 text-center font-bold">{{ $order->duration_days }} Hari</td>
                            <td class="p-4 text-right font-bold text-slate-900">
                                Rp {{ number_format($order->lens->daily_price * $order->duration_days, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot class="bg-slate-50 border-t-2 border-slate-200">
                        <tr>
                            <td colspan="4" class="p-4 text-right font-extrabold text-base text-slate-900 uppercase">
                                Total Biaya Sewa:
                            </td>
                            <td class="p-4 text-right font-extrabold text-xl text-[#0284C7]">
                                {{ $order->formatted_price }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Syarat Serah Terima --}}
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-1 leading-relaxed">
            <span class="font-bold text-slate-800 uppercase block">Klausul Serah Terima Unit Studio:</span>
            <p>1. Penyewa telah memeriksa bersama fisik gear, sensor bersih dari debu/jamur, baterai terisi, dan tombol berfungsi normal.</p>
            <p>2. Penyewa menitipkan kartu identitas asli (KTP / SIM / KK) sebagai jaminan selama masa sewa.</p>
            <p>3. Keterlambatan pengembalian dikenakan denda toleransi Rp 25.000 / jam atau dihitung 1 hari sewa penuh jika melebihi 4 jam.</p>
            <p>4. Kerusakan atau kehilangan unit menjadi tanggung jawab penuh penyewa sesuai ketentuan perbaikan resmi Sony Indonesia.</p>
        </div>

        {{-- Tanda Tangan Serah Terima --}}
        <div class="grid grid-cols-2 gap-12 pt-6 border-t-2 border-slate-200 text-sm">
            <div class="text-center space-y-16">
                <span class="font-bold text-slate-700 block">Pihak Penyewa,</span>
                <div>
                    <div class="border-b-2 border-slate-400 w-48 mx-auto"></div>
                    <p class="font-bold text-slate-900 mt-2">({{ $order->customer_name }})</p>
                </div>
            </div>

            <div class="text-center space-y-16">
                <span class="font-bold text-slate-700 block">Petugas Dezzly Creative,</span>
                <div>
                    <div class="border-b-2 border-slate-400 w-48 mx-auto"></div>
                    <p class="font-bold text-slate-900 mt-2">(....................................................)</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
