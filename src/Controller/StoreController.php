<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\Store\ProductRepository;
use App\Repository\Store\BrandRepository;
use App\Repository\Store\CommentRepository;
use App\Entity\Store\Comment;
use App\Form\CommentType;

final class StoreController extends AbstractController
{
    private EntityManagerInterface $em;
    private ProductRepository $productRepository;
    private BrandRepository $brandRepository;
    private CommentRepository $commentRepository;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository, 
    BrandRepository $brandRepository, CommentRepository $commentRepository)
    {
        $this->em = $em;
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->commentRepository = $commentRepository;
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
     * @Route("/product/{id}/details/{slug}", name="store_show_product", requirements={"id" = "\d+"}, methods={"GET", "POST"})
     * @param int $id
     * @param string $slug
     * @return Response
     */
    public function showProduct(int $id, string $slug, Request $request): Response
    {
        $product= $this->productRepository->find($id);
        $comments = $this->commentRepository->findBy(['product' => $product]);

        if($product === null){
            throw new NotFoundHttpException();
        }

        $comment = new Comment();
        $comment->setProduct($product);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Merci pour votre avis !');
            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('store_show_product', [
                'id' => $product->getId(),
                'slug' => $product->getSlug(),
            ]);
        }

        return $this->render('store/show_product.html.twig', [
            'product' => $product,
            'slug' => $slug,
            'comments' => $comments,
            'form' => $form->createView()
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

    public function menuBrands(int $currentBrandId = null): Response
    {
        $brands = $this->brandRepository->findAll();

        return $this->render('store/_menu_brands.html.twig', [
           'brands' => $brands,
           'current_brand_id' => $currentBrandId
        ]);
    }
}