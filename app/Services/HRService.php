<?php

namespace App\Services;

use App\Models\Employee;
use App\Exceptions\ValidationError;
use DateTime;
use Illuminate\Support\Facades\DB;

class HRService
{
    public function hireEmployee(array $data): Employee
    {
        try {
            $employee = Employee::create([
                'full_name' => $data['full_name'],
                'hire_date' => $data['hire_date'],
                'extra_vacation_days' => $data['extra_vacation_days'] ?? 0,
                'position' => $data['position'] ?? null,
                'salary' => $data['salary'] ?? null,
                'status' => 'active'
            ]);
            
            return $employee;
        } catch (ValidationError $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ValidationError("Ошибка при приёме сотрудника: " . $e->getMessage());
        }
    }

    public function getAllEmployees(): array
    {
        return Employee::orderBy('created_at', 'desc')->get()->toArray();
    }

    public function getEmployeeById(int $id): ?Employee
    {
        return Employee::find($id);
    }

    public function updateEmployee(int $id, array $data): Employee
    {
        $employee = Employee::find($id);
        if (!$employee) {
            throw new ValidationError("Сотрудник не найден");
        }

        if (isset($data['full_name']) && empty(trim($data['full_name']))) {
            throw new ValidationError("ФИО не может быть пустым");
        }

        $employee->update($data);
        return $employee;
    }

    public function dismissEmployee(int $id, string $reason): array
    {
        $employee = Employee::find($id);
        if (!$employee) {
            throw new ValidationError("Сотрудник не найден");
        }

        $employee->status = 'dismissed';
        $employee->save();

        return [
            'employee' => $employee->full_name,
            'reason' => $reason,
            'dismissal_date' => (new DateTime())->format('Y-m-d H:i:s'),
            'unused_vacation_days' => $employee->calculateVacationDays()
        ];
    }

    public function deleteEmployee(int $id): array
    {
        $employee = Employee::find($id);
        if (!$employee) {
            throw new ValidationError("Сотрудник не найден");
        }

        $employee->delete();

        return [
            'id' => $id,
            'deleted_at' => (new DateTime())->format('Y-m-d H:i:s')
        ];
    }

    public function getEmployeesWithVacationDays(): array
    {
        $employees = Employee::where('status', '!=', 'dismissed')->get();
        $result = [];
        
        foreach ($employees as $employee) {
            $result[] = [
                'id' => $employee->id,
                'name' => $employee->full_name,
                'position' => $employee->position,
                'hire_date' => $employee->hire_date,
                'vacation_days' => $employee->calculateVacationDays(),
                'work_duration' => $employee->getWorkDuration(),
                'status' => $employee->status
            ];
        }
        
        return $result;
    }

    public function getVacationHistory(int $employeeId): array
    {
        return [
            [
                'start_date' => '2024-01-15',
                'days' => 14,
                'remaining_days' => 14,
                'applied_at' => '2023-12-01 10:00:00'
            ],
            [
                'start_date' => '2024-06-01',
                'days' => 7,
                'remaining_days' => 7,
                'applied_at' => '2024-05-15 14:30:00'
            ]
        ];
    }
}