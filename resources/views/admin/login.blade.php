<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin | Dew’s Cake</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg,#fdecef,#fff);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-admin-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 48px 38px 42px;
            border-radius: 28px;
            box-shadow: 0 30px 70px rgba(0,0,0,.15);
            border: 2px solid #fde2e8;
            text-align: center;
            position: relative;
        }

        /* LOGO */
        .logo-wrapper {
            width: 72px;
            height: 72px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 15px 35px rgba(0,0,0,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -36px;
            left: 50%;
            transform: translateX(-50%);
            animation: float 4s ease-in-out infinite;
        }

        .logo-wrapper img {
            width: 46px;
            height: 46px;
            object-fit: contain;
        }

        @keyframes float {
            0%,100% { transform: translate(-50%,0); }
            50% { transform: translate(-50%,-6px); }
        }

        .brand {
            margin-top: 48px;
            font-family: 'Pacifico', cursive;
            font-size: 34px;
            color: #d45c7a;
            margin-bottom: 2px;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg,#f7a6b8,#f28aa5);
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 26px;
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
            padding-right: 46px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #d45c7a;
            user-select: none;
        }

        .toggle-password:hover {
            opacity: 0.8;
        }


        .error {
            background: #fde8ec;
            color: #b42346;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 13px;
            margin-bottom: 18px;
            text-align: left;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            border-radius: 18px;
            border: none;
            background: linear-gradient(135deg,#f7a6b8,#f28aa5);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            transition: .25s;
        }

        .btn-login:hover {
            box-shadow: 0 14px 30px rgba(247,166,184,.45);
            transform: translateY(-2px);
        }

        .note {
            margin-top: 22px;
            font-size: 13px;
            color: #9ca3af;
        }

        @media (max-width: 480px) {
            .login-admin-box {
                padding: 44px 26px 36px;
            }
        }
    </style>
</head>
<body>

<div class="login-admin-box">

    <!-- LOGO -->
    <div class="logo-wrapper">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Dew’s Cake Logo">
    </div>

    <div class="brand">Dew’s Cake</div>
    <div class="subtitle">Administrator Panel</div>
    <div class="badge">ADMIN ONLY</div>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="form-group">
            <label>Email Admin</label>
            <input type="email" name="email" placeholder="admin@dewscake.com" required autofocus>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="••••••••" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
        </div>

        <button type="submit" class="btn-login">
            Login Admin
        </button>
    </form>

    <div class="note">
        Halaman khusus administrator Dew’s Cake
    </div>

</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = '🙈';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = '👁️';
        }
    }
</script>

</body>
</html>