<?php

require __DIR__.'/../vendor/autoload.php'; // Autoloader

/*
 * Data
 */
$MY_KEY_ID = '0-080j09R3QcM125';
$MY_KEY = 'A25p573435609wDI';

/*
 * Request data
 * Only RequestData class
 */
$MY_SESSION = '0123456789abcdef0123456789abcdef'; # string
$MY_ACTION = 'AccountSave'; # string
$MY_PARAMETERS = ['myMail@domain.com', '12345']; # array

$RequestData = new \SF_Crypto\Request\RequestData($MY_SESSION, $MY_ACTION, $MY_PARAMETERS);

/*
 * Init decrypt class
 * Passing values: Crypto Key ID & Crypto Key
 */
$RequestEncrypt = new SF_Crypto\Request\RequestEncrypt($MY_KEY_ID, $MY_KEY); // Init decrypt class

/*
 * Request encryption
 * Encrypted data returned as string
 */
$encrypt_data = $RequestEncrypt->encryptRequest($RequestData);

/*
 * Print encrypted data
 */
echo "<h1>Encrypted data</h1>";
echo "<b>Request:</b> {$encrypt_data}<br/>"; # string