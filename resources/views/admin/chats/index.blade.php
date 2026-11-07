@extends('layouts.admin')

@section('title', 'Ruang Negosiasi Chat - DEZZLY CREATIVE Panel Kendali')

@section('content')
<div class="py-6 sm:py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" x-data="adminChatApp()" x-init="initChat()">

    {{-- Header Banner & Stats --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-6 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Real-time Negotiation Hub</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 dark:text-white mt-1">
                Ruang Negosiasi & Chat Langsung
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                Bernegosiasi secara langsung dengan calon klien. Saat sepakat, kunci kesepakatan (Deal) untuk diarahkan ke WhatsApp resmi studio.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            {{-- Retention Cleanup Trigger Button --}}
            <form action="{{ route('admin.chats.prune') }}" method="POST" onsubmit="return confirm('Jalankan pembersihan otomatis untuk chat yang sudah DEAL dan berusia lebih dari 60 hari?')">
                @csrf
                <button type="submit"
                        class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors flex items-center gap-1.5 cursor-pointer"
                        title="Hapus sesi deal yang sudah lewat dari 60 hari">
                    <span>🧹</span>
                    <span>Bersihkan Deal > 60 Hari</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Metrics Cards Strip --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 p-5 rounded-2xl shadow-sm">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Total Sesi Chat</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ $totalSessions }}</div>
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-1 block">Riwayat negosiasi klien</span>
        </div>

        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 p-5 rounded-2xl shadow-sm">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Sedang Aktif Nego</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-[#0284C7] dark:text-sky-400 mt-1">{{ $activeSessions }}</div>
            <span class="text-xs font-bold text-sky-700 dark:text-sky-400 mt-1 block">Perlu respon tim</span>
        </div>

        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 p-5 rounded-2xl shadow-sm">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Deal Tercapai</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $dealSessions }}</div>
            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 mt-1 block">Disepakati (Retensi 60 hari)</span>
        </div>

        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 p-5 rounded-2xl shadow-sm">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Pesan Baru Unread</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-red-500 mt-1" x-text="unreadTotal">{{ $totalUnread }}</div>
            <span class="text-xs font-bold text-red-600 dark:text-red-400 mt-1 block">Pesan menunggu balasan</span>
        </div>
    </div>

    {{-- Dual Pane Chat Workspace --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-3xl shadow-lg overflow-hidden h-[750px]">

        {{-- =============================================================
             LEFT PANE: SESSIONS LIST & FILTERS
        ============================================================= --}}
        <div class="lg:col-span-4 border-r-2 border-slate-200 dark:border-slate-700 flex flex-col h-full bg-slate-50/50 dark:bg-slate-800/60">

            {{-- Search & Filter Controls --}}
            <div class="p-4 border-b-2 border-slate-200 dark:border-slate-700 space-y-3">
                <div class="relative">
                    <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSessions()"
                           placeholder="Cari nama klien / kode chat..."
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7]">
                    <span class="absolute left-3 top-2.5 text-xs text-slate-400">🔍</span>
                </div>

                {{-- Status Tabs --}}
                <div class="flex items-center gap-1.5">
                    <button @click="setStatusFilter('all')"
                            :class="activeStatusFilter === 'all' ? 'bg-[#0284C7] text-white font-extrabold shadow-xs' : 'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-lg text-xs transition-colors cursor-pointer">
                        Semua
                    </button>
                    <button @click="setStatusFilter('active')"
                            :class="activeStatusFilter === 'active' ? 'bg-[#0284C7] text-white font-extrabold shadow-xs' : 'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-lg text-xs transition-colors cursor-pointer">
                        Aktif Nego
                    </button>
                    <button @click="setStatusFilter('deal')"
                            :class="activeStatusFilter === 'deal' ? 'bg-emerald-600 text-white font-extrabold shadow-xs' : 'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-lg text-xs transition-colors cursor-pointer">
                        Deal (Sepakat)
                    </button>
                </div>
            </div>

            {{-- Sessions Scroll List --}}
            <div class="flex-1 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700/60">
                <template x-for="s in sessions" :key="s.id">
                    <div @click="selectSession(s.id)"
                         class="p-4 hover:bg-slate-100 dark:hover:bg-slate-700/50 cursor-pointer transition-colors relative"
                         :class="selectedSessionId === s.id ? 'bg-sky-50 dark:bg-sky-950/40 border-l-4 border-[#0284C7]' : ''">

                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <span class="font-extrabold text-sm text-slate-900 dark:text-white block" x-text="s.customer_name"></span>
                                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400" x-text="s.session_code"></span>
                            </div>
                            <span class="text-[10px] text-slate-400 whitespace-nowrap" x-text="s.last_message_at"></span>
                        </div>

                        <div class="flex items-center justify-between gap-2 mt-2">
                            <span class="text-xs font-semibold text-[#0284C7] dark:text-sky-400 truncate max-w-[170px]"
                                  x-text="s.package_name || 'Diskusi Kustom'"></span>

                            <div class="flex items-center gap-1.5">
                                <template x-if="s.is_deal">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300">
                                        Deal
                                    </span>
                                </template>
                                <template x-if="!s.is_deal">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-100 dark:bg-sky-900/60 text-sky-800 dark:text-sky-300">
                                        Nego
                                    </span>
                                </template>

                                <template x-if="s.admin_unread_count > 0">
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-500 text-white animate-pulse"
                                          x-text="s.admin_unread_count"></span>
                                </template>
                            </div>
                        </div>

                        {{-- Retention Tag for Deal Sessions --}}
                        <template x-if="s.is_deal && s.days_until_prune !== null">
                            <div class="mt-1.5 text-[10px] text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <span>⏳</span>
                                <span>Auto-hapus dalam <strong class="text-amber-600 dark:text-amber-400" x-text="s.days_until_prune"></strong> hari</span>
                            </div>
                        </template>

                    </div>
                </template>

                <div x-show="sessions.length === 0" class="p-8 text-center text-slate-400 text-xs font-medium">
                    Tidak ada percakapan yang cocok.
                </div>
            </div>

        </div>

        {{-- =============================================================
             RIGHT PANE: LIVE CONVERSATION & DEAL DESK
        ============================================================= --}}
        <div class="lg:col-span-8 flex flex-col h-full bg-white dark:bg-slate-800 relative">

            {{-- State: No Session Selected --}}
            <div x-show="!selectedSessionId" class="flex-1 flex flex-col items-center justify-center p-8 text-center text-slate-400">
                <div class="w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-700/60 flex items-center justify-center text-4xl mb-4">
                    💬
                </div>
                <h3 class="font-extrabold text-lg text-slate-800 dark:text-slate-200">Pilih Percakapan Negosiasi</h3>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-sm mt-1">
                    Klik salah satu sesi obrolan klien di sebelah kiri untuk melihat pesan, berbalas pesan, atau menandai kesepakatan (Deal).
                </p>
            </div>

            {{-- State: Session Active --}}
            <template x-if="selectedSessionId && currentSession">
                <div class="flex-1 flex flex-col h-full">

                    {{-- Chat Room Header --}}
                    <div class="p-4 sm:px-6 border-b-2 border-slate-200 dark:border-slate-700 flex flex-wrap items-center justify-between gap-3 bg-slate-50 dark:bg-slate-900/60">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-extrabold text-base sm:text-lg text-slate-900 dark:text-white" x-text="currentSession.customer_name"></h3>
                                <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300" x-text="currentSession.session_code"></span>
                            </div>

                            <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 mt-1">
                                <span x-text="'Paket: ' + (currentSession.package_name || 'Kustom')"></span>
                                <template x-if="currentSession.customer_whatsapp">
                                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold" x-text="'WA: ' + currentSession.customer_whatsapp"></span>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- Deal Action Button --}}
                            <template x-if="!currentSession.is_deal">
                                <button @click="openDealModal()"
                                        class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs shadow-md shadow-emerald-600/20 transition-all flex items-center gap-1.5 cursor-pointer">
                                    <span>🤝</span>
                                    <span>Kunci Kesepakatan (Deal)</span>
                                </button>
                            </template>

                            {{-- Already Deal Badge / WA Direct Link --}}
                            <template x-if="currentSession.is_deal">
                                <a :href="currentSession.whatsapp_deal_url" target="_blank"
                                   class="px-3.5 py-2 rounded-xl bg-emerald-100 hover:bg-emerald-200 dark:bg-emerald-950/70 dark:hover:bg-emerald-900 border border-emerald-400 text-emerald-900 dark:text-emerald-300 font-bold text-xs flex items-center gap-1.5 transition-colors">
                                    <span>✓ Deal:</span>
                                    <span x-text="currentSession.agreed_price_formatted"></span>
                                    <span>(Buka WA &rarr;)</span>
                                </a>
                            </template>

                            {{-- Delete Session Button --}}
                            <button @click="deleteCurrentSession()"
                                    class="p-2 rounded-xl border border-red-200 dark:border-red-800 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 text-xs transition-colors cursor-pointer"
                                    title="Hapus Sesi Chat">
                                🗑
                            </button>
                        </div>
                    </div>

                    {{-- Deal Notice Banner (If Deal) --}}
                    <template x-if="currentSession.is_deal">
                        <div class="bg-emerald-500/10 border-b border-emerald-500/20 px-6 py-2.5 flex items-center justify-between text-xs text-emerald-800 dark:text-emerald-300">
                            <div class="flex items-center gap-2">
                                <span class="text-base">🎉</span>
                                <span>Kesepakatan tercapai pada <strong x-text="currentSession.deal_at"></strong>. Sesi ini otomatis dibersihkan dalam <strong x-text="currentSession.days_until_prune"></strong> hari.</span>
                            </div>
                            <a :href="currentSession.whatsapp_deal_url" target="_blank" class="font-extrabold underline hover:text-emerald-600">
                                Direct ke WhatsApp &rarr;
                            </a>
                        </div>
                    </template>

                    {{-- Messages Stream Area --}}
                    <div id="admin-chat-messages-container"
                         class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 bg-slate-100/50 dark:bg-slate-900/40">

                        <template x-for="m in currentMessages" :key="m.id">
                            <div>
                                {{-- Customer Message (Left) --}}
                                <template x-if="m.sender_type === 'customer'">
                                    <div class="flex items-start gap-2.5 max-w-[80%]">
                                        <div class="w-8 h-8 rounded-full bg-slate-300 dark:bg-slate-700 flex items-center justify-center text-xs font-extrabold text-slate-700 dark:text-slate-200 shrink-0">
                                            <span x-text="m.sender_name.charAt(0)"></span>
                                        </div>
                                        <div class="bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-2xl rounded-tl-none p-3.5 shadow-xs">
                                            <div class="flex items-center justify-between gap-3 mb-1">
                                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200" x-text="m.sender_name"></span>
                                                <span class="text-[10px] text-slate-400" x-text="formatTime(m.created_at)"></span>
                                            </div>
                                            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 whitespace-pre-wrap leading-relaxed" x-text="m.message"></p>
                                        </div>
                                    </div>
                                </template>

                                {{-- Admin Message (Right) --}}
                                <template x-if="m.sender_type === 'admin'">
                                    <div class="flex items-start justify-end gap-2.5 ml-auto max-w-[80%]">
                                        <div class="bg-[#0284C7] text-white rounded-2xl rounded-tr-none p-3.5 shadow-sm">
                                            <div class="flex items-center justify-between gap-3 mb-1">
                                                <span class="text-xs font-bold text-sky-100" x-text="m.sender_name"></span>
                                                <span class="text-[10px] text-sky-200" x-text="formatTime(m.created_at)"></span>
                                            </div>
                                            <p class="text-xs sm:text-sm text-white whitespace-pre-wrap leading-relaxed" x-text="m.message"></p>
                                        </div>
                                        <div class="w-8 h-8 rounded-full bg-sky-600 flex items-center justify-center text-xs font-extrabold text-white shrink-0">
                                            D
                                        </div>
                                    </div>
                                </template>

                                {{-- System / Deal Card Message (Center) --}}
                                <template x-if="m.sender_type === 'system'">
                                    <div class="my-4 max-w-lg mx-auto">
                                        <div class="p-4 sm:p-5 rounded-2xl border border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-950/40 text-amber-950 dark:text-amber-200 shadow-md">
                                            <div class="flex items-center gap-2 font-extrabold text-xs sm:text-sm uppercase tracking-wider text-amber-800 dark:text-amber-400">
                                                <span>✦</span>
                                                <span x-text="m.sender_name"></span>
                                            </div>
                                            <p class="text-xs sm:text-sm mt-1 whitespace-pre-wrap leading-relaxed" x-text="m.message"></p>

                                            <template x-if="m.deal_payload && m.deal_payload.whatsapp_url">
                                                <div class="mt-3 pt-3 border-t border-amber-200 dark:border-amber-800 flex items-center justify-between">
                                                    <span class="text-xs font-bold" x-text="'Deal: ' + m.deal_payload.agreed_price_formatted"></span>
                                                    <a :href="m.deal_payload.whatsapp_url" target="_blank"
                                                       class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition-colors flex items-center gap-1">
                                                        <span>Buka di WhatsApp &rarr;</span>
                                                    </a>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </template>

                    </div>

                    {{-- Chat Input Bar --}}
                    <div class="p-3 sm:p-4 border-t-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                        {{-- Quick Responses Snippets --}}
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-2 scrollbar-none text-[11px]">
                            <button @click="fillQuickReply('Halo kak! Ada yang bisa kami bantu mengenai rincian paket dokumentasi acara Anda?')"
                                    class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 whitespace-nowrap cursor-pointer">
                                Sapa Klien
                            </button>
                            <button @click="fillQuickReply('Bisa kami tawarkan penyesuaian harga khusus untuk tanggal dan lokasi tersebut.')"
                                    class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 whitespace-nowrap cursor-pointer">
                                Tawaran Diskon
                            </button>
                            <button @click="fillQuickReply('Boleh diinfokan durasi acara serta apakah membutuhkan rekaman udara drone 4K?')"
                                    class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 whitespace-nowrap cursor-pointer">
                                Tanya Drone & Rundown
                            </button>
                        </div>

                        <form @submit.prevent="sendAdminMessage()" class="flex items-center gap-2">
                            <textarea x-model="newMessageText"
                                      @keydown.enter.prevent="if(!$event.shiftKey) sendAdminMessage()"
                                      rows="1"
                                      placeholder="Ketik balasan untuk klien... (Enter untuk kirim)"
                                      class="flex-1 bg-slate-100 dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7] resize-none"></textarea>

                            <button type="submit"
                                    :disabled="isSending || !newMessageText.trim()"
                                    class="px-5 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-xs sm:text-sm shadow-md transition-all disabled:opacity-50 cursor-pointer shrink-0">
                                <span x-text="isSending ? '...' : 'Kirim'"></span>
                            </button>
                        </form>
                    </div>

                </div>
            </template>

        </div>

    </div>

    {{-- =============================================================
         MODAL: KUNCI KESEPAKATAN (DEAL DESK)
    ============================================================= --}}
    <div x-show="isDealModalOpen"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isDealModalOpen = false"
             class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl max-w-md w-full border-2 border-slate-300 dark:border-slate-600 shadow-2xl space-y-4">

            <div class="flex items-start justify-between border-b-2 border-slate-100 dark:border-slate-700 pb-3">
                <div>
                    <span class="text-xs font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Kesepakatan Studio</span>
                    <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Kunci Kesepakatan (Deal)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Ringkasan kesepakatan akan dikirim ke chat & siap dialihkan ke WhatsApp.</p>
                </div>
                <button type="button" @click="isDealModalOpen = false" class="text-slate-400 hover:text-slate-800 dark:hover:text-white text-2xl font-bold p-1 cursor-pointer">&times;</button>
            </div>

            <form @submit.prevent="submitDeal()" class="space-y-4 text-xs sm:text-sm">
                <div>
                    <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Harga Akhir Disepakati (Rp): *</label>
                    <input type="number" step="10000" x-model="dealForm.agreed_price" required
                           placeholder="Contoh: 3500000"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-mono font-bold focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Nama Paket / Layanan:</label>
                    <input type="text" x-model="dealForm.package_name"
                           placeholder="Paket Menengah / Full Documentation"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Tanggal Acara:</label>
                        <input type="date" x-model="dealForm.event_date"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-3 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Lokasi Acara:</label>
                        <input type="text" x-model="dealForm.venue_location"
                               placeholder="Kota / Venue"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-3 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Catatan Kesepakatan Khusus:</label>
                    <textarea x-model="dealForm.deal_notes" rows="2"
                              placeholder="Kru 2 orang, termasuk drone 4K, revisi 2x..."
                              class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500"></textarea>
                </div>

                <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-300 dark:border-amber-700 text-xs text-amber-900 dark:text-amber-300">
                    ℹ️ Sesi chat yang deal akan disimpan selama 60 hari untuk keperluan arsip operasional, lalu otomatis dibersihkan sistem.
                </div>

                <button type="submit"
                        :disabled="isSubmittingDeal"
                        class="w-full py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold uppercase tracking-wide shadow-md transition-all cursor-pointer">
                    <span x-text="isSubmittingDeal ? 'Mengunci Kesepakatan...' : 'Kunci Kesepakatan & Kirim Kartu Deal →'"></span>
                </button>
            </form>

        </div>
    </div>

</div>

{{-- =============================================================
     ALPINE JS SCRIPT FOR ADMIN CHAT REALTIME
============================================================= --}}
<script>
function adminChatApp() {
    return {
        sessions: [],
        activeStatusFilter: 'all',
        searchQuery: '',
        selectedSessionId: null,
        currentSession: null,
        currentMessages: [],
        unreadTotal: {{ $totalUnread }},
        newMessageText: '',
        isSending: false,
        isDealModalOpen: false,
        isSubmittingDeal: false,
        pollTimer: null,
        dealForm: {
            agreed_price: '',
            package_name: '',
            event_date: '',
            venue_location: '',
            deal_notes: ''
        },

        initChat() {
            this.fetchSessions();
            // Start polling every 3 seconds for real-time updates
            this.pollTimer = setInterval(() => {
                this.pollUpdates();
            }, 3000);
        },

        setStatusFilter(filter) {
            this.activeStatusFilter = filter;
            this.fetchSessions();
        },

        async fetchSessions() {
            try {
                let url = '{{ route('admin.chats.sessions') }}?status=' + this.activeStatusFilter;
                if (this.searchQuery) {
                    url += '&q=' + encodeURIComponent(this.searchQuery);
                }
                const res = await fetch(url);
                const data = await res.json();
                if (data.status === 'success') {
                    this.sessions = data.sessions;
                    this.unreadTotal = this.sessions.reduce((acc, s) => acc + (s.admin_unread_count || 0), 0);
                }
            } catch (e) {
                console.error('Error fetching sessions:', e);
            }
        },

        async selectSession(sessionId) {
            this.selectedSessionId = sessionId;
            this.currentMessages = [];
            await this.loadMessages(sessionId, 0);
            this.fetchSessions();
            this.scrollToBottom();
        },

        async loadMessages(sessionId, lastId = 0) {
            try {
                const url = '/admin/chats/' + sessionId + '/messages?last_id=' + lastId;
                const res = await fetch(url);
                const data = await res.json();
                if (data.status === 'success') {
                    this.currentSession = data.session;
                    if (lastId === 0) {
                        this.currentMessages = data.messages;
                    } else if (data.messages && data.messages.length > 0) {
                        this.currentMessages = [...this.currentMessages, ...data.messages];
                    }
                    this.scrollToBottom();
                }
            } catch (e) {
                console.error('Error loading messages:', e);
            }
        },

        async pollUpdates() {
            // Update sidebar sessions list
            await this.fetchSessions();

            // If a session is open, poll for new messages
            if (this.selectedSessionId) {
                const lastId = this.currentMessages.length > 0
                    ? this.currentMessages[this.currentMessages.length - 1].id
                    : 0;
                await this.loadMessages(this.selectedSessionId, lastId);
            }
        },

        async sendAdminMessage() {
            if (!this.newMessageText.trim() || !this.selectedSessionId || this.isSending) return;

            this.isSending = true;
            try {
                const res = await fetch('/admin/chats/' + this.selectedSessionId + '/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: this.newMessageText })
                });
                const data = await res.json();
                if (data.status === 'success') {
                    this.currentMessages.push(data.message);
                    this.newMessageText = '';
                    this.scrollToBottom();
                }
            } catch (e) {
                alert('Gagal mengirim pesan.');
            } finally {
                this.isSending = false;
            }
        },

        fillQuickReply(text) {
            this.newMessageText = text;
        },

        openDealModal() {
            if (!this.currentSession) return;
            this.dealForm.package_name = this.currentSession.package_name || '';
            this.dealForm.event_date = this.currentSession.event_date || '';
            this.dealForm.venue_location = this.currentSession.venue_location || '';
            this.dealForm.deal_notes = '';
            this.isDealModalOpen = true;
        },

        async submitDeal() {
            if (!this.selectedSessionId || this.isSubmittingDeal) return;

            this.isSubmittingDeal = true;
            try {
                const res = await fetch('/admin/chats/' + this.selectedSessionId + '/deal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.dealForm)
                });
                const data = await res.json();
                if (data.status === 'success') {
                    this.isDealModalOpen = false;
                    await this.loadMessages(this.selectedSessionId, 0);
                    this.fetchSessions();
                    if (data.whatsapp_url) {
                        if (confirm('Kesepakatan Deal berhasil dikunci! Apakah Anda ingin membuka WhatsApp sekarang?')) {
                            window.open(data.whatsapp_url, '_blank');
                        }
                    }
                }
            } catch (e) {
                alert('Gagal mengunci deal.');
            } finally {
                this.isSubmittingDeal = false;
            }
        },

        async deleteCurrentSession() {
            if (!this.selectedSessionId) return;
            if (!confirm('Hapus sesi obrolan negosiasi ini secara permanen?')) return;

            try {
                const res = await fetch('/admin/chats/' + this.selectedSessionId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    this.selectedSessionId = null;
                    this.currentSession = null;
                    this.currentMessages = [];
                    this.fetchSessions();
                }
            } catch (e) {
                alert('Gagal menghapus sesi.');
            }
        },

        formatTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const el = document.getElementById('admin-chat-messages-container');
                if (el) {
                    el.scrollTop = el.scrollHeight;
                }
            });
        }
    };
}
</script>
@endsection

