<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6c63ff;
            --secondary: #4a42e8;
            --dark: #2f2e41;
            --light: #f8f9fa;
            --gray: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
            animation: fadeIn 0.8s ease-out;
        }

        .error-illustration {
            max-width: 400px;
            margin: 0 auto 2rem;
            filter: drop-shadow(0 10px 15px rgba(108, 99, 255, 0.2));
        }

        .error-code {
            font-size: 5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .error-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .error-message {
            font-size: 1.1rem;
            color: var(--gray);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.8rem 1.8rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            border: 2px solid transparent;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.3);
        }

        .btn-outline {
            border-color: var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .maintenance-icon {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 3.5rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-illustration {
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
<div class="error-container">
    <!-- SVG illustration of maintenance (can be replaced with your own) -->


    <div class="maintenance-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
        </svg>
    </div>

    <h1 class="error-code">503</h1>
    <h2 class="error-title">Сайт временно недоступен</h2>
    <p class="error-message">
        В настоящее время проводятся технические работы, либо сервер временно перегружен.
        Пожалуйста, зайдите позже. Приносим извинения за возможные неудобства.
    </p>

    <div class="action-buttons">
        {{--        <a href="{{ url('/') }}" class="btn btn-primary">На главную</a>--}}
        {{--        <a href="mailto:support@example.com" class="btn btn-outline">Связаться со службой поддержки</a>--}}
    </div>
</div>
</body>
</html>
