<?php

declare(strict_types=1);

namespace UserTestProject\User;

use DateTime;
use InvalidArgumentException;
use PDO;
use UserTestProject\Config;
use Psr\Log\LoggerInterface;

/**
 * User Repository class
 */
class UserRepository implements UserRepositoryInterface
{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;


    /**
     * UserRepository constructor
     *
     * @param PDO             $pdo
     * @param LoggerInterface $logger
     * @param Config          $config
     */
    public function __construct(PDO $pdo, LoggerInterface $logger, Config $config)
    {
        $this->pdo    = $pdo;
        $this->logger = $logger;
        $this->config = $config;
    }


    /**
     * Create user
     *
     * @param  User $user
     * @return User
     */
    public function createUser(User $user): User
    {
        $this->validateUser($user);
        $sql = 'INSERT INTO users (name, email, created, deleted, notes) VALUES (:name, :email, :created, :deleted, :notes) RETURNING id';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(
            [
                ':name'    => $user->getName(),
                ':email'   => $user->getEmail(),
                ':created' => $user->getCreated()->format('Y-m-d H:i:s'),
                ':deleted' => $user->getDeleted() ? $user->getDeleted()->format('Y-m-d H:i:s') : null,
                ':notes'   => $user->getNotes(),
            ]
        );

        $id = $statement->fetch(PDO::FETCH_ASSOC)['id'];
        $user->setId($id);

        $this->logger->info(
            'User created',
            [
                'id'    => $user->getId(),
                'name'  => $user->getName(),
                'email' => $user->getEmail(),
            ]
        );

        return $user;
    }


    /**
     * Update user
     *
     * @param  User $user
     * @return User
     */
    public function updateUser(User $user): User
    {
        $this->validateUser($user);
        $sql       = 'UPDATE users SET name = :name, email = :email, deleted = :deleted, notes = :notes WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(
            [
                ':id'      => $user->getId(),
                ':name'    => $user->getName(),
                ':email'   => $user->getEmail(),
                ':deleted' => $user->getDeleted() ? $user->getDeleted()->format('Y-m-d H:i:s') : null,
                ':notes'   => $user->getNotes(),
            ]
        );

        $this->logger->info(
            'User updated',
            [
                'id'    => $user->getId(),
                'name'  => $user->getName(),
                'email' => $user->getEmail(),
            ]
        );

        return $user;
    }


    /**
     * Find user by id
     *
     * @param  integer $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        $sql       = 'SELECT * FROM users WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':id' => $id]);
        $user_data = $statement->fetch(PDO::FETCH_ASSOC);

        return $user_data ? $this->createUserFromData($user_data) : null;
    }

    /**
     * Find user by email
     *
     * @param  string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        $sql       = 'SELECT * FROM users WHERE email = :email';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':email' => $email]);
        $user_data = $statement->fetch(PDO::FETCH_ASSOC);

        return $user_data ? $this->createUserFromData($user_data) : null;
    }


    /**
     * Find user by name
     *
     * @param  string $name
     * @return User|null
     */
    public function findByName(string $name): ?User
    {
        $sql       = 'SELECT * FROM users WHERE name = :name';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':name' => $name]);
        $user_data = $statement->fetch(PDO::FETCH_ASSOC);

        return $user_data ? $this->createUserFromData($user_data) : null;
    }


    /**
     * Find user by email or name
     *
     * @param  string       $name
     * @param  integer|null $excludeUserId
     * @return boolean
     */
    public function isNameUnique(string $name, ?int $excludeUserId = null): bool
    {
        $sql    = 'SELECT * FROM users WHERE (name = :name)';
        $params = ['name' => $name];

        if ($excludeUserId !== null) {
            $sql                    .= ' AND id != :excludeUserId';
            $params['excludeUserId'] = $excludeUserId;
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return empty($data);
    }


    /**
     * Find user by email or name
     *
     * @param  string       $email
     * @param  integer|null $excludeUserId
     * @return boolean
     */
    public function isEmailUnique(string $email, ?int $excludeUserId = null): bool
    {
        $sql    = 'SELECT * FROM users WHERE (email = :email)';
        $params = ['email' => $email];

        if ($excludeUserId !== null) {
            $sql                    .= ' AND id != :excludeUserId';
            $params['excludeUserId'] = $excludeUserId;
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return empty($data);
    }


    /**
     * Return user from data array
     *
     * @param  array $data
     * @return User
     */
    private function createUserFromData(array $data): User
    {
        $created = DateTime::createFromFormat('Y-m-d H:i:s', $data['created']);
        $deleted = $data['deleted'] ? DateTime::createFromFormat('Y-m-d H:i:s', $data['deleted']) : null;

        return new User($data['name'], $data['email'], $data['notes'], $created, $deleted, $data['id']);
    }

    /**
     * Validate user
     *
     * @param  User $user
     * @return void
     */
    private function validateUser(User $user): void
    {
        $restrictedNames   = $this->config->get('restrictedNames');
        $restrictedDomains = $this->config->get('restrictedDomains');
        $errors            = (new UserValidator($this, $restrictedNames, $restrictedDomains))->validate($user);
        if (!empty($errors)) {
            throw new InvalidArgumentException(implode("\n", $errors));
        }
    }
}
