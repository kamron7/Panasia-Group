<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - OSG CMS</title>
    <meta name="author" content="OSG"/>
    <style id="critical-css">
        .logo-dark {
            display: none;
        }

        [data-theme="dark"] .logo-light {
            display: none;
        }

        [data-theme="dark"] .logo-dark {
            display: block;
        }

        [data-theme="light"] .logo-light {
            display: block;
        }

        [data-theme="light"] .logo-dark {
            display: none;
        }
    </style>
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Assets -->
    <link rel="stylesheet" type="text/css" href="<?= assets_a() ?>app-assets/css/bootstrap.min.css">
    <link rel="shortcut icon" href="<?= assets_a() ?>img/favicon.ico"/>
    <link rel="stylesheet" href="<?= assets_a() ?>newlogin/css/reset.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_a() ?>app-assets/vendors/css/vendors.min.css">

    <script type="text/javascript" src="<?= assets_a() ?>js/jquery.min.js"></script>
    <script src="<?= assets_a() ?>newlogin/js/index.js"></script>

    <style>
        :root {
            --quantum-primary: #ed2553;
            --quantum-primary-dark: #ed2553;
            --quantum-error: #e11d48;
            --quantum-success: #10b981;
            --quantum-warning: #f59e0b;
            --quantum-gray-100: #f3f4f6;
            --quantum-gray-200: #e5e7eb;
            --quantum-gray-300: #d1d5db;
            --quantum-gray-700: #374151;
            --quantum-gray-900: #111827;
            --quantum-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --quantum-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --quantum-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --quantum-glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --quantum-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.15) 0%, rgba(226, 232, 240, 0.1) 100%),
            var(--body-bg-image) center/cover no-repeat fixed !important;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--quantum-gray-900);
            line-height: 1.5;
        }

        :root[data-theme="light"] {
            .quantum-theme-switcher button {
                color: rgb(138, 196, 255);
                border: 1px solid rgb(138, 196, 255);
            }
            .quantum-theme-switcher button:hover {
                background: rgba(138, 196, 255, 0.43);
                color: white;
            }
            --body-bg-image: url(<?= assets_a() ?>newlogin/er.jpg);
        }

        :root[data-theme="dark"] {
            .quantum-form-label{
                color: white;
            }
            .quantum-form-input{
                color: white;
            }
            .quantum-theme-switcher button:hover {
                background: rgba(255, 255, 255, 0.3);
            }
            .quantum-submit-btn:hover{
                color: rgba(255, 255, 255, 0.66);
            }
            .quantum-auth-title span{
                color: #eef2ffa3;
            }
            .quantum-password-toggle{
                color: rgba(255, 255, 255, 0.6);
            }
            --body-bg-image: url(<?= assets_a() ?>newlogin/erd2.png);
        }

        .quantum-login-container {
            width: 100%;
            max-width: 480px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .quantum-glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-radius: 12px;
            box-shadow: var(--quantum-shadow-lg);
            overflow: hidden;
            transition: var(--quantum-transition);
            padding: 2.5rem;
            border: 1px solid rgb(138 196 255 / 58%);
        }

        .quantum-brand-logo {
            display: block;
            margin: 0 auto 2rem;
            width: 220px;
            height: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .quantum-auth-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #0043ffa3;
            font-weight: 700;
            font-size: 1.12rem;
            position: relative;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }


        .quantum-form-group {
            position: relative;
            margin-bottom: 1.75rem;
        }

        .quantum-form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 1rem;
            font-size: 1rem;
            border: 1px solid rgb(55 52 173 / 21%);
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.2);
            transition: var(--quantum-transition);
            box-shadow: var(--quantum-shadow-sm);
            color: var(--quantum-primary);
        }

        .quantum-form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .quantum-form-input:focus {
            outline: none;
            border-color: white;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.3);
        }

        .quantum-form-label {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: #757575;
            transition: var(--quantum-transition);
            pointer-events: none;
            background-color: transparent;
            padding: 0 0.25rem;
            border-radius: 4px;
        }

        .quantum-form-input:focus + .quantum-form-label,
        .quantum-form-input:not(:placeholder-shown) + .quantum-form-label {
            top: -0.5rem;
            left: 0.75rem;
            font-size: 0.75rem;
            color: black;
            background-color: #ffffff;
            padding: 0 0.5rem;
        }

        .quantum-captcha-container {
            display: flex;
            gap: 0.5rem;
            margin: 2rem 0 0 0;
            align-items: center;
            background: rgb(255 255 255 / 45%);
            padding: 0.75rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .quantum-captcha-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid rgb(101 170 255 / 30%);
            border-radius: 8px;
            font-size: 1rem;
            height: 50px;
            width: 1px;
            background-color: rgb(193 193 193 / 20%);;
            color: var(--quantum-primary);
        }

        .quantum-captcha-input::placeholder {
            color: #757575;
        }

        .quantum-captcha-image {
            width: 120px;
            height: 50px;
            border-radius: 6px;
            border: 1px solid rgb(101 170 255 / 30%);
            object-fit: cover;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .quantum-captcha-refresh {
            background-color: var(--quantum-primary);
            color: white;
            border: none;
            border-radius: 6px;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--quantum-transition);
            flex-shrink: 0;
            backdrop-filter: blur(5px);
        }

        .quantum-captcha-refresh:hover {
            background-color: transparent;
            color: var(--quantum-primary);
            border: 1px solid var(--quantum-primary);
        }

        .quantum-submit-btn {
            background-color: var(--quantum-primary);
            color: white;
            padding: 10px 49px;
            border: 1px solid transparent;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--quantum-transition);
            margin: 1.5rem auto 0;
            display: block;
            width: fit-content;
            box-sizing: border-box;
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .quantum-submit-btn:hover {
            background-color: transparent;
            color: var(--quantum-primary);
            border: 1px solid var(--quantum-primary);
        }

        .quantum-alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 500;
            background-color: rgba(225, 29, 72, 0.2);
            color: white;
            border: 1px solid rgba(225, 29, 72, 0.3);
            backdrop-filter: blur(5px);
        }

        .quantum-footer {
            text-align: center;
            margin-top: 2rem;
            color: rgb(255, 255, 255);
            font-size: 0.875rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .quantum-footer a {
            color: var(--quantum-primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--quantum-transition);
        }

        .quantum-footer a:hover {
            text-decoration: underline;
        }

        .quantum-password-toggle {
            position: absolute;
            right: 1rem;
            top: 1rem;
            background: transparent;
            border: none;
            color: #757575;
            cursor: pointer;
            transition: var(--quantum-transition);
        }

        .quantum-form-input[type="password"],
        .quantum-form-input[type="text"] {
            padding-right: 3rem;
        }

        .quantum-theme-switcher {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            display: flex;
            gap: 0.5rem;
            z-index: 1000;
        }

        .quantum-theme-switcher button {
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: var(--quantum-transition);
            backdrop-filter: blur(5px);
        }

        .quantum-theme-switcher button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .quantum-login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #0043ffa3;
            font-size: 0.875rem;
        }

        .quantum-login-link a {
            color: var(--quantum-primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--quantum-transition);
        }

        .quantum-login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<div class="quantum-theme-switcher">
    <button data-theme="light"><i class="fas fa-sun"></i></button>
    <button data-theme="dark"><i class="fas fa-moon"></i></button>
