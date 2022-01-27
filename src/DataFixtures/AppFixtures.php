<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Store\Product;
use App\Entity\Store\Image;
use App\Entity\Store\Brand;
use App\Entity\Store\Color;

class AppFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadProducts();
        $this->loadBrands();
        $this->loadColors();

        $this->manager->flush();
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i < 21; $i++) {
            $product = (new Product())
                ->setName('produit n°' . $i)
                ->setDescription('Description du produit portant le n°' . $i)
                ->setPrice(mt_rand(10, 100))
                ->setCreatedAt(new \Datetime())
                ->setLongDescription('Description longue du produit n°' . $i . ' : Lorem ipsum dolor sit amet consectetur, 
                adipisicing elit. Saepe laboriosam laudantium voluptatum dicta fugit laborum ut soluta at, sapiente nisi 
                deserunt officia obcaecati quo eius. Tenetur fuga provident inventore nesciunt.')
                ->setSlug('produit-'. $i);

            $image = (new Image())
                ->setUrl("img/products/shoe-" . $i . ".jpg")
                ->setAlt($product->getName());

            $product->setImage($image);

            /** @var Brand $brand */
            $brand = $this->getReference(Brand::class . random_int(0,3));
            $product->setBrand($brand);

            /** @var Color $color */
            for($j = 0; $j < 7 ; $j++) {
                if (rand(0,1)) {
                    $color = $this->getReference(Color::class . $j);
                    $product->addColor($color);
                }
            }

            $this->manager->persist($product);
            $this->addReference(Product::class.$i, $product);
        }
    }

    private function loadBrands()
    {
        $brandNames = ['Adidas', 'Asics', 'Nike', 'Puma'];

        foreach ($brandNames as $key => $name) {
            $brand = (new Brand())
                ->setName($name);

            $this->manager->persist($brand);
            $this->addReference(Brand::class.$key, $brand);
        }
    }

    private function loadColors()
    {
        $colorNames = ['Blanc', 'Noir', 'Rouge', 'Vert', 'Jaune', 'Bleu'];

        foreach ($colorNames as $key => $name) {
            $color = (new Color())
                ->setName($name);

            $this->manager->persist($color);
            $this->addReference(Color::class.$key, $color);
        }
    }
      
}
