{{-- Widget Chatbot Peminjaman RS — partial snippet (bukan halaman penuh) --}}

<style>
    /* Scoped styles: hanya berlaku di dalam #hospital-chatbot */
    #hospital-chatbot * { box-sizing: border-box; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    #hospital-chatbot .chat-scroll::-webkit-scrollbar        { width: 5px; }
    #hospital-chatbot .chat-scroll::-webkit-scrollbar-track  { background: #f1f5f9; }
    #hospital-chatbot .chat-scroll::-webkit-scrollbar-thumb  { background: #cbd5e1; border-radius: 4px; }
    #hospital-chatbot .chat-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    #chat-window {
        width: 360px; height: 520px;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,.25);
        border: 1px solid #e2e8f0;
        display: flex; flex-direction: column;
        overflow: hidden;
        margin-bottom: 1rem;
        transform-origin: bottom right;
        transition: transform .3s ease, opacity .3s ease;
    }
    #chat-window.cb-hidden  { display: none; }
    #chat-window.cb-closing { transform: scale(.95); opacity: 0; }
    #chat-window.cb-open    { transform: scale(1);   opacity: 1; }

    #cb-header {
        background: linear-gradient(to right, #0369a1, #0284c7);
        color: #fff; padding: .9rem 1rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 2px 8px rgba(0,0,0,.15);
    }
    #cb-header .cb-avatar {
        width: 2.4rem; height: 2.4rem; border-radius: 50%;
        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; color: #fff; position: relative;
    }
    #cb-header .cb-status-dot {
        position: absolute; bottom: 0; right: 0;
        width: .7rem; height: .7rem;
        background: #34d399; border: 2px solid #fff; border-radius: 50%;
    }
    #cb-header h3 { font-size: .85rem; font-weight: 600; margin: 0; }
    #cb-header p  { font-size: .72rem; color: #bae6fd; margin: 0; display: flex; align-items: center; gap: .3rem; }
    #cb-header .cb-pulse { width: .45rem; height: .45rem; background: #34d399; border-radius: 50%; animation: cbPulse 1.5s infinite; }
    @keyframes cbPulse { 0%,100%{opacity:1} 50%{opacity:.4} }

    #chat-messages {
        flex: 1; padding: 1rem; overflow-y: auto;
        background: #f8fafc; font-size: .82rem;
        display: flex; flex-direction: column; gap: .65rem;
    }
    .cb-bot-row { display: flex; align-items: flex-start; gap: .6rem; }
    .cb-bot-icon {
        width: 1.7rem; height: 1.7rem; border-radius: 50%;
        background: #0369a1; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: .7rem; flex-shrink: 0; margin-top: .15rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
    }
    .cb-bot-bubble {
        background: #fff; color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 1rem 1rem 1rem .25rem;
        padding: .55rem .8rem; max-width: 82%;
        line-height: 1.5; box-shadow: 0 1px 3px rgba(0,0,0,.07);
    }
    .cb-user-row { display: flex; justify-content: flex-end; }
    .cb-user-bubble {
        background: #0369a1; color: #fff;
        border-radius: 1rem 1rem .25rem 1rem;
        padding: .55rem .8rem; max-width: 82%;
        line-height: 1.5; box-shadow: 0 1px 3px rgba(0,0,0,.15);
    }
    #quick-options {
        padding: .6rem .75rem; background: #fff;
        border-top: 1px solid #f1f5f9;
        display: flex; flex-wrap: wrap; gap: .4rem;
    }
    .cb-opt-btn {
        background: #f1f5f9; color: #475569;
        border: 1px solid #e2e8f0; border-radius: .65rem;
        padding: .3rem .7rem; font-size: .75rem; font-weight: 500;
        cursor: pointer; display: flex; align-items: center; gap: .25rem;
        transition: background .2s, color .2s, border-color .2s, transform .1s;
    }
    .cb-opt-btn:hover { background: #e0f2fe; color: #0369a1; border-color: #7dd3fc; }
    .cb-opt-btn:active { transform: scale(.95); }
    #cb-input-row {
        padding: .65rem .75rem; background: #fff;
        border-top: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: .5rem;
    }
    #user-input-cb {
        flex: 1; border: 1px solid #e2e8f0; border-radius: .75rem;
        padding: .45rem .75rem; font-size: .8rem; outline: none;
        background: #f8fafc; color: #334155;
        transition: border-color .2s, box-shadow .2s;
    }
    #user-input-cb:focus { border-color: #0284c7; box-shadow: 0 0 0 2px rgba(2,132,199,.15); }
    #cb-send-btn {
        width: 2.1rem; height: 2.1rem; border-radius: .6rem;
        background: #0369a1; color: #fff; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s, transform .1s;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
    }
    #cb-send-btn:hover { background: #075985; }
    #cb-send-btn:active { transform: scale(.93); }
    #chat-toggle-btn {
        width: 3.4rem; height: 3.4rem; border-radius: 50%;
        background: linear-gradient(to right, #0369a1, #0284c7);
        color: #fff; border: 2px solid #fff; cursor: pointer;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,.3);
        display: flex; align-items: center; justify-content: center;
        transition: transform .3s, box-shadow .3s; position: relative;
    }
    #chat-toggle-btn:hover { transform: scale(1.08); box-shadow: 0 15px 30px -5px rgba(0,0,0,.35); }
    #chat-toggle-btn:active { transform: scale(.95); }
    #chat-badge {
        position: absolute; top: -.25rem; right: -.25rem;
        width: 1.2rem; height: 1.2rem;
        background: #f43f5e; color: #fff;
        font-size: .6rem; font-weight: 700; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid #fff;
        animation: cbBounce .8s infinite alternate;
    }
    @keyframes cbBounce { from{transform:translateY(0)} to{transform:translateY(-3px)} }
    .cb-typing-dot {
        width: .4rem; height: .4rem;
        background: #94a3b8; border-radius: 50%; display: inline-block;
        animation: cbDot .9s infinite;
    }
    .cb-typing-dot:nth-child(2) { animation-delay: .2s; }
    .cb-typing-dot:nth-child(3) { animation-delay: .4s; }
    @keyframes cbDot { 0%,80%,100%{transform:translateY(0)} 40%{transform:translateY(-5px)} }
