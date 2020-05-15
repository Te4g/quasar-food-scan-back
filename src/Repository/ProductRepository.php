<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findOneProductPerUser(Product $product, User $user): ?Product
    {
        return $this->findOneBy(['code' => $product->getCode(), 'user' => $user->getId()]);
    }
}
