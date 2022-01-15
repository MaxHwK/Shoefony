<?php

namespace App\DataFixtures;

use App\Entity\Store\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadProducts();
        $this->manager->flush();
    }

    private function loadProducts(): void
    {
        for ($i = 1 ; $i < 20 ; $i++) {
            $product = (new Product())
                ->setName('produit n°' . $i)
                ->setDescription('Description du produit portant le n°' . $i)
                ->setPrice(mt_rand(10, 100))
                ->setCreatedAt(new \Datetime());

            $this->manager->persist($product);
        }
    }
}
