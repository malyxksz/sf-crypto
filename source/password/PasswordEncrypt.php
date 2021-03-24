<?php

declare(strict_types=1);

namespace SF_Crypto\Password;

final class PasswordEncrypt
{
    /** @var string Hash used to encrypt passwords */
    private const SALT = 'ahHoj2woo1eeChiech6ohphoB7Aithoh';

    /**
     * Create an encrypted password generated during the registration
     * @param string $password Password
     * @return string Encrypted password
     */
    public static function createHashRegister(string $password): string
    {
        return sha1($password.self::SALT);
    }

    /**
     * Create an encrypted password generated during the login
     * @param string $password Password
     * @param int $counter Logins counter
     * @param bool $hashed Password is encrypted (Yes/No)
     * @return string Encrypted password
     */
    public static function createHashLogin(string $password, int $counter = 0, bool $hashed = false): string
    {
        return sha1(((!$hashed) ? self::createHashRegister($password) : $password).$counter);
    }
}