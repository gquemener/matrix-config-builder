<?php

declare(strict_types=1);

namespace GQuemener\MatrixConfigBuilder\Model;

final class Collection implements Requirement, \Iterator
{
    const TYPE_ALL_OF = 1;
    const TYPE_ONE_OF = 2;

    private $type;
    private $requirements;

    private function __construct(int $type, Requirement ...$requirements)
    {
        $this->type = $type;
        $this->requirements = new \ArrayIterator($requirements);
    }

    public static function allOf(Requirement ...$requirements): self
    {
        return new self(self::TYPE_ALL_OF, ...$requirements);
    }

    public static function oneOf(Requirement ...$requirements): self
    {
        return new self(self::TYPE_ONE_OF, ...$requirements);
    }

    public function isAllOf(): bool
    {
        return self::TYPE_ALL_OF === $this->type;
    }

    public function isOneOf(): bool
    {
        return self::TYPE_ONE_OF === $this->type;
    }

    public function current()
    {
        return $this->requirements->current();
    }

    public function key()
    {
        return $this->requirements->key();
    }

    public function next()
    {
        return $this->requirements->next();
    }

    public function rewind()
    {
        return $this->requirements->rewind();
    }

    public function valid()
    {
        return $this->requirements->valid();
    }
}
