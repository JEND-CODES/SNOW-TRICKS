<?php

// LIVE ! php -S localhost:8000 -t public

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Mention;
use App\Entity\Screen;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FigureRepository;
use Symfony\Component\Security\Core\Security;
use App\Form\FigureType;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\MentionType;

class BlogController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    /**
     * @Route("/", name="blog")
     */
    public function blog(FigureRepository $repoFigure)
    {
        $current_member = $this->security->getUser();
      
        $figureSlides = $repoFigure->findBy(array(), array('id' => 'DESC'), 3);

        $promoteFigures = $repoFigure->findBy(array(), array('id' => 'DESC'), 6, 3);
        
        return $this->render('blog/posts.html.twig', [
            'current_member' => $current_member,
            'figureSlides' => $figureSlides,
            'promoteFigures' => $promoteFigures
        ]);
    }

    /**
     * @Route("/{starting}", name="more_figures", requirements={"starting": "\d+"})
     */
    public function moreFigures(FigureRepository $repoFigure, $starting = 3)
    {
        $promoteFigures = $repoFigure->findBy(array(), array('id' => 'DESC'), 3, $starting + 6);

        return $this->render('inc/tricksPaging.html.twig', [
            'promoteFigures' => $promoteFigures
        ]);
    }

    /**
    * @Route("/blog/new", name="blog_create")
    */
    public function createFigure(Figure $figure = null, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $current_member = $this->security->getUser();

        $figure = new Figure();

        for($i = 1; $i <= 24; $i++) {

            $dynamic_screen[$i] = new Screen();

            $dynamic_screen[$i]->setThumbnail('');
            
            $figure->getScreens()->add($dynamic_screen[$i]);

            if(!$dynamic_screen[$i]->getId())
            {
            
                $dynamic_screen[$i]->setFigure($figure);
            }

        }

        $createFigure = $this->createForm(FigureType::class, $figure);
        
        $createFigure->handleRequest($request);
        
        if($createFigure->isSubmitted() && $createFigure->isValid())
        {
            if(!$figure->getId())
            {
                $figure->setCreatedAt(new \DateTime());

                $figure->setLabelled($slugger->slug($figure->getTitle()));

                $figure->setUser($this->getUser());
            }

            $manager->persist($figure);

            $manager->flush();

            $this->addFlash(
                'notice',
                'CRÉATION RÉUSSIE'
            );
            
            return $this->redirectToRoute('chapter_show',[
                'id' => $figure->getId(),
                'labelled' => $figure->getLabelled()
            ]);
        }
        
        return $this->render('blog/createChapter.html.twig',[
            'current_member' => $current_member,
            'createFigure' => $createFigure->createView()
        ]);
        
    }

    /**
    * @Route("/blog/{id}/edit", name="blog_edit")
    */
    public function updateFigure(Figure $figure, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $current_member = $this->security->getUser();

        $screenCount = count($figure->getScreens());

        $addScreen = 24 - $screenCount;

        for($j = 1; $j <= $addScreen; $j++) {

            $dynamic_screen[$j] = new Screen();

            $dynamic_screen[$j]->setThumbnail('');
            
            $figure->getScreens()->add($dynamic_screen[$j]);

            if(!$dynamic_screen[$j]->getId())
            {
            
                $dynamic_screen[$j]->setFigure($figure);
            }

        }
       
        $updateFigure = $this->createForm(FigureType::class, $figure);
        
        $updateFigure->handleRequest($request);
        
        if($updateFigure->isSubmitted() && $updateFigure->isValid())
        {
         
            $figure->setFreshDate(new \DateTime());

            $figure->setLabelled($slugger->slug($figure->getTitle()));
            
            $manager->persist($figure);

            $manager->flush();

            $this->addFlash(
                'notice',
                'MISE À JOUR RÉUSSIE'
            );
            
            return $this->redirectToRoute('chapter_show',[
                'id' => $figure->getId(),
                'labelled' => $figure->getLabelled()
            ]);
        }
        
        return $this->render('blog/updateChapter.html.twig',[
            'current_member' => $current_member,
            'figure' => $figure,
            'updateFigure' => $updateFigure->createView()
        ]);
        
        
    }

    /**
     * @Route("/blog/{id}/{labelled}", name="chapter_show")
     */
    public function show(Figure $figure, Request $request, string $labelled)
    {

        $current_member = $this->security->getUser();

        $get_mentions = $request->query->get('show_mentions');

        if (is_null($get_mentions))
        {
        
            $start = 0;
            $limit = 10;

        } else {

            $start = (int) strip_tags($get_mentions);
            $limit = 10;
            
        }

        $mention = new Mention();

        $formMention = $this->createForm(MentionType::class, $mention);
        
        $formMention->handleRequest($request);
            
        if($formMention->isSubmitted() && $formMention->isValid()) 
        {
            if(!$mention->getId())
                {
                    $mention->setCreatedAt(new \DateTime());
                
                    $mention->setFigure($figure);

                    $mention->setUser($this->getUser());
                }
            
            $mention = $formMention->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($mention);
            
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'COMMENTAIRE AJOUTÉ'
            );
        
            return $this->redirect($request->getUri());
        }

        return $this->render('blog/oneChapter.html.twig', array(
            'current_member' => $current_member,
            'limit' => $limit,
            'start' => $start,
            'figure' => $figure,
            'labelled' => $figure->getLabelled(),
            'formMention' => $formMention->createView()
        ));
        
    }
   
    /**
     * @Route("/office/delete/{id}", name="delete_chapter")
     * @Method({"DELETE"})
     */
    public function delete(Figure $figure) 
    {
        $entityManager = $this->getDoctrine()->getManager();
       
        $entityManager->remove($figure);
        
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'SUPPRESSION RÉALISÉE'
        );

        return $this->redirect($this->generateUrl('blog'));
        
    }
    
  
}
