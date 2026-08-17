<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends Exception implements ContainerExceptionInterface
{
    // Option 1: Hardcode specific error/HTTP status codes per factory method
    public static function notInstantiable(string $id, int $code = 500): self
    {
        return new self("Class '{$id}' is not instantiable.", $code);
    }

    // Option 2: Allow callers to pass custom messages and custom codes
    public static function customError(string $message, int $code = 400, ?Throwable $previous = null): self
    {
        return new self($message, $code, $previous);
    }

    // Option 3: Standardize with domain specific error codes
    public static function unresolvableDependency(string $paramName, int $code = 1001): self
    {
        return new self("Could not resolve dependency for parameter '\${$paramName}'.", $code);
    }
    public static function unionTypeNotSupported(string $paramName): self
    {
        return new self("Unsupported uniontype'\${$paramName}'.");
    }
}