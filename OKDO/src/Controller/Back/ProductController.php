<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\Event;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\EventRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="back_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('back/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="back_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, EventRepository $eventRepository): Response
    {
        $product = new Product();
        $event = $eventRepository->findBy(['product' => $product]);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new DateTime);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('back_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('back/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new DateTime);
            $entityManager->flush();

            return $this->redirectToRoute('back_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/test/{id}", name="test", methods={"GET"})
     */
   /*  public function Test(ProductRepository $product, Event $event){
    
        $filteredProduct = $product->eventSearch($event);

        dd($filteredProduct);

    } */

     /**
     * @Route("/test1", name="test", methods={"GET"})
     */
    public function search(SerializerInterface $serializer, ProductRepository $ProductRepository, Request $request)
    {
        $profiles = $serializer->deserialize($request->getContent(), Profiles::class, 'json');
        $products = $ProductRepository->findBy(['status' => 1], ['created_at' => 'desc'], 20);
        

        
            $annonces = $ProductRepository->search(
                $search->get('category')->getData()
            );
        
    }


    /**
     * @Route("/{id}", name="back_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_product_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
