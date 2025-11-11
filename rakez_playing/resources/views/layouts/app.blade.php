<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RAKEZ العقارية')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        .cube-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Header -->
    <div class="fixed top-0 left-0 right-0 z-50">
        <div class="glass-effect m-4 rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-building text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">RAKEZ العقارية</h1>
                        <p class="text-sm text-gray-600">شركـتك الأمـثل فـي العـقارات</p>
                    </div>
                </div>
                
                @auth
                <div class="flex items-center space-x-4 space-x-reverse">
                    <span class="text-gray-700">مرحباً, {{ Auth::user()->name }}</span>
                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="w-full max-w-4xl mt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <div class="fixed bottom-0 left-0 right-0 z-50">
        <div class="glass-effect m-4 rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between p-4 text-sm text-gray-600">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fas fa-phone"></i>
                    <span>+966 123 456 789</span>
                </div>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fas fa-envelope"></i>
                    <span>info@rakez-realestate.com</span>
                </div>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>الرياض، المملكة العربية السعودية</span>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>