</div>
<div class="quantum-login-container">
    <a href="https://osg.uz/" class="quantum-brand-logo" title="Online Service Group">
        <img src="<?= assets_a() ?>newlogin/logo.png" alt="OSG Logo" class="quantum-brand-logo logo-light" />
        <img src="<?= assets_a() ?>newlogin/g.svg" alt="OSG Logo" class="quantum-brand-logo logo-dark" />
    </a>

    <div class="quantum-glass-effect">
        <h1 class="quantum-auth-title">
            <span>РЕГИСТРАЦИЯ</span>
        </h1>

        @if ($errors->any())
            <div class="quantum-alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="quantum-form-group">
                <input type="text" id="username" name="username" class="quantum-form-input"
                       value="{{ old('username') }}" placeholder=" " required autofocus>
                <label for="username" class="quantum-form-label">Имя пользователя</label>
            </div>

            <div class="quantum-form-group">
                <input type="email" id="email" name="email" class="quantum-form-input"
                       value="{{ old('email') }}" placeholder=" " required>
                <label for="email" class="quantum-form-label">Email</label>
            </div>

            <div class="quantum-form-group">
                <input type="password" id="password" name="password" class="quantum-form-input"
                       placeholder=" " required autocomplete="new-password">
                <label for="password" class="quantum-form-label">Пароль</label>
                <button type="button" class="quantum-password-toggle">
                    <i class="far fa-eye"></i>
                </button>
            </div>

            <div class="quantum-form-group">
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="quantum-form-input" placeholder=" " required autocomplete="new-password">
                <label for="password_confirmation" class="quantum-form-label">Подтвердите пароль</label>
                <button type="button" class="quantum-password-toggle">
                    <i class="far fa-eye"></i>
                </button>
            </div>

            <div class="quantum-captcha-container">
                <input type="text" class="quantum-captcha-input" id="captcha" name="captcha"
                       placeholder="Код" minlength="4" maxlength="255" required>

                <img src="{!! route('captcha') !!}" id="cap" class="quantum-captcha-image" width="120" height="50"/>

                <button type="button" id="refresh_captcha_contacts" class="quantum-captcha-refresh"
                        onclick="recaptcha()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>

            <button type="submit" class="quantum-submit-btn">
                <span>Зарегистрироваться</span>
            </button>

            <div class="quantum-login-link">
                Уже зарегистрированы? <a href="{{ route('login') }}">Войти</a>
            </div>
        </form>
    </div>

    <div class="quantum-footer">
        <a href="https://osg.uz/" title="Online Service Group">
            <p>OOO "Online Service Group"</p>
        </a>
        <p>&copy; <?= date('Y') ?>. Все права защищены.</p>
    </div>
