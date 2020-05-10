<?php

namespace App\EventListener;

use App\Entity\Product;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class ProductListener
{
    private $security;
    private $tokenStorage;

    public function __construct(Security $security, TokenStorageInterface $tokenStorage)
    {
        $this->security = $security;
        $this->tokenStorage = $tokenStorage;
    }

    public function prePersist(Product $product, LifecycleEventArgs $event): void
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $product->setUser($user);
    }
}
