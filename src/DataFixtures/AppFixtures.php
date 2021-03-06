<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Store\Product;
use App\Entity\Store\Image;
use App\Entity\Store\Brand;
use App\Entity\Store\Color;
use App\Entity\Store\Comment;

class AppFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    private const DATA_BRANDS = [
        ['Adidas'],
        ['Asics'],
        ['Nike'],
        ['Puma'],
    ];

    private const DATA_COLORS = [
        ['Blanc'],
        ['Noir'],
        ['Rouge'],
        ['Bleu'],
        ['Jaune'],
        ['Vert'],
    ];

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadBrands();
        $this->loadColors();
        $this->loadProducts();
        $this->loadComments();
        
        $this->manager->flush();
    }

    private function loadBrands()
    {
        foreach (self::DATA_BRANDS as $key => [$name]) {
            $brand = (new Brand())
                ->setName($name);

            $this->manager->persist($brand);
            $this->addReference(Brand::class.$key, $brand);
        }
    }

    private function loadColors()
    {
        foreach (self::DATA_COLORS as $key => [$name]) {
            $color = (new Color())
                ->setName($name);

            $this->manager->persist($color);
            $this->addReference(Color::class.$key, $color);
        }
    }

    private function loadComments() 
    {
        $DATA_PSEUDOS = [
            'Max',
            'Flavien',
            'Logan',
            'Adel',
            'M.Hermann',
        ];
    
        $DATA_MESSAGES = [
            'Meilleures chaussures !',
            'Meilleur investissement !',
            'Très confortables !',
            'Nuuuuuuul !',
            'Non confortables !',
            'Pire investissement !',
            'Pires chaussures !',
        ];

        for ($i = 1; $i < 21; $i++) {
            /** @var Product $product */
            $product = $this->getReference(Product::class . $i);

            $commentsCount = random_int(0, 3);

            for ($j = 0; $j < $commentsCount; $j++) {  
                sleep(1);
                
                $comment = (new Comment() )
                    ->setPseudo($DATA_PSEUDOS[array_rand($DATA_PSEUDOS)])
                    ->setMessage($DATA_MESSAGES[array_rand($DATA_MESSAGES)])
                    ->setProduct($product);

                $this->manager->persist($comment);
            }
        }
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i < 21; $i++) {
            /** @var Brand $brand */
            $brand = $this->getReference(Brand::class . random_int(0, count(self::DATA_BRANDS) -1));

            $product = (new Product())
                ->setName('produit n°' . $i)
                ->setDescription('Description du produit portant le n°' . $i)
                ->setPrice(mt_rand(10, 100))
                ->setCreatedAt(new \Datetime())
                ->setLongDescription('Description longue du produit n°' . $i . ' : Lorem ipsum dolor sit amet consectetur, 
                adipisicing elit. Saepe laboriosam laudantium voluptatum dicta fugit laborum ut soluta at, sapiente nisi 
                deserunt officia obcaecati quo eius.')
                ->setSlug('produit-'. $i)
                ->setBrand($brand);

            $image = (new Image())
                ->setUrl("img/products/shoe-" . $i . ".jpg")
                ->setAlt($product->getName());

            $product->setImage($image);

            /** @var Color $color */
            for($j = 0; $j < 4; $j++) {
                if (random_int(0,1)) {
                    $color = $this->getReference(Color::class . random_int(0, count(self::DATA_COLORS) -1));
                    $product->addColor($color);
                }
            }

            $this->manager->persist($product);
            $this->addReference(Product::class.$i, $product);
        }
    }
    
}
