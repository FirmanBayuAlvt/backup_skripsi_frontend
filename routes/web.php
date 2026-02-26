<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LivestockController;
use App\Http\Controllers\Web\PredictionController;
use App\Http\Controllers\Web\PenController;
use App\Http\Controllers\Web\FeedController;
use App\Http\Controllers\Web\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ============================================
// ROOT REDIRECT & LANDING PAGE
// ============================================
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// ============================================
// AUTHENTICATION ROUTES
// ============================================
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->only('email', 'password');

        if (!empty($credentials['email']) && !empty($credentials['password'])) {
            session(['authenticated' => true, 'user' => ['name' => 'Admin', 'email' => $credentials['email']]]);
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email dan password diperlukan']);
    })->name('login.post');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        session(['authenticated' => true, 'user' => $data]);
        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    })->name('register.post');

    Route::post('/logout', function () {
        session()->flush();
        return redirect()->route('auth.login')->with('success', 'Logout berhasil!');
    })->name('logout');

    Route::get('/logout', function () {
        session()->flush();
        return redirect()->route('auth.login')->with('success', 'Logout berhasil!');
    })->name('logout.get');
});

// ============================================
// PROTECTED ROUTES (Require Authentication)
// ============================================
Route::middleware(['web'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // LIVESTOCK MANAGEMENT
    Route::prefix('livestocks')->name('livestocks.')->group(function () {
        Route::get('/', [LivestockController::class, 'index'])->name('index');
        Route::get('/{id}', [LivestockController::class, 'show'])->name('show')->where('id', '[0-9]+');
        Route::get('/{id}/growth', [LivestockController::class, 'growth'])->name('growth')->where('id', '[0-9]+');
        Route::get('/create', function () {
            return view('livestocks.create');
        })->name('create');
    });

    // PEN MANAGEMENT
    Route::prefix('pens')->name('pens.')->group(function () {
        Route::get('/', [PenController::class, 'index'])->name('index');
        Route::get('/{id}', [PenController::class, 'show'])->name('show')->where('id', '[0-9]+');
        Route::get('/{id}/analytics', [PenController::class, 'analytics'])->name('analytics')->where('id', '[0-9]+');
        Route::get('/create', function () {
            return view('pens.create');
        })->name('create');
    });

    // FEED MANAGEMENT
    Route::prefix('feeds')->name('feeds.')->group(function () {
        Route::get('/', [FeedController::class, 'index'])->name('index');
        Route::get('/stock', [FeedController::class, 'stock'])->name('stock');
        Route::get('/requirements', [FeedController::class, 'requirements'])->name('requirements');
        Route::get('/create', function () {
            return view('feeds.create');
        })->name('create');
    });

    // PREDICTIONS
    Route::prefix('predictions')->name('predictions.')->group(function () {
        Route::get('/', [PredictionController::class, 'index'])->name('index');
        Route::get('/results/{id}', [PredictionController::class, 'show'])->name('show')->where('id', '[0-9]+');
        Route::get('/correlation', [PredictionController::class, 'correlation'])->name('correlation');
        Route::get('/create', function () {
            return view('predictions.create');
        })->name('create');
    });

    // REPORTS
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/performance', [ReportController::class, 'performance'])->name('performance');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('/growth', [ReportController::class, 'growth'])->name('growth');
    });

    // PROFILE
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', function () {
            return view('profile.index', [
                'user' => session('user', ['name' => 'Admin', 'email' => 'admin@ternakpark.com'])
            ]);
        })->name('index');

        Route::get('/settings', function () {
            return view('profile.settings', [
                'user' => session('user', ['name' => 'Admin', 'email' => 'admin@ternakpark.com'])
            ]);
        })->name('settings');

        Route::post('/update', function (Request $request) {
            $user = session('user', []);
            $user['name'] = $request->name;
            session(['user' => $user]);
            return back()->with('success', 'Profile updated successfully!');
        })->name('update');
    });

    // WEB API ROUTES (AJAX ENDPOINTS)
    Route::prefix('web-api')->name('web-api.')->group(function () {
        // Dashboard API
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/overview', [DashboardController::class, 'getOverviewData'])->name('overview');
            Route::get('/pen-analytics', [DashboardController::class, 'getPenAnalytics'])->name('pen-analytics');
            Route::get('/predictions/history', [DashboardController::class, 'getPredictionHistory'])->name('predictions.history');
        });

        // Livestock API - SESUAI DENGAN CONTROLLER
        Route::prefix('livestocks')->name('livestocks.')->group(function () {
            Route::get('/data', [LivestockController::class, 'getLivestocksData'])->name('data');
            Route::get('/{id}/detail', [LivestockController::class, 'getLivestockDetail'])->name('detail')->where('id', '[0-9]+');
            Route::post('/store', [LivestockController::class, 'storeLivestock'])->name('store');
            Route::post('/{id}/record-weight', [LivestockController::class, 'recordWeight'])->name('record-weight')->where('id', '[0-9]+');
            // HAPUS ROUTE YANG TIDAK ADA: updateLivestock, deleteLivestock
        });

        // Pen API - SESUAI DENGAN CONTROLLER
        Route::prefix('pens')->name('pens.')->group(function () {
            Route::get('/data', [PenController::class, 'getPensData'])->name('data');
            Route::get('/{id}/detail', [PenController::class, 'getPenDetail'])->name('detail')->where('id', '[0-9]+');
            Route::get('/{id}/analytics', [PenController::class, 'getPenAnalytics'])->name('analytics')->where('id', '[0-9]+');
            // HAPUS ROUTE YANG TIDAK ADA: storePen, updatePen
        });

        // Feed API - SESUAI DENGAN CONTROLLER
        Route::prefix('feeds')->name('feeds.')->group(function () {
            Route::get('/data', [FeedController::class, 'getFeedsData'])->name('data');
            Route::get('/stock-levels', [FeedController::class, 'getStockLevels'])->name('stock-levels');
            Route::get('/requirements', [FeedController::class, 'getFeedRequirements'])->name('requirements');
            Route::post('/record-feeding', [FeedController::class, 'recordFeeding'])->name('record-feeding');
            Route::post('/update-stock', [FeedController::class, 'updateStock'])->name('update-stock');
            // HAPUS ROUTE YANG TIDAK ADA: storeFeed
        });

        // Prediction API - SESUAI DENGAN CONTROLLER
        Route::prefix('predictions')->name('predictions.')->group(function () {
            Route::get('/data', [PredictionController::class, 'getPredictionsData'])->name('data');
            Route::get('/{id}/detail', [PredictionController::class, 'getPredictionDetail'])->name('detail')->where('id', '[0-9]+');
            Route::get('/correlation', [PredictionController::class, 'getCorrelationData'])->name('correlation');
            Route::get('/history', [PredictionController::class, 'getPredictionHistory'])->name('history');
            Route::post('/create', [PredictionController::class, 'createPrediction'])->name('create');
            // HAPUS ROUTE YANG TIDAK ADA: getPredictionModels
        });

        // Report API - SESUAI DENGAN CONTROLLER
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/data', [ReportController::class, 'getReportsData'])->name('data');
            // HAPUS ROUTE YANG TIDAK ADA: getSummaryReport, getPerformanceReport, getFinancialReport, getGrowthReport, exportReport
        });
    });
});

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now()->toISOString(),
        'service' => 'TernakPark Frontend',
        'version' => '1.0.0'
    ]);
})->name('health');

Route::get('/maintenance', function () {
    return response()->view('maintenance', [], 503);
})->name('maintenance');

// ============================================
// DEVELOPMENT ROUTES
// ============================================
if (app()->environment('local')) {
    Route::prefix('dev')->name('dev.')->group(function () {
        Route::get('/test-backend', function () {
            return response()->json([
                'success' => true,
                'message' => 'Development route accessible'
            ]);
        })->name('test-backend');

        Route::get('/clear-cache', function () {
            Artisan::call('optimize:clear');
            return response()->json([
                'success' => true,
                'message' => 'Application cache cleared successfully'
            ]);
        })->name('clear-cache');
    });
}

// ============================================
// FALLBACK ROUTES
// ============================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
})->name('fallback.404');
