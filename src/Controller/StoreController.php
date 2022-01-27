<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\Store\ProductRepository;
use App\Repository\Store\BrandRepository;

final class StoreController extends AbstractController
{
    private ProductRepository $productRepository;
    private BrandRepository $brandRepository;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @Route("/products", name="store_list_products", methods={"GET"})
     * @return Response
     */
    public function listProducts(): Response
    {
        return $this->render('store/list_products.html.twig', [
            'products' => $this->productRepository->findAll(),
            'brands' => $this->brandRepository->findAll()
        ]);
    }

    /**
     * @Route("/product/{id}/details/{slug}", name="store_show_product", requirements={"id" = "\d+"}, methods={"GET"})
     * @param int $id
     * @param string $slug
     * @return Response
     */
    public function showProduct(int $id, string $slug): Response
    {
        $product= $this->productRepository->find($id);

        if($product === null){
            throw new NotFoundHttpException();
        }

        return $this->render('store/show_product.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/products/brand/{brandId}", name="store_list_by_brand", requirements={"brandId" = "\d+"}, methods={"GET"})
     * @param int $brandId
     * @return Response
     */
    public function productsByBrand(int $brandId): Response
    {
        if($brandId === null) {
            throw new NotFoundHttpException();
        }

        $products = $this->productRepository->findBy(
            ['brand' => $brandId]
        );

        return $this->render('store/list_products.html.twig', [
            'products' => $products,
            'curent_brand_id' => $brandId
        ]);
    }

    public function brandsMenu(int $currentBrandId = null): Response
    {
        $brands = $this->brandRepository->findAll();

        return $this->render('store/list_products.html.twig',[
           'brands' => $brands,
           'current_brand_id' => $currentBrandId
        ]);
    }

}