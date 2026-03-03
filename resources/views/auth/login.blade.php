<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Amin Jaya Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; display: flex; align-items: center; height: 100vh; }
        .login-card { width: 100%; max-width: 400px; padding: 2rem; border-radius: 15px; border: none; }
    </style>
</head>
<body>
    <div class="card login-card shadow mx-auto">
        <h3 class="text-center fw-bold mb-4">Amin Jaya Login</h3>
        
        @if($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold">Sign In</button>
        </form>
        <p class="text-center mt-3 small text-muted">Akses khusus Admin & Pembeli</p>
    </div>
</body>
</html>