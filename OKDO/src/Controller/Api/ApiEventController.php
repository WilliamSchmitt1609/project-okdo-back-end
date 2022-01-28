<?php

namespace App\Controller\Api;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiEventController extends AbstractController
{
/**
     * Get events collection
     *
     * @Route("/api/secure/events", name="api_events_get", methods={"GET"})
     */
    public function getCategoriesCollection(EventRepository $eventRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $eventsList = $eventRepository->findAll();
        

        return $this->json(
            // les données à serializer
            $eventsList,
            // status code
            Response::HTTP_OK,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_events_collection']
        );
    }
}
