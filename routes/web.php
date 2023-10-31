<?php

use App\Http\Controllers\SquareController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if(!auth()->check()){
        return redirect()->route('login');
    }
    $logs = DB::table('log_sqrt')->orderByDesc('created_at')->get();
    return view('index', compact('logs'));
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('total-kirim', function () {
    $logs = DB::table('log_sqrt')->select(DB::raw('count(*) as total, number'))->groupBy('number')->get();
    $fastest = DB::table('log_sqrt')->select('execution_time')->orderBy('execution_time')->first();
    $slowest = DB::table('log_sqrt')->select('execution_time')->orderByDesc('execution_time')->first();
    if ($fastest && $slowest) {
        $fastest = $fastest->execution_time;
        $slowest = $slowest->execution_time;
    } else {
        $fastest = 0;
        $slowest = 0;
    }
    $totalData = DB::table('log_sqrt')->select(DB::raw('count(*) as total'))->first()->total;
    return view('total-kirim', compact('logs', 'fastest', 'slowest', 'totalData'));
})->name('total-kirim');
