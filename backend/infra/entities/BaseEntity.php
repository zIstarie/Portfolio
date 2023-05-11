<?php

namespace Portfolio\Infra\Entities;

use Doctrine\ORM\Mapping\Entity;

abstract class BaseEntity
{
    public static abstract function retrieveIndexes(): array;

    public abstract function create(object $data): void;

    public abstract function update(object $data): void;
}

?>
