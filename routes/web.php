<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('asistencia.index');
    } else {
        return view('auth/login');
    }
});

Auth::routes();

Route::get('alumnos/pdf', [App\Http\Controllers\AlumnoController::class, 'pdf'])->name('alumno.pdf') ;

Route::match(['get', 'post'], 'asistencias/diariopdf', [App\Http\Controllers\AsistenciaController::class, 'diariopdf'])->name('asistencia.diariopdf');


Route::middleware(['auth'])->group(function () {
    // Rutas protegidas aquí
    Route::resource('alumnos', App\Http\Controllers\AlumnoController::class);
    Route::resource('secciones', App\Http\Controllers\SeccioneController::class);
    Route::resource('grados', App\Http\Controllers\GradoController::class);

    Route::resource('asistencias', App\Http\Controllers\AsistenciaController::class);

    Route::get('/camara', function () { return view('asistencia.camara'); });
   
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/asistencia', [App\Http\Controllers\AsistenciaController::class, 'index'])->name('asistencia.index');   
