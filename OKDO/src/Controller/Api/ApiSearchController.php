<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ApiSearchController extends AbstractController
{
    /**
     * @Route("/api/search", name="api_search", methods={"POST"})
     */
    public function search(ProductRepository $productRepository, Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
       
        $categories = $data['categories'];
        $ages = $data['ages'];
        $genres = $data['genres'];
        $events = $data['events'];

        $productListForProfile = $productRepository->findProductByFilters($categories, $ages, $genres, $events);

        return $this->json(
            // les données à serializer
            $productListForProfile,
            // status code
            200,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_searchs_collection']
        );
    }
}
