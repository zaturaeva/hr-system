<?php
// app/Http/Controllers/EmployeeController.php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\HRService;
use App\Exceptions\ValidationError;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    private HRService $hrService;

    public function __construct(HRService $hrService)
    {
        $this->hrService = $hrService;
    }

    public function index()
    {
        try {
            $employees = Employee::where('status', '!=', 'dismissed')->get();
            $stats = $this->getStatistics();
            
            return view('employees.index', compact('employees', 'stats'));
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка загрузки сотрудников: ' . $e->getMessage());
            return view('employees.index', ['employees' => [], 'stats' => []]);
        }
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(EmployeeRequest $request)
    {
        try {
            $employee = Employee::create([
                'full_name' => $request->full_name,
                'hire_date' => $request->hire_date,
                'extra_vacation_days' => $request->extra_vacation_days ?? 0,
                'position' => $request->position ?? null,
                'salary' => $request->salary ?? null,
                'status' => 'active'
            ]);
            
            Session::flash('success', "Сотрудник {$employee->full_name} успешно принят на работу!");
            return redirect()->route('employees.index');
            
        } catch (ValidationError $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
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
            
            $vacationHistory = $this->getVacationHistory($id);
            $vacationDays = $employee->calculateVacationDays();
            
            return view('employees.show', compact('employee', 'vacationHistory', 'vacationDays'));
            
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->route('employees.index');
        }
    }

    public function edit($id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                abort(404, 'Сотрудник не найден');
            }
            
            return view('employees.edit', compact('employee'));
            
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->route('employees.index');
        }
    }

    public function update(EmployeeRequest $request, $id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                throw new \Exception('Сотрудник не найден');
            }

            $employee->update($request->validated());
            
            Session::flash('success', "Данные сотрудника {$employee->full_name} обновлены!");
            return redirect()->route('employees.index');
            
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function dismiss(Request $request, $id)
    {
        try {
            $request->validate([
                'reason' => 'required|string|min:3|max:255'
            ]);
            
            $employee = Employee::find($id);
            if (!$employee) {
                throw new \Exception('Сотрудник не найден');
            }

            $employee->status = 'dismissed';
            $employee->save();

            Session::flash('success', "Сотрудник {$employee->full_name} уволен");
            return redirect()->route('employees.index');
            
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function vacation($id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                abort(404, 'Сотрудник не найден');
            }
            
            $vacationDays = $employee->calculateVacationDays();
            
            return view('employees.vacation', compact('employee', 'vacationDays'));
            
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->route('employees.index');
        }
    }

    public function storeVacation(Request $request, $id)
    {
        try {
            $request->validate([
                'start_date' => 'required|date|after:today',
                'days' => 'required|integer|min:1|max:365'
            ]);
            
            $employee = Employee::find($id);
            if (!$employee) {
                throw new \Exception('Сотрудник не найден');
            }
            
            $availableDays = $employee->calculateVacationDays();
            if ($request->days > $availableDays) {
                throw new \Exception("Недостаточно дней отпуска. Доступно: {$availableDays} дней");
            }
            
            Session::flash('success', "Отпуск для {$employee->full_name} оформлен на {$request->days} дней");
            return redirect()->route('employees.show', $id);
            
        } catch (\Exception $e) {
            Session::flash('error', 'Ошибка: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    private function getStatistics(): array
    {
        try {
            $total = Employee::count();
            $active = Employee::where('status', 'active')->count();
            $onVacation = Employee::where('status', 'on_vacation')->count();
            $dismissed = Employee::where('status', 'dismissed')->count();
            
            $avgVacationDays = 0;
            if ($total > 0) {
                $totalDays = Employee::all()->sum(function($emp) {
                    return $emp->calculateVacationDays();
                });
                $avgVacationDays = round($totalDays / $total, 1);
            }
            
            return [
                'total' => $total,
                'active' => $active,
                'on_vacation' => $onVacation,
                'dismissed' => $dismissed,
                'avg_vacation_days' => $avgVacationDays
            ];
        } catch (\Exception $e) {
            return [
                'total' => 0,
                'active' => 0,
                'on_vacation' => 0,
                'dismissed' => 0,
                'avg_vacation_days' => 0
            ];
        }
    }

    private function getVacationHistory($employeeId): array
    {
        // Временная заглушка для истории отпусков
        return [];
    }
}