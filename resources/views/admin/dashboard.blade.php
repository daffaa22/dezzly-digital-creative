@extends('layouts.app')

@section('title', 'Admin Dashboard — DEZZLY CREATIVE Panel Kendali')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b-2 border-slate-200 pb-6 bg-white p-6 rounded-2xl border-2 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-widest">Pusat Manajemen Internal</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">Dashboard Operasional Dezzly Creative</h1>
            <p class="text-sm text-slate-600">Pantau data pesanan sewa kamera dan permintaan jasa dokumentasi acara yang masuk.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="hidden md:inline-block text-xs font-bold text-slate-500 dark:text-slate-400">
                Login sebagai: <strong class="text-slate-800 dark:text-slate-200">{{ Auth::user()->name ?? 'Admin' }}</strong>
            </span>
            <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 text-xs font-extrabold text-slate-800 dark:text-slate-200 transition-colors">
                Lihat Website &rarr;
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 border-2 border-red-300 dark:border-red-700 text-xs font-extrabold text-red-700 dark:text-red-300 transition-colors">
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </div>

    <!-- Feedback Flash Message -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border-2 border-emerald-300 text-emerald-900 text-sm font-bold flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    <!-- Metrics Cards Strip (Kotak Bersih, Angka Besar, Kontras Tajam) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="card-clean p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 block uppercase">Total Sewa Kamera</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">{{ $totalOrders }}</div>
            <span class="text-xs font-bold text-[#0284C7] mt-2 block">Masuk dari website &amp; WhatsApp</span>
        </div>
        <div class="card-clean p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 block uppercase">Permintaan Dokumentasi</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-[#0284C7] mt-1">{{ $totalInquiries }}</div>
            <span class="text-xs font-bold text-blue-700 mt-2 block">Acara &amp; Gathering Korporat</span>
        </div>
        <div class="card-clean p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 block uppercase">Omset Sewa Terkonfirmasi</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <span class="text-xs font-bold text-emerald-700 mt-2 block">Status Aktif / Selesai</span>
        </div>
        <div class="card-clean p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 block uppercase">Kamera Tersedia</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-purple-800 mt-1">{{ $availableCameras }} Unit</div>
            <span class="text-xs font-bold text-purple-700 mt-2 block">Siap disewa di studio</span>
        </div>
    </div>

    <!-- Table 1: Incoming Rental Orders -->
    <div class="card-clean rounded-2xl overflow-hidden">
        <div class="p-6 border-b-2 border-slate-100 flex items-center justify-between bg-slate-50">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900">Daftar Order Sewa Kamera Terkini</h2>
                <p class="text-sm text-slate-600">Pesanan sewa kamera 24 jam yang masuk dari kalkulator web.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-200 text-slate-800">{{ $rentalOrders->count() }} Data Order</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-100 text-slate-700 uppercase tracking-wider border-b-2 border-slate-200 font-bold text-xs">
                    <tr>
                        <th class="p-4">Kode Order</th>
                        <th class="p-4">Penyewa &amp; Kontak</th>
                        <th class="p-4">Kamera &amp; Lensa</th>
                        <th class="p-4">Tanggal Sewa</th>
                        <th class="p-4">Total Biaya</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rentalOrders as $order)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-extrabold text-slate-900">{{ $order->order_code }}</td>
                        <td class="p-4">
                            <strong class="font-bold text-slate-900 block">{{ $order->customer_name }}</strong>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_whatsapp) }}" target="_blank" class="text-emerald-700 font-bold hover:underline">
                                💬 {{ $order->customer_whatsapp }}
                            </a>
                        </td>
                        <td class="p-4">
                            <strong class="font-bold text-[#0284C7] block">{{ $order->camera->name }}</strong>
                            <span class="text-slate-600 text-xs">{{ $order->lens ? $order->lens->name : 'Lensa Kit / Tanpa Lensa Tambahan' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-semibold block text-slate-900">{{ $order->start_date->format('d M Y') }}</span>
                            <span class="text-slate-500 text-xs">{{ $order->duration_days }} Hari Sewa</span>
                        </td>
                        <td class="p-4 font-extrabold text-[#0284C7] text-base">{{ $order->formatted_price }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase
                                @if($order->status === 'confirmed') bg-emerald-100 text-emerald-900 border border-emerald-300
                                @elseif($order->status === 'active') bg-blue-100 text-blue-900 border border-blue-300
                                @elseif($order->status === 'returned') bg-purple-100 text-purple-900 border border-purple-300
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-900 border border-red-300
                                @else bg-amber-100 text-amber-900 border border-amber-300 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
                                   title="Cetak Nota Invoice"
                                   class="px-2.5 py-1.5 rounded-lg bg-sky-50 dark:bg-sky-900/30 border border-sky-300 dark:border-sky-700 text-sky-800 dark:text-sky-300 text-xs font-bold hover:bg-sky-100 transition-colors">
                                    Cetak Nota
                                </a>
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 text-xs font-bold rounded-lg px-2.5 py-1.5 text-slate-800 dark:text-slate-200">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="active" {{ $order->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="returned" {{ $order->status === 'returned' ? 'selected' : '' }}>Returned</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500 font-medium">Belum ada order sewa kamera yang masuk. Silakan lakukan simulasi di halaman depan!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 2: Service Inquiries -->
    <div class="card-clean rounded-2xl overflow-hidden">
        <div class="p-6 border-b-2 border-slate-100 flex items-center justify-between bg-slate-50">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900">Daftar Permintaan Dokumentasi &amp; Event</h2>
                <p class="text-sm text-slate-600">Calon klien yang memesan paket foto, video, atau penawaran kustom.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-200 text-slate-800">{{ $serviceInquiries->count() }} Data Masuk</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-100 text-slate-700 uppercase tracking-wider border-b-2 border-slate-200 font-bold text-xs">
                    <tr>
                        <th class="p-4">Kode</th>
                        <th class="p-4">Nama Pemesan</th>
                        <th class="p-4">Paket Dipilih</th>
                        <th class="p-4">Tanggal &amp; Lokasi</th>
                        <th class="p-4">Kebutuhan Acara</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($serviceInquiries as $inq)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-extrabold text-slate-900">{{ $inq->inquiry_code }}</td>
                        <td class="p-4">
                            <strong class="font-bold text-slate-900 block">{{ $inq->customer_name }}</strong>
                            @if($inq->company_name)
                            <span class="text-slate-500 text-xs block">{{ $inq->company_name }}</span>
                            @endif
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inq->customer_whatsapp) }}" target="_blank" class="text-emerald-700 font-bold hover:underline">
                                💬 {{ $inq->customer_whatsapp }}
                            </a>
                        </td>
                        <td class="p-4">
                            <strong class="font-bold text-[#0284C7]">{{ $inq->package ? $inq->package->name : $inq->service_type }}</strong>
                        </td>
                        <td class="p-4">
                            <span class="font-semibold block text-slate-900">{{ $inq->event_date ? $inq->event_date->format('d M Y') : 'Menyesuaikan' }}</span>
                            <span class="text-slate-500 text-xs">{{ $inq->venue_location ?? '-' }}</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <p class="truncate text-slate-600 text-xs" title="{{ $inq->brief_notes }}">{{ $inq->brief_notes ?? '-' }}</p>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase
                                @if($inq->status === 'deal') bg-emerald-100 text-emerald-900 border border-emerald-300
                                @elseif($inq->status === 'quoted') bg-blue-100 text-blue-900 border border-blue-300
                                @elseif($inq->status === 'contacted') bg-purple-100 text-purple-900 border border-purple-300
                                @else bg-slate-200 text-slate-800 @endif">
                                {{ $inq->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.inquiries.update-status', $inq) }}" method="POST" class="inline-flex items-center gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="bg-white border-2 border-slate-300 text-xs font-bold rounded-lg px-2.5 py-1.5 text-slate-800">
                                    <option value="new" {{ $inq->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="contacted" {{ $inq->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="quoted" {{ $inq->status === 'quoted' ? 'selected' : '' }}>Quoted</option>
                                    <option value="deal" {{ $inq->status === 'deal' ? 'selected' : '' }}>Deal</option>
                                    <option value="lost" {{ $inq->status === 'lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500 font-medium">Belum ada permintaan dokumentasi yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 3: Inventory Control -->
    <div class="card-clean rounded-2xl p-6 space-y-4">
        <h3 class="font-extrabold text-lg text-slate-900">Kelola Status Ketersediaan Unit Kamera &amp; Lensa</h3>
        <p class="text-sm text-slate-600">Klik tombol di bawah untuk mengubah status barang menjadi 'Tersedia' atau 'Sedang Disewa'.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-2">
            @foreach($rentalItems as $item)
            <div class="p-4 rounded-xl bg-slate-50 border-2 border-slate-200 flex items-center justify-between">
                <div>
                    <strong class="font-extrabold text-slate-900 text-sm block">{{ $item->name }}</strong>
                    <span class="text-xs font-bold text-[#0284C7]">{{ $item->formatted_price }} / 24 jam</span>
                </div>
                <form action="{{ route('admin.items.toggle', $item) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase transition-all shadow-sm {{ $item->is_available ? 'bg-emerald-100 text-emerald-900 border-2 border-emerald-400 hover:bg-emerald-200' : 'bg-red-100 text-red-900 border-2 border-red-400 hover:bg-red-200' }}">
                        {{ $item->is_available ? '✓ Tersedia' : '✕ Sedang Disewa' }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
