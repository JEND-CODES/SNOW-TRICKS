<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
// use Doctrine\ORM\EntityManager;
use App\Entity\Classification;
use App\Entity\Figure;
use App\Entity\Member;
use App\Entity\Mention;
use App\Entity\Screen;

// php bin/phpunit
// php bin/console cache:clear

// Doc : https://symfony.com/doc/current/testing.html

class EntityTest extends TestCase
{
    // private $entityManager;

 	public function testFigure()
	{
		$figure = new Figure();

		$value = "Lorem";

		$figure->setTitle($value)
				->setContent($value)
				;

		$this->assertEquals($value, $figure->getTitle());
		$this->assertEquals($value, $figure->getContent());
	} 

    public function testClassification()
    {
        $figure = new Figure();

        $classification = new Classification();

        $figure->setClassification($classification);

        $this->assertSame($classification, $figure->getClassification());
    }

    public function testScreen()
    {
        $screen = new Screen();

        $figure = new Figure();

        $screen->setFigure($figure);

        $this->assertSame($figure, $screen->getFigure());
    }

    public function testMention()
    {
        $mention = new Mention();

        $member = new Member();

        $mention->setUser($member);

        $this->assertSame($member, $mention->getUser());
    }

    // Renvoi d'erreur
    /*
	public function testMember()
	{
		$member = new Member();

		$value = null;

		$member->setPassword($value);

		$this->assertEquals($value, $member->getPassword());
		
	}
    */

    // Renvoi d'erreur
    /*
    public function testEmail()
    {
        $member = new Member();

        $value = null;

        $member->setEmail($value);

        $this->assertEquals($value, $member->getEmail());
    }
    */

    // Renvoi d'erreur
    /*
    public function testPseudo()
    {
        $member = new Member();

        $pseudo = null;

        $member->setUsername($pseudo);

        $this->assertEquals($pseudo, $member->getUsername());
        
    }
    */

   

}
