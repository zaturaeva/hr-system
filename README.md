<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# HR-Система 

### Целевая аудитория
- Сотрудники отдела кадров
- Бухгалтеры
- Директор организации
- Руководители подразделений

### Основные возможности

#### Управление сотрудниками
- Приём на работу
- Редактирование данных
- Просмотр карточки сотрудника
- Увольнение с указанием причины
- Автоматический расчёт рабочего стажа

#### Управление отпусками
- Оформление заявок на отпуск
- Автоматический расчёт доступных дней
- История отпусков
- Пропорциональный расчёт при стаже менее 6 месяцев

#### Аналитика
- Общая статистика по сотрудникам
- Средний отпуск по компании
- Фонд заработной платы
- Быстрые действия

## Технологии

- **Laravel**  10.x - PHP-фреймворк
- **PHP** 8.1+ - Язык программирования 
- **MySQL** 5.7+ - База данных 
- **SQLite** 3.x - База данных (для разработки) 
- **Bootstrap** 5.3 - CSS-фреймворк 
- **Font Awesome** 6.4 - Иконки 
- **PHPUnit** 10.x - Тестирование 

## Установка

### Системные требования

- PHP >= 8.1
- Composer >= 2.x
- MySQL >= 5.7 или SQLite 3.x
- Node.js >= 18.x 

### Пошаговая установка

#### 1. Клонирование репозитория

```bash
git clone https://github.com/your-username/hr-system.git
cd hr-system
```

#### 2. Установка зависимостей

```bash
composer install
```

#### 3. Настройка окружения

```bash
# Создайте файл .env
cp .env.example .env

# Настройте подключение к БД (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_system
DB_USERNAME=root
DB_PASSWORD=

# Или используйте SQLite
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

#### 4. Генерация ключа

```bash
php artisan key:generate
```

#### 5. Создание базы данных

**Для MySQL:**
```sql
CREATE DATABASE hr_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Для SQLite:**
```bash
touch database/database.sqlite
```

#### 6. Запуск миграций и сидеров

```bash
php artisan migrate
php artisan db:seed
```

#### 7. Запуск сервера

```bash
php artisan serve
```

Приложение будет доступно по адресу: `http://127.0.0.1:8000`

##  Структура проекта

```
hr-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── EmployeeController.php     
│   │   │   ├── VacationController.php     
│   │   │   └── ReportController.php        
│   │   └── Requests/
│   │       └── EmployeeRequest.php         
│   ├── Models/
│   │   └── Employee.php                    
│   └── Exceptions/
│       └── ValidationError.php             
├── database/
│   ├── migrations/
│   │   └── create_employees_table.php      
│   ├── seeders/
│   │   └── EmployeeSeeder.php              
│   └── factories/
│       └── EmployeeFactory.php           
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                   
│   ├── employees/
│   │   ├── index.blade.php                 
│   │   ├── create.blade.php                
│   │   ├── show.blade.php                  
│   │   └── edit.blade.php                 
│   ├── vacations/
│   │   ├── index.blade.php                
│   │   ├── create.blade.php                
│   │   └── show.blade.php                 
│   └── reports/
│       └── index.blade.php                
├── routes/
│   └── web.php                           
├── tests/
│   └── Unit/
│       └── VacationTest.php                
├── public/
│   └── css/
│       └── custom.css                      
├── composer.json
├── package.json
└── README.md
```

## Тестирование

### Запуск всех тестов

```bash
php artisan test
```

### Запуск конкретного теста

```bash
php artisan test --filter VacationTest
```

### Тестовые сценарии

- TC-01 - Стаж > 6 мес, без доп. дней ( 28.0 дней )
- TC-02 - Стаж > 6 мес, +7 дней ( 35.0 дней )
- TC-03 - Стаж ровно 6 мес ( 28.0 дней )
- TC-04 - Стаж < 6 мес ( 9.3 дней )
- TC-05 - Стаж < 6 мес, +7 дней ( 11.7 дней )
- TC-06 - Дата приёма в будущем ( Ошибка ValidationError )
- TC-07 - Отрицательные доп. дни ( Ошибка ValidationError )

## API Маршруты

- GET `/` - Перенаправление на сотрудников 
- GET `/employees` - employees.index - Список сотрудников 
- GET `/employees/create` - employees.create - Форма приёма 
- POST `/employees` - employees.store - Сохранение сотрудника 
- GET `/employees/{id}` - employees.show - Карточка сотрудника 
- GET `/employees/{id}/edit` - employees.edit - Редактирование 
- PUT `/employees/{id}` - employees.update - Обновление 
- POST `/employees/{id}/dismiss` - employees.dismiss - Увольнение 
- GET `/employees/{id}/vacation` - employees.vacation - Форма отпуска 
- POST `/employees/{id}/vacation` - employees.store-vacation - Оформление отпуска 
- GET `/vacations` - vacations.index - Список отпусков 
- GET `/vacations/create` - vacations.create - Форма отпуска 
- POST `/vacations` - vacations.store - Сохранение отпуска 
- GET `/vacations/{id}` - vacations.show - Детали отпуска 
- GET `/reports` - reports.index - Аналитика

## Конфигурация

### Основные настройки (.env)

```env
APP_NAME=HR-System
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# База данных (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_system
DB_USERNAME=root
DB_PASSWORD=

# Или SQLite
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

## Автор

**GitHub:** [@zaturaeva](https://github.com/zaturaeva)
## 📄 Файл README.md в формате Markdown

Вы можете скопировать этот код и сохранить его как `README.md` в корне вашего проекта.
>>>>>>> ad4563b250d1c08bf53215f744b8bc97e1b26c11
