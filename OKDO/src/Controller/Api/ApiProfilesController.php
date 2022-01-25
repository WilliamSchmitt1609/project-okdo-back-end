<?php

namespace App\Controller\Api;

use App\Entity\Profiles;
use App\Repository\ProfilesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiProfilesController extends AbstractController
{
    /**
     * Get profiles collection
     *
     * @Route("/api/profiles", name="api_profiles_get", methods={"GET"})
     */
    public function getProfilessCollection(ProfilesRepository $profilesRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $profilesList = $profilesRepository->findAll();

        return $this->json(
            // les données à serializer
            $profilesList,
            // status code
            200,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_profiles_collection']
        );
    }

    /**
     * @Route("/api/profiles/{id<\d+>}", name="api_profiles_get_item", methods={"GET"})
     */
    public function getItem(Profiles $profiles = null): Response
    {

        // 404 ?
        if ($profiles === null) {
            return $this->json(['error' => 'Utilisateur non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($profiles, Response::HTTP_OK, [], ['groups' => 'get_profiles_collection']);
    }


    /**
     * @Route("/api/profiles", name="api_profiles_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        // Récupérer contenu JSON
        $jsonContent = $request->getContent();

        try {
            // Désérialiser (convertir) le JSON en entité Doctrine Profiles
            $profiles = $serializer->deserialize($jsonContent, Profiles::class, 'json');
        } catch (NotEncodableValueException $e) {
            // Si le JSON fourni est "malformé" ou manquant, on prévient le client
            return $this->json(
                ['error' => 'JSON invalide'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // Valider l'entité
        // @link : https://symfony.com/doc/current/validation.html#using-the-validator-service
        $errors = $validator->validate($profiles);

        // Y'a-t-il des erreurs ?
        if (count($errors) > 0) {
            // tableau de retour
            $errorsClean = [];
            // @Retourner des erreurs de validation propres
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorsClean[$error->getPropertyPath()][] = $error->getMessage();
            };

            return $this->json($errorsClean, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // On sauvegarde l'entité
        $entityManager = $doctrine->getManager();
        $entityManager->persist($profiles);
        $entityManager->flush();

        // On retourne la réponse adaptée (201 + location: URL de la ressource)
        return $this->json(

            $profiles,

            // status code
            //en constante de classe
            Response::HTTP_CREATED,
            // REST demande un header Location + URL de la ressource 
            [
                // nom de l'en-tête + URL
                'Location' => $this->generateUrl('api_profiles_get_item', ['id' => $profiles->getId()])
            ],

            // Groupe
            ['groups' => 'create_profiles_item']
        );
    }
}
