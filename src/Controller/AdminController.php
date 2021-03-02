<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Security;

// use App\Entity\Figure;
use App\Entity\Mention;

use App\Repository\FigureRepository;
use App\Repository\MentionRepository;



class AdminController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    // GESTION DES POSTS EN BACK OFFICE
    /**
     * @Route("/admin/backoff", name="admin_backoff")
     */
    public function backOff(FigureRepository $repoFigure) 
    {
        $current_member = $this->security->getUser();

        $articles = $repoFigure->findBy(array(), array('id' => 'desc'));
        
        return $this->render('admin/backOffice.html.twig', [
            'current_member' => $current_member,
            'articles' => $articles
        ]);

    }

    // GESTION DES COMMENTAIRES EN BACK OFFICE
    /**
     * @Route("/admin/backcom", name="admin_backcom")
     */
    public function backCom(MentionRepository $repoMention)
    {
        $current_member = $this->security->getUser();

        $comments = $repoMention->findBy(array(), array('id' => 'desc'));
     
        return $this->render('admin/commentOffice.html.twig', [
            'current_member' => $current_member,
            'comments' => $comments
        ]);
    }
    
    // SUPPRESSION DES COMMENTAIRES EN BACK OFFICE
    /**
     * @Route("/admin/backcom/delete/{id}", name="delete_comment")
     * @Method({"DELETE"})
     */
    public function deleteComment(Mention $mention)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->remove($mention);
        
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'COMMENTAIRE SUPPRIMÉ'
        );
        
        return $this->redirect($this->generateUrl('admin_backcom'));
        
    }
    

}
