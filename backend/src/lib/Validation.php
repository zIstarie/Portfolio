<?php

require __DIR__ . '/../../vendor/autoload.php';

use Portfolio\Infra\Entities\BaseEntity;
use Portfolio\Infra\Entities;

function validate(array $data, BaseEntity|string $entity): bool
{
    $indexes = $entity::retrieveIndexes();
    $keys = array_keys($data);

    foreach ($indexes as $index) {
        if (
            !array_key_exists($index, $keys) AND
            isset($indexes[$index])
        ) return false;
    }

    return true;
}

?>
