<?php

class InvalidFileException extends Exception
{
    public function __construct(int $line = 0, int $code = 0, Throwable $previous = null)
    {
        $message = "File do not contain valid edges list. Error in line $line";
        parent::__construct($message, $code, $previous);
    }
}
