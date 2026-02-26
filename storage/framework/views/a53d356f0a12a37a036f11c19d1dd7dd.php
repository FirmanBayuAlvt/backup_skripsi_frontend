<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-25">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - TernakPark Wonosalam</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('images/Logo Ternakpark Wonosalam.png')); ?>">

    <!-- Enhanced Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Advanced Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.5/dist/apexcharts.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gray: {
                            25: '#fcfdfd',
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        },
                        primary: {
                            25: '#f6fef6',
                            50: '#ecfdf3',
                            100: '#d1fadf',
                            200: '#a6f4c5',
                            300: '#6ce9a6',
                            400: '#32d583',
                            500: '#12b76a', // Modern green
                            600: '#039855',
                            700: '#027a48',
                            800: '#05603a',
                            900: '#054f31',
                        },
                        secondary: {
                            25: '#fefdf0',
                            50: '#fefbe8',
                            100: '#fef7c3',
                            200: '#feee95',
                            300: '#fde272',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        },
                        blue: {
                            500: '#3b82f6',
                            600: '#2563eb',
                        },
                        orange: {
                            500: '#f97316',
                            600: '#ea580c',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'fade-in-scale': 'fadeInScale 0.5s ease-out',
                        'slide-in-right': 'slideInRight 0.4s ease-out',
                        'pulse-soft': 'pulseSoft 2s infinite',
                        'bounce-subtle': 'bounceSubtle 2s infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        fadeInScale: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.95)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            },
                        },
                        slideInRight: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            },
                        },
                        pulseSoft: {
                            '0%, 100%': {
                                opacity: '1'
                            },
                            '50%': {
                                opacity: '0.7'
                            },
                        },
                        bounceSubtle: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-5px)'
                            },
                        },
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        }
                    },
                    boxShadow: {
                        'xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                        'sm': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
                        'base': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                        'md': '0 6px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        'lg': '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                        'xl': '0 20px 40px -10px rgba(0, 0, 0, 0.1), 0 10px 20px -5px rgba(0, 0, 0, 0.04)',
                        '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                        'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #12b76a 0%, #039855 50%, #027a48 100%);
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
        }

        .card-hover:hover::before {
            left: 100%;
        }

        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .stat-card-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .loading-spinner {
            border: 2px solid #f3f4f6;
            border-top: 2px solid #12b76a;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        .nav-item-active {
            position: relative;
            background: rgba(255, 255, 255, 0.15);
        }

        .nav-item-active::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 32px;
            background: #facc15;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(250, 204, 21, 0.5);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Enhanced scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #12b76a 0%, #facc15 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Shimmer loading effect */
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="h-full font-sans antialiased bg-gradient-to-br from-gray-25 via-white to-green-50/30">
    <div class="min-h-full flex">
        <!-- Enhanced Sidebar -->
        <div class="hidden lg:flex lg:w-72 lg:flex-col lg:fixed lg:inset-y-0 sidebar-transition">
            <div
                class="flex grow flex-col gap-y-8 overflow-y-auto gradient-bg px-6 pb-8 border-r border-white/20 shadow-2xl">
                <!-- Enhanced Logo -->
                <div class="flex h-24 shrink-0 items-center">
    <div class="flex items-center space-x-4 group cursor-pointer">
        <div class="relative">
            <div
                class="w-12 h-12 glass-morphism rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg overflow-hidden">
                <img
                    src="<?php echo e(asset('images/Logo Ternakpark Wonosalam.png')); ?>"
                    alt="TernakPark Logo"
                    class="w-8 h-8 object-contain"
                >
            </div>
            <div
                class="absolute -inset-2 bg-white/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10">
            </div>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">TernakPark</h1>
            <p class="text-sm text-green-100 font-medium">Wonosalam Jombang</p>
        </div>
    </div>
