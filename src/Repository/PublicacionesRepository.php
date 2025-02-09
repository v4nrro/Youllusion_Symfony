<?php

namespace App\Repository;

use App\Entity\Publicaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publicaciones>
 */
class PublicacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publicaciones::class);
    }

    /**
     * @return Publicacion[] Returns an array of Publicacion objects
     */
    public function findLikeTitulo(string $value): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->Where($qb->expr()->like('i.titulo', ':val'))->setParameter('val', '%' . $value . '%');
        return $qb->getQuery()->getResult();
    }
}
