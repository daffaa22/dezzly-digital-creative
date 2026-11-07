@php
    $chatPackages = \App\Models\Package::select('id', 'name', 'subtitle')->get();
    $waRaw = \App\Models\SiteSetting::get('whatsapp_number', '0821-4603-1398');
    $waDigits = preg_replace('/[^0-9]/', '', $waRaw);
    if (str_starts_with($waDigits, '0')) {
        $waIntl = '62' . substr($waDigits, 1);
    } else {
        $waIntl = $waDigits;
    }
@endphp

<div x-data="visitorNegotiationChat()" x-init="initWidget()" class="select-none">

    {{-- ===================================================================
         FLOATING ACTION DOCK (BOTTOM RIGHT)
    =================================================================== --}}
    <div class="fixed bottom-5 right-5 z-50 flex items-center gap-2.5">

        {{-- 1. WhatsApp Fast Direct Link --}}
        <a href="https://wa.me/{{ $waIntl }}?text=Halo%20Dezzly%20Creative,%20saya%20ingin%20konsultasi%20dokumentasi%20acara"
           target="_blank"
           class="hidden sm:inline-flex items-center gap-2 px-4 py-3 rounded-full bg-[#15803D] hover:bg-[#166534] text-white font-bold text-xs shadow-lg shadow-green-900/30 hover:scale-105 active:scale-95 transition-all border border-white/20"
           title="Langsung chat ke WhatsApp Studio">
            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
            </svg>
            <span>WhatsApp</span>
        </a>

        {{-- 2. Real-time Live Negotiation Chat Toggle Button --}}
        <button @click="toggleChatWindow()"
                class="relative flex items-center gap-2.5 px-5 py-3.5 sm:px-6 sm:py-3.5 rounded-full bg-gradient-to-r from-sky-600 via-cyan-600 to-sky-700 hover:from-sky-500 hover:to-cyan-500 text-white font-extrabold text-sm shadow-[0_10px_30px_rgba(2,132,199,0.4)] hover:scale-105 active:scale-95 transition-all border border-cyan-400/50 cursor-pointer">

            <div class="relative flex items-center justify-center">
                <span class="text-lg">💬</span>
                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
            </div>

            <div class="text-left leading-tight">
                <span class="text-[10px] text-cyan-200 block font-semibold tracking-wider uppercase">Live Nego Studio</span>
                <span class="text-xs sm:text-sm font-extrabold">Chat & Negosiasi</span>
            </div>

            {{-- Unread Badge --}}
            <template x-if="unreadCount > 0">
                <span class="ml-1 px-2 py-0.5 rounded-full bg-red-500 text-white text-xs font-extrabold animate-bounce"
                      x-text="unreadCount"></span>
            </template>
        </button>

    </div>

    {{-- ===================================================================
         CHAT WINDOW POPUP (MODAL DRAWER)
    =================================================================== --}}
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-95"
         class="fixed bottom-20 right-4 sm:right-6 z-50 w-[94vw] sm:w-[410px] h-[590px] max-h-[85vh] bg-[#0A0E18]/95 backdrop-blur-2xl border border-white/20 rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] flex flex-col overflow-hidden text-white"
         style="display: none;">

        {{-- Chat Window Header --}}
        <div class="px-5 py-4 border-b border-white/10 bg-gradient-to-r from-slate-950 via-[#0E1527] to-slate-950 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-600 to-cyan-400 flex items-center justify-center font-extrabold text-white text-lg shadow-md shrink-0">
                    D
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-sm tracking-wide text-white">Dezzly Concierge</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_#34d399]"></span>
                    </div>
                    <span class="text-[10px] text-cyan-300 font-medium block">Ruang Negosiasi & Penawaran Studio</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button @click="isOpen = false"
                        class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white flex items-center justify-center text-lg font-bold transition-colors cursor-pointer"
                        title="Tutup Chat">
                    ✕
                </button>
            </div>
        </div>

        {{-- ===============================================================
             MODE 1: FORM PENDAFTARAN MULAI CHAT (JIKA BELUM ADA SESI)
        =============================================================== --}}
        <template x-if="!sessionToken">
            <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-5">
                <div class="space-y-1.5 text-center">
                    <span class="inline-block text-xs font-bold tracking-widest uppercase text-cyan-400">Negosiasi Langsung</span>
                    <h3 class="font-bold text-lg text-white font-serif italic">Mulai Obrolan dengan Tim Produser</h3>
                    <p class="text-xs text-slate-400 font-light leading-relaxed">
                        Konsultasikan rundown, sesuaikan jumlah kamera/drone, dan dapatkan penawaran harga terbaik.
                    </p>
                </div>

                <form @submit.prevent="startSession()" class="space-y-4 text-xs">
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Nama Lengkap Anda: *</label>
                        <input type="text" x-model="startForm.customer_name" required
                               placeholder="Contoh: Rian Pratama"
                               class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>

                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Nomor WhatsApp (Opsional):</label>
                        <input type="text" x-model="startForm.customer_whatsapp"
                               placeholder="Contoh: 08123456789"
                               class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>

                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Pilihan Paket Acara:</label>
                        <select x-model="startForm.package_id"
                                class="w-full bg-[#0F1626] border border-white/15 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-cyan-400 transition-colors">
                            <option value="" class="bg-[#0F1626]">-- Pilih Paket (Atau Penawaran Kustom) --</option>
                            @foreach($chatPackages as $pkg)
                            <option value="{{ $pkg->id }}" class="bg-[#0F1626]">{{ $pkg->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Pertanyaan / Rencana Acara Anda: *</label>
                        <textarea x-model="startForm.initial_message" required rows="3"
                                  placeholder="Contoh: Halo, kami ada gathering kantor 150 pax di Bogor tanggal 20 depan, apakah ada diskon untuk paket menengah?"
                                  class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors"></textarea>
                    </div>

                    <button type="submit"
                            :disabled="isStarting"
                            class="w-full py-3.5 rounded-xl bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-slate-950 font-extrabold text-xs uppercase tracking-wider shadow-lg transition-all disabled:opacity-50 cursor-pointer">
                        <span x-text="isStarting ? 'Menghubungkan...' : 'Mulai Chat Negosiasi &rarr;'"></span>
                    </button>
                </form>

                <div class="text-[10px] text-slate-400 text-center pt-2 border-t border-white/10">
                    🔒 Obrolan aman dan tersimpan rapi. Sesi yang deal akan otomatis dibersihkan setelah 60 hari.
                </div>
            </div>
        </template>

        {{-- ===============================================================
             MODE 2: RUANG PERCAKAPAN LIVE (JIKA SUDAH ADA SESI)
        =============================================================== --}}
        <template x-if="sessionToken">
            <div class="flex-1 flex flex-col h-full overflow-hidden">

                {{-- DEAL BANNER (KETIKA SUDAH TERJADI KESEPAKATAN) --}}
                <template x-if="isDeal">
                    <div class="bg-gradient-to-r from-emerald-950/90 via-emerald-900/90 to-emerald-950/90 border-b border-emerald-500/40 p-3.5 space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold text-emerald-300">
                            <span class="flex items-center gap-1.5">
                                <span class="text-base">🎉</span>
                                <span>KESEPAKATAN DEAL TERCAPAI!</span>
                            </span>
                            <span x-text="agreedPriceFormatted" class="font-extrabold text-white"></span>
                        </div>
                        <p class="text-[11px] text-emerald-200/90 font-light leading-snug">
                            Lanjutkan ke WhatsApp resmi studio untuk konfirmasi invoice dan penguncian jadwal acara.
                        </p>
                        <a :href="whatsappDealUrl" target="_blank"
                           class="w-full py-2.5 px-4 rounded-xl bg-[#15803D] hover:bg-[#166534] text-white font-extrabold text-xs flex items-center justify-center gap-2 shadow-md transition-all">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
                            </svg>
                            <span>Lanjut ke WhatsApp Sekarang &rarr;</span>
                        </a>
                    </div>
                </template>

                {{-- Messages Stream List --}}
                <div id="visitor-chat-messages-container"
                     class="flex-1 overflow-y-auto p-4 space-y-3.5 bg-slate-950/60">

                    <template x-for="m in messages" :key="m.id">
                        <div>
                            {{-- Customer Message (Right) --}}
                            <template x-if="m.sender_type === 'customer'">
                                <div class="flex items-end justify-end gap-2 ml-auto max-w-[85%]">
                                    <div class="bg-gradient-to-r from-sky-600 to-cyan-600 text-white rounded-2xl rounded-tr-none px-4 py-2.5 shadow-sm text-xs leading-relaxed">
                                        <p class="whitespace-pre-wrap" x-text="m.message"></p>
                                        <span class="text-[9px] text-cyan-200 block text-right mt-1" x-text="formatTime(m.created_at)"></span>
                                    </div>
                                </div>
                            </template>

                            {{-- Admin Message (Left) --}}
                            <template x-if="m.sender_type === 'admin'">
                                <div class="flex items-start gap-2 max-w-[85%]">
                                    <div class="w-7 h-7 rounded-lg bg-sky-600 flex items-center justify-center font-bold text-white text-xs shrink-0 mt-0.5">
                                        D
                                    </div>
                                    <div class="bg-white/[0.08] border border-white/10 rounded-2xl rounded-tl-none px-4 py-2.5 shadow-sm text-xs leading-relaxed text-slate-100">
                                        <div class="flex items-center justify-between gap-3 mb-1">
                                            <span class="text-[10px] font-bold text-cyan-300" x-text="m.sender_name"></span>
                                            <span class="text-[9px] text-slate-400" x-text="formatTime(m.created_at)"></span>
                                        </div>
                                        <p class="whitespace-pre-wrap text-slate-200 font-light" x-text="m.message"></p>
                                    </div>
                                </div>
                            </template>

                            {{-- System Message / Deal Card (Center) --}}
                            <template x-if="m.sender_type === 'system'">
                                <div class="my-3 max-w-[90%] mx-auto">
                                    <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-400/30 text-amber-200 text-xs">
                                        <div class="flex items-center gap-1.5 font-bold uppercase tracking-wider text-amber-400 text-[10px] mb-1">
                                            <span>✦</span>
                                            <span x-text="m.sender_name"></span>
                                        </div>
                                        <p class="whitespace-pre-wrap leading-relaxed text-amber-100 font-light" x-text="m.message"></p>

                                        <template x-if="m.deal_payload && m.deal_payload.whatsapp_url">
                                            <div class="mt-2.5 pt-2 border-t border-amber-400/20 flex flex-col gap-2">
                                                <div class="flex items-center justify-between font-bold text-[11px] text-white">
                                                    <span>Harga Deal:</span>
                                                    <span x-text="m.deal_payload.agreed_price_formatted" class="text-emerald-400"></span>
                                                </div>
                                                <a :href="m.deal_payload.whatsapp_url" target="_blank"
                                                   class="w-full py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs text-center transition-colors">
                                                    Buka WhatsApp &rarr;
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
                <div class="p-3 border-t border-white/10 bg-[#0A0E18]">
                    <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                        <textarea x-model="newMessage"
                                  @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                                  rows="1"
                                  placeholder="Ketik pesan negosiasi Anda..."
                                  class="flex-1 bg-white/[0.05] border border-white/15 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 resize-none"></textarea>

                        <button type="submit"
                                :disabled="isSending || !newMessage.trim()"
                                class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-slate-950 font-bold text-xs shadow-md transition-all disabled:opacity-50 cursor-pointer shrink-0">
                            <span x-text="isSending ? '...' : 'Kirim'"></span>
                        </button>
                    </form>

                    <div class="flex items-center justify-between text-[10px] text-slate-500 pt-2 px-1">
                        <span>Kode: <strong class="text-slate-400" x-text="sessionCode"></strong></span>
                        <button @click="resetSession()" class="hover:text-red-400 transition-colors cursor-pointer">
                            Akhiri & Mulai Baru
                        </button>
                    </div>
                </div>

            </div>
        </template>

    </div>

</div>

{{-- ===================================================================
     ALPINE JS LOGIC FOR VISITOR CHAT
=================================================================== --}}
<script>
function visitorNegotiationChat() {
    return {
        isOpen: false,
        sessionToken: localStorage.getItem('dezzly_chat_token') || null,
        sessionCode: '',
        messages: [],
        unreadCount: 0,
        isStarting: false,
        isSending: false,
        isDeal: false,
        agreedPriceFormatted: '',
        whatsappDealUrl: '',
        pollTimer: null,
        newMessage: '',

        startForm: {
            customer_name: '',
            customer_whatsapp: '',
            package_id: '',
            initial_message: ''
        },

        initWidget() {
            window.openNegotiationChat = (pkgId = null, pkgName = '') => {
                this.isOpen = true;
                if (!this.sessionToken && pkgId) {
                    this.startForm.package_id = pkgId;
                    this.startForm.initial_message = 'Halo Dezzly Studio, saya tertarik dan ingin bernegosiasi untuk ' + (pkgName || 'paket ini') + '.';
                }
                this.scrollToBottom();
            };
            if (this.sessionToken) {
                this.loadExistingSession();
            }
        },

        toggleChatWindow() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.unreadCount = 0;
                this.scrollToBottom();
                if (this.sessionToken && !this.pollTimer) {
                    this.startPolling();
                }
            }
        },

        async startSession() {
            if (!this.startForm.customer_name || !this.startForm.initial_message || this.isStarting) return;

            this.isStarting = true;
            try {
                const res = await fetch('{{ route('chat.start') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.startForm)
                });
                const data = await res.json();
                if (data.status === 'success') {
                    this.sessionToken = data.session_token;
                    this.sessionCode = data.session_code;
                    localStorage.setItem('dezzly_chat_token', this.sessionToken);
                    this.messages = data.messages;
                    this.startPolling();
                    this.scrollToBottom();
                }
            } catch (e) {
                alert('Terjadi kendala jaringan saat memulai chat.');
            } finally {
                this.isStarting = false;
            }
        },

        async loadExistingSession() {
            try {
                const res = await fetch('/chat/' + this.sessionToken);
                const data = await res.json();
                if (data.status === 'success') {
                    this.sessionCode = data.session.session_code;
                    this.messages = data.messages;
                    this.isDeal = data.session.is_deal;
                    this.agreedPriceFormatted = data.session.agreed_price_formatted;
                    this.whatsappDealUrl = data.session.whatsapp_deal_url;
                    this.startPolling();
                    this.scrollToBottom();
                } else {
                    this.resetSession();
                }
            } catch (e) {
                console.error('Error loading session:', e);
            }
        },

        startPolling() {
            if (this.pollTimer) clearInterval(this.pollTimer);
            this.pollTimer = setInterval(async () => {
                if (!this.sessionToken) return;
                const lastId = this.messages.length > 0 ? this.messages[this.messages.length - 1].id : 0;
                try {
                    const res = await fetch('/chat/' + this.sessionToken + '/poll?last_id=' + lastId);
                    const data = await res.json();
                    if (data.status === 'success') {
                        if (data.is_deal) {
                            this.isDeal = true;
                            this.whatsappDealUrl = data.whatsapp_deal_url;
                        }
                        if (data.messages && data.messages.length > 0) {
                            this.messages = [...this.messages, ...data.messages];
                            if (!this.isOpen) {
                                this.unreadCount += data.messages.length;
                            }
                            this.scrollToBottom();
                        }
                    }
                } catch (e) {
                    console.error('Polling error:', e);
                }
            }, 2500);
        },

        async sendMessage() {
            if (!this.newMessage.trim() || !this.sessionToken || this.isSending) return;

            this.isSending = true;
            try {
                const res = await fetch('/chat/' + this.sessionToken + '/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: this.newMessage })
                });
                const data = await res.json();
                if (data.status === 'success') {
                    this.messages.push(data.message);
                    this.newMessage = '';
                    this.scrollToBottom();
                }
            } catch (e) {
                alert('Gagal mengirim pesan.');
            } finally {
                this.isSending = false;
            }
        },

        resetSession() {
            localStorage.removeItem('dezzly_chat_token');
            this.sessionToken = null;
            this.sessionCode = '';
            this.messages = [];
            this.isDeal = false;
            if (this.pollTimer) clearInterval(this.pollTimer);
        },

        formatTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const el = document.getElementById('visitor-chat-messages-container');
                if (el) {
                    el.scrollTop = el.scrollHeight;
                }
            });
        }
    };
}
</script>
