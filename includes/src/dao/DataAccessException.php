<?php
namespace es\ucm\fdi\aw\dao;

/** 
 * https://stackoverflow.com/a/28650987
 */
class DataAccessException extends \RuntimeException
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
    public function getStatusCode()
    {
        return 500;
    }
}