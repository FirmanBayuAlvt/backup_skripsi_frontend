<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - TernakPark Wonosalam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden -z-10">
            <div class="absolute -top-40 -right-32 w-80 h-80 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-40 -left-32 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-1/2 w-80 h-80 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Main Content -->
        <div class="glass-effect rounded-3xl p-8 md:p-12 shadow-2xl">
            <!-- Error Number -->
            <div class="mb-8">
                <div class="text-9xl font-bold text-gray-800 mb-4">
                    404
                </div>
                <div class="w-24 h-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mx-auto mb-6"></div>
            </div>

            <!-- Icon -->
            <div class="mb-8">
                <div class="w-20 h-20 mx-auto mb-4 relative">
                    <div class="w-full h-full bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Message -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Halaman Tidak Ditemukan
                </h1>
                <p class="text-lg text-gray-600 mb-2">
                    Maaf, kami tidak dapat menemukan halaman yang Anda cari.
                </p>
                <p class="text-gray-500">
                    <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ request()->path() }}</span>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="{{ url('/') }}"
                   class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                    🏠 Kembali ke Beranda
                </a>
                <button onclick="history.back()"
                        class="px-8 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-300 transform hover:-translate-y-1">
                    ↩️ Kembali Sebelumnya
                </button>
            </div>

            <!-- Additional Info -->
            <div class="text-sm text-gray-500">
                <p>Jika Anda merasa ini adalah kesalahan, silakan hubungi tim support kami.</p>
                <div class="mt-4 flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                        <i class="fab fa-whatsapp"></i> Support
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                        <i class="fas fa-phone"></i> Telepon
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} TernakPark Wonosalam. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Animation Styles -->
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</body>
</html>
