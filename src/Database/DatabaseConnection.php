<?php

declare(strict_types=1);

namespace UserTestProject\Database;

use PDO;
use PDOException;
use RuntimeException;
use Dotenv\Dotenv;

/**
 * Class DatabaseConnection
 */
class DatabaseConnection
{
    /**
     * @var PDO|null
     */
    private static $instance = null;

    /**
     * Get instance
     * @param array|null $config
     * @return PDO
     */
    public static function getInstance(?array $config = null): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::createConnection($config);
        }

        return self::$instance;
    }

    /**
     * Create connection
     * @param array|null $config
     * @return PDO
     */
    private static function createConnection(?array $config = null): PDO
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $host = $config['host'] ?? $_ENV['DB_HOST'];
        $dbname = $config['dbname'] ?? $_ENV['DB_NAME'];
        $username = $config['username'] ?? $_ENV['DB_USER'];
        $password = $config['password'] ?? $_ENV['DB_PASS'];

        try {
            $dsn = "pgsql:host=$host;dbname=$dbname";
            $connection = new PDO($dsn, $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $connection;
        } catch (PDOException $e) {
            throw new RuntimeException('Error establishing database connection: ' . $e->getMessage());
        }
    }
}
