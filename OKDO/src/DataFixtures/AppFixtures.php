<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        $this->connection->executeQuery('TRUNCATE TABLE product');
        $this->connection->executeQuery('TRUNCATE TABLE category');
        
    }
    public function load(ObjectManager $manager): void
    {

        // On TRUNCATE manuellement
        $this->truncate();
        
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');
                


                    // User 


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


                    // Products


        // product 1
        $product = new Product();
        $product->setName('Mug overflow');
        $product->setPrice('15');
        $product->setDescription($faker->text());   
        $product->setPicture('https://wp.oclock.io/wp-content/uploads/2016/10/DSC_0250-800x550.jpg');
        $product->setShoppingLink('https://www.oclock.io');
        $product->setAgeRange('19-34 ans');
        $product->setGender('homme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 2 
        $product = new Product();
        $product->setName('PC portable');
        $product->setPrice('400');
        $product->setDescription($faker->text());   
        $product->setPicture('https://www.pexels.com/fr-fr/photo/ordinateur-portable-argente-et-tasse-blanche-sur-table-7974/');
        $product->setShoppingLink('https://www.monpcmarchepas.fr');
        $product->setAgeRange('19-34 ans');
        $product->setGender('homme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 3
        $product = new Product();
        $product->setName('Figurine');
        $product->setPrice('10');
        $product->setDescription($faker->text());   
        $product->setPicture('https://images.unsplash.com/photo-1514302240736-b1fee5985889?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8Z2Vla3xlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60');
        $product->setShoppingLink('https://www.mabellefigurine.fr');
        $product->setAgeRange('19-34 ans');
        $product->setGender('homme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 4
        $product = new Product();
        $product->setName('casque micro');
        $product->setPrice('20');
        $product->setDescription($faker->text());   
        $product->setPicture('https://images.pexels.com/photos/7682341/pexels-photo-7682341.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
        $product->setShoppingLink('https://www.monmicromarchepas.fr');
        $product->setAgeRange('19-34 ans');
        $product->setGender('homme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 5
        $product = new Product();
        $product->setName('casque VR');
        $product->setPrice('800');
        $product->setDescription($faker->text()); 
        $product->setPicture('https://images.pexels.com/photos/3761267/pexels-photo-3761267.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');
        $product->setShoppingLink('https://www.vendunreinpouruncasqueVR.com');
        $product->setAgeRange('19-34 ans');
        $product->setGender('homme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 6
        $product = new Product();
        $product->setName('Bouteille Coeur');
        $product->setPrice('30');
        $product->setDescription($faker->text());   
        $product->setPicture('https://cdn.pixabay.com/photo/2016/03/27/13/53/bottle-1282705_960_720.jpg');
        $product->setShoppingLink('https://www.unebouteillealamer.net');
        $product->setAgeRange('35-50 ans');
        $product->setGender('femme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 7
        $product = new Product();
        $product->setName('Chocolat / Macarons ');
        $product->setPrice('20');
        $product->setDescription($faker->text());   
        $product->setPicture('https://previews.123rf.com/images/starkovphoto/starkovphoto1602/starkovphoto160200025/52658110-la-bo%C3%AEte-de-macarons-en-forme-de-coeur-avec-des-fleurs-et-du-ruban-sur-une-table-en-bois-cadeau-cr%C3%A9a.jpg');
        $product->setShoppingLink('https://www.lesbonschoco.fr');
        $product->setAgeRange('35-50 ans');
        $product->setGender('femme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        //product 8
        $product = new Product();
        $product->setName('Montre Femme');
        $product->setPrice('100');
        $product->setDescription($faker->text());   
        $product->setPicture('https://images.pexels.com/photos/9981093/pexels-photo-9981093.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260');
        $product->setShoppingLink('https://www.ocaro.fr');
        $product->setAgeRange('35-50 ans');
        $product->setGender('femme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus('femme');

        $manager->persist($product);

        // product 9
        $product = new Product();
        $product->setName('Bague en coeur');
        $product->setPrice('100');
        $product->setDescription($faker->text());   
        $product->setPicture('https://cdn.pixabay.com/photo/2014/12/31/14/11/wedding-ring-584974_960_720.jpg');
        $product->setShoppingLink('https://www.clear.com');
        $product->setAgeRange('35-50 ans');
        $product->setGender('femme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 10
        $product = new Product();
        $product->setName('Magnifique tenue de marche athlétique');
        $product->setPrice('150');
        $product->setDescription($faker->text());   
        $product->setPicture('https://www.programme-tv.net/imgre/fit/https.3A.2F.2Fprd2-tel-epg-img.2Es3-eu-west-1.2Eamazonaws.2Ecom.2Fprogram.2F44691aba5c165697.2Ejpg/630x355/quality/80/malcolm.jpg');
        $product->setShoppingLink('http://www.haladustyle.com');
        $product->setAgeRange('35-50 ans');
        $product->setGender('femme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);

        // product 11
        $product = new Product();
        $product->setName('Tenue de basket');
        $product->setPrice('60');
        $product->setDescription($faker->text());   
        $product->setPicture('https://images.pexels.com/photos/7005769/pexels-photo-7005769.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');
        $product->setShoppingLink('https://www.grosport.fr');
        $product->setAgeRange('35-50 ans');
        $product->setGender('femme');
        //get the createdAtValue, he get the actual time/hour and put it on setcreatedAt.
        $product->setCreatedAt(new \datetime('now'));
        $product->setStatus(1);

        $manager->persist($product);
        
        // category fixtures

        // category 1
        $category = new Category();
        $category->setName('geek');
        $category->setcreatedAt(new \datetime('now'));

        $manager->persist($category);
       
        //category 2
        $category = new Category();
        $category->setName('Sport et Bien-être');
        $category->setcreatedAt(new \datetime('now'));

        $manager->persist($category);

        // category 3
        $category = new Category();
        $category->setName('Food & Drink Lovers');
        $category->setcreatedAt(new \datetime('now'));

        $manager->persist($category);

        // category 4
        $category = new Category();
        $category->setName('Voyages');
        $category->setcreatedAt(new \datetime('now'));

        $manager->persist($category);

        // category 5
        $category = new Category();
        $category->setName('Musique');
        $category->setcreatedAt(new \datetime('now'));

        $manager->persist($category);

        // category 6
        $category = new Category();
        $category->setName('Bijoux');
        $category->setcreatedAt(new \datetime('now'));

        $manager->persist($category);

        // category 7
        $category = new Category();
        $category->setName('Décoration');
        $category->setcreatedAt(new \datetime('now'));

        $manager->persist($category);
        
        // insert on BDD
        $manager->flush();

    }


}
