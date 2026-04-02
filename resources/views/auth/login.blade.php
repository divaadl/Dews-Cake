<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Dew’s Cake</title>
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

        .login-box {
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

        .logo-badge {
            position: absolute;
            top: -32px;
            right: -32px;
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg,#f7a6b8,#f28aa5);
            border-radius: 50%;
            padding: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,.25);
            animation: floatLogo 3s ease-in-out infinite;
        }

        .logo-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: white;
            border-radius: 50%;
            padding: 8px;
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
            margin-bottom: 18px;
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

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 48px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #d45c7a;
            user-select: none;
        }

        .btn-login {
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

        .btn-login:hover {
            box-shadow: 0 14px 34px rgba(247,166,184,.55);
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 8px 18px rgba(247,166,184,.4);
        }

        .register-link {
            margin-top: 22px;
            font-size: 13px;
            color: #6b7280;
        }

        .register-link a {
            color: #d45c7a;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-box {
            background:#fde8ec;
            color:#b42346;
            padding:12px 14px;
            border-radius:14px;
            font-size:13px;
            margin-bottom:18px;
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 36px 28px;
                border-radius: 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-box">

    <div class="brand">Dew’s Cake</div>
    <div class="subtitle">Login untuk melanjutkan pemesanan 🎂</div>

    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="email@email.com" required autofocus>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="••••••••" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
        </div>

        <button type="submit" class="btn-login">
            Login
        </button>
    </form>

    <div class="register-link">
        Belum punya akun?
        <a href="/register">Daftar di sini</a>
    </div>

    <div class="logo-badge">
        <img src="/images/logo.jpeg">
    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.querySelector('.toggle-password');

        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = '🙈';
        } else {
            input.type = 'password';
            icon.textContent = '👁️';
        }
    }
</script>

</body>
</html>