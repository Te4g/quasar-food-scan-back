<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\ProductRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProductSubscriber implements EventSubscriberInterface
{
    private $productRepository;
    private $tokenStorage;

    public function __construct(ProductRepository $productRepository, TokenStorageInterface $tokenStorage)
    {
        $this->productRepository = $productRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if ('api_products_post_collection' !== $request->attributes->get('_route')) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user instanceof User) {
            return;
        }

        $newProduct = $request->attributes->get('data');

        $isAlreadyScanned = count($this->productRepository->findBy(['code' => $newProduct->getCode(), 'user' => $user->getId()])) > 0;

        if($isAlreadyScanned) {
            return;
        }



    }
}