</style>



{{-- FLOATING CHATBOT WIDGET --}}
<div id="hospital-chatbot" style="position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;align-items:flex-end;">

    {{-- Chat Window --}}
    <div id="chat-window" class="cb-hidden">

        {{-- Header --}}
        <div id="cb-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div class="cb-avatar">
                    <i class="fa-solid fa-robot"></i>
                    <span class="cb-status-dot"></span>
                </div>
                <div>
                    <h3>Asisten Peminjaman RS</h3>
                    <p><span class="cb-pulse"></span> Online | Siap Membantu</p>
                </div>
            </div>
            <button onclick="cbToggle()" title="Tutup"
                style="width:1.8rem;height:1.8rem;border-radius:50%;border:none;background:rgba(255,255,255,.15);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:background .2s;"
                onmouseover="this.style.background='rgba(255,255,255,.25)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Messages --}}
        <div id="chat-messages" class="chat-scroll"></div>

        {{-- Quick options --}}
        <div id="quick-options"></div>

        {{-- Input --}}
        <div id="cb-input-row">
            <input type="text" id="user-input-cb" placeholder="Ketik pertanyaan atau pilih opsi..." onkeypress="cbHandleKey(event)">
            <button id="cb-send-btn" onclick="cbSend()" title="Kirim">
                <i class="fa-solid fa-paper-plane" style="font-size:.75rem;"></i>
            </button>
        </div>
    </div>

    {{-- Toggle button --}}
    <button id="chat-toggle-btn" onclick="cbToggle()" title="Buka Chat Asisten">
        <i id="cb-icon-chat" class="fa-solid fa-comments" style="font-size:1.3rem;"></i>
        <i id="cb-icon-close" class="fa-solid fa-xmark" style="font-size:1.3rem;display:none;"></i>
        <span id="chat-badge">1</span>
    </button>
