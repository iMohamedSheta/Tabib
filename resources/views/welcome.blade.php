
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" /> --}}

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/fonts-family.css') }}" /> --}}

    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=El+Messiri:wght@400..700&display=swap" rel="stylesheet">

    <style>
        body {
                font-family: "El Messiri", sans-serif;
                font-optical-sizing: auto;
                font-style: normal;
            }
    </style>
    @stack('styles')
    <!-- Styles -->
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقنية الدمج بالذكاء الاصطناعي</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/material.min.css">
    @livewireStyles
    @livewireScripts

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #2A3B55;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }

        header {
            background: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            width: 100px; /* عرض ثابت للأزرار */
            margin: 10px auto; /* محاذاة الوسط */
        }

        .btn:hover {
            background: #218838;
        }

        .back-btn {
            background: #dc3545;
        }

        .back-btn:hover {
            background: #c82333;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .step-title {
            margin: 20px 0;
            font-size: 20px;
            color: #007bff;
        }

        label {
            margin-top: 10px;
            display: block;
        }

        input[type="text"], input[type="number"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .CodeMirror {
            height: auto;
            border: 1px solid #ccc;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<header>
    <h1>تقنية الدمج بالذكاء الاصطناعي</h1>
</header>

<div class="container">

    <livewire.load-balancer />


<footer>
    <p>&copy; 2024 جميع الحقوق محفوظة.</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
<script>
    document.getElementById('copy-button').onclick = function() {
        navigator.clipboard.writeText(document.getElementById('generated-code').innerText)
            .then(() => {
                alert('تم نسخ الكود بنجاح!');
            })
            .catch(err => {
                console.error('فشل نسخ الكود:', err);
            });
    };
</script>
</body>
</html>
