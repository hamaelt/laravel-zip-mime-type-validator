<?php
namespace Hamaelt\ZipValidator\Exception;

class InvalidFileTypeException extends \Exception
{
    public function __construct($message)
    {
        Parent::__construct($message);
    }
}
