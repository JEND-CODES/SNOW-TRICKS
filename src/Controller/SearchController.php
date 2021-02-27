<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\FigureRepository;

use Symfony\Component\Security\Core\Security;

class SearchController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, FigureRepository $repoFigure)
    {

        $current_member = $this->security->getUser();

        $posts = '';
        
        $nothing = '';

        $get_figure = $request->query->get('query');
        
        if(isset($get_figure) AND !empty($get_figure)) 
        {
            $query = htmlspecialchars($get_figure);

            // $posts = $bdd->query('SELECT id, title, labelled, SUBSTRING(content, 1, 200) AS content FROM figure WHERE title LIKE "%'.$q.'%" ORDER BY id DESC');

            $posts = $repoFigure->findByQuery($query);

            if(!$posts) {

                $nothing = 'Aucun résultat';

            }
            
        }

        return $this->render('search/searching.html.twig', [
            'current_member' => $current_member,
            'posts' => $posts,
            'nothing' => $nothing
        ]);

    }


}
