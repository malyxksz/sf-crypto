<?php

declare(strict_types=1);

namespace SF_Crypto\Request;

use SF_Crypto\Exceptions\CryptoException;

abstract class Crypto
{
    /** @var string Cryptographic default method */
    protected const CRYPTO_METHOD = 'AES-128-CBC';
    /** @var string Cryptographic default prefix */
    protected const CRYPTO_ID = '0-00000000000000';
    /** @var string Cryptographic default prefix without AES */
    protected const CRYPTO_ID_NO_AES = '0-000000000000-0';
    /** @var string Cryptographic default key */
    protected const CRYPTO_KEY = '[_/$VV&*Qg&)r?~g';
    /** @var string Cryptographic default IV */
    protected const CRYPTO_VECTOR = 'jXT#/vz]3]5X7Jl\\';

    /** @var string Request separator (session|action) */
    protected const SEPARATOR = '|';
    /** @var string Request action separator (action:parameters) */
    protected const ACTION_SEPARATOR = ':';
    /** @var string Request action parameters separator (parameter/parameter) */
    protected const PARAMETERS_SEPARATOR = '/';

    /** @var string Cryptographic key ID */
    private string $crypto_id;
    /** @var string Cryptographic key */
    private string $crypto_key;
    /** @var string Cryptographic IV */
    private string $crypto_vector;

    public function getCryptoId(): string
    {
        return $this->crypto_id;
    }

    public function setCryptoId(string $crypto_id): void
    {
        $this->crypto_id = $crypto_id;
    }

    public function getCryptoKey(): string
    {
        return $this->crypto_key;
    }

    public function setCryptoKey(string $crypto_key): void
    {
        $this->crypto_key = $crypto_key;
    }

    public function getCryptoVector(): string
    {
        return $this->crypto_vector;
    }

    public function setCryptoVector(string $crypto_vector): void
    {
        $this->crypto_vector = $crypto_vector;
    }

    /**
     * Returns the currently used cryptographic key (default or set)
     * @param string $crypto_id Cryptographic key ID
     * @return string Cryptographic key
     */
    public function getCurrentKey(string $crypto_id): string
    {
        return ($crypto_id === self::CRYPTO_ID) ? self::CRYPTO_KEY : $this->getCryptoKey();
    }

    /**
     * Returns request data as RequestData class
     * @param string $data Request data as string
     * @return RequestData Request data
     */
    protected function unpackData(string $data): RequestData
    {
        try {
            $data_handler = explode(self::SEPARATOR, $data);
            if (!isset($data_handler[1])) {
                throw new CryptoException('Data format is invalid', 1);
            }

            $data_action_handler = explode(self::ACTION_SEPARATOR, $data_handler[1]);
            if (!isset($data_action_handler[1])) {
                throw new CryptoException('Data format is invalid', 1);
            }

            $data_parameters_handler = explode(self::PARAMETERS_SEPARATOR, $data_action_handler[1]);

            return new RequestData($data_handler[0], $data_action_handler[0], $data_parameters_handler ?? null);
        } catch (CryptoException $exception) {
            exit($exception);
        }
    }

    /**
     * Returns request data as string
     * @param RequestData $RequestData Request data
     * @return string Request data as a string
     */
    protected function packData(RequestData $RequestData): string
    {
        return
            $RequestData->getSession().self::SEPARATOR.
            $RequestData->getAction().self::ACTION_SEPARATOR.
            implode(self::PARAMETERS_SEPARATOR, $RequestData->getParameters());
    }
}