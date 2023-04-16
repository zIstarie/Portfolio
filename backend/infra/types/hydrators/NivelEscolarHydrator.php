<?php

namespace Portfolio\Infra\Types\Hydrators;

use Laminas\Hydrator\Strategy\StrategyInterface;
use Portfolio\Infra\Types\NivelEscolar;

class NivelEscolarHydrator implements StrategyInterface
{
    public function extract($value, ?object $object = null): ?string
    {
        return $value === null ? null : NivelEscolar::tryFrom($value)->value;
    }

    public function hydrate($value, ?array $data): ?NivelEscolar
    {
        return $value === null ? null : NivelEscolar::tryFrom($value);
    }
}

?>