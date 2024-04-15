<?php
namespace es\ucm\fdi\aw\src\Pedidos;

class PedidoYaExisteException extends \Exception
{
    function __construct(string $message = "" , int $code = 0 , Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }
}

