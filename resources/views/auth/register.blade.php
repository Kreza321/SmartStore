<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Amin Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; display: flex; align-items: center; height: 100vh; }
        .register-card { width: 100%; max-width: 450px; padding: 2rem; border-radius: 15px; border: none; }
    </style>
</head>
<body>
    <div class="card register-card shadow mx-auto">
        <h3 class="text-center fw-bold mb-4">Daftar Akun Baru</h3>
        <form action="/register" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Daftar Sekarang</button>
            <p class="text-center mt-3 small">Sudah punya akun? <a href="/login">Login di sini</a></p>
        </form>
    </div>
</body>
</html>