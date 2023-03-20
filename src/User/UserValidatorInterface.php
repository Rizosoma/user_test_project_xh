<?php

declare(strict_types=1);

namespace UserTestProject\User;

/**
 * Interface ValidatorInterface
 */
interface UserValidatorInterface
{
    /**
     * Validate user data
     *
     * @param  User $user
     * @return array
     */
    public function validate(User $user): array;
}