<?php
declare(strict_types=1);

namespace App\Subscription\Infrastructure\Persistence\Doctrine\Repository;

use App\Product\Domain\Model\Product;
use App\Subscription\Domain\Model\Subscription;
use App\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Subscription>
 *
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository implements SubscriptionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function save(Subscription $subscription): void
    {
        $this->getEntityManager()->persist($subscription);
        $this->getEntityManager()->flush();
    }

    /** @inheritDoc */
    public function findActiveByUserId(Uuid $userId): array
    {
        $now = new DateTimeImmutable();

        return $this->createQueryBuilder('s')
            ->where('s.user = :userId')
            ->andWhere('s.active = true')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate >= :now OR s.endDate IS NULL)')
            ->setParameter('userId', $userId)
            ->setParameter('now', $now)
            ->getQuery()
            ->getResult();
    }

    public function findActiveByUserIdAndProductName(Uuid $userId, string $productName): ?Subscription
    {
        $now = new DateTimeImmutable();

        return $this->createQueryBuilder('s')
            ->where('s.user = :userId')
            ->andWhere('s.productName = :productName')
            ->andWhere('s.active = true')
            ->andWhere('s.cancelled = false')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate >= :now OR s.endDate IS NULL)')
            ->setParameter('userId', $userId)
            ->setParameter('productName', $productName)
            ->setParameter('now', $now)
            ->getQuery()
            ->getOneOrNullResult();
    }
}