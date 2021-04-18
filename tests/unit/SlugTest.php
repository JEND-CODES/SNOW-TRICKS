<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{

    public function testSlug()
    {
                    
    $before = "Snow Tricks";

    $after = "snow-tricks";

    $result = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $before)));

    $this->assertEquals($result, $after);

    } 

}