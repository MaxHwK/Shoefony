<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

final class StoreController extends AbstractController
{
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

    /**
     * @Route("/products", name="store_list_products", methods={"GET"})
     * @return Response
     */
    public function listProducts(): Response
    {
        return $this->render('store/list_products.html.twig', [
            'controller_name' => 'StoreListProducts',
        ]);
    }

}