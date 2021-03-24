<?php

declare(strict_types=1);

namespace SF_Crypto\Exceptions;

use Exception;

class CryptoException extends Exception
{
    public function __toString(): string
    {
        return "(".self::class.") <b>".(($this->getCode() === 0) ? "Warning" : "Error")."</b>: ".$this->getMessage()." in <b>".$this->getFile()."</b> on line <b>".$this->getLine()."</b>\n";
    }
}