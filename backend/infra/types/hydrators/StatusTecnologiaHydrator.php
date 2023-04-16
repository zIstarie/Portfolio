<?php

namespace Portfolio\Infra\Types\Hydrators;

use Laminas\Hydrator\Strategy\StrategyInterface;
use Portfolio\Infra\Types\StatusTecnologia;

class StatusTecnologiaHydrator implements StrategyInterface
{
    public function extract($value, ?object $object = null): ?string
    {
        return $value === null ? null : StatusTecnologia::tryFrom($value)->value;
    }

    public function hydrate($value, ?array $data): ?StatusTecnologia
    {
        return $value === null ? null : StatusTecnologia::tryFrom($value);
    }
}

?>
