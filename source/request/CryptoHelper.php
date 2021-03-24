<?php

declare(strict_types=1);

namespace SF_Crypto\Request;

final class CryptoHelper
{
    /**
     * Completes encrypted request by adding the required characters (=)
     * @param string $request Request
     * @return string Converted request
     */
    public static function padRequestEncrypted(string $request): string
    {
        return str_pad($request, strlen($request) + (4 - strlen($request) % 4), '=', STR_PAD_RIGHT);
    }

    /**
     * Completes decrypted request by adding the required characters (|)
     * @param string $request Request
     * @return string Converted request
     */
    public static function padRequestDecrypted(string $request): string
    {
        return str_pad($request, strlen($request) + (16 - strlen($request) % 16), '|', STR_PAD_RIGHT);
    }

    /**
     * Prepares (converts) request on an HTTP request
     * @param string $request Request
     * @param bool $reverse Reverse swap (Yes/No)
     * @return string Prepared request
     */
    public static function prepareRequest(string $request, bool $reverse = false): string
    {
        return (!$reverse) ? strtr($request, '-_', '+/') : strtr($request, '+/', '-_');
    }
}