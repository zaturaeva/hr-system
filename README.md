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
