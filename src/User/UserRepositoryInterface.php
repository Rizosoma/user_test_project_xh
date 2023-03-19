<?php

declare(strict_types=1);

namespace UserTestProject\User;

/**
 * UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * Create user
     *
     * @param  User $user
     * @return User
     */
    public function createUser(User $user): User;


    /**
     * Update user
     *
     * @param  User $user
     * @return User
     */
    public function updateUser(User $user): User;


    /**
     * Find user by ID
     *
     * @param  integer $id
     * @return User|null
     */
    public function findById(int $id): ?User;


    /**
     * Find user by email
     *
     * @param  string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;


    /**
     * Find user by name
     *
     * @param  string $name
     * @return User|null
     */
    public function findByName(string $name): ?User;
}
