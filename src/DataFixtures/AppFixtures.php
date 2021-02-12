<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Member;
use App\Entity\Figure;
use App\Entity\Classification;
use App\Entity\Screen;
use App\Entity\Mention;

// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// Voir documentation Symfony DoctrineFixturesBundle : 
// https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html

// Pour générer les Fixtures entrer : "php bin/console doctrine:fixtures:load"
// Attention toute la base de donnée est réinitialisée lors de l'opération (purging database) ! 

class AppFixtures extends Fixture
{

    /*
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    */

    public function load(ObjectManager $manager)
    {
        // $members = [];
        $figures = [];
        // $classifications = [];
        // $arrayCategories = ['Actualités', 'Nouveautés'];
        $screens = [];
        // $mentions = [];

        /*
        // 2 MEMBRES CRÉÉS
        for ($i=0; $i<2; $i++)
        {
            $member = new Member();

            $member->setEmail('billy'. $i .'@gmail.com')
                    ->setUsername('Billy'.$i)
                    // Même mot de passe pour tous les Members générés par la Fixture
                    ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                    // ->setPassword($this->encoder->encodePassword($user, 'password'))
                    ->setCreatedAt(new \DateTime)
                    ->setToken(hash('sha256', random_bytes(10)))
                    ->setValidation(true)
                    ->setStatus('1')
                    ->setAvatar('snowAvatar'. $i .'-6025b9fc9bcc8.png')
                    // ->setAvatar('snowAvatar'. $i .'-6025b9fc9bcc'. $i .'.png')

                 ;

            $manager->persist($member);

            $members[] = $member;
        }
        */

        // 1 MEMBRE CRÉÉ

            $member = new Member();

            $member->setEmail('billy@gmail.com')
                    ->setUsername('Billy')
                    // Même mot de passe pour tous les Members générés par la Fixture
                    ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                    // ->setPassword($this->encoder->encodePassword($user, 'password'))
                    ->setCreatedAt(new \DateTime)
                    // ->setToken(hash('sha256', random_bytes(10)))
                    ->setValidation(true)
                    ->setStatus('1')
                    ->setAvatar('newAvatar-2020b9fc9bcc8.jpg')
                    // ->setAvatar('snowAvatar'. $i .'-6025b9fc9bcc'. $i .'.png')

                 ;

            $manager->persist($member);
 

        // 2 CATÉGORIES CRÉÉES
        // foreach ($arrayCategories as $value)
        // {
            $classification = new Classification();

            // $classification->setTitle($value);

            $classification->setTitle("Nouveautés");

            $manager->persist($classification);

            // $classifications[] = $classification;
        // }

        // 24 TRICKS CRÉÉS 
        for ($j=0; $j<24; $j++)
        {
            $figure = new Figure();

            $figure->setTitle('Trick Post '.$j)
                    ->setContent("Lorem Ipsum sed ut perspiciatis !")
                    ->setImage('https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg')
                    ->setCreatedAt(new \Datetime)
                    ->setClassification($classification)
                    
                    ;

            $manager->persist($figure);

            $figures[] = $figure;
            
        }

        // 6 MÉDIAS CRÉÉS 
        for ($j=0; $j<6; $j++)
        {
            $screen = new Screen();

            $screen->setThumbnail('8AWdZKMTG3U')
                    // ->setFigure(20)
                    ->setFigure($figure)

                    ;

            $manager->persist($screen);

            $screens[] = $screen;
            
        }

        // 24 COMMENTAIRES CRÉÉS
        // for ($k=0; $k<24; $k++)
        // {
            $mention = new Mention();

            // $mention->setAuthor('Membre '.$k)
            $mention->setAuthor('Billy')
                    ->setContent("Lorem Ipsum sed ut perspiciatis !")
                    ->setCreatedAt(new \Datetime)
                    // ->setFigure(20)
                    // ->setUser(1)
                    ->setFigure($figure)
                    ->setUser($member)

                    ;

            $manager->persist($mention);

            // $mentions[] = $mention;
            
        // }
        

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();

    }

}
