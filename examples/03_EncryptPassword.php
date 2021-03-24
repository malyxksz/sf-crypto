<?php

require __DIR__.'/../vendor/autoload.php'; // Autoloader

/*
 * Data
 */
$MY_PASSWORD = '12345'; # User password

/*
 * Password encryption
 */
$password_encrypted = \SF_Crypto\Password\PasswordEncrypt::createHashRegister($MY_PASSWORD);

$MY_LOGIN_COUNT = 10; # User logins counter
$password_encrypted_login = \SF_Crypto\Password\PasswordEncrypt::createHashLogin($MY_PASSWORD, $MY_LOGIN_COUNT);

/*
 * Print encrypted password
 */
echo "<h1>Encrypted password</h1>";
echo "<b>Password:</b> {$MY_PASSWORD}<br/>";
echo "<b>Encrypted password (register):</b> {$password_encrypted}<br/>"; # Password encryption during the registration
echo "<b>Encrypted password (login):</b> {$password_encrypted_login}<br/>"; # Password encryption during the login