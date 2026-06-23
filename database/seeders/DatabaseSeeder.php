<?php
// database/seeders/EmployeeSeeder.php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Очищаем таблицу перед заполнением
        Employee::truncate();

        // Тестовые данные для проверки всех кейсов
        $testEmployees = [
            // TC-01: Стаж более 6 месяцев, без дополнительных дней
            [
                'full_name' => 'Иван Петров (TC-01)',
                'hire_date' => '2025-01-01',
                'extra_vacation_days' => 0,
                'position' => 'Разработчик',
                'salary' => 100000,
                'status' => 'active'
            ],
            // TC-02: Стаж более 6 месяцев, с дополнительными днями
            [
                'full_name' => 'Анна Сидорова (TC-02)',
                'hire_date' => '2025-01-01',
                'extra_vacation_days' => 7,
                'position' => 'Тестировщик',
                'salary' => 80000,
                'status' => 'active'
            ],
            // TC-03: Стаж ровно 6 месяцев
            [
                'full_name' => 'Сергей Козлов (TC-03)',
                'hire_date' => '2025-12-21',
                'extra_vacation_days' => 0,
                'position' => 'Аналитик',
                'salary' => 90000,
                'status' => 'active'
            ],
            // TC-04: Стаж менее 6 месяцев (пропорциональный расчёт)
            [
                'full_name' => 'Мария Иванова (TC-04)',
                'hire_date' => '2026-03-01',
                'extra_vacation_days' => 0,
                'position' => 'Дизайнер',
                'salary' => 70000,
                'status' => 'active'
            ],
            // TC-05: Стаж менее 6 месяцев с дополнительными днями
            [
                'full_name' => 'Дмитрий Смирнов (TC-05)',
                'hire_date' => '2026-03-01',
                'extra_vacation_days' => 7,
                'position' => 'Менеджер',
                'salary' => 85000,
                'status' => 'active'
            ],
            // Дополнительные сотрудники
            [
                'full_name' => 'Елена Васильева',
                'hire_date' => '2024-08-15',
                'extra_vacation_days' => 3,
                'position' => 'HR-специалист',
                'salary' => 75000,
                'status' => 'on_vacation'
            ],
            [
                'full_name' => 'Алексей Петров',
                'hire_date' => '2025-11-01',
                'extra_vacation_days' => 0,
                'position' => 'Системный администратор',
                'salary' => 95000,
                'status' => 'active'
            ],
        ];

        foreach ($testEmployees as $employee) {
            Employee::create($employee);
        }

        // Создаём 20 случайных сотрудников
        Employee::factory(20)->create();

        $this->command->info('✅ Создано ' . (count($testEmployees) + 20) . ' сотрудников');
    }
}