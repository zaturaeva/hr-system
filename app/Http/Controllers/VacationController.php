<?php
// app/Http/Controllers/VacationController.php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VacationController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::where('status', '!=', 'dismissed')->get();
            $vacationData = [];
            
            foreach ($employees as $employee) {
                $vacationData[] = [
                    'id' => $employee->id,
                    'name' => $employee->full_name,
                    'position' => $employee->position ?? '—',
                    'work_duration' => $employee->getWorkDuration(),
                    'available_days' => $employee->calculateVacationDays(),
                    'used_days' => 0,
                    'status' => $employee->status
                ];
            }
            
            return view('vacations.index', compact('vacationData'));
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка загрузки отпусков: ' . $e->getMessage());
            return view('vacations.index', ['vacationData' => []]);
        }
    }

    public function create()
    {
        try {
            $employees = Employee::where('status', 'active')->get();
            return view('vacations.create', compact('employees'));
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->route('vacations.index');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'start_date' => 'required|date|after:today',
                'days' => 'required|integer|min:1|max:365'
            ]);

            $employee = Employee::find($request->employee_id);
            $availableDays = $employee->calculateVacationDays();

            if ($request->days > $availableDays) {
                throw new \Exception("Недостаточно дней отпуска. Доступно: {$availableDays} дней");
            }

            Session::flash('success', "Отпуск для {$employee->full_name} оформлен на {$request->days} дней");
            return redirect()->route('vacations.index');

        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                abort(404, 'Сотрудник не найден');
            }

            $availableDays = $employee->calculateVacationDays();
            $workDuration = $employee->getWorkDuration();

            return view('vacations.show', compact('employee', 'availableDays', 'workDuration'));
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->route('vacations.index');
        }
    }
}