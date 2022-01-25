<?php

namespace App\Controller\Api;

use App\Entity\Profiles;
use App\Normalizer;
use App\Repository\ProfilesRepository;
use App\Repository\UserRepository;
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
            return $this->json(['error' => 'Profil de recherche non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($profiles, Response::HTTP_OK, [], ['groups' => 'get_profiles_collection']);
    }


    /**
     * @Route("/api/profiles", name="api_profiles_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, UserRepository $userRepository): Response
    {
        $profiles = $serializer->deserialize($request->getContent(), Profiles::class, 'json');
        $jsonContent = json_decode($request->getContent(), true);
        $user = $userRepository->find($jsonContent["User"]);
        $profiles->setCreatedAt(new \DateTime('now'));
          // Récupérer le contenu JSON
        //   $jsonContent = $request->getContent();

        /*try {
              // Désérialiser (convertir) le JSON en entité Doctrine Movie
              $profiles = $serializer->deserialize($jsonContent, Profiles::class, 'json');
          } catch (NotEncodableValueException $e) {
              // Si le JSON fourni est "malformé" ou manquant, on prévient le client
              return $this->json(
                  ['error' => 'JSON invalide'],
                  Response::HTTP_UNPROCESSABLE_ENTITY
              );
          }*/
  
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
  
          $profiles->setUser($user);
          // On sauvegarde l'entité
          $entityManager = $doctrine->getManager();
          $entityManager->persist($profiles);
          $entityManager->flush();
  
          // On retourne la réponse adaptée (201 + Location: URL de la ressource)
          return $this->json(
              // Le film créé peut être ajouté au retour
              $profiles,
              // Le status code : 201 CREATED
              // utilisons les constantes de classes !
              Response::HTTP_CREATED,
              // REST demande un header Location + URL de la ressource
              [
                  // Nom de l'en-tête + URL
                  'Location' => $this->generateUrl('api_profiles_get_item', ['id' => $profiles->getId()])
              ],
            // Groupe
            ['groups' => 'create_profiles_item']
        );
    }
}
