<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - Amin Jaya Smart Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; color: #1a1a1b; }
        .card { border: none; border-radius: 12px; transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-5px); }
        .card-img-top { height: 220px; object-fit: cover; border-radius: 12px 12px 0 0; }
        .ai-chat-float { position: fixed; bottom: 20px; right: 20px; width: 350px; z-index: 1050; }
        .chat-win { height: 250px; overflow-y: auto; background: #ffffff; display: flex; flex-direction: column; padding: 10px; }
        .msg { margin-bottom: 8px; padding: 10px; border-radius: 15px; font-size: 0.9rem; max-width: 85%; }
        .user-msg { background: #007bff; color: white; align-self: flex-end; border-bottom-right-radius: 2px; }
        .juki-msg { background: #fff3e0; color: #856404; align-self: flex-start; border-bottom-left-radius: 2px; border: 1px solid #ffeeba; }
        #juki-launcher { position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; display: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">PT AMIN JAYA</a>
        <a href="/admin" class="btn btn-outline-warning btn-sm">Masuk Mode Admin</a>
    </div>
</nav>

<div class="container py-5">
    <div class="mb-5">
        <h3 class="fw-bold mb-4 text-center"><i class="bi bi-truck me-2"></i>Pesanan Saya</h3>
        <div class="row">
            @foreach($orders as $o)
            <div class="col-md-6 mb-3">
                <div class="card p-3 shadow-sm border-start border-warning border-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-bold">{{ $o->produk->nama_baju }}</h6>
                        <span class="badge bg-info text-dark">{{ $o->status }}</span>
                    </div>
                    <p class="small text-muted mb-1">Kurir: {{ $o->kurir }} | {{ $o->pembayaran }}</p>
                    <p class="small mb-0">Estimasi Tiba: <strong>{{ $o->tanggal_pengiriman ?? 'Menunggu konfirmasi admin' }}</strong></p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <hr>

    <h3 class="fw-bold mb-4 text-center">Katalog Produk</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($produks as $p)
        <div class="col">
            <div class="card h-100 shadow-sm product-card border-0">
                <img src="{{ $p->image }}" class="card-img-top">
                <div class="card-body text-center">
                    <span class="badge bg-light text-secondary mb-2">{{ $p->brand }}</span>
                    <h5 class="fw-bold">{{ $p->nama_baju }}</h5>
                    <p class="text-primary fw-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                    <button onclick="openCheckoutModal({{ $p->id }}, '{{ $p->nama_baju }}', {{ $p->harga }})" class="btn btn-dark w-100 rounded-pill mt-2">
                        <i class="bi bi-cart-plus me-2"></i>Beli Sekarang
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-warning fw-bold">Detail Pengiriman</div>
            <div class="modal-body">
                <div class="mb-3"><label class="small fw-bold">Item</label><input type="text" id="co-nama" class="form-control" readonly></div>
                <div class="mb-3"><label class="small fw-bold">Alamat Pengiriman</label><textarea id="co-alamat" class="form-control" rows="2" required></textarea></div>
                <div class="row">
                    <div class="col-6 mb-3"><label class="small fw-bold">Kurir</label><select id="co-kurir" class="form-select"><option value="JNE">JNE</option><option value="GoSend">GoSend</option></select></div>
                    <div class="col-6 mb-3"><label class="small fw-bold">Bayar</label><select id="co-bayar" class="form-select"><option value="Bank">Transfer</option><option value="E-Wallet">OVO/Dana</option></select></div>
                </div>
                <div class="p-3 bg-light rounded d-flex justify-content-between">
                    <span class="fw-bold">Total:</span><span id="co-total" class="fw-bold text-danger fs-5"></span>
                </div>
                <input type="hidden" id="co-id">
            </div>
            <div class="modal-footer"><button type="button" onclick="prosesCheckout()" class="btn btn-warning w-100 fw-bold rounded-pill">Konfirmasi & Bayar</button></div>
        </div>
    </div>
</div>

<div id="juki-container" class="ai-chat-float shadow-lg">
    <div class="card border-0 shadow">
        <div class="card-header bg-warning py-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-robot me-2"></i>Si Juki AI</span>
            <button onclick="toggleJuki()" class="btn btn-sm btn-dark rounded-circle">—</button>
        </div>
        <div class="card-body">
            <div id="chat-win" class="chat-win mb-3 rounded border shadow-inner">
                <div class="msg juki-msg">Huwala! Mau belanja apa lu?</div>
            </div>
            <div class="input-group mb-2">
                <input type="text" id="chat-input" class="form-control border-0 bg-light" placeholder="Ketik pesan...">
                <button onclick="handleChat()" class="btn btn-primary"><i class="bi bi-send"></i></button>
            </div>
            <button id="mic-btn" class="btn btn-outline-danger w-100 fw-bold rounded-pill">🎤 Bicara</button>
        </div>
    </div>
</div>
<button id="juki-launcher" onclick="toggleJuki()" class="btn btn-warning rounded-circle shadow-lg">🤖</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let checkoutModal;
    const chatInput = document.getElementById('chat-input');
    const chatWin = document.getElementById('chat-win');
    const micBtn = document.getElementById('mic-btn');

    document.addEventListener('DOMContentLoaded', () => {
        checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    });

    // --- FUNGSI UI ---
    function toggleJuki() {
        const container = document.getElementById('juki-container');
        const launcher = document.getElementById('juki-launcher');
        const isHidden = container.style.display === 'none';
        container.style.display = isHidden ? 'block' : 'none';
        launcher.style.display = isHidden ? 'none' : 'block';
    }

    function openCheckoutModal(id, nama, harga) {
        document.getElementById('co-id').value = id;
        document.getElementById('co-nama').value = nama;
        document.getElementById('co-total').innerText = 'Rp ' + harga.toLocaleString('id-ID');
        checkoutModal.show();
    }

    // --- LOGIKA VOICE (SPEECH RECOGNITION) ---
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (SpeechRecognition) {
        const recognition = new SpeechRecognition();
        recognition.lang = 'id-ID';
        recognition.continuous = false;

        micBtn.addEventListener('click', () => {
            recognition.start();
            micBtn.classList.add('mic-active', 'btn-danger'); // Tambah warna merah saat aktif
            micBtn.innerHTML = "🎤 Menyimak...";
        });

        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            micBtn.classList.remove('mic-active', 'btn-danger');
            micBtn.innerHTML = "🎤 Bicara";
            sendToAI(transcript); // Otomatis kirim teks hasil suara ke AI
        };

        recognition.onerror = (event) => {
            micBtn.classList.remove('mic-active', 'btn-danger');
            micBtn.innerHTML = "🎤 Bicara";
            console.error("Mic Error:", event.error);
        };
    } else {
        micBtn.style.display = "none";
        console.warn("Browser tidak mendukung Web Speech API");
    }

    // --- LOGIKA AI & CHAT ---
        function sendToAI(text) {
        chatWin.innerHTML += `<div class="msg user-msg">${text}</div>`;
        chatWin.scrollTop = chatWin.scrollHeight;

        // Gunakan 127.0.0.1 agar lebih stabil di Windows/Mac
        fetch('http://127.0.0.1:5000/proses', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ text: text }) // Pastikan key-nya 'text' sesuai Query model Python
        })
        .then(r => {
            if (!r.ok) throw new Error("Server AI Down");
            return r.json();
        })
        .then(data => {
            chatWin.innerHTML += `<div class="msg juki-msg">${data.reply}</div>`;
            chatWin.scrollTop = chatWin.scrollHeight;
            
            const utter = new SpeechSynthesisUtterance(data.reply);
            utter.lang = 'id-ID';
            window.speechSynthesis.speak(utter);
        })
        .catch(err => {
            console.error("Detail Error:", err);
            chatWin.innerHTML += `<div class="msg juki-msg text-danger">Aduh, koneksi ke Juki AI putus, Bos!</div>`;
        });
    }

    function handleChat() {
        if(chatInput.value.trim()) {
            sendToAI(chatInput.value);
            chatInput.value = "";
        }
    }

    // Biar bisa kirim pesan pake tombol Enter
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') handleChat();
    });

    // --- LOGIKA CHECKOUT ---
    function prosesCheckout() {
        const id = document.getElementById('co-id').value;
        const alamat = document.getElementById('co-alamat').value;
        if(!alamat) return alert('Alamat diisi dulu!');

        fetch(`/api/checkout/${id}`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Content-Type': 'application/json', 
                'Accept': 'application/json' 
            },
            body: JSON.stringify({ 
                alamat: alamat, 
                kurir: document.getElementById('co-kurir').value, 
                bayar: document.getElementById('co-bayar').value 
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                checkoutModal.hide();
                const jukiSay = `Huwala! Pesanan ${data.produk} lo udah gue proses. Dikirim ke ${alamat}. Sikat!`;
                
                chatWin.innerHTML += `<div class="msg juki-msg">${jukiSay}</div>`;
                const utter = new SpeechSynthesisUtterance(jukiSay);
                utter.lang = 'id-ID';
                window.speechSynthesis.speak(utter);

                setTimeout(() => location.reload(), 3000);
            }
        })
        .catch(err => alert("Gagal checkout, cek koneksi database!"));
    }
</script>
</body>
</html>