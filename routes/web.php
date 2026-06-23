<?php
// routes/web.php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return redirect()->route('employees.index');
});

// ===== СОТРУДНИКИ =====
Route::resource('employees', EmployeeController::class);
Route::post('/employees/{id}/dismiss', [EmployeeController::class, 'dismiss'])->name('employees.dismiss');
Route::get('/employees/{id}/vacation', [EmployeeController::class, 'vacation'])->name('employees.vacation');
Route::post('/employees/{id}/vacation', [EmployeeController::class, 'storeVacation'])->name('employees.store-vacation');

// ===== ОТПУСКА =====
Route::get('/vacations', [VacationController::class, 'index'])->name('vacations.index');
Route::get('/vacations/create', [VacationController::class, 'create'])->name('vacations.create');
Route::post('/vacations', [VacationController::class, 'store'])->name('vacations.store');
Route::get('/vacations/{id}', [VacationController::class, 'show'])->name('vacations.show');

// ===== ОТЧЁТЫ =====
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
Route::get('/reports/vacation', [ReportController::class, 'vacation'])->name('reports.vacation');