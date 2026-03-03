import './bootstrap';

// Fungsi Minimize / Maximize
function toggleJuki() {
    const container = document.getElementById('juki-container');
    const launcher = document.getElementById('juki-launcher');

    if (container.style.display !== 'none') {
        container.style.display = 'none';
        launcher.style.display = 'block';
    } else {
        container.style.display = 'block';
        launcher.style.display = 'none';
    }
}
let modalCheckout;

document.addEventListener('DOMContentLoaded', function() {
    modalCheckout = new bootstrap.Modal(document.getElementById('checkoutModal'));
});

// 1. Fungsi buka modal saat klik 'Beli Sekarang'
function checkout(id, nama, harga) {
    document.getElementById('co-id').value = id;
    document.getElementById('co-nama').value = nama;
    document.getElementById('co-harga').innerText = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
    modalCheckout.show();
}

// 2. Fungsi kirim data ke Laravel
function prosesBayar() {
    const id = document.getElementById('co-id').value;
    const data = {
        alamat: document.getElementById('co-alamat').value,
        pengiriman: document.getElementById('co-kurir').value,
        pembayaran: document.getElementById('co-bayar').value
    };

    if(!data.alamat) { alert('Isi alamat dulu bos!'); return; }

    fetch(`/api/checkout/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(resData => {
        if (resData.status === 'success') {
            modalCheckout.hide();
            
            // Si Juki Lapor
            const pesan = `Huwala! Pesanan ${document.getElementById('co-nama').value} siap dikirim ke ${data.alamat} pake ${data.pengiriman}. Sikat miring!`;
            
            chatWin.innerHTML += `<div class="msg juki-msg">${pesan}</div>`;
            chatWin.scrollTop = chatWin.scrollHeight;

            const utter = new SpeechSynthesisUtterance(pesan);
            utter.lang = 'id-ID';
            window.speechSynthesis.speak(utter);

            setTimeout(() => { location.reload(); }, 3000);
        }
    })
    .catch(err => console.error("Error:", err));
}

// Fungsi Mengirim Pesan Lewat Ketikan
function kirimChat() {
    const input = document.getElementById('chat-input');
    const pesan = input.value;
    if (pesan.trim() === "") return;

    input.value = "";
    prosesKeAI(pesan);
}

// Support tombol 'Enter' untuk kirim chat
document.getElementById('chat-input').addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        kirimChat();
    }
});

// Fungsi Utama Komunikasi ke Python (Di-share antara Voice & Text)
function prosesKeAI(teks) {
    const win = document.getElementById('chat-win');
    win.innerHTML += `<div class="user-msg small"><b>Kamu:</b> ${teks}</div>`;
    win.scrollTop = win.scrollHeight;

    fetch('http://127.0.0.1:5000/proses', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({text: teks})
    })
    .then(r => r.json())
    .then(d => {
        win.innerHTML += `<div class="juki-msg small text-primary"><b>Juki:</b> ${d.reply}</div>`;
        win.scrollTop = win.scrollHeight;
        
        // Juki bicara otomatis
        const s = new SpeechSynthesisUtterance(d.reply);
        s.lang = 'id-ID';
        window.speechSynthesis.speak(s);
    });
}

// Update fungsi onresult suara kamu agar memanggil prosesKeAI()
recognition.onresult = (e) => {
    const txt = e.results[0][0].transcript;
    prosesKeAI(txt);
};