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
        // 13 février ajout de fakerPhp via composer :
        // https://packagist.org/packages/fakerphp/faker
        // Full documentation : https://fakerphp.github.io/
        // composer require fakerphp/faker
        // $faker = \Faker\Factory::create('FR-fr');

        // $members = [];

        // $figures = [];
        // 30 figures
        $figures = ['Mute', 'Style Week', 'Indy', 'Stalefish', 'Tail grab', 'Nose Grab', 'Japan Air', 'Seat Belt', 'Truck driver', 'Big foot', 'Slide', 'Rocket Air', 'Flip', 'Method Air', 'Back flip', 'Misty', 'Tail slide', 'Backside air', 'Gutter Ball', 'Flip 900', 'Rotation 180', 'Rotation 360', 'Rotation 720', 'Switch 270', 'Front flip', 'Mac Twist', 'Rodeo', 'Backside Air', 'Nose slide', 'Modulo'];

        // $images = ['https://www.snowsurf.com/media/NEWS_2016/ovembre%202016/itw%20lucile%20lefevre/lucile%20lefevre.jpg', 'https://cdn.unitycms.io/image/focus/1200,900,1000,1000,0,0,500,500/HkMGZ2vmlOc/Ald6zCINK-H84XhALHYLwQ.jpg', 'https://cdn.shopify.com/s/files/1/0244/5983/7536/articles/erik1_1200x.jpg?v=1581671080', 'https://www.sci-sport.com/articles/img/a02400.jpg', 'https://www.10wallpaper.com/wallpaper/2560x1600/1307/snowboard_tricks_guys_snow-Sports_HD_Wallpaper_2560x1600.jpg', 'https://cdn.shopify.com/s/files/1/0148/9585/articles/snowboardingtricks_1800x900.png?v=1539207001', 'https://www.abc-of-snowboarding.com/wp-content/uploads/2019/05/Snowboarding-Tricks.jpg', 'https://cdn.shopify.com/s/files/1/0230/2239/articles/Snowboard_Trick_Terminology_1024x1024.jpg?v=1556396922', 'https://www.abc-of-snowboarding.com/wp-content/uploads/2019/05/Snowboarding-Tricks.jpg', 'https://www.sci-sport.com/articles/img/a02400.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.sci-sport.com/articles/img/a02400.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.sci-sport.com/articles/img/a02400.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'];

        $classifications = [];
        // $arrayClassifications = ['Nouveautés', 'Créations', 'Grabs', 'Rotations', 'Flips', 'Slides', 'One Foot', 'Old School', 'Switchings',  'Improvisés', 'Flyings', 'Big Air', 'Half Pipe', 'Slopestyle', 'Bordercross', 'Street'];

        // $screens = [];
        $screens = ['aINlzgrOovI', '8AWdZKMTG3U', 'Zc8Gu8FwZkQ', 'UrMDH3um3CE', 's3jRiFyOijw', 'SQyTWk7OxSI'];

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
        // for ($j=0; $j<24; $j++)

        // 30 TRICKS CRÉÉS
        foreach ($figures as $key => $value)
        {
            $figure = new Figure();

            // $figure->setTitle('Trick Post '.$j)
            $figure->setTitle($value)
                    ->setContent("Lorem Ipsum sed ut perspiciatis !")
                    ->setImage('https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg')
                    // ->setImage($faker->randomElement($images))
                    ->setCreatedAt(new \Datetime)
                    ->setClassification($classification)
                    ->setUser($member)
                    
                    ;

            $manager->persist($figure);

            $figures[] = $figure;
            
        }

        // 6 MÉDIAS CRÉÉS 
        // for ($j=0; $j<6; $j++)
        foreach ($screens as $key => $media)
        {
            $screen = new Screen();

            $screen->setThumbnail($media)
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
