<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiProductsController extends AbstractController
{
    /**
     * Get products collection
     *
     * @Route("/api/products", name="api_products_get", methods={"GET"})
     */
    public function getProductsCollection(ProductRepository $productRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $productsList = $productRepository->findAll();
        

        return $this->json(
            // les données à serializer
            $productsList,
            // status code
            Response::HTTP_OK,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_products_collection']
        );
    }

    /**
     * @Route("/api/category/{id}/products", name="api_products_get_category", methods={"GET"})
     */
    public function getProductsByCategory($id, CategoryRepository $categoryRepository): Response
    {
        // 404 ?
        
        // if ($product === null) {
        //     return $this->json(['error' => 'Genre non trouvé.'], Response::HTTP_NOT_FOUND);
        // }

        $category = $categoryRepository->find($id);
        $productsList = $category->getProducts();

        // Tableau PHP à convertir en JSON
        $data = [
            'category' => $category,
            'products' => $productsList,
        ];

        return $this->json(
            $data,
            Response::HTTP_OK,
            [],
            [
                'groups' => [
                    // Le groupe des films
                    'get_products_collection'
                ]
            ]);
    }

    /**
     * @Route("/api/products/{id<\d+>}", name="api_products_get_item", methods={"GET"})
     */
    public function getItem(Product $product = null): Response
    {

        // 404 ?
        if ($product === null) {
            return $this->json(['error' => 'Profil de recherche non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($product, Response::HTTP_OK, [], ['groups' => 'get_products_collection']);
    }

    

}
