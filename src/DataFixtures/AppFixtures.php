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

class AppFixtures extends Fixture
{
    public function __construct(ClassificationRepository $classificationRepository, FigureRepository $figureRepository, ScreenRepository $screenRepository, MentionRepository $mentionRepository, MemberRepository $memberRepository)
	{
		$this->classificationRepository = $classificationRepository;
		$this->figureRepository = $figureRepository;
		$this->screenRepository = $screenRepository;
		$this->mentionRepository = $mentionRepository;
		$this->memberRepository = $memberRepository;

	}

    public function load(ObjectManager $manager)
    {
        
        $faker = \Faker\Factory::create('FR-fr');

        $members = ['jean', 'julie', 'vincent', 'billy', 'marion', 'michel', 'paolo'];

        $roles = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER'];

        $figures = ['Mute', 'Style Week', 'Indy', 'Stalefish', 'Tail grab', 'Nose Grab', 'Japan Air', 'Seat Belt', 'Truck driver', 'Big foot', 'Slide', 'Modulo', 'Flip', 'Method Air', 'Back flip', 'Misty', 'Tail slide', 'Big air', 'Gutter Ball', 'Flip 900', 'Rotation 180', 'Rotation 360', 'Rotation 720', 'Switch 270', 'Front flip', 'Mac Twist', 'Rodeo', 'Backside Air', 'Nose slide', 'Rocket Air'];

        $images = ['http://snow.planetcode.fr/photos/styleweek.jpg','http://snow.planetcode.fr/photos/tips.jpg','http://snow.planetcode.fr/photos/backair.jpg','http://snow.planetcode.fr/photos/stalefish.jpg','http://snow.planetcode.fr/photos/redstyle.jpg', 'http://snow.planetcode.fr/photos/backgrab.jpg', 'http://snow.planetcode.fr/photos/birdy.jpg', 'http://snow.planetcode.fr/photos/elegant.jpg', 'http://snow.planetcode.fr/photos/falling.jpg', 'http://snow.planetcode.fr/photos/flying.jpg', 'http://snow.planetcode.fr/photos/halfpipe.jpg', 'http://snow.planetcode.fr/photos/header.jpg', 'http://snow.planetcode.fr/photos/indy.jpg', 'http://snow.planetcode.fr/photos/curvy.jpg', 'http://snow.planetcode.fr/photos/jumpgrab.jpg', 'http://snow.planetcode.fr/photos/longrampe.jpg', 'http://snow.planetcode.fr/photos/multiple.jpg', 'http://snow.planetcode.fr/photos/jump.jpg', 'http://snow.planetcode.fr/photos/noseslide.jpg', 'http://snow.planetcode.fr/photos/onehand.jpg', 'http://snow.planetcode.fr/photos/perspective.jpg', 'http://snow.planetcode.fr/photos/rampe.jpg', 'http://snow.planetcode.fr/photos/sapins.jpg', 'http://snow.planetcode.fr/photos/slide.jpg', 'http://snow.planetcode.fr/photos/slideleft.jpg', 'http://snow.planetcode.fr/photos/specialjump.jpg', 'http://snow.planetcode.fr/photos/speed.jpg', 'http://snow.planetcode.fr/photos/mute.jpg', 'http://snow.planetcode.fr/photos/backnose.jpg', 'http://snow.planetcode.fr/photos/incredible.jpg'];

        $classifications = ['Nouveautés', 'Créations', 'Grabs', 'Rotations', 'Flips', 'Slides', 'One Foot', 'Old School', 'Switchings',  'Improvisés', 'Flyings', 'Big Air', 'Half Pipe', 'Slopestyle', 'Bordercross', 'Street'];

        $screens = ['https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'UrMDH3um3CE', 's3jRiFyOijw', 'SQyTWk7OxSI'];

		$this->memberRepository->fixtureIndex();
		$this->screenRepository->fixtureIndex();
		$this->mentionRepository->fixtureIndex();
		$this->figureRepository->fixtureIndex();
		$this->classificationRepository->fixtureIndex();

        foreach ($members as $key => $value)
        {
            $member = new Member();

            $member->setEmail(''. $members[$key] .'@gmail.com')
                    ->setUsername($members[$key])
                    ->setPassword('$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6')
                    ->setCreatedAt(new \DateTime)
                    ->setValidation(true)
                    ->setAvatar('snowAvatar'. $key .'.jpg')
                    ->setRole($roles[$key])
                    ;
    
            $manager->persist($member);

        }
 

        foreach ($classifications as $key2 => $value2)
        {
            $classification = new Classification();

            $classification->setTitle($value2);

            $manager->persist($classification);

        }

    
        foreach ($figures as $key3 => $value3)
        {
            
            $figure = new Figure();

            $figure->setTitle($value3)
                    ->setContent($faker->paragraph(3))
                    ->setLabelled(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value3))))
                    ->setImage($images[$key3])
                    ->setCreatedAt(new \Datetime)
                    ->setClassification($classification)
                    ->setUser($member)
                    ;

            $manager->persist($figure);


            $mention = new Mention();

            $mention->setContent($faker->sentences(1, true))
                    ->setCreatedAt(new \Datetime)
                    ->setFigure($figure)
                    ->setUser($member)
                    ;

            $manager->persist($mention);


            for ($j=0; $j<6; $j++)
            {
                $screen = new Screen();

                $screen->setThumbnail($screens[$j])
                        ->setFigure($figure)
                        ;

                $manager->persist($screen);

            }
            
        }

        $manager->flush();

    }

}
