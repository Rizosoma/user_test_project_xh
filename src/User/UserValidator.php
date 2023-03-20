<?php

declare(strict_types=1);

namespace UserTestProject\User;

use DateTime;

/**
 * UserValidator class
 */
class UserValidator implements UserValidatorInterface
{

    /**
     * @var array
     */
    private $restrictedWords;

    /**
     * @var array
     */
    private $restrictedDomains;
    /**
     * @var int
     */
    private const NAME_MIN_LENGTH = 8;
    /**
     * @var string
     */
    private const NAME_PREG_PATTERN = '/^[a-z0-9]+$/i';


    /**
     * UserValidator constructor
     *
     * @param array<string>           $restrictedWords
     * @param array<string>           $restrictedDomains
     */
    public function __construct(
        array $restrictedWords = [],
        array $restrictedDomains = []
    ) {
        $this->restrictedWords   = $restrictedWords;
        $this->restrictedDomains = $restrictedDomains;
    }


    /**
     * Validate user data
     *
     * @param  User $user
     * @return array
     */
    public function validate(User $user): array
    {
        $errors = [];

        if (!$this->validateName($user->getName())) {
            $errors[] = 'Invalid name';
        }

        if (!$this->validateEmail($user->getEmail())) {
            $errors[] = 'Invalid email';
        }

        if ($user->getDeleted() !== null && !$this->validateDeletedDate($user->getCreated(), $user->getDeleted())) {
            $errors[] = 'Invalid deleted date';
        }

        return $errors;
    }


    /**
     * Validate name
     *
     * @param  string $name
     * @return boolean
     */
    private function validateName(string $name): bool
    {
        if (strlen($name) < self::NAME_MIN_LENGTH || !preg_match(self::NAME_PREG_PATTERN, $name)) {
            return false;
        }

        foreach ($this->restrictedWords as $word) {
            if (strpos($name, $word) !== false) {
                return false;
            }
        }

        return true;
    }


    /**
     * Validate email
     *
     * @param  string $email
     * @return boolean
     */
    private function validateEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = substr(strrchr($email, '@'), 1);
        if (in_array($domain, $this->restrictedDomains, true)) {
            return false;
        }

        return true;
    }


    /**
     * Validate deleted date
     *
     * @param  DateTime $created
     * @param  DateTime $deleted
     * @return boolean
     */
    private function validateDeletedDate(DateTime $created, DateTime $deleted): bool
    {
        return $deleted >= $created;
    }
}
