<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Store\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

final class StoreController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products", name="store_list_products", methods={"GET"})
     * @return Response
     */
    public function listProducts(): Response
    {
        $products = $this->productRepository->findAll();
        return $this->render('store/list_products.html.twig', [
            "products" => $products,
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_show_product", requirements={"id": "\d+"}, methods={"GET"})
     * @param int $id
     * @param string $slug
     */
    public function showProduct(Request $request, int $id, string $slug): Response
    {
        return $this->render('store/show_product.html.twig', [
            'id' => $id,
            'slug' => $slug,
        ]);
    }

}