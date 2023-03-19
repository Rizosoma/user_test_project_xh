<?php

declare(strict_types=1);

namespace UserTestProject\User;

use DateTime;

/**
 * class User
 */
class User
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var DateTime
     */
    private $created;
    /**
     * @var DateTime|null
     */
    private $deleted;
    /**
     * @var string|null
     */
    private $notes;

    /**
     * User constructor
     * @param string $name
     * @param string $email
     * @param string|null $notes
     * @param DateTime|null $created
     * @param DateTime|null $deleted
     * @param int|null $id
     */
    public function __construct(
        string $name,
        string $email,
        ?string $notes = null,
        ?DateTime $created = null,
        ?DateTime $deleted = null,
        ?int $id = null
    ) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setNotes($notes);
        $this->setCreated($created ?? new DateTime());
        $this->setDeleted($deleted);
        $this->setId($id);
    }

    /**
     * Return Id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set Id
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     * @param string $name
     * @return $this
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return email
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * SetEmail
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Return Created Date
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created): User
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDeleted(): ?DateTime
    {
        return $this->deleted;
    }

    /**
     * @param DateTime|null $deleted
     * @return $this
     */
    public function setDeleted(?DateTime $deleted): User
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     * @return $this
     */
    public function setNotes(?string $notes): User
    {
        $this->notes = $notes;
        return $this;
    }
}
