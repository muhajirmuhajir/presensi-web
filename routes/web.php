<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PresensiRecordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::redirect('/', '/login', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('presensi', PresensiController::class);
    Route::resource('presensi.record', PresensiRecordController::class);
    Route::resource('course', CourseController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('student', StudentController::class);
    Route::resource('teacher', TeacherController::class);
    Route::get('kelas/{id}/student/add', [KelasController::class, 'addStudent'])->name('kelas.student.add');
    Route::post('kelas/{id}/student', [KelasController::class, 'storeStudent'])->name('kelas.student.store');
    Route::delete('kelas/{id}/student/{student_id}', [KelasController::class, 'destroyStudent'])->name('kelas.student.destroy');

    Route::get('presensi/{id}/rekap', [PresensiController::class, 'rekapPresensi'])->name('presensi.rekap');

    Route::get('profile', [UserController::class, 'show'])->name('profile.show');
    Route::put('profile', [UserController::class, 'update'])->name('profile.update');
});

Route::get('user/activation/{token}', [UserController::class, 'activate'])->name('account.activate');
Route::post('user/activation/{token}', [UserController::class, 'verifiy'])->name('account.verifiy');

Route::get('activation/success', [UserController::class, 'success'])->name('activation.success');

require __DIR__ . '/auth.php';
