@extends('layouts.app')

@section('title', 'Admin Dashboard — DEZZLY CREATIVE Control Center')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Internal Control Center</span>
            </div>
            <h1 class="font-display font-bold text-2xl sm:text-3xl text-white mt-1">Dashboard Operasional Dezzly</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-700 text-xs font-semibold text-slate-200 transition-colors">
                🌐 Lihat Website Publik
            </a>
        </div>
    </div>

    <!-- Feedback Flash Message -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center justify-between">
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Metrics Cards Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="glass-panel p-5 rounded-2xl border-white/5">
            <span class="text-xs text-slate-400 block">Total Booking Sewa Kamera</span>
            <div class="text-3xl font-display font-extrabold text-white mt-1">{{ $totalOrders }}</div>
            <span class="text-[11px] text-cyan-400 mt-2 block">Masuk via Web & WhatsApp</span>
        </div>
        <div class="glass-panel p-5 rounded-2xl border-white/5">
            <span class="text-xs text-slate-400 block">Total Permintaan Dokumentasi (Inquiry)</span>
            <div class="text-3xl font-display font-extrabold text-blue-400 mt-1">{{ $totalInquiries }}</div>
            <span class="text-[11px] text-blue-300 mt-2 block">Event & Enterprise Leads</span>
        </div>
        <div class="glass-panel p-5 rounded-2xl border-white/5">
            <span class="text-xs text-slate-400 block">Estimasi Omset Rental Terkonfirmasi</span>
            <div class="text-3xl font-display font-extrabold text-emerald-400 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <span class="text-[11px] text-emerald-300 mt-2 block">Status Sewa Aktif / Terkonfirmasi</span>
        </div>
        <div class="glass-panel p-5 rounded-2xl border-white/5">
            <span class="text-xs text-slate-400 block">Kamera Siap Disewa</span>
            <div class="text-3xl font-display font-extrabold text-purple-400 mt-1">{{ $availableCameras }} Unit</div>
            <span class="text-[11px] text-purple-300 mt-2 block">Stok Aktif di Studio</span>
        </div>
    </div>

    <!-- Table 1: Incoming Rental Orders -->
    <div class="glass-panel rounded-2xl border-white/5 overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-900/60">
            <div>
                <h2 class="font-display font-bold text-base text-white">Daftar Order Sewa Kamera Terkini</h2>
                <p class="text-xs text-slate-400">Pesanan sewa kamera 24 jam yang masuk dari kalkulator web.</p>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full bg-slate-800 text-slate-300">{{ $rentalOrders->count() }} Order</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/60 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="p-3.5">Kode Order</th>
                        <th class="p-3.5">Penyewa & WA</th>
                        <th class="p-3.5">Kamera & Lensa</th>
                        <th class="p-3.5">Mulai / Durasi</th>
                        <th class="p-3.5">Total Biaya</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5 text-right">Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($rentalOrders as $order)
                    <tr class="hover:bg-slate-900/40 transition-colors">
                        <td class="p-3.5 font-bold text-white">{{ $order->order_code }}</td>
                        <td class="p-3.5">
                            <span class="font-semibold text-white block">{{ $order->customer_name }}</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_whatsapp) }}" target="_blank" class="text-emerald-400 hover:underline">
                                💬 {{ $order->customer_whatsapp }}
                            </a>
                        </td>
                        <td class="p-3.5">
                            <span class="font-semibold text-cyan-300 block">{{ $order->camera->name }}</span>
                            <span class="text-slate-400 text-[11px]">{{ $order->lens ? $order->lens->name : 'Tanpa Lensa Tambahan' }}</span>
                        </td>
                        <td class="p-3.5">
                            <span class="block">{{ $order->start_date->format('d M Y') }}</span>
                            <span class="text-slate-400 text-[11px]">{{ $order->duration_days }} Hari (x 24 Jam)</span>
                        </td>
                        <td class="p-3.5 font-bold text-cyan-400">{{ $order->formatted_price }}</td>
                        <td class="p-3.5">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase
                                @if($order->status === 'confirmed') bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                                @elseif($order->status === 'active') bg-blue-500/20 text-blue-300 border border-blue-500/30
                                @elseif($order->status === 'returned') bg-purple-500/20 text-purple-300 border border-purple-500/30
                                @elseif($order->status === 'cancelled') bg-rose-500/20 text-rose-300 border border-rose-500/30
                                @else bg-amber-500/20 text-amber-300 border border-amber-500/30 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-3.5 text-right">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline-flex items-center gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="bg-slate-900 border border-slate-700 text-xs rounded-lg px-2 py-1 text-slate-200">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="active" {{ $order->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="returned" {{ $order->status === 'returned' ? 'selected' : '' }}>Returned</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-slate-500">Belum ada order sewa kamera yang masuk. Coba lakukan simulasi di halaman depan!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 2: Service Inquiries -->
    <div class="glass-panel rounded-2xl border-white/5 overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-900/60">
            <div>
                <h2 class="font-display font-bold text-base text-white">Daftar Permintaan Dokumentasi & Event</h2>
                <p class="text-xs text-slate-400">Leads proposal & paket dokumentasi dari calon klien korporat / event organizer.</p>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full bg-slate-800 text-slate-300">{{ $serviceInquiries->count() }} Leads</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/60 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="p-3.5">Kode</th>
                        <th class="p-3.5">Klien / Perusahaan</th>
                        <th class="p-3.5">Paket Layanan</th>
                        <th class="p-3.5">Tanggal Acara & Venue</th>
                        <th class="p-3.5">Brief Kebutuhan</th>
                        <th class="p-3.5">Status Lead</th>
                        <th class="p-3.5 text-right">Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($serviceInquiries as $inq)
                    <tr class="hover:bg-slate-900/40 transition-colors">
                        <td class="p-3.5 font-bold text-white">{{ $inq->inquiry_code }}</td>
                        <td class="p-3.5">
                            <span class="font-semibold text-white block">{{ $inq->customer_name }}</span>
                            @if($inq->company_name)
                            <span class="text-slate-400 text-[11px] block">{{ $inq->company_name }}</span>
                            @endif
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inq->customer_whatsapp) }}" target="_blank" class="text-emerald-400 hover:underline">
                                💬 {{ $inq->customer_whatsapp }}
                            </a>
                        </td>
                        <td class="p-3.5">
                            <span class="font-bold text-cyan-300 block">{{ $inq->package ? $inq->package->name : $inq->service_type }}</span>
                        </td>
                        <td class="p-3.5">
                            <span class="block">{{ $inq->event_date ? $inq->event_date->format('d M Y') : 'Menyesuaikan' }}</span>
                            <span class="text-slate-400 text-[11px]">{{ $inq->venue_location ?? '-' }}</span>
                        </td>
                        <td class="p-3.5 max-w-xs">
                            <p class="truncate text-slate-400" title="{{ $inq->brief_notes }}">{{ $inq->brief_notes ?? '-' }}</p>
                        </td>
                        <td class="p-3.5">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase
                                @if($inq->status === 'deal') bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                                @elseif($inq->status === 'quoted') bg-blue-500/20 text-blue-300 border border-blue-500/30
                                @elseif($inq->status === 'contacted') bg-purple-500/20 text-purple-300 border border-purple-500/30
                                @else bg-slate-800 text-slate-300 @endif">
                                {{ $inq->status }}
                            </span>
                        </td>
                        <td class="p-3.5 text-right">
                            <form action="{{ route('admin.inquiries.update-status', $inq) }}" method="POST" class="inline-flex items-center gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="bg-slate-900 border border-slate-700 text-xs rounded-lg px-2 py-1 text-slate-200">
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
                        <td colspan="7" class="p-6 text-center text-slate-500">Belum ada inquiry yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 3: Inventory Control -->
    <div class="glass-panel rounded-2xl border-white/5 p-6 space-y-4">
        <h3 class="font-display font-bold text-base text-white">Inventaris Unit Kamera & Lensa</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($rentalItems as $item)
            <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                <div>
                    <span class="font-bold text-white text-xs block">{{ $item->name }}</span>
                    <span class="text-[11px] text-cyan-400">{{ $item->formatted_price }} / 24 jam</span>
                </div>
                <form action="{{ route('admin.items.toggle', $item) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-2.5 py-1 rounded text-[10px] font-bold uppercase transition-colors {{ $item->is_available ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-rose-500/20 text-rose-300 border border-rose-500/40' }}">
                        {{ $item->is_available ? 'Tersedia' : 'Disewa' }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
