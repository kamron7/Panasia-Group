<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= a_lang('title_admin', 'ru') ?></title>
    <meta name="author" content="OSG"/>
    <style id="critical-css">
        .logo-dark {
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
            --quantum-primary: #de2626;
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
            background: url(<?= assets_a() ?>newlogin/bg.jpg) center no-repeat !important;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--quantum-gray-900);
            line-height: 1.5;
        }
        :focus:not(:focus-visible) {
            outline: none;
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
            border: 1px solid rgba(153, 153, 153, 0.32);
        }

        .quantum-brand-logo {
            display: block;
            margin: 0 auto 2rem;
            width: 350px;
            height: auto;
        }

        .quantum-auth-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #de2626;
            font-weight: 700;
            font-size: 1.75rem;
            position: relative;

        }

        .quantum-auth-title span {
            display: block;
            font-size: 1rem;
            font-weight: 500;
            color:black;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
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
            border-color: var(--quantum-primary);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.3);
        }

        .quantum-form-label {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: #4b4b4b;
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
            background-color: rgb(255 255 255 / 63%);
            color: black;
        }

        .quantum-captcha-input:focus{
            border: 1px solid var(--quantum-primary);
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
            background-color: rgb(255 255 255 / 63%);
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
        @media (max-width: 364px) {
            .quantum-captcha-refresh{
                width: 100% !important;
            }
        }

        @media (max-width: 576px) {
            .quantum-captcha-container {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .quantum-captcha-input {
                width: 100%;
                order: 1;
            }

            .quantum-captcha-image {
                order: 2;
            }

            .quantum-captcha-refresh {
                order: 3;
            }
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
            border: 1px solid var(--quantum-primary);
            color: #f80000;
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
            color: black;
            font-size: 0.875rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .quantum-footer a {
            color: #de2626;
            text-decoration: none;
            font-weight: 500;
            transition: var(--quantum-transition);
        }

        .quantum-footer a:hover {
            text-decoration: underline;
        }

        .quantum-countdown {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin: 2rem 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .quantum-countdown .dots {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .quantum-auth-card {
                padding: 1.5rem;
            }

            .quantum-captcha-container {
                align-items: stretch;
            }
        }

        .quantum-password-toggle {
            position: absolute;
            right: 1rem;
            top: 1rem;
            background: transparent;
            border: none;
            color: #4b4b4b;
            cursor: pointer;
            transition: var(--quantum-transition);
        }

        .quantum-form-input[type="password"],
        .quantum-form-input[type="text"] {
            padding-right: 3rem;
        }
    </style>
</head>
<body>
<div class="quantum-login-container">
    <a href="https://osg.uz/" class="quantum-brand-logo" title="Online Service Group">
        <img src="<?= assets_a() ?>newlogin/logo.png" alt="OSG Logo" class="quantum-brand-logo logo-light" />
    </a>

    <div class="quantum-glass-effect">
        @if (!session('ban_ip'))
            <h1 class="quantum-auth-title">
                <span>ВХОД В ПАНЕЛЬ УПРАВЛЕНИЯ</span>
                OSG CMS
            </h1>

            @if (session('errors'))
                <div class="quantum-alert">
                    {{ $errors->get('username')[0] ?? '' }}
                    {{ $errors->get('captcha')[0] ?? '' }}
                </div>
            @endif

            @if (session('error'))
                <div class="quantum-alert">
                    {!! session('error') !!}
                </div>
            @endif

            <form action="<?= route('login') ?>" method="post">
                @csrf

                <input type="hidden" name="redirect_to" value="{{ request('redirect_to', '/admin') }}">
                <div class="quantum-form-group">
                    <input type="text" id="username" name="username" class="quantum-form-input"
                           inputmode="username" autocomplete="username" value="<?= old('username') ?>"
                           placeholder=" " required>
                    <label for="username" class="quantum-form-label">Логин</label>
                </div>

                <div class="quantum-form-group">
                    <input type="password" id="password" name="password" class="quantum-form-input"
                           inputmode="text" autocomplete="new-password" placeholder=" " required>
                    <label for="password" class="quantum-form-label">Пароль</label>
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
                    <span>Войти в систему</span>
                </button>
            </form>
        @else
            <h1 class="quantum-auth-title">
                Доступ временно ограничен
            </h1>

            <div class="quantum-alert">
                Превышено количество попыток входа. Пожалуйста, попробуйте позже.
            </div>

            <div class="quantum-countdown">
                <div class="num" id="min_tens">0</div>
                <div class="num" id="min">0</div>
                <div class="dots">:</div>
                <div class="num" id="sec_tens">0</div>
                <div class="num" id="sec">0</div>
            </div>

            <script>
                $(document).ready(function () {
                    app.submit('<?= session('ban_ip') ?>');
                });
            </script>
        @endif
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
    class App {
        timer = {
            min_tens: document.getElementById('min_tens'),
            min: document.getElementById('min'),
            sec_tens: document.getElementById('sec_tens'),
            sec: document.getElementById('sec'),
        };
        #interval;

        submit(time) {
            this.#clearTimer();
            this.#startTimer(time);
        }

        #clearTimer() {
            if (this.#interval) {
                clearInterval(this.#interval);
            }
            this.#setTimer({
                min_tens: 0,
                min: 0,
                sec_tens: 0,
                sec: 0
            })
        }

        #startTimer(time) {
            const end = Date.now() + time * 1000 * 60;
            this.#interval = setInterval(() => {
                const now = Date.now();
                const delta = end - now;
                if (delta < 0) {
                    clearInterval(this.#interval);
                    location.reload()
                    return;
                }
                this.#setTimer({
                    min_tens: Math.floor(delta / 1000 / 60 / 10),
                    min: Math.floor((delta / 1000 / 60) % 10),
                    sec_tens: Math.floor((delta % 60000) / 10000),
                    sec: Math.floor(((delta % 60000) / 1000) % 10)
                })
            }, 500);
        }

        #setTimer({min_tens, min, sec_tens, sec}) {
            this.timer.min_tens.innerText = min_tens;
            this.timer.min.innerText = min;
            this.timer.sec_tens.innerText = sec_tens;
            this.timer.sec.innerText = sec;
        }
    }

    const app = new App();
</script>
<script>
    document.querySelector('.quantum-password-toggle').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
</body>
</html>