<?php

declare(strict_types=1);

namespace App;

use ReflectionClass;
use ReflectionParameter;
use ReflectionNamedType;
use ReflectionUnionType;
use App\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $callable = $this->entries[$id];
            return $callable($this);
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $callable): void
    {
        $this->entries[$id] = $callable;
    }

    public function resolve(string $id): object
    {
        if (!class_exists($id)) {
            throw ContainerException::notInstantiable($id);
        }

        $reflectionClass = new ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw ContainerException::notInstantiable($id);
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $id();
        }

        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $id();
        }

        $dependencies = array_map(
            fn (ReflectionParameter $param) => $this->resolveParameter($param),
            $parameters
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    private function resolveParameter(ReflectionParameter $param)
    {
        $type = $param->getType();

        // No type hint — fallback to default value if present
        if (!$type) {
            if ($param->isDefaultValueAvailable()) {
                return $param->getDefaultValue();
            }
            throw ContainerException::unresolvableDependency($param->getName());
        }

        // Union types (e.g., int|string $x)
        if ($type instanceof ReflectionUnionType) {
            throw ContainerException::unionTypeNotSupported($param->getName());
        }

        // Custom Class/Interface dependency — resolve recursively
        if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
            return $this->get($type->getName());
        }

        // Built-in type (int, string, bool) — fallback to default
        if ($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }

        // Nullable type with no default (e.g., ?int $x)
        if ($type->allowsNull()) {
            return null;
        }

        throw ContainerException::unresolvableDependency($param->getName());
    }
}