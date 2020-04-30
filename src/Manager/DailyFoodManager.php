<?php

namespace App\Manager;

use App\Entity\Product;
use App\Repository\DailyFoodRepository;

class DailyFoodManager
{
    private $dailyFoodRepository;

    public function __construct(DailyFoodRepository $dailyFoodRepository)
    {
        $this->dailyFoodRepository = $dailyFoodRepository;
    }

    public function update(Product $product): void
    {

    }
}