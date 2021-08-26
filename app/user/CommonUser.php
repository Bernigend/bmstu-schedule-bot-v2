<?php

namespace app\user;

use app\command\handlers\RegistrationCommandHandler;
use app\core\Application;
use app\user\exception\RegisterCommonUserException;

class CommonUser
{
    /** @var string */
    protected const DEFAULT_EXPECTED_INPUT = RegistrationCommandHandler::EXPECTED_INPUT_REGISTRATION;

    /** @var int внутренний ID пользователя */
    protected int $id;

    /** @var string внешний ID пользователя */
    protected string $externalId;

    /** @var string к чему принадлежит пользователь (например, вк или телеграм) */
    protected string $namespace;

    /** @var string тип ожидаемого ввода от пользователя */
    protected string $expectedInput;

    /** @var string ID текущей группы */
    protected string $currentGroupId;

    /**
     * @param int $id
     * @param string $externalId
     * @param string $namespace
     * @param string $expectedInput
     * @param string $currentGroupId
     */
    public function __construct(
        int $id,
        string $externalId,
        string $namespace,
        string $expectedInput,
        string $currentGroupId
    )
    {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->namespace = $namespace;
        $this->expectedInput = $expectedInput;
        $this->currentGroupId = $currentGroupId;
    }

    /**
     * Ищет пользователя по внешнему ID.
     *
     * @param string $externalId
     * @param string $namespace
     *
     * @return static|null
     * @throws \app\core\database\exception\SqlException
     */
    public static function findByExternalId(string $externalId, string $namespace): ?self
    {
        $user = Application::getInstance()->getDatabase()->fetchRow(
            "SELECT * FROM common_users WHERE namespace = ? AND external_id = ?",
            [$namespace, $externalId]
        );

        if (!$user) {
            return null;
        }

        return new static(
            (int)$user['id'],
            $user['external_id'] ?: '',
            $user['namespace'] ?: '',
            $user['expected_input'] ?: '',
            $user['current_group_id'] ?: '',
        );
    }

    /**
     * Регистрирует пользователя.
     *
     * @param string $externalId
     * @param string $namespace
     *
     * @return static
     * @throws \app\core\database\exception\SqlException
     * @throws \app\user\exception\RegisterCommonUserException
     */
    public static function register(string $externalId, string $namespace): self
    {
        $database = Application::getInstance()->getDatabase();

        $insertResult = $database->query(
            "INSERT INTO common_users (external_id, namespace, expected_input) VALUES (?,?,?)",
            [$externalId, $namespace, static::DEFAULT_EXPECTED_INPUT]
        );

        if (!$insertResult) {
            throw new RegisterCommonUserException("Cannot register user [{$externalId}, {$namespace}]: {$database->getLastError()}");
        }

        return new self(
            (int)$database->getLastInsertId(),
            $externalId,
            $namespace,
            static::DEFAULT_EXPECTED_INPUT,
            ''
        );
    }

    /**
     * Сохраняет данные пользователя в БД.
     *
     * @throws \app\core\database\exception\SqlException
     */
    public function save(): void
    {
        Application::getInstance()->getDatabase()->query(
            "UPDATE common_users SET external_id = ?, namespace = ?, expected_input = ?, current_group_id = ? WHERE id = ?",
            [$this->externalId, $this->namespace, $this->expectedInput, $this->currentGroupId, $this->id]
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return CommonUser
     */
    public function setId(int $id): CommonUser
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     *
     * @return CommonUser
     */
    public function setExternalId(string $externalId): CommonUser
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     *
     * @return CommonUser
     */
    public function setNamespace(string $namespace): CommonUser
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpectedInput(): string
    {
        return $this->expectedInput;
    }

    /**
     * @param string $expectedInput
     *
     * @return CommonUser
     */
    public function setExpectedInput(string $expectedInput): CommonUser
    {
        $this->expectedInput = $expectedInput;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentGroupId(): string
    {
        return $this->currentGroupId;
    }

    /**
     * @param string $currentGroupId
     *
     * @return CommonUser
     */
    public function setCurrentGroupId(string $currentGroupId): CommonUser
    {
        $this->currentGroupId = $currentGroupId;
        return $this;
    }
}