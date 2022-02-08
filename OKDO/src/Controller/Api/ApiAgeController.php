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
     * @Route("/api/ages", name="api_ages_get", methods={"GET"})
     */
    public function getAgeCollection(AgeRepository $ageRepository): Response
    {
<<<<<<< HEAD
        
        // On va chercher les données
=======
        // Get age's data
>>>>>>> 1567e08cc2d19268261bae57a628309959dfddfd
        $agesList = $ageRepository->findAll();
        

        return $this->json(
            // Serialize data
            $agesList,
            // status code
            Response::HTTP_OK,
            // Header response (None)
            [],
            // needed groups for serialize
            ['groups' => 'get_ages_collection']
        );
    }
}
