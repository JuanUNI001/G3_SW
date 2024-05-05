<?php

namespace es\ucm\fdi\aw\eventos;

use es\ucm\fdi\aw\http\ResponseStatusCode;

class EventoNoEncontradoException extends \RuntimeException implements ResponseStatusCode
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
      
    public function getStatusCode()
    {
        return 404;
    }
}