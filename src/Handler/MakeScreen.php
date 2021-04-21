<?php

namespace App\Handler;

use App\Entity\Screen;

class MakeScreen
{
    /**
     * @param $figure
     */
    public function newScreen($figure)
    {

        for($i = 1; $i <= 24; $i++) {

            $dynamic_screen[$i] = new Screen();

            $dynamic_screen[$i]->setThumbnail('');
            
            $figure->getScreens()->add($dynamic_screen[$i]);

            if(!$dynamic_screen[$i]->getId())
            {
            
                $dynamic_screen[$i]->setFigure($figure);
            }

        }
        
    }

    /**
     * @param int $addScreen
     * @param $figure
     */
    public function nextScreen($addScreen, $figure)
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
