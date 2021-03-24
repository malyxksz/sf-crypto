<?php

declare(strict_types=1);

namespace SF_Crypto\Request;

use SF_Crypto\Exceptions\CryptoException;

final class RequestDecrypt extends Crypto
{
    /**
     * RequestDecrypt constructor.
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
     * Decrypts request
     * @param string $request Request
     * @return RequestData Decrypted request data
     */
    public function decryptRequest(string $request): RequestData
    {
        try {
            $crypto_id = substr($request, 0, 16);

            if (strlen($crypto_id) !== 16) {
                throw new CryptoException('Crypto ID must be 16 characters', 1);
            }

            $request = substr($request, 16);
            $request = CryptoHelper::prepareRequest($request);
            $request = CryptoHelper::padRequestEncrypted($request);
            $request = base64_decode($request);

            $request_decrypted = rtrim(
                openssl_decrypt(
                    $request,
                    self::CRYPTO_METHOD,
                    $this->getCurrentKey($crypto_id),
                    OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->getCryptoVector()
                ), '\0'
            );

            if (!mb_detect_encoding($request_decrypted, 'UTF-8', true)) {
                throw new CryptoException('Decrypt failed', 1);
            }

            return $this->unpackData($request_decrypted);
        } catch (CryptoException $exception) {
            exit($exception);
        }
    }
}