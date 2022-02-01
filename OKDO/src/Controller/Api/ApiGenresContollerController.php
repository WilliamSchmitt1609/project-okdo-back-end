<?php

namespace App\Controller\Api;

use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenresContollerController extends AbstractController
{
    /**
     * Get profiles collection
     *
     * @Route("/api/genres", name="api_genres_get", methods={"GET"})
     */
    public function getGenresCollection(GenreRepository $genreRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $genresList = $genreRepository->findAll();
        

        return $this->json(
            // les données à serializer
            $genresList,
            // status code
            Response::HTTP_OK,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_genres_collection']
        );
    }
}
