<?php

namespace App\Repository;

use App\Entity\MotsCles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotsCles>
 *
 * @method MotsCles|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotsCles|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotsCles[]    findAll()
 * @method MotsCles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotsClesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotsCles::class);
    }

//    /**
//     * @return MotsCles[] Returns an array of MotsCles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MotsCles
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function save(MotsCles $motsCles, bool $flush = false): void
    {
        $this->_em->persist($motsCles);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function remove(MotsCles $motsCle, bool $flush = false): void
    {
        $this->_em->remove($motsCle);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