</div>

<script>
    // Enhanced recaptcha function with loading state
    let numlog = 0;

    function recaptcha() {
        if (numlog <= 5) {
            const refreshBtn = document.getElementById('refresh_captcha_contacts');
            refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            $.ajax({
                type: 'get',
                url: '<?= route('recap') ?>',
                data: {csrf_token: $('#csrf').val()},
                success: function (result) {
                    numlog++;
                    $('#cap').attr('src', "data:image/png;base64," + result + '');
                    refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
                },
                error: function () {
                    refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
                }
            });
        } else {
            $('#refresh_captcha_contacts').prop('disabled', true)
                .html('<i class="fas fa-times"></i>')
                .css('opacity', '0.6');
        }
    }

    // Auto-focus first input field
    $(document).ready(function () {
        $('.quantum-form-input').first().focus();

        // Position the login card vertically centered
        function centerLoginCard() {
            const windowHeight = $(window).height();
            const cardHeight = $('.quantum-glass-effect').outerHeight();
            const logoHeight = $('.quantum-brand-logo').outerHeight();
            const footerHeight = $('.quantum-footer').outerHeight();

            const totalHeight = logoHeight + cardHeight + footerHeight + 80; // 80px for margins

            if (windowHeight > totalHeight) {
                const topMargin = (windowHeight - totalHeight) / 2;
                $('.quantum-login-container').css('margin-top', topMargin + 'px');
            } else {
                $('.quantum-login-container').css('margin-top', '2rem');
            }
        }

        centerLoginCard();
        $(window).resize(centerLoginCard);
    });
</script>

<script>
    document.querySelectorAll('.quantum-password-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>

<script>
    document.querySelectorAll('.quantum-theme-switcher button').forEach(button => {
        button.addEventListener('click', () => {
            const theme = button.getAttribute('data-theme');
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);

            document.body.style.backgroundImage = 'none';
            setTimeout(() => {
                document.body.style.backgroundImage = '';
            }, 10);
        });
    });

    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
</script>
</body>
</html>
