<?php

declare(strict_types=1);

namespace SF_Crypto\Request;

use SF_Crypto\Exceptions\CryptoException;

class RequestData
{
    /** @var string Default session */
    private const SESSION = '00000000000000000000000000000000';

    /** @var string Session */
    private string $session;
    /** @var string Action */
    private string $action;
    /** @var array|null Action parameters */
    private ?array $parameters;

    /**
     * RequestData constructor.
     * @param string $session Session
     * @param string $action Action
     * @param array|null $parameters Action parameters
     */
    public function __construct(string $session, string $action, ?array $parameters)
    {
        $this->setSession($session);
        $this->setAction($action);
        $this->setParameters($parameters);
    }

    public function getSession(): string
    {
        return $this->session;
    }

    public function setSession(string $session): void
    {
        $this->validSession($session);
        $this->session = $session;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    /**
     * @param array|null $parameters
     */
    public function setParameters(?array $parameters): void
    {
        $this->parameters = $parameters ?? [];
    }

    /**
     * Checks if the session is valid
     * @param string $session Session
     */
    private function validSession(string $session): void
    {
        try {
            if (strlen($session) !== 32) {
                throw new CryptoException('Session should contain 32 characters', 0);
            }
        } catch (CryptoException $exception) {
            echo($exception);
        }
    }
}