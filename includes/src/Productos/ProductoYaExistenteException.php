<?php
use \es\ucm\fdi\aw\src\Productos\Producto;

class ProductoYaExistenteException extends \Exception
{
    function __construct(string $message = "" , int $code = 0 , Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }
}