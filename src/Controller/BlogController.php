<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Mention;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FigureRepository;
use Symfony\Component\Security\Core\Security;
use App\Form\FigureType;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\MentionType;
use App\Handler\MakeScreen;

class BlogController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var SluggerInterface
     */
    private $slugger;

    /**
     * @var MakeScreen
     */
    private $makeScreen;

    public function __construct(Security $security, EntityManagerInterface $manager, SluggerInterface $slugger, MakeScreen $makeScreen)
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->slugger = $slugger;
        $this->makeScreen = $makeScreen;
    }

    /**
     * @Route("/", name="blog")
     * @param FigureRepository $repoFigure
     * @return Response
     */
    public function blog(FigureRepository $repoFigure): Response
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
     * @param FigureRepository $repoFigure
     * @param int $starting
     * @return Response
     */
    public function moreFigures(FigureRepository $repoFigure, $starting = 3): Response
    {
        $promoteFigures = $repoFigure->findBy(array(), array('id' => 'DESC'), 3, $starting + 6);

        return $this->render('inc/tricksPaging.html.twig', [
            'promoteFigures' => $promoteFigures
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @param Figure $figure
     * @param Request $request
     * @return Response
     */
    public function createFigure(Figure $figure = null, Request $request): Response
    {
        $current_member = $this->security->getUser();

        $figure = new Figure();

        $this->makeScreen->newScreen($figure);

        $createFigure = $this->createForm(FigureType::class, $figure);
        
        $createFigure->handleRequest($request);
        
        if($createFigure->isSubmitted() && $createFigure->isValid())
        {
            if(!$figure->getId())
            {
                $figure->setCreatedAt(new \DateTime());

                $figure->setLabelled($this->slugger->slug($figure->getTitle()));

                $figure->setUser($this->getUser());
            }

            $this->manager->persist($figure);

            $this->manager->flush();

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
     * @param Figure $figure
     * @param Request $request
     * @return Response
     */
    public function updateFigure(Figure $figure, Request $request): Response
    {
        $current_member = $this->security->getUser();

        $screenCount = count($figure->getScreens());

        $addScreen = 24 - $screenCount;

        $this->makeScreen->nextScreen($addScreen, $figure);
       
        $updateFigure = $this->createForm(FigureType::class, $figure);
        
        $updateFigure->handleRequest($request);
        
        if($updateFigure->isSubmitted() && $updateFigure->isValid())
        {
         
            $figure->setFreshDate(new \DateTime());

            $figure->setLabelled($this->slugger->slug($figure->getTitle()));
            
            $this->manager->persist($figure);

            $this->manager->flush();

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
     * @param Figure $figure
     * @param Request $request
     * @param string $labelled
     * @return Response
     */
    public function show(Figure $figure, Request $request, string $labelled): Response
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

            $this->manager->persist($mention);
            
            $this->manager->flush();

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
     * @param Figure $figure
     * @return RedirectResponse
     */
    public function delete(Figure $figure) 
    {
        $this->manager->remove($figure);
            
        $this->manager->flush();

        $this->addFlash(
            'notice',
            'SUPPRESSION RÉALISÉE'
        );

        return $this->redirect($this->generateUrl('blog'));
        
    }
    
  
}
