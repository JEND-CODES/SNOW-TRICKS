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

    
}
