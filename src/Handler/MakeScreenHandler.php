<?php

namespace App\Handler;

use App\Entity\Screen;
use App\Entity\Figure;

class MakeScreenHandler
{

    /**
     * @param int $addScreen
     * @param Figure $figure
     */
    public function handle(int $addScreen, Figure $figure)
    {

        for($j = 1; $j <= $addScreen; $j++) {

            $dynamic_screen[$j] = new Screen();

            $dynamic_screen[$j]->setThumbnail('');
            
            $figure->getScreens()->add($dynamic_screen[$j]);

            if(!$dynamic_screen[$j]->getId())
            {
                $dynamic_screen[$j]->setFigure($figure);
            }

        }
        
    }


}
