<?php

declare(strict_types=1);

namespace Roave\BetterReflection\Reflection\Adapter;

use Closure;
use OutOfBoundsException;
use ReflectionClass as CoreReflectionClass;
use ReflectionException as CoreReflectionException;
use ReflectionExtension as CoreReflectionExtension;
use ReflectionFunction as CoreReflectionFunction;
use ReflectionType as CoreReflectionType;
use Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented;
use Roave\BetterReflection\Reflection\ReflectionAttribute as BetterReflectionAttribute;
use Roave\BetterReflection\Reflection\ReflectionFunction as BetterReflectionFunction;
use Roave\BetterReflection\Reflection\ReflectionParameter as BetterReflectionParameter;
use Roave\BetterReflection\Util\FileHelper;
use Throwable;
use ValueError;

use function array_map;
use function func_get_args;
use function sprintf;

final class ReflectionFunction extends CoreReflectionFunction
{
    public function __construct(private BetterReflectionFunction $betterReflectionFunction)
    {
        unset($this->name);
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function __toString(): string
    {
        return $this->betterReflectionFunction->__toString();
    }

    /** @psalm-mutation-free */
    public function inNamespace(): bool
    {
        return $this->betterReflectionFunction->inNamespace();
    }

    /** @psalm-mutation-free */
    public function isClosure(): bool
    {
        return $this->betterReflectionFunction->isClosure();
    }

    /** @psalm-mutation-free */
    public function isDeprecated(): bool
    {
        return $this->betterReflectionFunction->isDeprecated();
    }

    /** @psalm-mutation-free */
    public function isInternal(): bool
    {
        return $this->betterReflectionFunction->isInternal();
    }

    /** @psalm-mutation-free */
    public function isUserDefined(): bool
    {
        return $this->betterReflectionFunction->isUserDefined();
    }

    /** @psalm-mutation-free */
    public function getClosureThis(): object|null
    {
        throw new NotImplemented('Not implemented');
    }

    /** @psalm-mutation-free */
    public function getClosureScopeClass(): CoreReflectionClass|null
    {
        throw new NotImplemented('Not implemented');
    }

    /** @psalm-mutation-free */
    public function getClosureCalledClass(): CoreReflectionClass|null
    {
        throw new NotImplemented('Not implemented');
    }

    /** @psalm-mutation-free */
    public function getDocComment(): string|false
    {
        return $this->betterReflectionFunction->getDocComment() ?? false;
    }

    /** @psalm-mutation-free */
    public function getStartLine(): int
    {
        return $this->betterReflectionFunction->getStartLine();
    }

    /** @psalm-mutation-free */
    public function getEndLine(): int
    {
        return $this->betterReflectionFunction->getEndLine();
    }

    /** @psalm-mutation-free */
    public function getExtension(): CoreReflectionExtension|null
    {
        throw new NotImplemented('Not implemented');
    }

    /**
     * @return non-empty-string|false
     *
     * @psalm-mutation-free
     */
    public function getExtensionName(): string|false
    {
        return $this->betterReflectionFunction->getExtensionName() ?? false;
    }

    /**
     * @return non-empty-string|false
     *
     * @psalm-mutation-free
     */
    public function getFileName(): string|false
    {
        $fileName = $this->betterReflectionFunction->getFileName();

        return $fileName !== null ? FileHelper::normalizeSystemPath($fileName) : false;
    }

    /** @psalm-mutation-free */
    public function getName(): string
    {
        return $this->betterReflectionFunction->getName();
    }

    /** @psalm-mutation-free */
    public function getNamespaceName(): string
    {
        return $this->betterReflectionFunction->getNamespaceName() ?? '';
    }

    /** @psalm-mutation-free */
    public function getNumberOfParameters(): int
    {
        return $this->betterReflectionFunction->getNumberOfParameters();
    }

    /** @psalm-mutation-free */
    public function getNumberOfRequiredParameters(): int
    {
        return $this->betterReflectionFunction->getNumberOfRequiredParameters();
    }

    /**
     * @return list<ReflectionParameter>
     *
     * @psalm-mutation-free
     */
    public function getParameters(): array
    {
        return array_map(
            static fn (BetterReflectionParameter $parameter): ReflectionParameter => new ReflectionParameter($parameter),
            $this->betterReflectionFunction->getParameters(),
        );
    }

    /** @psalm-mutation-free */
    public function hasReturnType(): bool
    {
        return $this->betterReflectionFunction->hasReturnType();
    }

    /** @psalm-mutation-free */
    public function getReturnType(): CoreReflectionType|null
    {
        return ReflectionType::fromTypeOrNull($this->betterReflectionFunction->getReturnType());
    }

    /** @psalm-mutation-free */
    public function getShortName(): string
    {
        return $this->betterReflectionFunction->getShortName();
    }

    /** @return array<string, scalar> */
    public function getStaticVariables(): array
    {
        throw new NotImplemented('Not implemented');
    }

    /** @psalm-mutation-free */
    public function returnsReference(): bool
    {
        return $this->betterReflectionFunction->returnsReference();
    }

    /** @psalm-mutation-free */
    public function isGenerator(): bool
    {
        return $this->betterReflectionFunction->isGenerator();
    }

    /** @psalm-mutation-free */
    public function isVariadic(): bool
    {
        return $this->betterReflectionFunction->isVariadic();
    }

    /** @psalm-mutation-free */
    public function isDisabled(): bool
    {
        return $this->betterReflectionFunction->isDisabled();
    }

    public function invoke(mixed ...$args): mixed
    {
        try {
            return $this->betterReflectionFunction->invoke(...func_get_args());
        } catch (Throwable $e) {
            throw new CoreReflectionException($e->getMessage(), previous: $e);
        }
    }

    /** @param list<mixed> $args */
    public function invokeArgs(array $args): mixed
    {
        try {
            return $this->betterReflectionFunction->invokeArgs($args);
        } catch (Throwable $e) {
            throw new CoreReflectionException($e->getMessage(), previous: $e);
        }
    }

    /** @psalm-mutation-free */
    public function getClosure(): Closure
    {
        return $this->betterReflectionFunction->getClosure();
    }

    /** @return mixed[] */
    public function getClosureUsedVariables(): array
    {
        throw new Exception\NotImplemented('Not implemented');
    }

    public function hasTentativeReturnType(): bool
    {
        return $this->betterReflectionFunction->hasTentativeReturnType();
    }

    public function getTentativeReturnType(): CoreReflectionType|null
    {
        return ReflectionType::fromTypeOrNull($this->betterReflectionFunction->getTentativeReturnType());
    }

    public function isStatic(): bool
    {
        return $this->betterReflectionFunction->isStatic();
    }

    /**
     * @param class-string|null $name
     *
     * @return list<ReflectionAttribute>
     */
    public function getAttributes(string|null $name = null, int $flags = 0): array
    {
        if ($flags !== 0 && $flags !== ReflectionAttribute::IS_INSTANCEOF) {
            throw new ValueError('Argument #2 ($flags) must be a valid attribute filter flag');
        }

        if ($name !== null && $flags & ReflectionAttribute::IS_INSTANCEOF) {
            $attributes = $this->betterReflectionFunction->getAttributesByInstance($name);
        } elseif ($name !== null) {
            $attributes = $this->betterReflectionFunction->getAttributesByName($name);
        } else {
            $attributes = $this->betterReflectionFunction->getAttributes();
        }

        return array_map(static fn (BetterReflectionAttribute $betterReflectionAttribute): ReflectionAttribute => new ReflectionAttribute($betterReflectionAttribute), $attributes);
    }

    public function __get(string $name): mixed
    {
        if ($name === 'name') {
            return $this->betterReflectionFunction->getName();
        }

        throw new OutOfBoundsException(sprintf('Property %s::$%s does not exist.', self::class, $name));
    }

    public function isAnonymous(): bool
    {
        return $this->betterReflectionFunction->isClosure();
    }
}
