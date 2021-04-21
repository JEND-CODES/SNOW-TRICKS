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
    public function __construct(ClassificationRepository $classificationRepo, FigureRepository $figureRepo, ScreenRepository $screenRepo, MentionRepository $mentionRepo, MemberRepository $memberRepo)
	{
		$this->classificationRepo = $classificationRepo;
		$this->figureRepo = $figureRepo;
		$this->screenRepo = $screenRepo;
		$this->mentionRepo = $mentionRepo;
		$this->memberRepo = $memberRepo;
	}

    public function load(ObjectManager $manager)
    {
        
        $faker = \Faker\Factory::create('FR-fr');

        $members = ['jean', 'julie', 'vincent', 'billy', 'marion', 'michel', 'paolo'];

        $roles = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER', 'ROLE_USER'];

        $figures = ['Mute', 'Style Week', 'Indy', 'Stalefish', 'Tail grab', 'Nose Grab', 'Japan Air', 'Seat Belt', 'Truck driver', 'Big foot', 'Slide', 'Modulo', 'Flip', 'Method Air', 'Back flip', 'Misty', 'Tail slide', 'Big air', 'Gutter Ball', 'Flip 900', 'Rotation 180', 'Rotation 360', 'Rotation 720', 'Switch 270', 'Front flip', 'Mac Twist', 'Rodeo', 'Backside Air', 'Nose slide', 'Rocket Air'];

        $images = ['<DOMAIN_NAME>/photos/styleweek.jpg','<DOMAIN_NAME>/photos/tips.jpg','<DOMAIN_NAME>/photos/backair.jpg','<DOMAIN_NAME>/photos/stalefish.jpg','<DOMAIN_NAME>/photos/redstyle.jpg', '<DOMAIN_NAME>/photos/backgrab.jpg', '<DOMAIN_NAME>/photos/birdy.jpg', '<DOMAIN_NAME>/photos/elegant.jpg', '<DOMAIN_NAME>/photos/falling.jpg', '<DOMAIN_NAME>/photos/flying.jpg', '<DOMAIN_NAME>/photos/halfpipe.jpg', '<DOMAIN_NAME>/photos/header.jpg', '<DOMAIN_NAME>/photos/indy.jpg', '<DOMAIN_NAME>/photos/curvy.jpg', '<DOMAIN_NAME>/photos/jumpgrab.jpg', '<DOMAIN_NAME>/photos/longrampe.jpg', '<DOMAIN_NAME>/photos/multiple.jpg', '<DOMAIN_NAME>/photos/jump.jpg', '<DOMAIN_NAME>/photos/noseslide.jpg', '<DOMAIN_NAME>/photos/onehand.jpg', '<DOMAIN_NAME>/photos/perspective.jpg', '<DOMAIN_NAME>/photos/rampe.jpg', '<DOMAIN_NAME>/photos/sapins.jpg', '<DOMAIN_NAME>/photos/slide.jpg', '<DOMAIN_NAME>/photos/slideleft.jpg', '<DOMAIN_NAME>/photos/specialjump.jpg', '<DOMAIN_NAME>/photos/speed.jpg', '<DOMAIN_NAME>/photos/mute.jpg', '<DOMAIN_NAME>/photos/backnose.jpg', '<DOMAIN_NAME>/photos/incredible.jpg'];

        $classifications = ['Nouveautés', 'Créations', 'Grabs', 'Rotations', 'Flips', 'Slides', 'One Foot', 'Old School', 'Switchings',  'Improvisés', 'Flyings', 'Big Air', 'Half Pipe', 'Slopestyle', 'Bordercross', 'Street'];

        $screens = ['https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg', 'UrMDH3um3CE', 's3jRiFyOijw', 'SQyTWk7OxSI'];

		$this->memberRepo->fixtureIndex();
		$this->screenRepo->fixtureIndex();
		$this->mentionRepo->fixtureIndex();
		$this->figureRepo->fixtureIndex();
		$this->classificationRepo->fixtureIndex();

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
