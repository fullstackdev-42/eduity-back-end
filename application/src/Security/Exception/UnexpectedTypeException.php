<?php

namespace App\Security\Exception;

class UnexpectedTypeException extends \InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param mixed  $value        The value
     * @param string $expectedType The expected type
     */
    public function __construct($value, string $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, \is_object($value) ? \get_class($value) : \gettype($value)));
    }
}
