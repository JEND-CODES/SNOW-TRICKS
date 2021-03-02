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

        $roles = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER'];

        // $figures = [];
        // 30 figures
        $figures = ['Mute', 'Style Week', 'Indy', 'Stalefish', 'Tail grab', 'Nose Grab', 'Japan Air', 'Seat Belt', 'Truck driver', 'Big foot', 'Slide', 'Modulo', 'Flip', 'Method Air', 'Back flip', 'Misty', 'Tail slide', 'Big air', 'Gutter Ball', 'Flip 900', 'Rotation 180', 'Rotation 360', 'Rotation 720', 'Switch 270', 'Front flip', 'Mac Twist', 'Rodeo', 'Backside Air', 'Nose slide', 'Rocket Air'];

        $images = ['http://symfony1.planetcode.fr/photos/styleweek.jpg','http://symfony1.planetcode.fr/photos/tips.jpg','http://symfony1.planetcode.fr/photos/backair.jpg','http://symfony1.planetcode.fr/photos/stalefish.jpg','http://symfony1.planetcode.fr/photos/redstyle.jpg', 'http://symfony1.planetcode.fr/photos/backgrab.jpg', 'http://symfony1.planetcode.fr/photos/birdy.jpg', 'http://symfony1.planetcode.fr/photos/elegant.jpg', 'http://symfony1.planetcode.fr/photos/falling.jpg', 'http://symfony1.planetcode.fr/photos/flying.jpg', 'http://symfony1.planetcode.fr/photos/halfpipe.jpg', 'http://symfony1.planetcode.fr/photos/header.jpg', 'http://symfony1.planetcode.fr/photos/indy.jpg', 'http://symfony1.planetcode.fr/photos/curvy.jpg', 'http://symfony1.planetcode.fr/photos/jumpgrab.jpg', 'http://symfony1.planetcode.fr/photos/longrampe.jpg', 'http://symfony1.planetcode.fr/photos/multiple.jpg', 'http://symfony1.planetcode.fr/photos/jump.jpg', 'http://symfony1.planetcode.fr/photos/noseslide.jpg', 'http://symfony1.planetcode.fr/photos/onehand.jpg', 'http://symfony1.planetcode.fr/photos/perspective.jpg', 'http://symfony1.planetcode.fr/photos/rampe.jpg', 'http://symfony1.planetcode.fr/photos/sapins.jpg', 'http://symfony1.planetcode.fr/photos/slide.jpg', 'http://symfony1.planetcode.fr/photos/slideleft.jpg', 'http://symfony1.planetcode.fr/photos/specialjump.jpg', 'http://symfony1.planetcode.fr/photos/speed.jpg', 'http://symfony1.planetcode.fr/photos/mute.jpg', 'http://symfony1.planetcode.fr/photos/backnose.jpg', 'http://symfony1.planetcode.fr/photos/incredible.jpg'];

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
        // for ($i=0; $i<7; $i++)
        foreach ($members as $key => $value)
        {
            $member = new Member();

            $member->setEmail(''. $members[$key] .'@gmail.com')
                    ->setUsername($members[$key])
                    // Même mot de passe pour tous les Members générés par la Fixture
                    ->setPassword('$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6')
                    // ->setPassword($this->encoder->encodePassword($member, 'password'))
                    ->setCreatedAt(new \DateTime)
                    // ->setToken(hash('sha256', random_bytes(10)))
                    ->setValidation(true)
                    // ->setStatus('1')
                    ->setAvatar('snowAvatar'. $key .'.jpg')
                    // ->setAvatar('snowAvatar'. $key .'-6025b9fc9bcc'. $key .'.png')
                    ->setRole($roles[$key])
    
                    ;
    
            $manager->persist($member);

        }
 

        // 16 CATÉGORIES CRÉÉES
        foreach ($classifications as $key2 => $value2)
        {
            $classification = new Classification();

            $classification->setTitle($value2);

            $manager->persist($classification);

            // $classifications[] = $classification;
        }

        // TRICKS  
        // for ($j=0; $j<30; $j++)

        // 30 TRICKS CRÉÉS
        foreach ($figures as $key3 => $value3)
        {
            

            $figure = new Figure();

            $figure->setTitle($value3)
                    ->setContent("Lorem ipsum sed ut perspiciatis..!")
                    // ->setImage('https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg')
                    // ->setImage('https://coresites-cdn-adm.imgix.net/onboardfr/wp-content/uploads/2015/03/wpid-StaleSandbech_Fonna2013_FrodePhoto_MG_38581.jpg')

                    ->setLabelled(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value3))))

                    ->setImage($images[$key3])
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
            // foreach ($screens as $key4 => $value4)
            {
                $screen = new Screen();

                $screen->setThumbnail($screens[$j])
                        // ->setThumbnail($screens[random_int(0, 5)])
                        // ->setThumbnail($value4)
                        ->setFigure($figure)

                        ;

                $manager->persist($screen);

                // $screens[] = $screen;
                
            }
            
        }

        
        $manager->flush();

    }

}
