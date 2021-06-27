<?php
namespace Hamaelt\ZipValidator\Exception;


use Illuminate\Foundation\Exceptions\Handler;

class InvalidMimeTypeException extends Handler
{
    public function __construct($message)
    {
        return 'error';
    }
}