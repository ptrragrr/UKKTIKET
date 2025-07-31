<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #9CAF88 0%, #B5C99A 25%, #F7F3E9 50%, #C8AE7D 75%, #8B5A3C 100%);
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            min-height: 100vh;
            margin: 0;
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

        .register-container {
            background: rgba(247, 243, 233, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 0;
            box-shadow: 
                0 20px 40px rgba(139, 90, 60, 0.2),
                0 8px 16px rgba(156, 175, 136, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .register-header {
            background: linear-gradient(135deg, #9CAF88, #B5C99A);
            padding: 40px 40px 30px;
            text-align: center;
            position: relative;
        }

        .register-header::after {
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

        h2 {
            margin: 0;
            color: #ffffff;
            font-size: 28px;
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

        .register-body {
            padding: 40px 40px 30px;
        }

        .form-group {
            margin-bottom: 24px;
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

        input[type="text"],
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
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #9CAF88;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 4px rgba(156, 175, 136, 0.1);
            transform: translateY(-2px);
        }

        .submit-button {
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

        .submit-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .submit-button:hover::before {
            left: 100%;
        }

        .submit-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(139, 90, 60, 0.4);
        }

        .submit-button:active {
            transform: translateY(-1px);
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

        .login-link {
            margin-top: 24px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(156, 175, 136, 0.3);
        }

        .login-link {
            color: #8B5A3C;
            font-size: 14px;
        }

        .login-link a {
            color: #9CAF88;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #8B5A3C;
            text-decoration: underline;
        }

        .decorative-elements {
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.1;
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

        @media (max-width: 480px) {
            .register-container {
                margin: 10px;
                max-width: none;
            }

            .register-header,
            .register-body {
                padding: 30px 25px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 14px 16px;
                font-size: 16px;
            }

            .submit-button {
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
    
    <div class="register-container">
        <div class="register-header">
            <h2>Daftar Akun</h2>
            <div class="subtitle">Bergabunglah dengan komunitas kami</div>
        </div>
        
        <div class="register-body">
            @if($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nama</label>
                    <div class="input-container">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-container">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-container">
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-container">
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="submit-button">Daftar Sekarang</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>
    </div>
</body>
</html>