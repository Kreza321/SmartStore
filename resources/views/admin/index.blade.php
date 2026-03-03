<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Amin Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">ADMIN PANEL</a>
        <a href="/" class="btn btn-outline-info btn-sm">Lihat Toko (User Mode)</a>
    </div>
</nav>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8"><h2 class="fw-bold">Manajemen Inventaris & Pesanan</h2></div>
        <div class="col-md-4 text-end"><a href="/download-stok" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a></div>
    </div>

    <div class="card p-4 shadow-sm mb-5">
        <h5 class="fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>Riwayat Pesanan Masuk</h5>
        <table class="table align-middle">
            <thead class="table-dark">
                <tr><th>Produk</th><th>Alamat</th><th>Status</th><th>Tanggal Kirim</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($orders as $o)
                <tr>
                    <td>{{ $o->produk->nama_baju }}</td>
                    <td>{{ $o->alamat }}</td>
                    <td><span class="badge bg-warning text-dark">{{ $o->status }}</span></td>
                    <td>{{ $o->tanggal_pengiriman ?? 'Belum Diatur' }}</td>
                    <td>
                        <form action="/admin/order/{{ $o->id }}" method="POST" class="d-flex gap-2">
                            @csrf @method('PUT')
                            <input type="date" name="tanggal_pengiriman" class="form-control form-control-sm">
                            <select name="status" class="form-select form-select-sm">
                                <option value="Dikirim">Dikirim</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card p-4 mb-4 shadow-sm">
        <h5 class="fw-bold mb-3">Tambah Stok Baru</h5>
        <form action="/admin/produk" method="POST" class="row g-3">
            @csrf
            <div class="col-md-3"><input type="text" name="nama_baju" class="form-control" placeholder="Nama Baju" required></div>
            <div class="col-md-2"><input type="text" name="brand" class="form-control" placeholder="Brand" required></div>
            <div class="col-md-2"><input type="text" name="kategori" class="form-control" placeholder="Kategori" required></div>
            <div class="col-md-1"><input type="text" name="ukuran" class="form-control" placeholder="Size" required></div>
            <div class="col-md-2"><input type="number" name="stok" class="form-control" placeholder="Stok" required></div>
            <div class="col-md-2"><input type="number" name="harga" class="form-control" placeholder="Harga" required></div>
            <div class="col-md-10"><input type="text" name="image" class="form-control" placeholder="URL Foto"></div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Simpan</button></div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm h-100">
                <table class="table">
                    <thead><tr><th>Nama</th><th>Stok</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($produks as $p)
                        <tr><td>{{ $p->nama_baju }}</td><td>{{ $p->stok }}</td><td>
                            <form action="/admin/produk/{{ $p->id }}" method="POST">@csrf @method('DELETE')<button class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i></button></form>
                        </td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 shadow-sm h-100">
                <canvas id="stokChart"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="card p-4 shadow-sm border-0 mt-5">
    <h5 class="fw-bold mb-3"><i class="bi bi-people me-2"></i>Daftar Pelanggan Terdaftar</h5>
    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama</th><th>Email</th><th>Role</th><th>Bergabung Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-success' }}">{{ $user->role }}</span></td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stokChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($brands) !!},
            datasets: [{
                label: 'Jumlah Stok',
                data: {!! json_encode($stokCounts) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2, borderRadius: 8
            }]
        }
    });
</script>
</body>
</html>