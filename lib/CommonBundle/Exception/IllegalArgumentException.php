<?php

declare(strict_types=1);

namespace Common\Exception;

class IllegalArgumentException extends \Exception implements \Throwable
{
    public function __construct($expectedClass, $argGiven, $code = 0, ?\Throwable $previous = null)
    {
        $trace = $this->getTrace();
        $message = '';

        if (!class_exists($expectedClass)) {
            throw new \Exception('Expected Class passed to IllegalArgumentException is not an Object.');
        }

        if (array_key_exists(0, $trace)) {
            $lastTrace = $trace[0];

            $typeGiven = is_object($argGiven) ? get_class($argGiven) : 'type ' . gettype($argGiven);

            $message = $lastTrace['class'] . ' method ' . $lastTrace['function'] . ' expected object of type ' . $expectedClass . ' got ' . $typeGiven;
        }

        parent::__construct($message, $code, $previous);
    }
}
