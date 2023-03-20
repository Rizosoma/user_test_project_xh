<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Database/DatabaseConnection.php';
require_once __DIR__ . '/../src/User/User.php';
require_once __DIR__ . '/../src/User/UserRepository.php';
require_once __DIR__ . '/../src/User/UserValidator.php';
require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Log/Logger.php';

use UserTestProject\Database\DatabaseConnection;
use UserTestProject\User\User;
use UserTestProject\User\UserRepository;
use UserTestProject\Log\Logger;
use UserTestProject\Config;

$options = getopt('', ['name:', 'email:']);
$name = empty($options['name'])? '' : $options['name'];
$email = empty($options['email'])? '' : $options['email'];

$databaseConnection = DatabaseConnection::getInstance();
$userRepository = new UserRepository(
    $databaseConnection,
    new Logger(),
    new Config(__DIR__.'/../config/settings.php')
);

$user = new User($name, $email);
$createdUser = $userRepository->createUser($user);
echo 'Пользователь создан: ' . PHP_EOL;
echo 'ID: ' . $createdUser->getId() . PHP_EOL;
echo 'Имя: ' . $createdUser->getName() . PHP_EOL;
echo 'Email: ' . $createdUser->getEmail() . PHP_EOL;