</div>

                <!-- Enhanced Navigation -->
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-6">
                        <li>
                            <ul role="list" class="space-y-2">
                                <?php
                                    $currentRoute = Route::currentRouteName();
                                    $navItems = [
                                        [
                                            'route' => 'dashboard',
                                            'icon' => 'fas fa-chart-pie',
                                            'label' => 'Dashboard',
                                            'badge' => null,
                                        ],
                                        [
                                            'route' => 'livestocks.index',
                                            'icon' => 'fas fa-cow',
                                            'label' => 'Manajemen Ternak',
                                            'badge' => '1.2K',
                                        ],
                                        [
                                            'route' => 'pens.index',
                                            'icon' => 'fas fa-warehouse',
                                            'label' => 'Manajemen Kandang',
                                            'badge' => '24',
                                        ],
                                        [
                                            'route' => 'feeds.index',
                                            'icon' => 'fas fa-wheat-awn',
                                            'label' => 'Manajemen Pakan',
                                            'badge' => '1.2T',
                                        ],
                                        [
                                            'route' => 'predictions.index',
                                            'icon' => 'fas fa-brain',
                                            'label' => 'Prediksi & AI',
                                            'badge' => 'New',
                                        ],
                                        [
                                            'route' => 'reports.index',
                                            'icon' => 'fas fa-chart-bar',
                                            'label' => 'Laporan & Analisis',
                                            'badge' => null,
                                        ],
                                    ];
                                ?>

                                <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route($item['route'])); ?>"
                                            class="<?php if($currentRoute == $item['route'] || str_contains($currentRoute, $item['route'])): ?> nav-item-active text-white <?php else: ?> text-green-100 hover:text-white hover:bg-white/5 <?php endif; ?> group flex items-center gap-x-4 rounded-2xl p-4 text-sm leading-6 font-semibold transition-all duration-300 shadow-sm">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 rounded-xl bg-white/10 group-hover:bg-white/20 transition-colors">
                                                <i class="<?php echo e($item['icon']); ?> text-base"></i>
                                            </div>
                                            <span class="flex-1 font-medium"><?php echo e($item['label']); ?></span>
                                            <?php if($item['badge']): ?>
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-white/20 text-white">
                                                    <?php echo e($item['badge']); ?>

                                                </span>
                                            <?php endif; ?>
                                            <?php if($currentRoute == $item['route']): ?>
                                                <div
                                                    class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse-soft shadow-lg shadow-yellow-400/50">
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>

                        <!-- Enhanced Quick Stats Sidebar -->
                        <li class="mt-6">
                            <div class="glass-morphism rounded-2xl p-5 shadow-lg">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Ringkasan
                                        Real-time</h3>
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse-soft"></div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-green-400 rounded-full animate-bounce-subtle"></div>
                                            <span class="text-xs text-green-100 font-medium">Total Ternak</span>
                                        </div>
                                        <span class="text-sm font-bold text-white">1,247</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce-subtle"
                                                style="animation-delay: 0.2s"></div>
                                            <span class="text-xs text-green-100 font-medium">Kandang Aktif</span>
                                        </div>
                                        <span class="text-sm font-bold text-white">24/30</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-bounce-subtle"
                                                style="animation-delay: 0.4s"></div>
                                            <span class="text-xs text-green-100 font-medium">Stok Pakan</span>
                                        </div>
                                        <span class="text-sm font-bold text-white">1.2T</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-white/10">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-green-200">Update Terakhir</span>
                                        <span class="text-white font-medium"><?php echo e(now()->format('H:i')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Enhanced User Profile -->
                        <li class="mt-auto pt-6 border-t border-white/10">
                            <div class="group relative">
                                <div
                                    class="flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 hover:bg-white/5 cursor-pointer glass-morphism">
                                    <div class="relative">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-user-tie text-white text-base"></i>
                                        </div>
                                        <div
                                            class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 border-2 border-green-700 rounded-full animate-pulse">
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-white truncate">Admin TernakPark</p>
                                        <p class="text-xs text-green-200 truncate">Super Administrator</p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-down text-green-200 text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Enhanced Main Content Area -->
        <div class="flex-1 lg:ml-72">
            <!-- Enhanced Top Navigation Bar -->
            <div
                class="sticky top-0 z-50 flex h-20 shrink-0 items-center gap-x-4 border-b border-gray-200/30 bg-white/80 backdrop-blur-xl px-6 shadow-sm lg:px-8">
                <div class="flex flex-1 gap-x-6 self-stretch">
                    <!-- Enhanced Page Title & Breadcrumb -->
                    <div class="flex flex-1 items-center">
                        <div class="flex items-center space-x-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 tracking-tight"><?php echo $__env->yieldContent('header-title', 'Dashboard'); ?></h1>
                                <nav class="flex text-sm text-gray-600 mt-1">
                                    <ol class="flex items-center space-x-2">
                                        <li><a href="<?php echo e(route('dashboard')); ?>"
                                                class="hover:text-primary-600 transition-colors duration-200 font-medium">TernakPark</a>
                                        </li>
                                        <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
                                        <li class="text-primary-600 font-semibold"><?php echo $__env->yieldContent('header-title', 'Dashboard'); ?></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Right Side Actions -->
                    <div class="flex items-center gap-x-6">
                        <!-- Enhanced Search -->
                        <div class="relative">
                            <div
                                class="relative rounded-2xl bg-gray-50/80 hover:bg-gray-100/60 transition-all duration-300 shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i class="fas fa-search text-gray-400 text-sm"></i>
                                </div>
                                <input type="text"
                                    class="block w-80 pl-11 pr-4 py-3 bg-transparent border-0 text-gray-900 placeholder-gray-500 focus:ring-0 text-sm rounded-2xl"
                                    placeholder="Cari ternak, kandang, atau laporan...">
                            </div>
                        </div>

                        <!-- Enhanced Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="relative p-3 text-gray-500 hover:text-primary-600 transition-all duration-300 rounded-2xl hover:bg-primary-50 group">
                                <i class="fas fa-bell text-lg"></i>
                                <span
                                    class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse shadow-lg">3</span>
                            </button>

                            <!-- Enhanced Notification Dropdown -->
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl border border-gray-200/60 py-3 z-50">
                                <div class="px-5 py-3 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-bold text-gray-900">Notifikasi</h3>
                                        <span
                                            class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded-full font-medium">3
                                            Baru</span>
                                    </div>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <!-- Enhanced Notification Items -->
                                    <div
                                        class="p-4 border-b border-gray-100 hover:bg-gray-50/50 transition-all duration-200 cursor-pointer group">
                                        <div class="flex space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                                <i class="fas fa-exclamation-triangle text-yellow-600 text-lg"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="text-sm font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                                    Stok Pakan Rendah</p>
                                                <p class="text-sm text-gray-600 mt-1">Stok silase tersisa 50kg - perlu
                                                    restok segera</p>
                                                <div class="flex items-center mt-2 space-x-4">
                                                    <span class="text-xs text-gray-500"><i
                                                            class="fas fa-clock mr-1"></i>2 jam lalu</span>
                                                    <span
                                                        class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">Prioritas</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="p-4 border-b border-gray-100 hover:bg-gray-50/50 transition-all duration-200 cursor-pointer group">
                                        <div class="flex space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                                <i class="fas fa-weight text-green-600 text-lg"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="text-sm font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                                    Prediksi Siap</p>
                                                <p class="text-sm text-gray-600 mt-1">Analisis pertumbuhan batch #5
                                                    telah siap dengan akurasi 92%</p>
                                                <div class="flex items-center mt-2 space-x-4">
                                                    <span class="text-xs text-gray-500"><i
                                                            class="fas fa-clock mr-1"></i>5 jam lalu</span>
                                                    <span
                                                        class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">AI</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl">
                                    <a href="#"
                                        class="text-sm font-semibold text-primary-600 hover:text-primary-700 transition-colors flex items-center justify-center">
                                        Lihat Semua Notifikasi
                                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Quick Actions -->
                        <div class="flex items-center space-x-2">
                            <button
                                class="p-3 text-gray-500 hover:text-primary-600 transition-all duration-300 rounded-2xl hover:bg-primary-50 group"
                                title="Bantuan & Support">
                                <i
                                    class="fas fa-question-circle text-lg group-hover:scale-110 transition-transform"></i>
                            </button>
                            <button
                                class="p-3 text-gray-500 hover:text-primary-600 transition-all duration-300 rounded-2xl hover:bg-primary-50 group"
                                title="Pengaturan Cepat">
                                <i class="fas fa-cog text-lg group-hover:scale-110 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Main Content -->
            <main class="flex-1">
                <div class="py-8">
                    <div class="px-6 lg:px-8">
                        <!-- Enhanced Flash Messages -->
                        <?php if(session('success')): ?>
                            <div
                                class="mb-8 rounded-2xl bg-green-50 border border-green-200 p-5 animate-fade-in-up shadow-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-green-800"><?php echo e(session('success')); ?></p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <button class="text-green-400 hover:text-green-600 transition-colors">
                                            <i class="fas fa-times text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div
                                class="mb-8 rounded-2xl bg-red-50 border border-red-200 p-5 animate-fade-in-up shadow-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-red-800"><?php echo e(session('error')); ?></p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <button class="text-red-400 hover:text-red-600 transition-colors">
                                            <i class="fas fa-times text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Enhanced Page Header (Custom) -->
                        <?php if (! empty(trim($__env->yieldContent('page-header')))): ?>
                            <div class="mb-8 animate-fade-in-up">
                                <?php echo $__env->yieldContent('page-header'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Enhanced Main Content -->
                        <div class="animate-fade-in-scale">
                            <?php echo $__env->yieldContent('content'); ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Enhanced Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.5/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        // Professional Utility Functions with Enhanced Features
        const TernakParkPro = {
                // Enhanced Formatting utilities
                format: {
                    number(num, decimals = 0) {
                        return new Intl.NumberFormat('id-ID', {
                            minimumFractionDigits: decimals,
                            maximumFractionDigits: decimals
                        }).format(num);
                    },

                    currency(num) {
                        if (num >= 1000000000) {
                            return 'Rp ' + this.number(num / 1000000000, 1) + 'M';
                        } else if (num >= 1000000) {
                            return 'Rp ' + this.number(num / 1000000, 1) + 'Jt';
                        } else {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(num);
                        }
                    },

                    date(dateString, options = {}) {
                        const defaultOptions = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        return new Date(dateString).toLocaleDateString('id-ID', {
                            ...defaultOptions,
                            ...options
                        });
                    },

                    weight(kg, decimals = 1) {
                        return `${this.number(kg, decimals)} kg`;
                    },

                    percentage(value, decimals = 1) {
                        return `${this.number(value, decimals)}%`;
                    },

                    timeAgo(dateString) {
                        const date = new Date(dateString);
                        const now = new Date();
                        const diffInSeconds = Math.floor((now - date) / 1000);

                        if (diffInSeconds < 60) return 'Baru saja';
                        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} menit lalu`;
                        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} jam lalu`;
                        if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)} hari lalu`;
                        return this.date(dateString);
                    }
                },

                // Enhanced UI Utilities
                ui: {
                    showLoading(button, text = 'Memproses...') {
                        const originalText = button.innerHTML;
                        button.disabled = true;
                        button.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="loading-spinner"></div>
                            <span class="font-medium">${text}</span>
                        </div>
                    `;
                        return originalText;
                    },

                    hideLoading(button, originalText) {
                        button.disabled = false;
                        button.innerHTML = originalText;
                    },

                    showToast(message, type = 'success', duration = 5000) {
                        const toastId = 'toast-' + Date.now();
                        const toast = document.createElement('div');
                        toast.id = toastId;
                        toast.className = `fixed top-6 right-6 z-50 p-5 rounded-2xl border shadow-2xl animate-fade-in-up ${
                        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
                        type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
                        type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' :
                        'bg-blue-50 border-blue-200 text-blue-800'
                    }`;

                        toast.innerHTML = `
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-xl ${
                                type === 'success' ? 'bg-green-100' :
                                type === 'error' ? 'bg-red-100' :
                                type === 'warning' ? 'bg-yellow-100' :
                                'bg-blue-100'
                            } flex items-center justify-center">
                                <i class="fas ${
                                    type === 'success' ? 'fa-check-circle text-green-600' :
                                    type === 'error' ? 'fa-exclamation-circle text-red-600' :
                                    type === 'warning' ? 'fa-exclamation-triangle text-yellow-600' :
                                    'fa-info-circle text-blue-600'
                                } text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold">${message}</p>
                            </div>
                            <button onclick="document.getElementById('${toastId}').remove()" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;

                        document.body.appendChild(toast);

                        // Auto remove after duration
                        setTimeout(() => {
                            const toastElement = document.getElementById(toastId);
                            if (toastElement) {
                                toastElement.style.animation = 'fadeInUp 0.6s ease-out reverse';
                                setTimeout(() => toastElement.remove(), 600);
                            }
                        }, duration);
                    },

                    createSkeletonLoader(type = 'card',
                    count = 1) {
                    const skeletons = {
                        card: `
                            <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                                <div class="animate-pulse">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gray-200 rounded-xl"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                            <div class="h-6 bg-gray-200 rounded w-1/2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `,
                        chart: `
                            <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                                <div class="animate-pulse">
                                    <div class="h-6 bg-gray-200 rounded w-1/3 mb-4"></div>
                                    <div class="h-64 bg-gray-200 rounded"></div>
                                </div>
                            </div>
                        `,
                        list: `
                            <div class="space-y-3">
                                ${Array.from({length: 5}, () => ` <
                            div class="flex items-center space-x-3 p-3 rounded-xl border border-gray-200 animate-pulse" >
                            <
                            div class="w-10 h-10 bg-gray-200 rounded-full" > < /div> <
                            div class="flex-1 space-y-2" >
                            <
                            div class="h-4 bg-gray-200 rounded w-2/3" > < /div> <
                            div class="h-3 bg-gray-200 rounded w-1/2" > < /div> <
                            /div> <
                            /div>
                        `).join('')}
                            </div>
                        `
                    };

                    return Array.from({
                        length: count
                    }, () => skeletons[type]).join('');
                }
            },

            // Enhanced Chart Utilities
            charts: {
                createProgressChart(canvasId, value, max = 100, color = '#12b76a') {
                    const ctx = document.getElementById(canvasId).getContext('2d');
                    const percentage = (value / max) * 100;

                    return new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    datasets: [{
                                                data: [percentage, 100 - percentage],
                                                backgroundColor: [color, '#f3f4f6'],
                                                borderWidth: 0,
                                                borderRadius: 12
<?php /**PATH D:\game\Aplikasi_Skripsi\frontend-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>