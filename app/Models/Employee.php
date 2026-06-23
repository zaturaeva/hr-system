<?php
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function save(array $options = [])
    {
        $this->validateEmployeeData($this->attributes);
        return parent::save($options);
    }

    protected function validateEmployeeData(array $data): void
    {
        if (empty(trim($data['full_name'] ?? ''))) {
            throw new ValidationError("ФИО не может быть пустым");
        }

        if (isset($data['hire_date'])) {
            try {
                // Проверяем тип данных
                if ($data['hire_date'] instanceof DateTime) {
                    $hireDate = $data['hire_date'];
                } elseif (is_string($data['hire_date'])) {
                    $hireDate = new DateTime($data['hire_date']);
                } else {
                    // Если это уже объект Carbon (из Eloquent)
                    $hireDate = $data['hire_date'];
                }
                
                $now = new DateTime();
                if ($hireDate > $now) {
                    throw new ValidationError("Дата приёма не может быть в будущем");
                }
            } catch (\Exception $e) {
                throw new ValidationError("Неверный формат даты приёма: " . $e->getMessage());
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

    public function getHireDateAttribute($value)
    {
        if ($value instanceof DateTime) {
            return $value;
        }
        return $value ? new DateTime($value) : null;
    }

    public function setHireDateAttribute($value)
    {
        if ($value instanceof DateTime) {
            $this->attributes['hire_date'] = $value->format('Y-m-d');
        } elseif (is_string($value)) {
            $this->attributes['hire_date'] = $value;
        } else {
            $this->attributes['hire_date'] = $value;
        }
    }
}