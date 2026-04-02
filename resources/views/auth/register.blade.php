<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register | Dew’s Cake</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    background:
        radial-gradient(circle at top left, #fde2e8, transparent 40%),
        radial-gradient(circle at bottom right, #fff1f4, transparent 45%),
        linear-gradient(135deg,#fdecef,#ffffff);
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-box {
    width: 100%;
    max-width: 420px;
    background: rgba(255,255,255,.85);
    backdrop-filter: blur(14px);
    padding: 44px 36px;
    border-radius: 28px;
    box-shadow: 0 30px 80px rgba(0,0,0,.15);
    border: 1.5px solid rgba(244,180,195,.6);
    text-align: center;
    animation: fadeUp .7s ease;
    position: relative;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to { opacity: 1; transform: translateY(0); }
}

.brand {
    font-family: 'Pacifico', cursive;
    font-size: 34px;
    color: #d45c7a;
    margin-bottom: 4px;
}

.subtitle {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 28px;
}

.form-group {
    text-align: left;
    margin-bottom: 16px;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #8b3f52;
    margin-bottom: 6px;
    display: block;
}

.form-group input {
    width: 100%;
    height: 48px;
    padding: 0 16px;
    border-radius: 18px;
    border: 2px solid #f3c2cd;
    font-size: 14px;
    outline: none;
    transition: .25s;
    background: #fff;
}

.form-group input::placeholder {
    color: #c7a0aa;
}

.form-group input:focus {
    border-color: #f28aa5;
    box-shadow: 0 0 0 4px rgba(247,166,184,.25);
}

.btn-register {
    width: 100%;
    height: 50px;
    border-radius: 18px;
    border: none;
    background: linear-gradient(135deg,#f7a6b8,#f28aa5);
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
    transition: .25s;
}

.btn-register:hover {
    box-shadow: 0 14px 34px rgba(247,166,184,.55);
    transform: translateY(-2px);
}

.login-link {
    margin-top: 22px;
    font-size: 13px;
    color: #6b7280;
}

.login-link a {
    color: #d45c7a;
    font-weight: 600;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .register-box {
        padding: 36px 28px;
        border-radius: 24px;
    }
}
</style>
</head>
<body>

<div class="register-box">

    <div class="brand">Dew’s Cake</div>
    <div class="subtitle">Daftar akun untuk mulai memesan 🍰</div>

    <form method="POST" action="/register">
        @csrf

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" placeholder="Nama Lengkap" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="email@email.com" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="form-group">
            <label>Ulangi Password</label>
            <input type="password" name="password_confirmation" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-register">
            Register
        </button>
    </form>

    <div class="login-link">
        Sudah punya akun?
        <a href="/login">Login di sini</a>
    </div>

</div>

</body>
</html>