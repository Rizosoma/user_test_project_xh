<?php

declare(strict_types=1);

namespace Tests\User;

use UserTestProject\User\User;

/**
 * Class UserRepositoryTest
 */
class UserRepositoryTest extends AbstractUserTest
{
    /**
     * @return void
     */
    public function testCreateUser(): void
    {
        $name = 'testuser123';
        $email = 'testuser123@example.com';
        $user = new User($name, $email);

        $createdUser = $this->userRepository->createUser($user);

        $this->assertInstanceOf(User::class, $createdUser);
        $this->assertSame($name, $createdUser->getName());
        $this->assertSame($email, $createdUser->getEmail());
    }

    /**
     * @return void
     */
    public function testFindUserById(): void
    {
        $name = 'testuser456';
        $email = 'testuser456@example.com';
        $user = new User($name, $email);
        $createdUser = $this->userRepository->createUser($user);

        $foundUser = $this->userRepository->findById($user->getId());

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertSame($user->getId(), $foundUser->getId());
        $this->assertSame($name, $foundUser->getName());
        $this->assertSame($email, $foundUser->getEmail());
    }

    /**
     * @return void
     */
    public function testUpdateUser(): void
    {
        $name = 'testuser789';
        $email = 'testuser789@example.com';
        $user = new User($name, $email);

        $createdUser = $this->userRepository->createUser($user);
        $updatedName = 'updatedtestuser789';
        $updatedEmail = 'updatedtestuser789@example.com';

        $createdUser->setName($updatedName);
        $createdUser->setEmail($updatedEmail);
        $updatedUser = $this->userRepository->updateUser($createdUser);

        $this->assertInstanceOf(User::class, $updatedUser);
        $this->assertSame($createdUser->getId(), $updatedUser->getId());
        $this->assertSame($updatedName, $updatedUser->getName());
        $this->assertSame($updatedEmail, $updatedUser->getEmail());
    }
}