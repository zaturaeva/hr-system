<?php
// database/factories/EmployeeFactory.php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    // Русские имена для реалистичных данных
    private $rusNames = [
        'Александр', 'Дмитрий', 'Сергей', 'Андрей', 'Алексей',
        'Иван', 'Михаил', 'Владимир', 'Николай', 'Павел',
        'Артём', 'Максим', 'Егор', 'Роман', 'Даниил',
        'Елена', 'Мария', 'Анна', 'Ольга', 'Татьяна',
        'Наталья', 'Ирина', 'Светлана', 'Ксения', 'Екатерина'
    ];

    private $rusSurnames = [
        'Иванов', 'Петров', 'Сидоров', 'Козлов', 'Смирнов',
        'Кузнецов', 'Попов', 'Соколов', 'Морозов', 'Волков',
        'Лебедев', 'Новиков', 'Медведев', 'Егоров', 'Фёдоров',
        'Васильев', 'Зайцев', 'Павлов', 'Семёнов', 'Голубев'
    ];

    private $rusPositions = [
        'Разработчик', 'Ведущий разработчик', 'Тестировщик',
        'Бизнес-аналитик', 'Системный администратор', 'DevOps инженер',
        'UI/UX дизайнер', 'Менеджер проектов', 'HR-специалист',
        'Финансовый аналитик', 'Главный бухгалтер', 'PR-менеджер',
        'Архитектор баз данных', 'Специалист по обучению',
        'Специалист по безопасности', 'Руководитель отдела'
    ];

    public function definition()
    {
        return [
            'full_name' => $this->generateRussianName(),
            'hire_date' => $this->faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'extra_vacation_days' => $this->faker->numberBetween(0, 14),
            'position' => $this->faker->randomElement($this->rusPositions),
            'salary' => $this->faker->numberBetween(60000, 250000),
            'status' => $this->faker->randomElement(['active', 'on_vacation']),
        ];
    }

    private function generateRussianName(): string
    {
        $firstName = $this->faker->randomElement($this->rusNames);
        $lastName = $this->faker->randomElement($this->rusSurnames);
        $patronymic = $this->generatePatronymic($firstName);
        
        return "{$lastName} {$firstName} {$patronymic}";
    }

    private function generatePatronymic($firstName): string
    {
        $malePatronymics = [
            'Александрович', 'Дмитриевич', 'Сергеевич', 'Андреевич', 'Алексеевич',
            'Иванович', 'Михайлович', 'Владимирович', 'Николаевич', 'Павлович',
            'Артёмович', 'Максимович', 'Егорович', 'Романович', 'Даниилович'
        ];

        $femalePatronymics = [
            'Александровна', 'Дмитриевна', 'Сергеевна', 'Андреевна', 'Алексеевна',
            'Ивановна', 'Михайловна', 'Владимировна', 'Николаевна', 'Павловна',
            'Артёмовна', 'Максимовна', 'Егоровна', 'Романовна', 'Данииловна'
        ];

        $maleNames = ['Александр', 'Дмитрий', 'Сергей', 'Андрей', 'Алексей', 
                      'Иван', 'Михаил', 'Владимир', 'Николай', 'Павел',
                      'Артём', 'Максим', 'Егор', 'Роман', 'Даниил'];

        $femaleNames = ['Елена', 'Мария', 'Анна', 'Ольга', 'Татьяна',
                        'Наталья', 'Ирина', 'Светлана', 'Ксения', 'Екатерина'];

        if (in_array($firstName, $maleNames)) {
            return $this->faker->randomElement($malePatronymics);
        } else {
            return $this->faker->randomElement($femalePatronymics);
        }
    }
}