<?php

declare(strict_types=1);

namespace SF_Crypto\Request;

use SF_Crypto\Exceptions\CryptoException;

final class RequestEncrypt extends Crypto
{
    /**
     * RequestEncrypt constructor.
     * @param string|null $crypto_id Cryptographic key ID
     * @param string|null $crypto_key Cryptographic key
     * @param string|null $crypto_vector Cryptographic IV
     */
    public function __construct(?string $crypto_id = null, ?string $crypto_key = null, ?string $crypto_vector = null)
    {
        $this->setCryptoId($crypto_id ?? self::CRYPTO_ID);
        $this->setCryptoKey($crypto_key ?? self::CRYPTO_KEY);
        $this->setCryptoVector($crypto_vector ?? self::CRYPTO_VECTOR);
    }

    /**
     * Encrypts request
     * @param RequestData $RequestData Request data
     * @param bool $default_key Use default key (Yes/No)
     * @return string Encrypted request
     */
    public function encryptRequest(RequestData $RequestData, bool $default_key = false): string
    {
        try {
            $request = $this->packData($RequestData);
            $request = CryptoHelper::padRequestDecrypted($request);

            $request_encrypted =
                base64_encode(openssl_encrypt(
                    $request,
                    self::CRYPTO_METHOD,
                    $this->getCurrentKey((!$default_key) ? $this->getCryptoKey() : self::CRYPTO_KEY),
                    OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, self::CRYPTO_VECTOR
                ));
            $request_encrypted = CryptoHelper::prepareRequest($request_encrypted, true);

            return $this->getCryptoId().$request_encrypted;
        } catch (CryptoException $exception) {
            exit($exception);
        }
    }
}