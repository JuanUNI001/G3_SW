<?php

namespace es\ucm\fdi\aw\eventos;

class EventoNoEncontradoException extends \RuntimeException
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
