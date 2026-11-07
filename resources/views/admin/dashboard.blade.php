@extends('layouts.admin')

@section('title', 'Admin Dashboard - DEZZLY CREATIVE Panel Kendali')

@section('content')
<div class="py-8 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

    {{-- Header Banner --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Pusat Kendali Operasional Studio</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 dark:text-white mt-1">
                Dashboard Operasional Dezzly Creative
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                Pantau seluruh permintaan jasa dokumentasi acara, gathering, konser, dan wedding yang masuk secara real-time.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                Operator Aktif: <strong class="text-slate-800 dark:text-slate-200">{{ Auth::user()->name ?? 'Admin' }}</strong>
            </span>
        </div>
    </div>

    {{-- Feedback Flash Message --}}
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    {{-- Metrics Cards Strip (100% Studio Focused) --}}
    @php
        $dealCount = $serviceInquiries->where('status', 'deal')->count();
        $negotiatingCount = $serviceInquiries->whereIn('status', ['contacted', 'quoted'])->count();
        $newCount = $serviceInquiries->where('status', 'new')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Total Permintaan Masuk</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-[#0284C7] dark:text-sky-400 mt-1">{{ $totalInquiries }}</div>
            <span class="text-xs font-bold text-slate-600 dark:text-slate-400 mt-2 block">Inquiry website & WhatsApp</span>
        </div>

        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Project Deal / Terkonfirmasi</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $dealCount }} Acara</div>
            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 mt-2 block">Jadwal event terkunci</span>
        </div>

        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Tahap Penawaran / Follow-up</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-amber-600 dark:text-amber-400 mt-1">{{ $negotiatingCount }} Klien</div>
            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 mt-2 block">Quoted & Contacted</span>
        </div>

        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm p-6 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Inquiry Baru Belum Dihubungi</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-purple-600 dark:text-purple-400 mt-1">{{ $newCount }} Klien</div>
            <span class="text-xs font-bold text-purple-700 dark:text-purple-400 mt-2 block">Perlu respon cepat WhatsApp</span>
        </div>
    </div>

    {{-- Main Table: Daftar Permintaan Dokumentasi & Event --}}
    <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b-2 border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50 dark:bg-slate-800/90">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900 dark:text-white">Daftar Permintaan Dokumentasi & Booking Event</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-0.5">Kelola pipeline calon klien yang memesan paket foto, video sinematik, atau penawaran kustom.</p>
            </div>
            <span class="text-xs font-bold px-3.5 py-1.5 rounded-full bg-sky-100 dark:bg-sky-950/70 border border-sky-300 dark:border-sky-800 text-sky-800 dark:text-sky-300">
                {{ $serviceInquiries->count() }} Permintaan Terdaftar
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b-2 border-slate-200 dark:border-slate-700 font-extrabold text-xs">
                    <tr>
                        <th class="p-4">Kode & Tanggal</th>
                        <th class="p-4">Klien & Kontak WhatsApp</th>
                        <th class="p-4">Paket / Acara</th>
                        <th class="p-4">Tanggal & Lokasi Acara</th>
                        <th class="p-4">Kebutuhan Acara</th>
                        <th class="p-4">Status Pipeline</th>
                        <th class="p-4 text-right">Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                    @forelse($serviceInquiries as $inq)
                    @php
                        $waNum = preg_replace('/[^0-9]/', '', $inq->customer_whatsapp);
                        if (str_starts_with($waNum, '0')) {
                            $waClean = '62' . substr($waNum, 1);
                        } else {
                            $waClean = $waNum;
                        }
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                        <td class="p-4">
                            <span class="font-extrabold text-slate-900 dark:text-white font-mono block">{{ $inq->inquiry_code }}</span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400">{{ $inq->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="p-4">
                            <strong class="font-bold text-slate-900 dark:text-white block">{{ $inq->customer_name }}</strong>
                            @if($inq->company_name)
                                <span class="text-xs text-slate-500 dark:text-slate-400 block">{{ $inq->company_name }}</span>
                            @endif
                            <a href="https://wa.me/{{ $waClean }}?text=Halo%20kak%20{{ urlencode($inq->customer_name) }},%20kami%20dari%20Dezzly%20Creative%20terkait%20permintaan%20dokumentasi%20acara%20{{ urlencode($inq->inquiry_code) }}"
                               target="_blank"
                               class="text-emerald-700 dark:text-emerald-400 font-bold hover:underline text-xs inline-flex items-center gap-1 mt-1">
                                <span>💬</span>
                                <span>{{ $inq->customer_whatsapp }}</span>
                            </a>
                        </td>
                        <td class="p-4">
                            <strong class="font-bold text-[#0284C7] dark:text-sky-400">{{ $inq->package ? $inq->package->name : $inq->service_type }}</strong>
                        </td>
                        <td class="p-4">
                            <span class="font-semibold block text-slate-900 dark:text-white">{{ $inq->event_date ? $inq->event_date->format('d M Y') : 'Menyesuaikan' }}</span>
                            <span class="text-slate-500 dark:text-slate-400 text-xs">{{ $inq->venue_location ?? 'Lokasi belum ditentukan' }}</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <p class="text-slate-600 dark:text-slate-400 text-xs line-clamp-2" title="{{ $inq->brief_notes }}">{{ $inq->brief_notes ?? '-' }}</p>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase
                                @if($inq->status === 'deal') bg-emerald-100 dark:bg-emerald-900/40 text-emerald-900 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700
                                @elseif($inq->status === 'quoted') bg-blue-100 dark:bg-blue-900/40 text-blue-900 dark:text-blue-300 border border-blue-300 dark:border-blue-700
                                @elseif($inq->status === 'contacted') bg-purple-100 dark:bg-purple-900/40 text-purple-900 dark:text-purple-300 border border-purple-300 dark:border-purple-700
                                @elseif($inq->status === 'new') bg-amber-100 dark:bg-amber-900/40 text-amber-900 dark:text-amber-300 border border-amber-300 dark:border-amber-700
                                @else bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 @endif">
                                {{ $inq->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.inquiries.update-status', $inq) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 text-xs font-bold rounded-lg px-2.5 py-1.5 text-slate-800 dark:text-slate-200 cursor-pointer">
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
                        <td colspan="7" class="p-8 text-center text-slate-500 dark:text-slate-400 font-medium">
                            Belum ada permintaan dokumentasi yang masuk. Formulir di halaman depan siap melayani pengunjung.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
