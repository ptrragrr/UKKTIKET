<!-- <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #9CAF88 0%, #B5C99A 25%, #F7F3E9 50%, #C8AE7D 75%, #8B5A3C 100%);
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .decorative-elements {
            position: absolute;
            top: 10%;
            right: 10%;
            opacity: 0.1;
            z-index: 0;
        }

        .circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            position: absolute;
        }

        .circle-1 {
            background: #9CAF88;
            top: 0;
            right: 0;
        }

        .circle-2 {
            background: #C8AE7D;
            width: 80px;
            height: 80px;
            top: 40px;
            right: 40px;
        }

        .circle-3 {
            background: #8B5A3C;
            width: 40px;
            height: 40px;
            top: 60px;
            right: 60px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 20px;
            background: rgba(247, 243, 233, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(139, 90, 60, 0.2),
                0 8px 16px rgba(156, 175, 136, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }

        .login-header {
            background: linear-gradient(135deg, #9CAF88, #B5C99A);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: #8B5A3C;
            border-radius: 2px;
        }

        .login-container h2 {
            margin: 0;
            color: #ffffff;
            font-size: 2rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(139, 90, 60, 0.3);
            letter-spacing: 0.5px;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 8px;
            font-weight: 400;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #8B5A3C;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-container {
            position: relative;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid rgba(156, 175, 136, 0.3);
            border-radius: 12px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            color: #8B5A3C;
            transition: all 0.3s ease;
            outline: none;
            box-sizing: border-box;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #9CAF88;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 4px rgba(156, 175, 136, 0.1);
            transform: translateY(-2px);
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 8px;
            color: #dc3545;
            padding: 12px 16px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
        }

        button[type="submit"] {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #8B5A3C, #C8AE7D);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 16px rgba(139, 90, 60, 0.3);
            position: relative;
            overflow: hidden;
        }

        button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        button[type="submit"]:hover::before {
            left: 100%;
        }

        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(139, 90, 60, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(-1px);
        }

        .text-center {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(156, 175, 136, 0.3);
            font-size: 14px;
            color: #8B5A3C;
        }

        .text-center a {
            color: #9CAF88;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .text-center a:hover {
            color: #8B5A3C;
            text-decoration: underline;
        }

        /* Welcome message styling */
        .welcome-text {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #8B5A3C;
            font-size: 15px;
            line-height: 1.4;
            opacity: 0.8;
        }

        /* Additional decorative elements inside container */
        .login-container::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            background: rgba(156, 175, 136, 0.05);
            border-radius: 50%;
            z-index: 0;
        }

        .login-container::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: -20px;
            width: 60px;
            height: 60px;
            background: rgba(200, 174, 125, 0.05);
            border-radius: 50%;
            z-index: 0;
        }

        .login-header,
        .login-body {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 20px 15px;
                max-width: none;
            }

            .login-header,
            .login-body {
                padding: 2rem 1.5rem;
            }

            .login-container h2 {
                font-size: 1.5rem;
            }

            input[type="email"],
            input[type="password"] {
                padding: 14px 16px;
                font-size: 16px;
            }

            button[type="submit"] {
                padding: 16px;
                font-size: 15px;
            }

            .decorative-elements {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="decorative-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>

    <div class="login-container">
        <div class="login-header">
            <h2>Login</h2>
            <div class="subtitle">Selamat datang kembali</div>
        </div>
        
        <div class="login-body">
            <div class="welcome-text">
                Masuk ke akun Anda untuk melanjutkan pengalaman yang menakjubkan
            </div>

            @if($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-container">
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-container">
                        <input type="password" name="password" required>
                    </div>
                </div>

                <button type="submit">Login Sekarang</button>
            </form>

            <div class="text-center">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </div>
        </div>
    </div>

</body>
</html> -->