<?php

namespace App\Controller\Api;

use App\Normalizer;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Profiles;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProfilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiProfilesController extends AbstractController
{
    /**
     * Get profiles collection
     *
     * @Route("/api/secure/profiles", name="api_profiles_get", methods={"GET"})
     */
    public function getProfilesCollection(ProfilesRepository $profilesRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $profilesList = $profilesRepository->findAll();
        

        return $this->json(
            // les données à serializer
            $profilesList,
            // status code
            Response::HTTP_OK,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_profiles_collection']
        );
    }

    /**
     * @Route("/api/secure/profiles/{id<\d+>}", name="api_profiles_get_item", methods={"GET"})
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
     * @Route("/api/secure/profiles", name="api_profiles_post", methods={"POST"})
     * 
     */
    public function createItem(CategoryRepository $categoryRepository, Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, UserRepository $userRepository): Response
    {
        $profiles = $serializer->deserialize($request->getContent(), Profiles::class, 'json');
        $jsonContent = json_decode($request->getContent(), true);
        $user = $userRepository->find($jsonContent["User"]);
        $category = $categoryRepository->find("id");
        /* $category = $categoryRepository->findAll();
        $profiles->addCategory($category, ['name']); */
        $profiles->setCreatedAt(new \DateTime('now'));
       
  
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
          $profiles->getCategories($category);
          
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

    /**
     *   
     * 
    * @Route("/api/secure/profiles/{id<\d+>}", name="api_profiles_put", methods={"PUT"})
    */
    public function updateItem(Profiles $profile, User $user, Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine): Response {

        // $profile est récupéré en argument via l'id passé à la route, on peut donc en profiter pour le mettre à jour avec les données qu'on envoi
         $serializer->deserialize($request->getContent(),
            Profiles::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $profile]
        );
        $profile->setUser($user);
        $profile->setUpdatedAt(new \DateTime());
        // On le sauvegarde avec les nouvelles données, et voilà !
        $entityManager = $doctrine->getManager();
        $entityManager->flush();
        
        return $this->json(
            $profile,
            JsonResponse::HTTP_OK,
            // REST demande un header Location + URL de la ressource
            [],
            // Groupe
            ['groups' => 'create_profiles_item']
        );
      }
    
    /** 
    * @Route("/api/secure/profiles/{id<\d+>}", name="api_profiles_delete", methods={"DELETE"})
    */
    public function deleteProfiles($id, ProfilesRepository $profiles, EntityManagerInterface $entityManager): Response
    {
       $existingProfiles = $profiles->find($id);
        $entityManager->remove($existingProfiles);
        $entityManager->flush();

        return $this->json($existingProfiles, Response::HTTP_OK, [], ['groups' => 'create_profiles_item']);
        
    }
}
