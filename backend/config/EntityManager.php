<?php

namespace Portfolio\Config;

use Doctrine\ORM\EntityManager as ORMEntityManager;

require_once '../infra/bootstrap.php';

class EntityManager
{
    private static ORMEntityManager $manager = $entityManager;

    public static function getEntityManager()
    {
        return self::$manager;
    }    
}

?>