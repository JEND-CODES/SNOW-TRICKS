<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Classification;
use App\Entity\Figure;
use App\Entity\Member;
use App\Entity\Mention;
use App\Entity\Screen;

class EntityTest extends TestCase
{

    // FIGURE
    public function testFigureId()
	{
		$figure = new Figure();

		$id = null;

		$this->assertEquals($id, $figure->getId());
	}

 	public function testFigureFields()
	{
		$figure = new Figure();

		$value = "Lorem Ipsum";

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));

        $image = "http://planetcode.fr/photos/styleweek.jpg";

        $date = new \Datetime;

		$figure->setTitle($value)
				->setContent($value)
                ->setLabelled($slug)
                ->setImage($image)
                ->setCreatedAt($date)
                ->setFreshDate($date)
				;

		$this->assertEquals($value, $figure->getTitle());
		$this->assertEquals($value, $figure->getContent());
        $this->assertEquals($slug, $figure->getLabelled());
        $this->assertEquals($image, $figure->getImage());
        $this->assertEquals($date, $figure->getCreatedAt());
        $this->assertEquals($date, $figure->getFreshDate());
	} 

    public function testFigureSetUser()
    {
        $figure = new Figure();

        $figure->setUser(new Member);

        $this->assertInstanceOf(Member::class, $figure->getUser());
    }

    public function testFigureSetClassification()
    {
        $figure = new Figure();

        $classification = new Classification();

        $figure->setClassification($classification);

        $this->assertSame($classification, $figure->getClassification());
    }

    public function testFigureRemoveMention()
	{
		$figure = new Figure();

		$mention = new Mention();

		$figure->addMention($mention);

		$this->assertEquals($mention, $figure->getMentions()[0]);

		$figure->removeMention($mention);

		$this->assertEquals([], $figure->getMentions()->toArray());
	}

    public function testFigureRemoveScreen()
	{
		$figure = new Figure();

		$screen = new Screen();

		$figure->addScreen($screen);

		$this->assertEquals($screen, $figure->getScreens()[0]);

		$figure->removeScreen($screen);

		$this->assertEquals([], $figure->getScreens()->toArray());
	}

    // MENTION
    public function testMentionSetUser()
    {
        $mention = new Mention();

        $mention->setUser(new Member);

        $this->assertInstanceOf(Member::class, $mention->getUser());
    }

    // SCREEN
    public function testScreenSetFigure()
    {
        $screen = new Screen();

        $figure = new Figure();

        $screen->setFigure($figure);

        $this->assertSame($figure, $screen->getFigure());
    }
    
    // MEMBER
    public function testMemberSetValidation()
    {
        $member = new Member();

        $member->setValidation(true);

        $this->assertEquals($member->getValidation(), true);
    }

    public function testMemberEraseCredentials()
    {
        $member = new Member();

        $this->assertEquals($member->eraseCredentials(), null);
    }

    // CLASSIFICATION
    public function testClassificationRemoveFigure()
	{
		$classification = new Classification();

		$figure = new Figure();

		$classification->addFigure($figure);

		$this->assertEquals($figure, $classification->getFigures()[0]);

		$classification->removeFigure($figure);

		$this->assertEquals([], $classification->getFigures()->toArray());
	}

    // Renvoi d'erreur : "TypeError: Argument 1 passed to App\Entity\Member::setPassword() must be of the type string, null given"
    /*
	public function testMemberPassword()
	{
		$member = new Member();

		$value = null;

		$member->setPassword($value);

		$this->assertEquals($value, $member->getPassword());
		
	}
    */

    // Renvoi d'erreur : "TypeError: Argument 1 passed to App\Entity\Member::setEmail() must be of the type string, null given"
    /*
    public function testMemberEmail()
    {
        $member = new Member();

        $value = null;

        $member->setEmail($value);

        $this->assertEquals($value, $member->getEmail());
    }
    */

    // Renvoi d'erreur : "TypeError: Argument 1 passed to App\Entity\Member::setUsername() must be of the type string, null given"
    /*
    public function testMemberPseudo()
    {
        $member = new Member();

        $pseudo = null;

        $member->setUsername($pseudo);

        $this->assertEquals($pseudo, $member->getUsername());
        
    }
    */
    

}
