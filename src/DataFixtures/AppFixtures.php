<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Member;
use App\Entity\Figure;
use App\Entity\Classification;
use App\Entity\Screen;
use App\Entity\Mention;

use App\Repository\MemberRepository;
use App\Repository\FigureRepository;
use App\Repository\ClassificationRepository;
use App\Repository\ScreenRepository;
use App\Repository\MentionRepository;


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

    public function __construct(ClassificationRepository $classificationRepository, FigureRepository $figureRepository, ScreenRepository $screenRepository, MentionRepository $mentionRepository, MemberRepository $memberRepository /*, UserPasswordEncoderInterface $encoder */)
	{
		$this->classificationRepository = $classificationRepository;
		$this->figureRepository = $figureRepository;
		$this->screenRepository = $screenRepository;
		$this->mentionRepository = $mentionRepository;
		$this->memberRepository = $memberRepository;

		// $this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {
        // 13 février ajout de fakerPhp via composer :
        // https://packagist.org/packages/fakerphp/faker
        // Full documentation : https://fakerphp.github.io/
        // composer require fakerphp/faker
        // $faker = \Faker\Factory::create('FR-fr');

        // $members = [];
        $members = ['jean', 'julie', 'vincent', 'billy', 'marion', 'michel', 'paolo'];

        // $figures = [];
        // 30 figures
        $figures = ['Mute', 'Style Week', 'Indy', 'Stalefish', 'Tail grab', 'Nose Grab', 'Japan Air', 'Seat Belt', 'Truck driver', 'Big foot', 'Slide', 'Modulo', 'Flip', 'Method Air', 'Back flip', 'Misty', 'Tail slide', 'Big air', 'Gutter Ball', 'Flip 900', 'Rotation 180', 'Rotation 360', 'Rotation 720', 'Switch 270', 'Front flip', 'Mac Twist', 'Rodeo', 'Backside Air', 'Nose slide', 'Rocket Air'];

        // $images = ['http://localhost:8000/photos/styleweek.jpg','http://localhost:8000/photos/tips.jpg','http://localhost:8000/photos/backair.jpg','http://localhost:8000/photos/stalefish.jpg','http://localhost:8000/photos/redstyle.jpg', 'http://localhost:8000/photos/backgrab.jpg', 'http://localhost:8000/photos/birdy.jpg', 'http://localhost:8000/photos/elegant.jpg', 'http://localhost:8000/photos/falling.jpg', 'http://localhost:8000/photos/flying.jpg', 'http://localhost:8000/photos/halfpipe.jpg', 'http://localhost:8000/photos/header.jpg', 'http://localhost:8000/photos/indy.jpg', 'http://localhost:8000/photos/curvy.jpg', 'http://localhost:8000/photos/jumpgrab.jpg', 'http://localhost:8000/photos/longrampe.jpg', 'http://localhost:8000/photos/multiple.jpg', 'http://localhost:8000/photos/jump.jpg', 'http://localhost:8000/photos/noseslide.jpg', 'http://localhost:8000/photos/onehand.jpg', 'http://localhost:8000/photos/perspective.jpg', 'http://localhost:8000/photos/rampe.jpg', 'http://localhost:8000/photos/sapins.jpg', 'http://localhost:8000/photos/slide.jpg', 'http://localhost:8000/photos/slideleft.jpg', 'http://localhost:8000/photos/specialjump.jpg', 'http://localhost:8000/photos/speed.jpg', 'http://localhost:8000/photos/mute.jpg', 'http://localhost:8000/photos/backnose.jpg', 'http://localhost:8000/photos/incredible.jpg'];

        // $classifications = [];
        $classifications = ['Nouveautés', 'Créations', 'Grabs', 'Rotations', 'Flips', 'Slides', 'One Foot', 'Old School', 'Switchings',  'Improvisés', 'Flyings', 'Big Air', 'Half Pipe', 'Slopestyle', 'Bordercross', 'Street'];

        // $screens = [];
        // $screens = ['http://localhost:8000/backgrounds/snowExample1.jpg', 'http://localhost:8000/backgrounds/snowExample2.jpg', 'http://localhost:8000/backgrounds/snowExample3.jpg', 'UrMDH3um3CE', 's3jRiFyOijw', 'SQyTWk7OxSI'];

        $screens = ['https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'UrMDH3um3CE', 's3jRiFyOijw', 'SQyTWk7OxSI'];

        // https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg

        // $mentions = [];

        // Pour remettre l'Index de départ au lancement de chaque nouvelle fixture
		$this->memberRepository->fixtureIndex();
		$this->screenRepository->fixtureIndex();
		$this->mentionRepository->fixtureIndex();
		$this->figureRepository->fixtureIndex();
		$this->classificationRepository->fixtureIndex();

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
        /*
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
                ->setAvatar('snowAvatar7.jpg')
                // ->setAvatar('snowAvatar'. $i .'-6025b9fc9bcc'. $i .'.png')

                ;

        $manager->persist($member);
        */

        // CRÉATION DE 7 MEMBRES
        for ($i=0; $i<7; $i++)
        {
            $member = new Member();

            $member->setEmail(''. $members[$i] .'@gmail.com')
                    ->setUsername($members[$i])
                    // Même mot de passe pour tous les Members générés par la Fixture
                    ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                    // ->setPassword($this->encoder->encodePassword($member, 'password'))
                    ->setCreatedAt(new \DateTime)
                    // ->setToken(hash('sha256', random_bytes(10)))
                    ->setValidation(true)
                    // ->setStatus('1')
                    ->setAvatar('snowAvatar'. $i .'.jpg')
                    // ->setAvatar('snowAvatar'. $i .'-6025b9fc9bcc'. $i .'.png')
    
                    ;
    
            $manager->persist($member);

        }
 

        // 16 CATÉGORIES CRÉÉES
        foreach ($classifications as $key => $value)
        {
            $classification = new Classification();

            $classification->setTitle($value);

            $manager->persist($classification);

            // $classifications[] = $classification;
        }

        // TRICKS  
        // for ($j=0; $j<30; $j++)

        // 30 TRICKS CRÉÉS
        foreach ($figures as $key2 => $value2)
        {
            

            $figure = new Figure();

            $figure->setTitle($value2)
                    ->setContent("Lorem ipsum sed ut perspiciatis..!")
                    // ->setImage('https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg')
                    ->setImage('https://coresites-cdn-adm.imgix.net/onboardfr/wp-content/uploads/2015/03/wpid-StaleSandbech_Fonna2013_FrodePhoto_MG_38581.jpg')

                    ->setLabelled(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value2))))

                    // ->setImage($images[$key2])
                    // ->setImage($faker->randomElement($images))
                    ->setCreatedAt(new \Datetime)
                    ->setClassification($classification)
                    ->setUser($member)
                    
                    
                    ;

            $manager->persist($figure);

            // $figures[] = $figure;

            // 24 COMMENTAIRES CRÉÉS
            // for ($k=0; $k<24; $k++)
            // {
                $mention = new Mention();

                $mention->setContent("Lorem ipsum dolor sit amet..!")
                        // ->setContent($faker->sentences(1, true))
                        ->setCreatedAt(new \Datetime)
                        ->setFigure($figure)
                        // ->setAuthor("Billy")
                        ->setUser($member)

                        ;

                $manager->persist($mention);

                // $mentions[] = $mention;
                
            // }

            // 6 MÉDIAS CRÉÉS 
            for ($j=0; $j<6; $j++)
            // foreach ($screens as $key3 => $value3)
            {
                $screen = new Screen();

                $screen->setThumbnail($screens[$j])
                        // ->setThumbnail($screens[random_int(0, 5)])
                        // ->setThumbnail($value3)
                        ->setFigure($figure)

                        ;

                $manager->persist($screen);

                // $screens[] = $screen;
                
            }
            
        }

        
        $manager->flush();

    }

}
