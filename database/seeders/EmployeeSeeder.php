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
                'full_name' => 'Иван Сергеевич Петров',
                'hire_date' => '2025-01-01',
                'extra_vacation_days' => 0,
                'position' => 'Ведущий разработчик',
                'salary' => 150000,
                'status' => 'active'
            ],
            // TC-02: Стаж более 6 месяцев, с дополнительными днями
            [
                'full_name' => 'Анна Михайловна Сидорова',
                'hire_date' => '2025-01-01',
                'extra_vacation_days' => 7,
                'position' => 'Руководитель отдела тестирования',
                'salary' => 180000,
                'status' => 'active'
            ],
            // TC-03: Стаж ровно 6 месяцев
            [
                'full_name' => 'Сергей Андреевич Козлов',
                'hire_date' => '2025-12-21',
                'extra_vacation_days' => 0,
                'position' => 'Бизнес-аналитик',
                'salary' => 130000,
                'status' => 'active'
            ],
            // TC-04: Стаж менее 6 месяцев (пропорциональный расчёт)
            [
                'full_name' => 'Мария Дмитриевна Иванова',
                'hire_date' => '2026-03-01',
                'extra_vacation_days' => 0,
                'position' => 'UI/UX дизайнер',
                'salary' => 110000,
                'status' => 'active'
            ],
            // TC-05: Стаж менее 6 месяцев с дополнительными днями
            [
                'full_name' => 'Дмитрий Алексеевич Смирнов',
                'hire_date' => '2026-03-01',
                'extra_vacation_days' => 7,
                'position' => 'Менеджер проектов',
                'salary' => 140000,
                'status' => 'active'
            ],
            // Дополнительные сотрудники
            [
                'full_name' => 'Елена Васильевна Кузнецова',
                'hire_date' => '2024-08-15',
                'extra_vacation_days' => 5,
                'position' => 'HR-специалист',
                'salary' => 95000,
                'status' => 'on_vacation'
            ],
            [
                'full_name' => 'Алексей Иванович Попов',
                'hire_date' => '2025-11-01',
                'extra_vacation_days' => 0,
                'position' => 'Системный администратор',
                'salary' => 120000,
                'status' => 'active'
            ],
            [
                'full_name' => 'Ольга Сергеевна Соколова',
                'hire_date' => '2025-03-15',
                'extra_vacation_days' => 3,
                'position' => 'Финансовый аналитик',
                'salary' => 135000,
                'status' => 'active'
            ],
            [
                'full_name' => 'Павел Николаевич Морозов',
                'hire_date' => '2025-07-10',
                'extra_vacation_days' => 0,
                'position' => 'DevOps инженер',
                'salary' => 160000,
                'status' => 'active'
            ],
            [
                'full_name' => 'Наталья Владимировна Волкова',
                'hire_date' => '2025-09-20',
                'extra_vacation_days' => 2,
                'position' => 'PR-менеджер',
                'salary' => 100000,
                'status' => 'on_vacation'
            ],
            [
                'full_name' => 'Андрей Борисович Лебедев',
                'hire_date' => '2026-01-15',
                'extra_vacation_days' => 0,
                'position' => 'Младший разработчик',
                'salary' => 85000,
                'status' => 'active'
            ],
            [
                'full_name' => 'Татьяна Дмитриевна Новикова',
                'hire_date' => '2024-12-01',
                'extra_vacation_days' => 10,
                'position' => 'Главный бухгалтер',
                'salary' => 170000,
                'status' => 'active'
            ],
            [
                'full_name' => 'Константин Петрович Медведев',
                'hire_date' => '2025-06-15',
                'extra_vacation_days' => 0,
                'position' => 'Архитектор баз данных',
                'salary' => 200000,
                'status' => 'dismissed'
            ],
            [
                'full_name' => 'Ирина Александровна Егорова',
                'hire_date' => '2025-08-05',
                'extra_vacation_days' => 4,
                'position' => 'Специалист по обучению',
                'salary' => 105000,
                'status' => 'active'
            ],
            [
                'full_name' => 'Владимир Станиславович Фёдоров',
                'hire_date' => '2026-02-10',
                'extra_vacation_days' => 0,
                'position' => 'Специалист по безопасности',
                'salary' => 125000,
                'status' => 'active'
            ],
        ];

        foreach ($testEmployees as $employee) {
            Employee::create($employee);
        }

        $this->command->info('✅ Создано ' . count($testEmployees) . ' сотрудников с русскими данными');
    }
}