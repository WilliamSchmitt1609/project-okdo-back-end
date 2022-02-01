<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiCategoriesController extends AbstractController
{
    /**
     * Get categories collection
     *
     * @Route("/api/categories", name="api_categories_get", methods={"GET"})
     */
    public function getCategoriesCollection(CategoryRepository $categoryRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $categoriesList = $categoryRepository->findAll();
        

        return $this->json(
            // les données à serializer
            $categoriesList,
            // status code
            Response::HTTP_OK,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_categories_collection']
        );
    }
}