<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Exceptions\ValidationError;
use DateTime;

class VacationTest extends TestCase
{
    public function test_vacation_calculation_for_more_than_6_months_no_extra_days()
    {
        $employee = new Employee([
            'full_name' => 'Иван Петров',
            'hire_date' => '2025-01-01',
            'extra_vacation_days' => 0
        ]);
        
        $result = $employee->calculateVacationDays();
        $this->assertEquals(28.0, $result);
    }

    public function test_vacation_calculation_for_more_than_6_months_with_extra_days()
    {
        $employee = new Employee([
            'full_name' => 'Иван Петров',
            'hire_date' => '2025-01-01',
            'extra_vacation_days' => 7
        ]);
        
        $result = $employee->calculateVacationDays();
        $this->assertEquals(35.0, $result);
    }

    public function test_vacation_calculation_for_exactly_6_months()
    {
        $employee = new Employee('Иван Петров', '2025-12-21', 0);
        $result = $employee->calculateVacationDays();
        
        $this->assertEquals(28.0, $result);
    }

    public function test_vacation_calculation_for_less_than_6_months()
    {
        $employee = new Employee('Иван Петров', '2026-03-01', 0);
        $result = $employee->calculateVacationDays();
        
       $this->assertEquals(9.3, $result);
    }

    public function test_vacation_calculation_for_less_than_6_months_with_extra_days()
    {
        $employee = new Employee('Иван Петров', '2026-03-01', 7);
        $result = $employee->calculateVacationDays();
        
        $this->assertEquals(11.7, $result);
    }

    public function test_hire_date_in_future_throws_exception()
    {
        $this->expectException(ValidationError::class);
        $this->expectExceptionMessage('Дата приёма не может быть в будущем');
        
        new Employee('Иван Петров', '2030-01-01', 0);
    }

    public function test_negative_extra_days_throws_exception()
    {
        $this->expectException(ValidationError::class);
        $this->expectExceptionMessage('Дополнительные дни отпуска не могут быть отрицательными');
        
        new Employee('Иван Петров', '2025-01-01', -5);
    }

}