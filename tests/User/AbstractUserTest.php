<?php

declare(strict_types=1);

namespace Tests\User;

use PDO;
use PHPUnit\Framework\TestCase;
use UserTestProject\Database\DatabaseConnection;
use UserTestProject\Log\Logger;
use UserTestProject\Config;
use UserTestProject\User\UserRepository;
use UserTestProject\User\UserValidator;

/**
 * Abstract user test class
 */
abstract class AbstractUserTest extends TestCase
{
    /**
     * @var string[]
     */
    protected const DB_CONFIG = [
        'host'     => 'localhost',
        'dbname'   => 'postgres',
        'username' => 'postgres',
        'password' => 'postgres'
    ];

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository(
            $this->getTestDatabaseConnection(),
            new Logger(),
            new Config(__DIR__ . '/../../config/settings.php'),
            new UserValidator()
        );
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $databaseConnection = DatabaseConnection::getInstance(self::DB_CONFIG);
        $databaseConnection->rollBack();
        parent::tearDown();
    }

    /**
     * @return PDO
     */
    protected function getTestDatabaseConnection(): PDO
    {
        $databaseConnection = DatabaseConnection::getInstance(self::DB_CONFIG);
        $databaseConnection->beginTransaction();

        return $databaseConnection;
    }

    /**
     * @param PDO $databaseConnection
     */
    protected function tearDownDatabaseConnection(PDO $databaseConnection): void
    {
        $databaseConnection->rollBack();
    }
}