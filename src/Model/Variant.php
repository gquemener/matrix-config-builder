<?php

declare(strict_types=1);

namespace GQuemener\MatrixConfigBuilder\Model;

final class Variant implements Requirement
{
    public function __construct(string $name, array $variants)
    {
        $this->name = $name;
        $this->variants = $variants;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function variants(): array
    {
        return $this->variants;
    }
}
