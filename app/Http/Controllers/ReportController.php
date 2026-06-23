<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function index()
    {
        try {
            $stats = $this->getStatistics();
            return view('reports.index', compact('stats'));
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка загрузки отчётов: ' . $e->getMessage());
            return view('reports.index', ['stats' => []]);
        }
    }

    public function employees()
    {
        try {
            $employees = Employee::all();
            return view('reports.employees', compact('employees'));
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->route('reports.index');
        }
    }

    public function vacation()
    {
        try {
            $employees = Employee::where('status', '!=', 'dismissed')->get();
            return view('reports.vacation', compact('employees'));
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->route('reports.index');
        }
    }

    private function getStatistics(): array
    {
        try {
            $total = Employee::count();
            $active = Employee::where('status', 'active')->count();
            $onVacation = Employee::where('status', 'on_vacation')->count();
            $dismissed = Employee::where('status', 'dismissed')->count();
            
            $avgVacation = 0;
            if ($total > 0) {
                $totalDays = Employee::all()->sum(function($emp) {
                    return $emp->calculateVacationDays();
                });
                $avgVacation = round($totalDays / $total, 1);
            }

            return [
                'total' => $total,
                'active' => $active,
                'on_vacation' => $onVacation,
                'dismissed' => $dismissed,
                'avg_vacation' => $avgVacation,
                'total_salary' => Employee::sum('salary') ?? 0
            ];
        } catch (\Exception $e) {
            return [
                'total' => 0,
                'active' => 0,
                'on_vacation' => 0,
                'dismissed' => 0,
                'avg_vacation' => 0,
                'total_salary' => 0
            ];
        }
    }
}