<?php

namespace App\Repository\Admin;

use App\Entity\Admin\ParametroConfiguracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParametroConfiguracion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametroConfiguracion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametroConfiguracion[]    findAll()
 * @method ParametroConfiguracion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametroConfiguracionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametroConfiguracion::class);
    }
}

