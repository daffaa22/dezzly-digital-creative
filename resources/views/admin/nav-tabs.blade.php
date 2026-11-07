<nav class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto py-2.5 text-xs sm:text-sm font-bold scrollbar-none">
    {{-- 1. Operasional & Inquiry --}}
    <a href="{{ route('admin.dashboard') }}"
       class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'bg-[#0284C7] text-white shadow-md shadow-sky-600/20' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
        <span>📊</span>
        <span>Operasional & Permintaan Event</span>
    </a>

    {{-- 2. Ruang Negosiasi Chat Realtime --}}
    @php
        $chatUnreadCount = \App\Models\ChatSession::sum('admin_unread_count');
    @endphp
    <a href="{{ route('admin.chats.index') }}"
       class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ request()->routeIs('admin.chats*') ? 'bg-[#0284C7] text-white shadow-md shadow-sky-600/20' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
        <span>💬</span>
        <span>Ruang Negosiasi Chat</span>
        @if($chatUnreadCount > 0)
        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-red-500 text-white animate-pulse shadow-sm">
            {{ $chatUnreadCount }}
        </span>
        @endif
    </a>

    {{-- 2. Info Studio & Teks Landing --}}
    <a href="{{ route('admin.cms.settings') }}"
       class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ request()->routeIs('admin.cms.settings*') ? 'bg-[#0284C7] text-white shadow-md shadow-sky-600/20' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
        <span>⚙️</span>
        <span>Info & Teks Landing</span>
    </a>

    {{-- 3. Paket Dokumentasi --}}
    <a href="{{ route('admin.cms.packages') }}"
       class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ request()->routeIs('admin.cms.packages*') ? 'bg-[#0284C7] text-white shadow-md shadow-sky-600/20' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
        <span>📦</span>
        <span>Paket Dokumentasi</span>
    </a>

    {{-- 4. Portofolio --}}
    <a href="{{ route('admin.cms.portfolio') }}"
       class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ request()->routeIs('admin.cms.portfolio*') ? 'bg-[#0284C7] text-white shadow-md shadow-sky-600/20' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
        <span>🖼️</span>
        <span>Portofolio Karya</span>
    </a>

    {{-- 5. FAQ --}}
    <a href="{{ route('admin.cms.faqs') }}"
       class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ request()->routeIs('admin.cms.faqs*') ? 'bg-[#0284C7] text-white shadow-md shadow-sky-600/20' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
        <span>❓</span>
        <span>FAQ Pengunjung</span>
    </a>
</nav>
