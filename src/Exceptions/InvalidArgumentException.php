<?php

namespace AbismoStudios\Supervisord\Exceptions;

use Exception;

class InvalidArgumentException extends Exception
{
    /**
     * Codigo do erro
     * 
     * @var int $faultCode
     */
    public $faultCode;

    /**
     * Messagem de erro
     * 
     * @var string $faultString
     */
    public $faultString;

    public function __construct($arguments)
    {
        $this->faultCode   = 0;
        $this->faultString = 'Error desconhecido';

        if (is_array($arguments)) {
            if (array_key_exists('faultCode', $arguments)) {
                $this->faultCode = (int) $arguments['faultCode'];
            }

            if (array_key_exists('faultString', $arguments)) {
                $this->faultString = $arguments['faultString'];
            }
        }

        parent::__construct($this->faultString, $this->faultCode);
    }
}