</div>

<script>
(function () {
    'use strict';

    // ---- URL endpoint dari Laravel route ----
    const URL_STOK   = '{{ route("chatbot.stok") }}';
    const URL_STATUS = '{{ route("chatbot.status-pengajuan") }}';
    const CSRF_TOKEN = '{{ csrf_token() }}';

    let cbIsOpen = false;
    const cbWindow    = document.getElementById('chat-window');
    const cbMessages  = document.getElementById('chat-messages');
    const cbOptions   = document.getElementById('quick-options');
    const cbBadge     = document.getElementById('chat-badge');
    const cbIconChat  = document.getElementById('cb-icon-chat');
    const cbIconClose = document.getElementById('cb-icon-close');

    const mainOptions = [
        { label: '📦 Cek Stok Barang',  action: 'cek_stok' },
        { label: '📝 Cara Pengajuan',   action: 'cara_pengajuan' },
        { label: '📊 Status Pengajuan', action: 'status_pengajuan' },
        { label: '📞 Kontak IT Support',action: 'kontak_it' },
    ];

    // ---- Status badge color helper ----
    const statusColor = { PENDING: '#d97706', APPROVED: '#0369a1', BORROWED: '#0369a1', PENDING_RETURN: '#7c3aed', RETURNED: '#059669', REJECTED: '#dc2626' };
    const statusLabel = { PENDING: 'Menunggu Persetujuan', APPROVED: 'Disetujui', BORROWED: 'Sedang Dipinjam', PENDING_RETURN: 'Menunggu Pengembalian', RETURNED: 'Sudah Dikembalikan', REJECTED: 'Ditolak' };

    window.cbToggle = function () {
        cbIsOpen = !cbIsOpen;
        if (cbIsOpen) {
            cbWindow.classList.remove('cb-hidden', 'cb-closing');
            void cbWindow.offsetWidth;
            cbWindow.classList.add('cb-open');
            cbIconChat.style.display = 'none';
            cbIconClose.style.display = '';
            if (cbBadge) cbBadge.style.display = 'none';
            if (cbMessages.children.length === 0) cbInit();
        } else {
            cbWindow.classList.remove('cb-open');
            cbWindow.classList.add('cb-closing');
            setTimeout(() => {
                cbWindow.classList.add('cb-hidden');
                cbWindow.classList.remove('cb-closing');
            }, 300);
            cbIconChat.style.display = '';
            cbIconClose.style.display = 'none';
        }
    };

    function cbInit() {
        cbAddBot('Halo! 👋 Saya Bot Asisten IT Rumah Sakit. Ada yang bisa saya bantu terkait <b>peminjaman aset</b> hari ini?');
        cbRenderOptions(mainOptions);
    }

    function cbAddBot(text) {
        const row = document.createElement('div');
        row.className = 'cb-bot-row';
        row.innerHTML = `<div class="cb-bot-icon"><i class="fa-solid fa-robot"></i></div><div class="cb-bot-bubble">${text}</div>`;
        cbMessages.appendChild(row);
        cbScroll();
    }

    function cbAddUser(text) {
        const row = document.createElement('div');
        row.className = 'cb-user-row';
        row.innerHTML = `<div class="cb-user-bubble">${text}</div>`;
        cbMessages.appendChild(row);
        cbScroll();
    }

    function cbRenderOptions(opts) {
        cbOptions.innerHTML = '';
        opts.forEach(o => {
            const btn = document.createElement('button');
            btn.className = 'cb-opt-btn';
            btn.textContent = o.label;
            btn.onclick = () => cbHandleAction(o.label, o.action, o.payload ?? null);
            cbOptions.appendChild(btn);
        });
    }

    function cbHandleAction(label, action, payload = null) {
        cbAddUser(label);
        // Jika cbProcess sudah showTyping sendiri (async), jangan tambah delay
        const asyncActions = ['cek_stok', 'status_pengajuan'];
        if (asyncActions.includes(action)) {
            cbProcess(action, payload);
        } else {
            cbShowTyping();
            setTimeout(() => { cbRemoveTyping(); cbProcess(action, payload); }, 500);
        }
    }

    function cbProcess(action, payload) {
        switch (action) {
            // ---- CEK STOK: ambil daftar nama barang dari DB ----
            case 'cek_stok':
                cbShowTyping();
                fetch(URL_STOK, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(data => {
                        cbRemoveTyping();
                        if (!data.length) {
                            cbAddBot('Saat ini belum ada data barang di sistem.');
                            cbRenderOptions([{ label: '⬅️ Menu Utama', action: 'menu_utama' }]);
                            return;
                        }
                        cbAddBot('Silakan pilih barang yang ingin dicek stoknya:');
                        const opts = data.map(item => ({
                            label: `📦 ${item.nama}`,
                            action: 'stok_detail',
                            payload: item,
                        }));
                        opts.push({ label: '⬅️ Menu Utama', action: 'menu_utama' });
                        cbRenderOptions(opts);
                    })
                    .catch(() => {
                        cbRemoveTyping();
                        cbAddBot('Gagal memuat data stok. Coba lagi nanti.');
                        cbRenderOptions([{ label: '⬅️ Menu Utama', action: 'menu_utama' }]);
                    });
                break;

            // ---- DETAIL STOK per barang ----
            case 'stok_detail': {
                const item = payload;
                let html = `<b>Stok ${item.nama}:</b><br>`;
                html += `• Total unit: <b>${item.total}</b><br>`;
                html += `• Tersedia: <b style="color:#059669;">${item.tersedia}</b><br>`;
                html += `• Sedang dipinjam: <b style="color:#dc2626;">${item.dipinjam}</b>`;
                if (item.tersedia > 0 && Object.keys(item.per_gedung).length) {
                    html += '<br><br><b>Lokasi tersedia:</b>';
                    for (const [gedung, jml] of Object.entries(item.per_gedung)) {
                        html += `<br>📍 ${gedung}: <b>${jml} unit</b>`;
                    }
                } else if (item.tersedia === 0) {
                    html += '<br><i style="color:#94a3b8;">Semua unit sedang dipinjam.</i>';
                }
                cbAddBot(html);
                cbRenderOptions([
                    { label: '📦 Cek Barang Lain', action: 'cek_stok' },
                    { label: '⬅️ Menu Utama',      action: 'menu_utama' },
                ]);
                break;
            }

            // ---- CARA PENGAJUAN: statis ----
            case 'cara_pengajuan':
                cbAddBot('<b>Langkah Pengajuan Peminjaman:</b><br>1️⃣ Buka menu <b>Peminjaman</b> di navbar.<br>2️⃣ Isi Gedung Pemohon &amp; Gedung Tujuan.<br>3️⃣ Pilih unit barang &amp; tanggal pinjam.<br>4️⃣ Klik <b>Kirim Pengajuan</b>, tunggu approval IT.');
                cbRenderOptions([
                    { label: '📊 Cek Status Pengajuan', action: 'status_pengajuan' },
                    { label: '⬅️ Menu Utama',           action: 'menu_utama' },
                ]);
                break;

            // ---- STATUS PENGAJUAN: ambil dari DB milik user login ----
            case 'status_pengajuan':
                cbShowTyping();
                fetch(URL_STATUS, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(data => {
                        cbRemoveTyping();
                        if (!data.length) {
                            cbAddBot('Kamu belum memiliki riwayat pengajuan peminjaman.');
                            cbRenderOptions([
                                { label: '📝 Cara Pengajuan', action: 'cara_pengajuan' },
                                { label: '⬅️ Menu Utama',     action: 'menu_utama' },
                            ]);
                            return;
                        }
                        let html = '<b>5 Pengajuan Terbaru Kamu:</b><br><br>';
                        data.forEach((b, i) => {
                            const color = statusColor[b.status] ?? '#64748b';
                            const label = statusLabel[b.status] ?? b.status;
                            html += `<b>${i+1}. ${b.barang || '—'}</b><br>`;
                            html += `&nbsp;&nbsp;📅 ${b.borrow_date ?? '—'} → ${b.return_date ?? '—'}<br>`;
                            html += `&nbsp;&nbsp;🏢 ${b.asal ?? '—'} → ${b.tujuan ?? '—'}<br>`;
                            html += `&nbsp;&nbsp;Status: <span style="color:${color};font-weight:600;">${label}</span>`;
                            if (i < data.length - 1) html += '<br><br>';
                        });
                        cbAddBot(html);
                        cbRenderOptions([
                            { label: '📞 Hubungi IT Support', action: 'kontak_it' },
                            { label: '⬅️ Menu Utama',         action: 'menu_utama' },
                        ]);
                    })
                    .catch(() => {
                        cbRemoveTyping();
                        cbAddBot('Gagal memuat status pengajuan. Coba lagi nanti.');
                        cbRenderOptions([{ label: '⬅️ Menu Utama', action: 'menu_utama' }]);
                    });
                break;

            // ---- KONTAK IT: statis ----
            case 'kontak_it':
                cbAddBot('<b>Layanan Helpdesk IT Support:</b><br>📍 Gedung Utama Lt. 2<br>📞 Ext. Internal: <b>104 / 105</b><br>📱 WhatsApp: 0812-3456-7890');
                cbRenderOptions([{ label: '⬅️ Menu Utama', action: 'menu_utama' }]);
                break;

            case 'menu_utama':
            default:
                cbAddBot('Ada hal lain yang bisa saya bantu?');
                cbRenderOptions(mainOptions);
        }
    }

    function cbShowTyping() {
        const row = document.createElement('div');
        row.id = 'cb-typing';
        row.className = 'cb-bot-row';
        row.innerHTML = `<div class="cb-bot-icon"><i class="fa-solid fa-robot"></i></div><div class="cb-bot-bubble" style="padding:.5rem .8rem;"><span class="cb-typing-dot"></span><span class="cb-typing-dot"></span><span class="cb-typing-dot"></span></div>`;
        cbMessages.appendChild(row);
        cbScroll();
    }
    function cbRemoveTyping() { const el=document.getElementById('cb-typing'); if(el)el.remove(); }

    window.cbHandleKey = function (e) { if (e.key === 'Enter') cbSend(); };
    window.cbSend = function () {
        const input = document.getElementById('user-input-cb');
        const q = input.value.trim();
        if (!q) return;
        cbAddUser(q); input.value = '';
        cbShowTyping();
        setTimeout(() => {
            cbRemoveTyping();
            const lower = q.toLowerCase();
            if (lower.includes('stok') || lower.includes('barang') || lower.includes('ada')) cbProcess('cek_stok');
            else if (lower.includes('cara') || lower.includes('pinjam') || lower.includes('syarat')) cbProcess('cara_pengajuan');
            else if (lower.includes('status') || lower.includes('acc') || lower.includes('proses')) cbProcess('status_pengajuan');
            else if (lower.includes('kontak') || lower.includes('it') || lower.includes('nomor') || lower.includes('wa')) cbProcess('kontak_it');
            else { cbAddBot('Maaf, kurang dipahami. Silakan pilih opsi:'); cbRenderOptions(mainOptions); }
        }, 650);
    };

    function cbScroll() { cbMessages.scrollTop = cbMessages.scrollHeight; }
})();
</script>