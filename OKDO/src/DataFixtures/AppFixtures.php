<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Connection;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;
    private $connection;
    


    public function __construct(UserPasswordHasherInterface $hasher, Connection $connection)
    {
        // each time we called hasher on our load, it will hash the password
        $this->hasher = $hasher;
        // On récupère la connexion à la BDD (DBAL ~= PDO)
        // pour exécuter des requêtes manuelles en SQL pur
        $this->connection = $connection;
        
    }

    
    /**
     * Allows to truncate tables and reset AI to 1
     */
    private function truncate()
    {
        // We use SQL 
        // Disablation FK constraint checking
        $this->connection->executeQuery('SET foreign_key_checks = 0');
        // We truncate
        $this->connection->executeQuery('TRUNCATE TABLE user');
        // etc.
    }
    public function load(ObjectManager $manager): void
    {

        // On TRUNCATE manuellement
        $this->truncate();
        
       // here we create our custom fixtures admin for our user
        $admin = new User();
        $admin->setNickname('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        // we call our dependance hasher for admin fixture
        $password = $this->hasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setFirstname('Ladislas');
        $admin->setLastname('Marchand');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $admin->setCreatedAt(new \datetime('now'));
    // persist before push
        $manager->persist($admin);

        $managerUser = new User();
        $managerUser->setNickname('manager');
        $managerUser->setEmail('manager@manager.com');
        $managerUser->setRoles(['ROLE_MANAGER']);
        $password = $this->hasher->hashPassword($managerUser, 'managerUser');
        $managerUser->setPassword($password);
        $managerUser->setFirstname('William');
        $managerUser->setLastname('Schmitt');
        $managerUser->setCreatedAt(new \datetime('now'));
        // Attention $manager = le Manager de Doctrine :D
        $manager->persist($managerUser);


        $user = new User();
        $user->setNickname('user');
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword($user, 'user');
        $user->setPassword($password);
        $user->setFirstname('JC');
        $user->setLastname('Guinez');
        $user->setCreatedAt(new \datetime('now'));
        

        $manager->persist($user);
        // push in our database
        $manager->flush();
    }
}
