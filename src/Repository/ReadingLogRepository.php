<?php

namespace App\Repository;

use App\Entity\ReadingLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReadingLog>
 *
 * @method ReadingLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReadingLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReadingLog[]    findAll()
 * @method ReadingLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReadingLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReadingLog::class);
    }

    /**
     * @return ReadingLog[] Returns an array of ReadingLog objects
     */
    public function getTodayReadingsLog($userId): array
    {
        $dayStart = new \DateTime();
        $dayStart->setTime(0, 0, 1);
        $dayEnd = new \DateTime();
        $dayEnd->setTime(23, 59, 59);


        return $this->createQueryBuilder('rl')
            ->andWhere('rl.date > :dayStart')
            ->andWhere('rl.date <= :dayEnd')
            ->andWhere('rl.userId <= :userId')
            ->setParameter('dayStart', $dayStart->format('Y-m-d H:i:s'))
            ->setParameter('dayEnd', $dayEnd->format('Y-m-d H:i:s'))
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
        ;
    }
}
