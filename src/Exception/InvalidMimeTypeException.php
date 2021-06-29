<?php
namespace Hamaelt\ZipValidator\Exception;

class InvalidMimeTypeException extends \Exception
{
    public function __construct($message)
    {
        Parent::__construct($message);
    }
}
