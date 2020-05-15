<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProductController
{
    private $productRepository;
    private $tokenStorage;

    public function __construct(ProductRepository $productRepository, TokenStorageInterface $tokenStorage)
    {
        $this->productRepository = $productRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Product $data)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $alreadyScannedProduct = $this->productRepository->findOneProductPerUser($data, $user);

        if (null !== $alreadyScannedProduct) {
            $alreadyScannedProduct->setQuantityInStock($alreadyScannedProduct->getQuantityInStock() + $data->getQuantityInStock());
            $this->productRepository->save($alreadyScannedProduct);

            return new JsonResponse('updated', 200);
        }

        $data->setUser($user);
        $this->productRepository->save($data);

        return new JsonResponse('created, 201');
    }
}