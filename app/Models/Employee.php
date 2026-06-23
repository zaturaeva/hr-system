<?php
// app/Models/Employee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ValidationError;
use DateTime;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'hire_date',
        'extra_vacation_days',
        'position',
        'salary',
        'status'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'float',
        'extra_vacation_days' => 'integer'
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->validateEmployeeData($employee->getAttributes());
        });

        static::updating(function ($employee) {
            $employee->validateEmployeeData($employee->getAttributes());
        });
    }

    public function validateEmployeeData(array $data): void
    {
        if (empty(trim($data['full_name'] ?? ''))) {
            throw new ValidationError("ФИО не может быть пустым");
        }

        if (isset($data['hire_date'])) {
            try {
                if ($data['hire_date'] instanceof DateTime) {
                    $hireDate = $data['hire_date'];
                } elseif (is_string($data['hire_date'])) {
                    $hireDate = new DateTime($data['hire_date']);
                } else {
                    $hireDate = $data['hire_date'];
                }
                
                $now = new DateTime();
                if ($hireDate > $now) {
                    throw new ValidationError("Дата приёма не может быть в будущем");
                }
            } catch (ValidationError $e) {
                throw $e;
            } catch (\Exception $e) {
                throw new ValidationError("Неверный формат даты приёма");
            }
        }

        if (isset($data['extra_vacation_days']) && $data['extra_vacation_days'] < 0) {
            throw new ValidationError("Дополнительные дни отпуска не могут быть отрицательными");
        }

        if (isset($data['salary']) && $data['salary'] <= 0) {
            throw new ValidationError("Зарплата должна быть положительным числом");
        }
    }

    public function calculateVacationDays(): float
    {
        $baseDays = 28.0;
        $monthsWorked = $this->calculateMonthsWorked();
        
        if ($monthsWorked >= 6) {
            $vacationDays = $baseDays + ($this->extra_vacation_days ?? 0);
        } else {
            $vacationDays = ($baseDays / 12) * $monthsWorked + ($this->extra_vacation_days ?? 0);
            $vacationDays = round($vacationDays, 1);
        }
        
        return $vacationDays;
    }

    private function calculateMonthsWorked(): float
    {
        $now = new DateTime();
        $hireDate = $this->hire_date instanceof DateTime ? $this->hire_date : new DateTime($this->hire_date);
        $interval = $now->diff($hireDate);
        
        $months = $interval->y * 12 + $interval->m;
        $days = $interval->d;
        
        if ($days > 0) {
            $months += $days / 30.44;
        }
        
        return round($months, 1);
    }

    public function getWorkDuration(): string
    {
        $hireDate = $this->hire_date instanceof DateTime ? $this->hire_date : new DateTime($this->hire_date);
        $now = new DateTime();
        $interval = $now->diff($hireDate);
        
        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;
        
        $parts = [];
        if ($years > 0) $parts[] = "{$years} лет";
        if ($months > 0) $parts[] = "{$months} мес.";
        if ($days > 0) $parts[] = "{$days} дн.";
        
        return implode(' ', $parts) ?: '0 дн.';
    }

    public function getStatusBadge(): string
    {
        $statuses = [
            'active' => 'bg-success',
            'on_vacation' => 'bg-warning',
            'dismissed' => 'bg-danger',
            'probation' => 'bg-info'
        ];
        return $statuses[$this->status ?? 'active'] ?? 'bg-secondary';
    }
}