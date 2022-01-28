<?php

namespace App\Controller\Api;

use App\Repository\AgeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiAgeController extends AbstractController
{
   /**
     * Get profiles collection
     *
     * @Route("/api/secure/ages", name="api_ages_get", methods={"GET"})
     */
    public function getCategoriesCollection(AgeRepository $ageRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $agesList = $ageRepository->findAll();
        

        return $this->json(
            // les données à serializer
            $agesList,
            // status code
            Response::HTTP_OK,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_ages_collection']
        );
    }
}
