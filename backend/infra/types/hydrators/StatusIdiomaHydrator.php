<?php

namespace Portfolio\Infra\Types\Hydrators;

use Laminas\Hydrator\Strategy\StrategyInterface;
use Portfolio\Infra\Types\StatusIdioma;

class StatusIdiomaHydrator implements StrategyInterface
{
    public function extract($value, ?object $object = null): ?string
    {
        return $value === null ? null : StatusIdioma::tryFrom($value)->value;
    }

    public function hydrate($value, ?array $data): ?StatusIdioma
    {
        return $value === null ? null : StatusIdioma::tryFrom($value);
    }
}

?>