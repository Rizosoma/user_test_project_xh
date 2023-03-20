<?php

declare(strict_types=1);

namespace Tests\User;

use DateTime;
use UserTestProject\User\User;
use UserTestProject\User\UserValidator;

/**
 * Class UserValidatorTest
 */
class UserValidatorTest extends AbstractUserTest
{
    /**
     * @var UserValidator
     */
    private $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->validator = new UserValidator();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        return;
    }

    /**
     * @return void
     */
    public function testValidUser(): void
    {
        $name = 'testuser789';
        $email = 'testuser789@example.com';
        $user = new User($name, $email);

        $result = $this->validator->validate($user);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testInvalidName(): void
    {
        $name = 'inv@lid';
        $email = 'invalidname@example.com';
        $user = new User($name, $email);

        $result = $this->validator->validate($user);

        $this->assertNotEmpty($result);
    }

    /**
     * @return void
     */
    public function testInvalidEmail(): void
    {
        $name = 'testuser000';
        $email = 'invalidemail@.com';
        $user = new User($name, $email);

        $result = $this->validator->validate($user);

        $this->assertNotEmpty($result);
    }

    /**
     * @return void
     */
    public function testInvalidDeletedDate(): void
    {
        $name = 'testuser456';
        $email = 'testuser456@example.com';
        $created = new DateTime('2023-01-01');
        $deleted = new DateTime('2022-12-31');
        $user = new User($name, $email, '', $created, $deleted);

        $result = $this->validator->validate($user);

        $this->assertNotEmpty($result);
    }
}
