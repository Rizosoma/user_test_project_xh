# User Test Project

Проект тестового задания для создания, редактирования и тестирования пользовательских данных с использованием PHP и PHPUnit.

## Требования

- PHP 7.3 или выше
- PHPUnit 9.5 или выше
- Composer

## Установка

1. Клонируйте репозиторий:
   git clone git clone https://github.com/Rizosoma/user_test_project_xh.git
2. Установите зависимости с помощью Composer:
   composer install

## Использование

1. Запустите тесты с помощью PHPUnit:
   ./vendor/bin/phpunit
2. Запустите скрипт testCreateUser.php из директории scripts.

## Структура проекта (основное)

- `src/`: Исходный код проекта, содержащий основные классы и интерфейсы.
    - `User/`: Классы и интерфейсы, связанные с пользователями.
        - `User.php`: Основной класс пользователя.
        - `UserRepository.php`: Репозиторий для работы с пользователями.
        - `UserValidator.php`: Валидатор пользовательских данных.
    - `Database/`: Классы, связанные с подключением к базе данных.
        - `DatabaseConnection.php`: Класс для работы с подключением к базе данных.
    - `Log/`: Классы, связанные с логированием.
        - `Logger.php`: Класс для работы с логированием.
- `tests/`: Тесты для проекта.
    - `User/`: Тесты для классов, связанных с пользователями.
        - `UserRepositoryTest.php`: Тесты для класса `UserRepository`.
        - `UserValidatorTest.php`: Тесты для класса `UserValidator`.
- `composer.json`: Файл зависимостей

## Примеры использования
1. Результат выполнения тестов:
PHPUnit 9.6.5 by Sebastian Bergmann and contributors.  
Runtime:       PHP 7.3.33  
Configuration: /UserTestProject/phpunit.xml  
.......  7 / 7 (100%)  
Time: 00:00.115, Memory: 6.00 MB  
OK (7 tests, 15 assertions)
2. Результат запуска скрипта testCreateUser.php:  
   Пользователь создан:  
   ID: 44  
   Имя: testuser123  
   Email: testuser123@example.com  
3. Запись в логах:  
   [2023-03-19T18:29:23.832272+00:00] user_test_project.INFO: User created {"id":44,"name":"testuser123","email":"testuser123@example.com"} []
4. Запуск скрипта с параметрами: неуникальное имя.  
   --name=testuser500 --email=testuser500@mail.com  
   PHP Fatal error:  Uncaught InvalidArgumentException: Name is already taken
5. Запуск скрипта с параметрами: короткое имя и неуникальный email.  
   php scripts/testCreateUser.php --name=testus --email=testuser500@mail.com  
   PHP Fatal error:  Uncaught InvalidArgumentException: Invalid name  
   Email is already taken in /Users/kara/PhpstormProjects/UserTestProject/src/User/UserRepository.php:249
6. Запуск скрипта с параметрами: некорректный email.  
   php scripts/testCreateUser.php --name=testuser600 --email=testuse@r500@mail.com  
   PHP Fatal error:  Uncaught InvalidArgumentException: Invalid email
7. Запуск скрипта с параметрами: имя содержит запрещённое значение.  
   php scripts/testCreateUser.php --name=testuser600admin --email=testuser600@mail.com  
   PHP Fatal error:  Uncaught InvalidArgumentException: Invalid name




