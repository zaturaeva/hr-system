<?php
// tests/Unit/VacationTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Exceptions\ValidationError;

class VacationTest extends TestCase
{
    /**
     * TC-01: Стаж более 6 месяцев, без дополнительных дней
     */
    public function test_vacation_calculation_for_more_than_6_months_no_extra_days()
    {
        $employee = Employee::factory()->make([
            'full_name' => 'Иван Петров',
            'hire_date' => '2025-01-01',
            'extra_vacation_days' => 0
        ]);
        
        $this->assertEquals(28.0, $employee->calculateVacationDays());
    }

    /**
     * TC-02: Стаж более 6 месяцев, с дополнительными днями
     */
    public function test_vacation_calculation_for_more_than_6_months_with_extra_days()
    {
        $employee = Employee::factory()->make([
            'full_name' => 'Анна Сидорова',
            'hire_date' => '2025-01-01',
            'extra_vacation_days' => 7
        ]);
        
        $this->assertEquals(35.0, $employee->calculateVacationDays());
    }

    /**
     * TC-03: Стаж ровно 6 месяцев
     */
    public function test_vacation_calculation_for_exactly_6_months()
    {
        $employee = Employee::factory()->make([
            'full_name' => 'Сергей Козлов',
            'hire_date' => '2025-12-21',
            'extra_vacation_days' => 0
        ]);
        
        $this->assertEquals(28.0, $employee->calculateVacationDays());
    }

    /**
     * TC-04: Стаж менее 6 месяцев (пропорциональный расчёт)
     * Исправлено: используем дату, которая даёт ровно 3 месяца стажа
     */
    public function test_vacation_calculation_for_less_than_6_months()
    {
        // Используем дату ровно 3 месяца назад
        $hireDate = date('Y-m-d', strtotime('-3 months'));
        
        $employee = Employee::factory()->make([
            'full_name' => 'Мария Иванова',
            'hire_date' => $hireDate,
            'extra_vacation_days' => 0
        ]);
        
        // При стаже 3 месяца: (28/12) * 3 = 7.0 дней
        $this->assertEquals(7.0, $employee->calculateVacationDays());
    }

    /**
     * TC-05: Стаж менее 6 месяцев с дополнительными днями
     * Исправлено: используем дату, которая даёт ровно 3 месяца стажа
     */
    public function test_vacation_calculation_for_less_than_6_months_with_extra_days()
    {
        // Используем дату ровно 3 месяца назад
        $hireDate = date('Y-m-d', strtotime('-3 months'));
        
        $employee = Employee::factory()->make([
            'full_name' => 'Дмитрий Смирнов',
            'hire_date' => $hireDate,
            'extra_vacation_days' => 7
        ]);
        
        // При стаже 3 месяца + 7 доп. дней: 7.0 + 7 = 14.0 дней
        $this->assertEquals(14.0, $employee->calculateVacationDays());
    }

    /**
     * TC-06: Дата приёма в будущем
     * Исправлено: проверяем правильное сообщение об ошибке
     */
    public function test_hire_date_in_future_throws_exception()
    {
        $this->expectException(ValidationError::class);
        // Проверяем, что сообщение содержит информацию о дате в будущем
        $this->expectExceptionMessageMatches('/будущем|future/i');
        
        $employee = Employee::factory()->make([
            'full_name' => 'Тест Тестович',
            'hire_date' => '2030-01-01',
            'extra_vacation_days' => 0
        ]);
        
        // Триггерим валидацию
        $employee->validateEmployeeData($employee->getAttributes());
    }

    /**
     * TC-07: Отрицательные дополнительные дни
     */
    public function test_negative_extra_days_throws_exception()
    {
        $this->expectException(ValidationError::class);
        $this->expectExceptionMessage('отрицательными');
        
        $employee = Employee::factory()->make([
            'full_name' => 'Тест Тестович',
            'hire_date' => '2025-01-01',
            'extra_vacation_days' => -5
        ]);
        
        $employee->validateEmployeeData($employee->getAttributes());
    }
}